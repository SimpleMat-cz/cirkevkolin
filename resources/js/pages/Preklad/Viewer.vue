<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useLocalStorage } from '@vueuse/core';
import { ArrowDown, Languages, Type } from 'lucide-vue-next';
import {
    computed,
    nextTick,
    onMounted,
    onUnmounted,
    reactive,
    ref,
    watch,
} from 'vue';
import Blob from '@/components/Blob.vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import { LANGUAGES, langOption, UI_STRINGS } from '@/lib/preklad/languages';
import type {
    CaptionEvent,
    CaptionLang,
    SessionInfo,
} from '@/lib/preklad/types';
import { getSupabase, isSupabaseConfigured } from '@/lib/supabase';

type Phase = 'loading' | 'no-session' | 'live';

const MAX_SEGMENTS = 50;
const FONT_STEPS = ['text-2xl', 'text-3xl', 'text-4xl'] as const;

const phase = ref<Phase>('loading');
const session = ref<SessionInfo | null>(null);
const sessionId = computed(() => session.value?.id ?? null);

const selectedLang = useLocalStorage<CaptionLang | null>('preklad-lang', null);
const fontStep = useLocalStorage<number>('preklad-font', 0);

const ui = computed(() => UI_STRINGS[selectedLang.value ?? 'cs']);
const showPicker = computed(
    () => phase.value === 'live' && !selectedLang.value,
);

/** On-demand: hostovi nabízíme všechny jazyky; překlad se spustí, až si vybere. */
const offeredLanguages = LANGUAGES;

/** Captions kept per language so switching languages preserves what arrived. */
const byLang = reactive<Record<string, Map<number, CaptionEvent>>>({});

const segments = computed<CaptionEvent[]>(() => {
    const lang = selectedLang.value;

    if (!lang || !byLang[lang]) {
        return [];
    }

    return [...byLang[lang].values()]
        .sort((a, b) => a.seq - b.seq)
        .slice(-MAX_SEGMENTS);
});

const { connectionState, onCaption, trackPresence, leave } =
    usePrekladChannel(sessionId);

onCaption((payload) => {
    if (!byLang[payload.lang]) {
        byLang[payload.lang] = new Map();
    }

    byLang[payload.lang].set(payload.seq, payload);
    const map = byLang[payload.lang];

    if (map.size > MAX_SEGMENTS * 2) {
        const oldest = [...map.keys()]
            .sort((a, b) => a - b)
            .slice(0, map.size - MAX_SEGMENTS);

        for (const key of oldest) {
            map.delete(key);
        }
    }

    if (payload.lang === selectedLang.value) {
        maybeAutoScroll();
    }
});

// Whenever a session is live and the guest has a language chosen, announce it
// via presence so the broadcaster spins that language's translation up.
watch(
    [phase, selectedLang],
    () => {
        if (phase.value === 'live' && selectedLang.value) {
            trackPresence(selectedLang.value);
        }
    },
    { immediate: true },
);

// --- session discovery ----------------------------------------------------

let pollTimer: ReturnType<typeof setInterval> | null = null;

async function loadActiveSession(): Promise<void> {
    const supabase = getSupabase();

    if (!supabase) {
        phase.value = 'no-session';

        return;
    }

    const { data } = await supabase
        .from('sermon_sessions')
        .select('id, title, status')
        .eq('status', 'live')
        .order('started_at', { ascending: false })
        .limit(1)
        .maybeSingle();

    if (data) {
        session.value = data as SessionInfo;
        phase.value = 'live';
    } else if (phase.value !== 'live') {
        phase.value = 'no-session';
    }
}

// --- auto-scroll ----------------------------------------------------------

const scrollEl = ref<HTMLElement | null>(null);
const autoScroll = ref(true);

function maybeAutoScroll(): void {
    if (!autoScroll.value) {
        return;
    }

    void nextTick(() => {
        const el = scrollEl.value;

        if (el) {
            el.scrollTop = el.scrollHeight;
        }
    });
}

function onScroll(): void {
    const el = scrollEl.value;

    if (!el) {
        return;
    }

    const atBottom = el.scrollHeight - el.scrollTop - el.clientHeight < 80;
    autoScroll.value = atBottom;
}

function jumpToLive(): void {
    autoScroll.value = true;
    maybeAutoScroll();
}

function cycleFont(): void {
    fontStep.value = (fontStep.value + 1) % FONT_STEPS.length;
}

function chooseLanguage(code: CaptionLang): void {
    selectedLang.value = code;
    void nextTick(maybeAutoScroll);
}

watch(selectedLang, () => {
    autoScroll.value = true;
    maybeAutoScroll();
});

onMounted(() => {
    void loadActiveSession();
    pollTimer = setInterval(loadActiveSession, 12000);
});

onUnmounted(() => {
    if (pollTimer) {
        clearInterval(pollTimer);
    }

    leave();
});
</script>

