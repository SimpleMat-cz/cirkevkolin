<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useEventListener, useWakeLock } from '@vueuse/core';
import { Mic, Pause, Play, Square } from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, reactive, ref } from 'vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import { postJson } from '@/lib/http';
import { LanguageAggregator, splitTokens } from '@/lib/preklad/aggregator';
import { SERMON_GLOSSARY } from '@/lib/preklad/glossary';
import { TRANSLATION_TARGETS } from '@/lib/preklad/languages';
import { encodePcmChunk, rms } from '@/lib/preklad/pcm';
import { SonioxSession } from '@/lib/preklad/sonioxClient';
import type {
    CaptionEvent,
    CaptionLang,
    ConnectionState,
} from '@/lib/preklad/types';
import { getBroadcasterClient, isSupabaseConfigured } from '@/lib/supabase';

type Phase = 'ready' | 'live';

const phase = ref<Phase>('ready');
const startError = ref('');

const accessToken = ref<string | null>(null);
const sessionId = ref<string | null>(null);
const sessionTitle = ref(defaultTitle());
const paused = ref(false);

const devices = ref<MediaDeviceInfo[]>([]);
const selectedDeviceId = ref<string>('');
const vuLevel = ref(0);

const sonioxState = ref<ConnectionState>('idle');
const sonioxError = ref('');
const previews = reactive<Record<string, CaptionEvent | null>>({
    cs: null,
    en: null,
});

const { connectionState, listenerCount, publish, leave } = usePrekladChannel(
    sessionId,
    accessToken,
);

let audioContext: AudioContext | null = null;
let mediaStream: MediaStream | null = null;
let workletNode: AudioWorkletNode | null = null;
let session: SonioxSession | null = null;
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

// --- audio devices --------------------------------------------------------

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

// --- credentials from the Laravel backend ---------------------------------

async function getTempKey(): Promise<string> {
    const { api_key } = await postJson<{ api_key: string }>(
        '/preklad/soniox-key',
    );

    return api_key;
}

// --- start / pause / stop -------------------------------------------------

async function start(): Promise<void> {
    startError.value = '';

    try {
        const { token } = await postJson<{ token: string }>(
            '/preklad/realtime-token',
        );
        accessToken.value = token;
    } catch {
        startError.value = 'Nepodařilo se získat oprávnění (realtime token).';

        return;
    }

    const supabase = getBroadcasterClient(accessToken.value);

    if (!supabase) {
        startError.value = 'Supabase není nakonfigurován.';

        return;
    }

    const { data, error } = await supabase
        .from('sermon_sessions')
        .insert({
            title: sessionTitle.value,
            status: 'live',
            started_at: new Date().toISOString(),
        })
        .select('id')
        .single();

    if (error || !data) {
        startError.value = error?.message ?? 'Nepodařilo se založit session.';

        return;
    }

    sessionId.value = data.id;

    aggregators.set('cs', new LanguageAggregator('cs'));

    for (const target of TRANSLATION_TARGETS) {
        aggregators.set(target.code, new LanguageAggregator(target.code));
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

        if (!paused.value && session && audioContext) {
            session.sendAudio(encodePcmChunk(frame, audioContext.sampleRate));
        }
    };

    source.connect(workletNode);
    workletNode.connect(audioContext.destination);
}

function startSoniox(): void {
    session = new SonioxSession({
        targetLanguage: 'en',
        getTempKey,
        context: SERMON_GLOSSARY,
        languageHints: ['cs'],
        onStateChange: (state) => (sonioxState.value = state),
        onError: (message) => (sonioxError.value = message),
        onTokens: (tokens) => {
            const { original, translation } = splitTokens(tokens);
            handleLang('cs', original);
            handleLang('en', translation);
        },
    });
    void session.connect();
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
    session?.finalize();

    for (const [lang, aggregator] of aggregators) {
        const event = aggregator.flush();

        if (event) {
            publish(event);
            previews[lang] = event;
        }
    }

    session?.close();
    session = null;
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
});

onUnmounted(() => {
    stopAudio();

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
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs"
                    >👂 {{ listenerCount }}</span
                >
            </header>

            <p
                v-if="!isSupabaseConfigured"
                class="rounded-lg bg-amber-500/15 px-4 py-3 text-sm text-amber-300"
            >
                Chybí VITE_SUPABASE_URL / VITE_SUPABASE_ANON_KEY — překlad se
                nespustí.
            </p>

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
                    <span class="text-neutral-400">Audio vstup</span>
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
                <div class="flex flex-wrap gap-2 text-xs">
                    <span
                        class="rounded-full px-2.5 py-1"
                        :class="
                            sonioxState === 'open'
                                ? 'bg-emerald-500/20 text-emerald-300'
                                : 'bg-red-500/20 text-red-300'
                        "
                    >
                        Soniox cs→en: {{ sonioxState }}
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
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="mb-2 text-xs font-semibold text-neutral-400">
                        🇨🇿 Čeština
                    </p>
                    <p class="text-sm leading-relaxed">
                        {{ previews.cs?.final }}
                        <span class="text-neutral-500 italic">{{
                            previews.cs?.partial
                        }}</span>
                    </p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="mb-2 text-xs font-semibold text-neutral-400">
                        🇬🇧 English
                    </p>
                    <p class="text-sm leading-relaxed">
                        {{ previews.en?.final }}
                        <span class="text-neutral-500 italic">{{
                            previews.en?.partial
                        }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
