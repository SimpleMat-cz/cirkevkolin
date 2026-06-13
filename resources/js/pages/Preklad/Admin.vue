<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useEventListener, useWakeLock } from '@vueuse/core';
import { Download, Mic, Pause, Play, Square } from 'lucide-vue-next';
import { renderSVG } from 'uqr';
import { computed, onMounted, onUnmounted, reactive, ref } from 'vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import { getJson, postJson } from '@/lib/http';
import { LanguageAggregator, splitTokens } from '@/lib/preklad/aggregator';
import { SERMON_GLOSSARY } from '@/lib/preklad/glossary';
import { langOption, TRANSLATION_TARGETS } from '@/lib/preklad/languages';
import { encodePcmChunk, rms } from '@/lib/preklad/pcm';
import { SonioxSession } from '@/lib/preklad/sonioxClient';
import type {
    CaptionEvent,
    CaptionLang,
    ConnectionState,
} from '@/lib/preklad/types';
import { getBroadcasterClient, isSupabaseConfigured } from '@/lib/supabase';

type Phase = 'ready' | 'live';

interface HealthInfo {
    soniox_key_configured: boolean;
    supabase_jwt_configured: boolean;
}

const phase = ref<Phase>('ready');
const startError = ref('');

const accessToken = ref<string | null>(null);
const sessionId = ref<string | null>(null);
const sessionTitle = ref(defaultTitle());
const paused = ref(false);

const devices = ref<MediaDeviceInfo[]>([]);
const selectedDeviceId = ref<string>('');
const vuLevel = ref(0);

/** Překladové cíle zaškrtnuté technikem; čeština (originál) jede vždy. */
const selectedTargets = ref<CaptionLang[]>(['en']);
const broadcastLangs = computed<CaptionLang[]>(() => [
    'cs',
    ...selectedTargets.value,
]);

const sonioxStates = reactive<Record<string, ConnectionState>>({});
const sonioxError = ref('');
const previews = reactive<Record<string, CaptionEvent | null>>({});

const health = ref<HealthInfo | null>(null);
const healthFailed = ref(false);

const { connectionState, listenerCount, publish, leave } = usePrekladChannel(
    sessionId,
    accessToken,
);

let audioContext: AudioContext | null = null;
let mediaStream: MediaStream | null = null;
let workletNode: AudioWorkletNode | null = null;
const sessions = new Map<CaptionLang, SonioxSession>();
const aggregators = new Map<CaptionLang, LanguageAggregator>();

// Throttle broadcasts to ~4/s per language (spec §7).
const pending = new Map<CaptionLang, CaptionEvent>();
let flushTimer: ReturnType<typeof setInterval> | null = null;

const {
    isSupported: wakeLockSupported,
    request: requestWakeLock,
    release: releaseWakeLock,
} = useWakeLock();

function defaultTitle(): string {
    return `Nedělní bohoslužba ${new Date().toLocaleDateString('cs-CZ')}`;
}

// --- QR kód pro hosty -------------------------------------------------------
// URL je stálá (/preklad), takže QR stačí vytisknout jednou a platí napořád.

const viewerUrl =
    typeof window !== 'undefined'
        ? `${window.location.origin}/preklad`
        : '/preklad';
const qrSvg = renderSVG(viewerUrl, { ecc: 'M', border: 2 });
const qrDownloadHref = `data:image/svg+xml;utf8,${encodeURIComponent(qrSvg)}`;

// --- audio devices ----------------------------------------------------------

async function loadDevices(): Promise<void> {
    try {
        const probe = await navigator.mediaDevices.getUserMedia({
            audio: true,
        });
        probe.getTracks().forEach((t) => t.stop());
    } catch {
        // permission denied — labels will be empty but Start will prompt again
    }

    const all = await navigator.mediaDevices.enumerateDevices();
    devices.value = all.filter((d) => d.kind === 'audioinput');

    if (!selectedDeviceId.value && devices.value[0]) {
        selectedDeviceId.value = devices.value[0].deviceId;
    }
}