<template>
    <Head>
        <title>Živý překlad — Církev Kolín</title>
        <meta name="robots" content="noindex" />
    </Head>

    <div
        class="relative flex min-h-screen flex-col overflow-hidden bg-brand-cream text-brand-ink"
    >
        <Blob
            color="#ff8c69"
            :size="320"
            variant="2"
            float="slow"
            :opacity="0.5"
            class="-top-24 -right-24"
        />
        <Blob
            color="#4db6ac"
            :size="240"
            variant="3"
            float="none"
            :opacity="0.35"
            class="-bottom-20 -left-16"
        />

        <!-- Top bar -->
        <header
            class="relative z-10 flex items-center justify-between border-b border-brand-ink/10 px-4 py-3 backdrop-blur-sm"
        >
            <span
                class="font-display text-lg tracking-tight text-brand-ink lowercase"
                >církev kolín</span
            >
            <div
                v-if="phase === 'live' && selectedLang"
                class="flex items-center gap-2"
            >
                <button
                    class="flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-sm font-semibold text-brand-ink shadow-sm ring-1 ring-brand-ink/5 transition-colors hover:bg-brand-cream-deep"
                    :aria-label="ui.fontSize"
                    @click="cycleFont"
                >
                    <Type class="h-4 w-4" />
                </button>
                <button
                    class="flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-sm font-semibold text-brand-ink shadow-sm ring-1 ring-brand-ink/5 transition-colors hover:bg-brand-cream-deep"
                    @click="selectedLang = null"
                >
                    <Languages class="h-4 w-4 text-brand-coral" />
                    {{ langOption(selectedLang).flag }}
                </button>
            </div>
        </header>

        <!-- Loading -->
        <div
            v-if="phase === 'loading'"
            class="relative z-10 flex flex-1 items-center justify-center p-8"
        >
            <div
                class="h-10 w-10 animate-spin rounded-full border-2 border-brand-coral/30 border-t-brand-coral"
            />
        </div>

        <!-- No live session -->
        <div
            v-else-if="phase === 'no-session'"
            class="relative z-10 flex flex-1 flex-col items-center justify-center gap-5 p-8 text-center"
        >
            <span class="text-5xl">🕊️</span>
            <h1 class="font-display text-3xl text-brand-ink sm:text-4xl">
                {{ ui.notLive }}
            </h1>
            <p class="max-w-sm text-lg text-brand-ink-soft">
                {{ ui.notLiveHint }}
            </p>
            <a
                href="/"
                class="mt-2 inline-flex items-center rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-coral-dark"
            >
                {{ ui.churchSite }}
            </a>
            <p
                v-if="!isSupabaseConfigured"
                class="mt-4 text-xs text-brand-coral-dark"
            >
                Supabase není nakonfigurován (chybí VITE_SUPABASE_URL /
                VITE_SUPABASE_ANON_KEY).
            </p>
        </div>

        <!-- Language picker -->
        <div
            v-else-if="showPicker"
            class="relative z-10 flex flex-1 flex-col items-center justify-center gap-8 p-6"
        >
            <div class="text-center">
                <span
                    class="text-xs font-bold tracking-[0.2em] text-brand-coral uppercase"
                    >Live translation</span
                >
                <h1
                    class="mt-2 font-display text-3xl text-brand-ink sm:text-4xl"
                >
                    {{ UI_STRINGS.en.chooseLanguage }}
                </h1>
                <p class="mt-1 text-brand-ink-soft">Vyber si jazyk</p>
            </div>
            <div class="grid w-full max-w-md gap-3">
                <button
                    v-for="lang in offeredLanguages"
                    :key="lang.code"
                    class="hover-lift flex items-center gap-4 rounded-3xl bg-white px-5 py-4 text-left shadow-sm ring-1 ring-brand-ink/5 transition-all hover:ring-brand-coral/40"
                    @click="chooseLanguage(lang.code)"
                >
                    <span class="text-3xl">{{ lang.flag }}</span>
                    <span class="text-lg font-semibold text-brand-ink">{{
                        lang.nativeName
                    }}</span>
                </button>
            </div>
        </div>

        <!-- Captions -->
        <div v-else class="relative z-10 flex flex-1 flex-col overflow-hidden">
            <div
                v-if="
                    connectionState === 'reconnecting' ||
                    connectionState === 'connecting'
                "
                class="bg-brand-sunny/30 py-1.5 text-center text-xs font-medium text-brand-ink/70"
            >
                {{ ui.connecting }}
            </div>

            <div
                ref="scrollEl"
                class="flex-1 space-y-4 overflow-y-auto px-4 py-6 sm:px-6"
                @scroll="onScroll"
            >
                <p
                    v-for="seg in segments"
                    :key="seg.seq"
                    :class="FONT_STEPS[fontStep]"
                    class="leading-relaxed font-medium text-brand-ink"
                >
                    <span>{{ seg.final }}</span>
                    <span v-if="seg.partial" class="text-brand-ink/45 italic">
                        {{ seg.partial }}</span
                    >
                </p>
                <div
                    v-if="segments.length === 0"
                    class="flex flex-col items-center gap-3 pt-16 text-center text-brand-ink/40"
                >
                    <div
                        class="h-8 w-8 animate-spin rounded-full border-2 border-brand-coral/30 border-t-brand-coral"
                    />
                    <p class="text-sm">{{ ui.connecting }}</p>
                </div>
            </div>

            <button
                v-if="!autoScroll"
                class="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-1.5 rounded-full bg-brand-coral px-4 py-2 text-sm font-semibold text-white shadow-lg transition-colors hover:bg-brand-coral-dark"
                @click="jumpToLive"
            >
                <ArrowDown class="h-4 w-4" />
                {{ ui.liveButton }}
            </button>
        </div>
    </div>
</template>
