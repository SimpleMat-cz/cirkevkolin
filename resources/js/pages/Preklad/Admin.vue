<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useEventListener, useWakeLock } from '@vueuse/core';
import {
    Coins,
    Download,
    Mic,
    Pause,
    Play,
    Printer,
    Square,
    Users,
    Volume2,
} from 'lucide-vue-next';
import { renderSVG } from 'uqr';
import { computed, onMounted, onUnmounted, reactive, ref, watch } from 'vue';
import Blob from '@/components/Blob.vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import { getJson, postJson } from '@/lib/http';
import { LanguageAggregator, splitTokens } from '@/lib/preklad/aggregator';
import { SERMON_GLOSSARY } from '@/lib/preklad/glossary';
import {
    LANGUAGES,
    langOption,
    TRANSLATION_TARGETS,
} from '@/lib/preklad/languages';
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

/** Všechny nabízené jazyky (host si vybírá ve své aplikaci). */
const OFFERED_CODES = LANGUAGES.map((l) => l.code);

const phase = ref<Phase>('ready');
const startError = ref('');

const accessToken = ref<string | null>(null);
const sessionId = ref<string | null>(null);
const sessionTitle = ref(defaultTitle());
const paused = ref(false);

const devices = ref<MediaDeviceInfo[]>([]);
const selectedDeviceId = ref<string>('');
const vuLevel = ref(0);

const sonioxStates = reactive<Record<string, ConnectionState>>({});
const sonioxError = ref('');
const previews = reactive<Record<string, CaptionEvent | null>>({});
/** Čeština (originál) + právě překládané jazyky — pořadí pro náhled a štítky. */
const activeLangs = ref<CaptionLang[]>([]);

const health = ref<HealthInfo | null>(null);
const healthFailed = ref(false);

const {
    connectionState,
    listenerCount,
    requestedLangs,
    connect,
    publish,
    leave,
} = usePrekladChannel(sessionId, accessToken);

let audioContext: AudioContext | null = null;
let mediaStream: MediaStream | null = null;
let workletNode: AudioWorkletNode | null = null;
const sessions = new Map<CaptionLang, SonioxSession>();
const aggregators = new Map<CaptionLang, LanguageAggregator>();

// Throttle broadcasts to ~4/s per language.
const pending = new Map<CaptionLang, CaptionEvent>();
let flushTimer: ReturnType<typeof setInterval> | null = null;
let heartbeatTimer: ReturnType<typeof setInterval> | null = null;

// --- spotřeba / odhad ceny --------------------------------------------------
// Soniox účtuje ~$0.12/hod přepis a ~$0.18/hod překlad za každou běžící session;
// bereme střední odhad. streamSeconds = součet času přes všechny běžící jazyky
// (fakturační jednotka), audioSeconds = skutečná délka odvysílaného zvuku.
const USD_PER_STREAM_HOUR = 0.15;
const CZK_PER_USD = 23.5;
let audioSecondsAcc = 0;
let streamSecondsAcc = 0;
const audioSeconds = ref(0);
const streamSeconds = ref(0);

/** Speech-to-speech (mluvený překlad) — zatím jen příprava, vypnuto. */
const speechEnabled = ref(false);

const {
    isSupported: wakeLockSupported,
    request: requestWakeLock,
    release: releaseWakeLock,
} = useWakeLock();

function defaultTitle(): string {
    return `Nedělní bohoslužba ${new Date().toLocaleDateString('cs-CZ')}`;
}

// --- QR kód pro hosty -------------------------------------------------------

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
        .insert({ ...base, languages: OFFERED_CODES })
        .select('id')
        .single();

    if (insert.error && /languages/i.test(insert.error.message)) {
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
    connect();
    audioSecondsAcc = 0;
    streamSecondsAcc = 0;
    audioSeconds.value = 0;
    streamSeconds.value = 0;

    try {
        await startAudio();
    } catch (error) {
        startError.value =
            'Nepodařilo se spustit zvuk (mikrofon nebo audio worklet): ' +
            (error as Error).message;
        await endSession();

        return;
    }

    startCzechSession();
    reconcileTranslations();

    flushTimer = setInterval(flushPending, 250);
    heartbeatTimer = setInterval(heartbeat, 15000);
    void heartbeat();
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

            const seconds = frame.length / audioContext.sampleRate;
            audioSecondsAcc += seconds;
            streamSecondsAcc += seconds * sessions.size;
        }
    };

    source.connect(workletNode);
    workletNode.connect(audioContext.destination);
}