// --- credentials from the Laravel backend -----------------------------------

async function getTempKey(): Promise<string> {
    const { api_key } = await postJson<{ api_key: string }>(
        '/preklad/soniox-key',
    );

    return api_key;
}

async function loadHealth(): Promise<void> {
    try {
        health.value = await getJson<HealthInfo>('/preklad/health');
    } catch {
        healthFailed.value = true;
    }
}

// --- start / pause / stop ---------------------------------------------------

async function start(): Promise<void> {
    startError.value = '';
    sonioxError.value = '';

    try {
        const { token } = await postJson<{ token: string }>(
            '/preklad/realtime-token',
        );
        accessToken.value = token;
    } catch {
        startError.value =
            'Nepodařilo se získat oprávnění (realtime token). Zkontroluj SUPABASE_JWT_SECRET na serveru.';

        return;
    }

    const supabase = getBroadcasterClient(accessToken.value);

    if (!supabase) {
        startError.value = 'Supabase není nakonfigurován.';

        return;
    }

    const base = {
        title: sessionTitle.value,
        status: 'live',
        started_at: new Date().toISOString(),
    };

    let insert = await supabase
        .from('sermon_sessions')
        .insert({ ...base, languages: broadcastLangs.value })
        .select('id')
        .single();

    if (insert.error && /languages/i.test(insert.error.message)) {
        // Sloupec languages ještě nemusí v DB existovat — vysílání má přednost.
        insert = await supabase
            .from('sermon_sessions')
            .insert(base)
            .select('id')
            .single();
    }

    if (insert.error || !insert.data) {
        startError.value =
            insert.error?.message ?? 'Nepodařilo se založit session.';

        return;
    }

    sessionId.value = insert.data.id;

    aggregators.clear();

    for (const lang of broadcastLangs.value) {
        aggregators.set(lang, new LanguageAggregator(lang));
    }

    await startAudio();
    startSoniox();

    flushTimer = setInterval(flushPending, 250);
    phase.value = 'live';
    paused.value = false;

    if (wakeLockSupported.value) {
        void requestWakeLock('screen');
    }
}

async function startAudio(): Promise<void> {
    mediaStream = await navigator.mediaDevices.getUserMedia({
        audio: {
            deviceId: selectedDeviceId.value
                ? { exact: selectedDeviceId.value }
                : undefined,
            echoCancellation: false,
            noiseSuppression: false,
            autoGainControl: false,
        },
    });
    audioContext = new AudioContext();
    await audioContext.audioWorklet.addModule('/worklets/pcm-processor.js');
    const source = audioContext.createMediaStreamSource(mediaStream);
    workletNode = new AudioWorkletNode(audioContext, 'pcm-processor');

    workletNode.port.onmessage = (event: MessageEvent<Float32Array>) => {
        const frame = event.data;
        vuLevel.value = rms(frame);

        if (!paused.value && sessions.size > 0 && audioContext) {
            const chunk = encodePcmChunk(frame, audioContext.sampleRate);

            for (const session of sessions.values()) {
                session.sendAudio(chunk);
            }
        }
    };

    source.connect(workletNode);
    workletNode.connect(audioContext.destination);
}

/**
 * Jedna Soniox session na každý cílový jazyk (API umí jen one-way překlad).
 * Český originál agreguje jen první session, jinak by se titulky duplikovaly.
 * Bez zaškrtnutého cíle běží jediná čistě přepisová session (jen čeština).
 */