/** Čeština jede vždy — přepisová session (bez překladu) vysílá originál. */
function startCzechSession(): void {
    aggregators.set('cs', new LanguageAggregator('cs'));

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
    refreshActiveLangs();
}

/**
 * On-demand: pro každý jazyk, který si právě čte aspoň jeden host, běží
 * překladová Soniox session. Když o jazyk nikdo nestojí, session se zavře
 * (šetří kredit). Čeština se řeší zvlášť přepisovou session a běží pořád.
 */
function reconcileTranslations(): void {
    if (phase.value !== 'live') {
        return;
    }

    const wanted = new Set(
        requestedLangs.value.filter((lang) => lang !== 'cs'),
    );

    for (const [lang, session] of [...sessions]) {
        if (lang === 'cs' || wanted.has(lang)) {
            continue;
        }

        session.close();
        sessions.delete(lang);
        aggregators.delete(lang);
        delete previews[lang];
        delete sonioxStates[lang];
    }

    for (const lang of wanted) {
        if (sessions.has(lang)) {
            continue;
        }

        const target = TRANSLATION_TARGETS.find((t) => t.code === lang);

        if (!target?.targetLanguage) {
            continue;
        }

        aggregators.set(lang, new LanguageAggregator(lang));
        const session = new SonioxSession({
            targetLanguage: target.targetLanguage,
            getTempKey,
            context: SERMON_GLOSSARY,
            languageHints: ['cs'],
            onStateChange: (state) => (sonioxStates[lang] = state),
            onError: (message) => (sonioxError.value = `${lang}: ${message}`),
            onTokens: (tokens) =>
                handleLang(lang, splitTokens(tokens).translation),
        });
        sessions.set(lang, session);
        void session.connect();
    }

    refreshActiveLangs();
}

function refreshActiveLangs(): void {
    activeLangs.value = [
        'cs',
        ...[...sessions.keys()].filter((lang) => lang !== 'cs'),
    ];
}

watch(requestedLangs, reconcileTranslations, { deep: true });

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
    audioSeconds.value = audioSecondsAcc;
    streamSeconds.value = streamSecondsAcc;
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
    aggregators.clear();
    stopAudio();

    if (flushTimer) {
        clearInterval(flushTimer);
        flushTimer = null;
    }

    if (heartbeatTimer) {
        clearInterval(heartbeatTimer);
        heartbeatTimer = null;
    }

    await endSession();

    void releaseWakeLock();
    phase.value = 'ready';
    sessionTitle.value = defaultTitle();
    activeLangs.value = [];
}

/**
 * Heartbeat — pravidelně potvrzuje, že vysílání běží, a ukládá nasbíraný čas
 * audia. Divácká stránka podle čerstvosti last_seen_at pozná, že je vysílání
 * opravdu živé (po zavření panelu do ~30 s zmizí). Chyby ignorujeme, ať
 * heartbeat nikdy nerozbije vysílání.
 */
async function heartbeat(): Promise<void> {
    const supabase = accessToken.value
        ? getBroadcasterClient(accessToken.value)
        : null;

    if (!supabase || !sessionId.value) {
        return;
    }

    await supabase
        .from('sermon_sessions')
        .update({
            last_seen_at: new Date().toISOString(),
            audio_seconds: Math.round(audioSecondsAcc),
        })
        .eq('id', sessionId.value);
}

/** Označí session jako ukončenou a uvolní kanál (po Stopu i po chybě startu). */
async function endSession(): Promise<void> {
    const supabase = accessToken.value
        ? getBroadcasterClient(accessToken.value)
        : null;

    if (supabase && sessionId.value) {
        await supabase
            .from('sermon_sessions')
            .update({
                status: 'ended',
                ended_at: new Date().toISOString(),
                audio_seconds: Math.round(audioSecondsAcc),
            })
            .eq('id', sessionId.value);
    }

    leave();
    sessionId.value = null;
    accessToken.value = null;
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

    if (heartbeatTimer) {
        clearInterval(heartbeatTimer);
    }
});

const vuPercent = computed(() =>
    Math.min(100, Math.round(vuLevel.value * 280)),
);

const serverReady = computed(
    () =>
        health.value?.soniox_key_configured &&
        health.value?.supabase_jwt_configured &&
        isSupabaseConfigured,
);

const audioMinutes = computed(() => audioSeconds.value / 60);
const estimatedUsd = computed(
    () => (streamSeconds.value / 3600) * USD_PER_STREAM_HOUR,
);
const estimatedCzk = computed(() => estimatedUsd.value * CZK_PER_USD);
const translationCount = computed(
    () => activeLangs.value.filter((lang) => lang !== 'cs').length,
);
</script>

<template>
    <Head>
        <title>Překlad — ovládání</title>
        <meta name="robots" content="noindex" />
    </Head>

    <div
        class="relative min-h-screen overflow-hidden bg-brand-cream text-brand-ink"
    >
        <Blob
            color="#ff8c69"
            :size="300"
            variant="2"
            float="slow"
            :opacity="0.4"
            class="-top-24 -right-24"
        />
        <Blob
            color="#4db6ac"
            :size="220"
            variant="3"
            float="none"
            :opacity="0.3"
            class="top-1/2 -left-20"
        />

        <div class="relative z-10 mx-auto max-w-2xl space-y-5 p-5 sm:p-6">
            <header class="flex items-center justify-between">
                <div>
                    <span
                        class="text-xs font-bold tracking-[0.2em] text-brand-coral uppercase"
                        >Živý překlad</span
                    >
                    <h1 class="font-display text-2xl text-brand-ink">
                        Ovládání vysílání
                    </h1>
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-sm font-semibold shadow-sm ring-1 ring-brand-ink/5"
                    >
                        <Users class="h-4 w-4 text-brand-teal" />
                        {{ listenerCount }}
                    </span>
                    <a
                        href="/admin"
                        class="rounded-full bg-white px-3 py-1.5 text-sm font-semibold shadow-sm ring-1 ring-brand-ink/5 transition-colors hover:bg-brand-cream-deep"
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
                    class="rounded-full px-3 py-1 font-semibold"
                    :class="
                        health.soniox_key_configured
                            ? 'bg-brand-mint/30 text-emerald-800'
                            : 'bg-red-100 text-red-700'
                    "
                >
                    {{
                        health.soniox_key_configured
                            ? '✓ Soniox klíč'
                            : '✗ Chybí SONIOX_API_KEY'
                    }}
                </span>
                <span
                    v-if="health"
                    class="rounded-full px-3 py-1 font-semibold"
                    :class="
                        health.supabase_jwt_configured
                            ? 'bg-brand-mint/30 text-emerald-800'
                            : 'bg-red-100 text-red-700'
                    "
                >
                    {{
                        health.supabase_jwt_configured
                            ? '✓ Supabase JWT'
                            : '✗ Chybí SUPABASE_JWT_SECRET'
                    }}
                </span>
                <span
                    v-if="healthFailed || !isSupabaseConfigured"
                    class="rounded-full bg-red-100 px-3 py-1 font-semibold text-red-700"
                >
                    ✗ Konfigurace serveru
                </span>
            </div>

            <!-- Nastavení -->
            <div
                class="space-y-4 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-brand-ink/5"
            >
                <label class="block text-sm">
                    <span class="font-semibold text-brand-ink-soft"
                        >Název session</span
                    >
                    <input
                        v-model="sessionTitle"
                        :disabled="phase === 'live'"
                        class="mt-1 w-full rounded-xl border border-brand-ink/10 bg-brand-cream px-3 py-2.5 text-sm text-brand-ink focus:border-brand-coral focus:ring-2 focus:ring-brand-coral/20 focus:outline-none disabled:opacity-60"
                    />
                </label>

                <label class="block text-sm">
                    <span class="font-semibold text-brand-ink-soft"
                        >Audio vstup (zvuk z OBS / mixu)</span
                    >
                    <select
                        v-model="selectedDeviceId"
                        :disabled="phase === 'live'"
                        class="mt-1 w-full rounded-xl border border-brand-ink/10 bg-brand-cream px-3 py-2.5 text-sm text-brand-ink focus:border-brand-coral focus:ring-2 focus:ring-brand-coral/20 focus:outline-none disabled:opacity-60"
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

                <div
                    class="rounded-2xl bg-brand-cream px-4 py-3 text-sm text-brand-ink-soft"
                >
                    <p class="font-semibold text-brand-ink">
                        Jazyky se spouštějí samy 🎧
                    </p>
                    <p class="mt-1">
                        Čeština jede vždy. Překlad do dalšího jazyka se zapne
                        teprve, když si ho host vybere ve své aplikaci — takže
                        se nepřekládá zbytečně.
                    </p>
                </div>

                <!-- VU meter -->
                <div class="flex items-center gap-2">
                    <Mic class="h-4 w-4 text-brand-ink/50" />
                    <div
                        class="h-2.5 flex-1 overflow-hidden rounded-full bg-brand-ink/10"
                    >
                        <div
                            class="h-full rounded-full bg-brand-teal transition-[width] duration-75"
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
                        v-for="lang in activeLangs"
                        :key="lang"
                        class="rounded-full px-3 py-1 font-semibold"
                        :class="
                            sonioxStates[lang] === 'open'
                                ? 'bg-brand-mint/30 text-emerald-800'
                                : 'bg-brand-sunny/40 text-amber-800'
                        "
                    >
                        {{ langOption(lang).flag }} {{ lang }}:
                        {{ sonioxStates[lang] ?? 'připojuji' }}
                    </span>
                    <span
                        class="rounded-full px-3 py-1 font-semibold"
                        :class="
                            connectionState === 'open'
                                ? 'bg-brand-mint/30 text-emerald-800'
                                : 'bg-brand-sunny/40 text-amber-800'
                        "
                    >
                        Realtime: {{ connectionState }}
                    </span>
                </div>
                <p v-if="sonioxError" class="text-xs text-red-600">
                    {{ sonioxError }}
                </p>
                <p v-if="startError" class="text-xs text-red-600">
                    {{ startError }}
                </p>

                <!-- Controls -->
                <div class="flex gap-3">
                    <button
                        v-if="phase === 'ready'"
                        class="flex flex-1 items-center justify-center gap-2 rounded-full bg-brand-coral px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-coral-dark disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="!serverReady"
                        @click="start"
                    >
                        <Play class="h-4 w-4" /> Spustit vysílání
                    </button>
                    <template v-else>
                        <button
                            class="flex flex-1 items-center justify-center gap-2 rounded-full bg-white px-4 py-3.5 text-sm font-semibold text-brand-ink shadow-sm ring-1 ring-brand-ink/10 transition-colors hover:bg-brand-cream-deep"
                            @click="togglePause"
                        >
                            <component
                                :is="paused ? Play : Pause"
                                class="h-4 w-4"
                            />
                            {{ paused ? 'Pokračovat' : 'Pauza' }}
                        </button>
                        <button
                            class="flex flex-1 items-center justify-center gap-2 rounded-full bg-brand-coral px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-coral-dark"
                            @click="stop"
                        >
                            <Square class="h-4 w-4" /> Konec
                        </button>
                    </template>
                </div>
            </div>

            <!-- Live preview -->
            <div v-if="phase === 'live'" class="grid gap-3 sm:grid-cols-2">
                <div
                    v-for="lang in activeLangs"
                    :key="lang"
                    class="rounded-3xl bg-white p-4 shadow-sm ring-1 ring-brand-ink/5"
                >
                    <p
                        class="mb-2 text-xs font-semibold tracking-wide text-brand-ink-soft"
                    >
                        {{ langOption(lang).flag }}
                        {{ langOption(lang).nativeName }}
                    </p>
                    <p class="text-sm leading-relaxed text-brand-ink">
                        {{ previews[lang]?.final }}
                        <span class="text-brand-ink/40 italic">{{
                            previews[lang]?.partial
                        }}</span>
                    </p>
                </div>
            </div>

            <!-- Spotřeba / odhad ceny -->
            <div
                v-if="phase === 'live'"
                class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-brand-ink/5"
            >
                <div class="flex items-center gap-2">
                    <Coins class="h-4 w-4 text-brand-coral" />
                    <h2 class="font-display text-lg text-brand-ink">
                        Spotřeba
                    </h2>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-2xl bg-brand-cream px-2 py-3">
                        <p class="font-display text-xl text-brand-ink">
                            {{ audioMinutes.toFixed(1) }}
                        </p>
                        <p class="text-xs text-brand-ink-soft">minut audia</p>
                    </div>
                    <div class="rounded-2xl bg-brand-cream px-2 py-3">
                        <p class="font-display text-xl text-brand-ink">
                            {{ 1 + translationCount }}
                        </p>
                        <p class="text-xs text-brand-ink-soft">
                            streamů (cs + {{ translationCount }})
                        </p>
                    </div>
                    <div class="rounded-2xl bg-brand-cream px-2 py-3">
                        <p class="font-display text-xl text-brand-ink">
                            ~{{ estimatedCzk.toFixed(0) }} Kč
                        </p>
                        <p class="text-xs text-brand-ink-soft">
                            ≈ ${{ estimatedUsd.toFixed(2) }}
                        </p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-brand-ink/50">
                    Odhad podle Soniox (~$0,15/hod za jazyk). Zavřením panelu se
                    vysílání i účtování zastaví.
                </p>
            </div>

            <!-- Mluvený překlad (speech-to-speech) — příprava -->
            <div
                class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-brand-ink/5"
            >
                <div class="flex items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <Volume2 class="h-4 w-4 text-brand-teal" />
                        <h2 class="font-display text-lg text-brand-ink">
                            Mluvený překlad
                        </h2>
                        <span
                            class="rounded-full bg-brand-sunny/40 px-2 py-0.5 text-[10px] font-bold tracking-wide text-amber-800 uppercase"
                            >Připravujeme</span
                        >
                    </div>
                    <button
                        type="button"
                        disabled
                        :aria-pressed="speechEnabled"
                        aria-label="Mluvený překlad (zatím nedostupné)"
                        class="relative h-6 w-11 shrink-0 cursor-not-allowed rounded-full bg-brand-ink/15 opacity-60"
                    >
                        <span
                            class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white shadow"
                        />
                    </button>
                </div>
                <p class="mt-2 text-sm text-brand-ink-soft">
                    Kromě textu uslyší host i namluvený překlad ve sluchátkách.
                    Technicky dosažitelné (Soniox TTS, ~$0,70/hod za jazyk) —
                    zapneme po doladění latence a rozvodu zvuku.
                </p>
            </div>

            <!-- QR kód pro hosty -->
            <div
                class="space-y-3 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-brand-ink/5"
            >
                <h2 class="font-display text-lg text-brand-ink">
                    QR kód pro hosty
                </h2>
                <p class="text-sm text-brand-ink-soft">
                    Adresa je stálá — QR stačí vytisknout jednou a platí pro
                    každé vysílání. Host ho načte telefonem, vybere si jazyk a
                    čte přepis.
                </p>
                <div class="flex flex-wrap items-center gap-5">
                    <!-- eslint-disable-next-line vue/no-v-html — SVG generované lokálně knihovnou uqr -->
                    <div
                        class="w-36 shrink-0 rounded-2xl bg-white p-2 ring-1 ring-brand-ink/10 [&_svg]:h-auto [&_svg]:w-full"
                        v-html="qrSvg"
                    />
                    <div class="space-y-2 text-sm">
                        <p class="font-mono text-brand-teal">
                            {{ viewerUrl }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <a
                                :href="qrDownloadHref"
                                download="cirkev-kolin-preklad-qr.svg"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink ring-1 ring-brand-ink/10 transition-colors hover:bg-brand-cream-deep"
                            >
                                <Download class="h-3.5 w-3.5" /> Stáhnout QR
                            </a>
                            <a
                                href="/preklad/karta"
                                target="_blank"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink ring-1 ring-brand-ink/10 transition-colors hover:bg-brand-cream-deep"
                            >
                                <Printer class="h-3.5 w-3.5" /> Kartička pro
                                hosty
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