function startSoniox(): void {
    sessions.clear();

    const targets = TRANSLATION_TARGETS.filter((t) =>
        selectedTargets.value.includes(t.code),
    );

    if (targets.length === 0) {
        const session = new SonioxSession({
            getTempKey,
            context: SERMON_GLOSSARY,
            languageHints: ['cs'],
            onStateChange: (state) => (sonioxStates.cs = state),
            onError: (message) => (sonioxError.value = `cs: ${message}`),
            onTokens: (tokens) => handleLang('cs', tokens),
        });
        sessions.set('cs', session);
        void session.connect();

        return;
    }

    targets.forEach((target, index) => {
        const handlesOriginal = index === 0;
        const session = new SonioxSession({
            targetLanguage: target.targetLanguage,
            getTempKey,
            context: SERMON_GLOSSARY,
            languageHints: ['cs'],
            onStateChange: (state) => (sonioxStates[target.code] = state),
            onError: (message) =>
                (sonioxError.value = `${target.code}: ${message}`),
            onTokens: (tokens) => {
                const { original, translation } = splitTokens(tokens);

                if (handlesOriginal) {
                    handleLang('cs', original);
                }

                handleLang(target.code, translation);
            },
        });
        sessions.set(target.code, session);
        void session.connect();
    });
}

function handleLang(
    lang: CaptionLang,
    tokens: { text: string; is_final?: boolean }[],
): void {
    const aggregator = aggregators.get(lang);

    if (!aggregator || tokens.length === 0) {
        return;
    }

    const event = aggregator.push(tokens);
    previews[lang] = event;
    pending.set(lang, event);
}

function flushPending(): void {
    for (const event of pending.values()) {
        publish(event);
    }

    pending.clear();
}

function togglePause(): void {
    paused.value = !paused.value;
}

async function stop(): Promise<void> {
    for (const session of sessions.values()) {
        session.finalize();
    }

    for (const [lang, aggregator] of aggregators) {
        const event = aggregator.flush();

        if (event) {
            publish(event);
            previews[lang] = event;
        }
    }

    for (const session of sessions.values()) {
        session.close();
    }

    sessions.clear();
    stopAudio();

    if (flushTimer) {
        clearInterval(flushTimer);
        flushTimer = null;
    }

    const supabase = accessToken.value
        ? getBroadcasterClient(accessToken.value)
        : null;

    if (supabase && sessionId.value) {
        await supabase
            .from('sermon_sessions')
            .update({ status: 'ended', ended_at: new Date().toISOString() })
            .eq('id', sessionId.value);
    }

    void releaseWakeLock();
    leave();
    phase.value = 'ready';
    sessionId.value = null;
    accessToken.value = null;
    sessionTitle.value = defaultTitle();
}

function stopAudio(): void {
    workletNode?.port.close();
    workletNode?.disconnect();
    workletNode = null;
    mediaStream?.getTracks().forEach((t) => t.stop());
    mediaStream = null;
    void audioContext?.close();
    audioContext = null;
    vuLevel.value = 0;
}

useEventListener(window, 'beforeunload', (event: BeforeUnloadEvent) => {
    if (phase.value === 'live') {
        event.preventDefault();
        event.returnValue = '';
    }
});

onMounted(() => {
    void loadDevices();
    void loadHealth();
});

onUnmounted(() => {
    stopAudio();

    for (const session of sessions.values()) {
        session.close();
    }

    if (flushTimer) {
        clearInterval(flushTimer);
    }
});

const vuPercent = computed(() =>
    Math.min(100, Math.round(vuLevel.value * 280)),
);
</script>

<template>
    <Head>
        <title>Překlad — ovládání</title>
        <meta name="robots" content="noindex" />
    </Head>

    <div class="min-h-screen bg-neutral-950 text-neutral-100">
        <div class="mx-auto max-w-2xl space-y-6 p-6">
            <header class="flex items-center justify-between">
                <h1 class="text-lg font-semibold">Ovládání živého překladu</h1>
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs"
                        >👂 {{ listenerCount }}</span
                    >
                    <a
                        href="/admin"
                        class="rounded-full bg-white/10 px-3 py-1 text-xs hover:bg-white/20"
                        >← Administrace</a
                    >
                </div>
            </header>

            <!-- Stav konfigurace serveru -->
            <div
                v-if="health || healthFailed || !isSupabaseConfigured"
                class="flex flex-wrap gap-2 text-xs"
            >
                <span
                    v-if="health"
                    class="rounded-full px-2.5 py-1"
                    :class="
                        health.soniox_key_configured
                            ? 'bg-emerald-500/20 text-emerald-300'
                            : 'bg-red-500/20 text-red-300'
                    "
                >
                    {{
                        health.soniox_key_configured
                            ? '✓ Soniox klíč nastaven'
                            : '✗ Chybí SONIOX_API_KEY na serveru'
                    }}
                </span>
                <span
                    v-if="health"
                    class="rounded-full px-2.5 py-1"
                    :class="
                        health.supabase_jwt_configured
                            ? 'bg-emerald-500/20 text-emerald-300'
                            : 'bg-red-500/20 text-red-300'
                    "
                >
                    {{
                        health.supabase_jwt_configured
                            ? '✓ Supabase JWT nastaven'
                            : '✗ Chybí SUPABASE_JWT_SECRET na serveru'
                    }}
                </span>
                <span
                    v-if="healthFailed"
                    class="rounded-full bg-red-500/20 px-2.5 py-1 text-red-300"
                >
                    ✗ Kontrola konfigurace selhala
                </span>
                <span
                    v-if="!isSupabaseConfigured"
                    class="rounded-full bg-red-500/20 px-2.5 py-1 text-red-300"
                >
                    ✗ Chybí VITE_SUPABASE_URL / VITE_SUPABASE_ANON_KEY
                </span>
            </div>

            <div
                class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-5"
            >
                <label class="block text-sm">
                    <span class="text-neutral-400">Název session</span>
                    <input
                        v-model="sessionTitle"
                        :disabled="phase === 'live'"
                        class="mt-1 w-full rounded-lg border border-white/15 bg-neutral-900 px-3 py-2 text-sm disabled:opacity-60"
                    />
                </label>

                <label class="block text-sm">
                    <span class="text-neutral-400"
                        >Audio vstup (zvuk z OBS / mixu)</span
                    >
                    <select
                        v-model="selectedDeviceId"
                        :disabled="phase === 'live'"
                        class="mt-1 w-full rounded-lg border border-white/15 bg-neutral-900 px-3 py-2 text-sm disabled:opacity-60"
                    >
                        <option
                            v-for="d in devices"
                            :key="d.deviceId"
                            :value="d.deviceId"
                        >
                            {{ d.label || 'Mikrofon' }}
                        </option>
                    </select>
                </label>

                <fieldset class="text-sm">
                    <legend class="text-neutral-400">
                        Jazyky překladu (čeština jede vždy)
                    </legend>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <label
                            v-for="target in TRANSLATION_TARGETS"
                            :key="target.code"
                            class="flex cursor-pointer items-center gap-2 rounded-lg border border-white/15 px-3 py-2"
                            :class="{
                                'bg-white/10': selectedTargets.includes(
                                    target.code,
                                ),
                                'opacity-60': phase === 'live',
                            }"
                        >
                            <input
                                v-model="selectedTargets"
                                type="checkbox"
                                :value="target.code"
                                :disabled="phase === 'live'"
                                class="accent-emerald-400"
                            />
                            {{ target.flag }} {{ target.nativeName }}
                        </label>
                    </div>
                    <p class="mt-1.5 text-xs text-neutral-500">
                        Každý jazyk = samostatná Soniox session (vyšší spotřeba
                        kreditu).
                    </p>
                </fieldset>

                <!-- VU meter -->
                <div class="flex items-center gap-2">
                    <Mic class="h-4 w-4 text-neutral-400" />
                    <div
                        class="h-2 flex-1 overflow-hidden rounded-full bg-white/10"
                    >
                        <div
                            class="h-full rounded-full bg-emerald-400 transition-[width] duration-75"
                            :style="{ width: vuPercent + '%' }"
                        />
                    </div>
                </div>

                <!-- Connection status -->
                <div
                    v-if="phase === 'live'"
                    class="flex flex-wrap gap-2 text-xs"
                >
                    <span
                        v-for="(state, lang) in sonioxStates"
                        :key="lang"
                        class="rounded-full px-2.5 py-1"
                        :class="
                            state === 'open'
                                ? 'bg-emerald-500/20 text-emerald-300'
                                : 'bg-red-500/20 text-red-300'
                        "
                    >
                        Soniox {{ lang }}: {{ state }}
                    </span>
                    <span
                        class="rounded-full px-2.5 py-1"
                        :class="
                            connectionState === 'open'
                                ? 'bg-emerald-500/20 text-emerald-300'
                                : 'bg-amber-500/20 text-amber-300'
                        "
                    >
                        Realtime: {{ connectionState }}
                    </span>
                </div>
                <p v-if="sonioxError" class="text-xs text-red-400">
                    {{ sonioxError }}
                </p>
                <p v-if="startError" class="text-xs text-red-400">
                    {{ startError }}
                </p>

                <!-- Controls -->
                <div class="flex gap-3">
                    <button
                        v-if="phase === 'ready'"
                        class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-emerald-500 px-4 py-3 text-sm font-semibold text-neutral-900"
                        @click="start"
                    >
                        <Play class="h-4 w-4" /> Start
                    </button>
                    <template v-else>
                        <button
                            class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-white/10 px-4 py-3 text-sm font-semibold"
                            @click="togglePause"
                        >
                            <component
                                :is="paused ? Play : Pause"
                                class="h-4 w-4"
                            />
                            {{ paused ? 'Pokračovat' : 'Pauza' }}
                        </button>
                        <button
                            class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-red-500 px-4 py-3 text-sm font-semibold text-neutral-900"
                            @click="stop"
                        >
                            <Square class="h-4 w-4" /> Konec
                        </button>
                    </template>
                </div>
            </div>

            <!-- Live preview -->
            <div v-if="phase === 'live'" class="grid gap-4 sm:grid-cols-2">
                <div
                    v-for="lang in broadcastLangs"
                    :key="lang"
                    class="rounded-2xl border border-white/10 bg-white/5 p-4"
                >
                    <p class="mb-2 text-xs font-semibold text-neutral-400">
                        {{ langOption(lang).flag }}
                        {{ langOption(lang).nativeName }}
                    </p>
                    <p class="text-sm leading-relaxed">
                        {{ previews[lang]?.final }}
                        <span class="text-neutral-500 italic">{{
                            previews[lang]?.partial
                        }}</span>
                    </p>
                </div>
            </div>

            <!-- QR kód pro hosty -->
            <div
                class="space-y-3 rounded-2xl border border-white/10 bg-white/5 p-5"
            >
                <h2 class="text-sm font-semibold">QR kód pro hosty</h2>
                <p class="text-xs text-neutral-400">
                    Adresa je stálá — QR stačí vytisknout jednou a platí pro
                    každé vysílání. Host ho načte telefonem, vybere si jazyk a
                    čte přepis.
                </p>
                <div class="flex flex-wrap items-center gap-5">
                    <!-- eslint-disable-next-line vue/no-v-html — SVG generované lokálně knihovnou uqr -->
                    <div
                        class="w-36 shrink-0 rounded-xl bg-white p-2 [&_svg]:h-auto [&_svg]:w-full"
                        v-html="qrSvg"
                    />
                    <div class="space-y-2 text-sm">
                        <p class="font-mono text-emerald-300">
                            {{ viewerUrl }}
                        </p>
                        <a
                            :href="qrDownloadHref"
                            download="cirkev-kolin-preklad-qr.svg"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 px-3 py-2 text-xs font-semibold hover:bg-white/20"
                        >
                            <Download class="h-3.5 w-3.5" /> Stáhnout QR (SVG)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
