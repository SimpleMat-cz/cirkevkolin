<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useLocalStorage } from '@vueuse/core';
import { ArrowDown, Languages } from 'lucide-vue-next';
import {
    computed,
    nextTick,
    onMounted,
    onUnmounted,
    reactive,
    ref,
    watch,
} from 'vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import {
    ENABLED_LANGUAGES,
    UI_STRINGS,
    langOption,
} from '@/lib/preklad/languages';
import type {
    CaptionEvent,
    CaptionLang,
    SessionInfo,
} from '@/lib/preklad/types';
import { getSupabase, isSupabaseConfigured } from '@/lib/supabase';

type Phase = 'loading' | 'no-session' | 'live';

const MAX_SEGMENTS = 50;
const FONT_STEPS = ['text-xl', 'text-3xl', 'text-4xl'] as const;

const phase = ref<Phase>('loading');
const session = ref<SessionInfo | null>(null);
const sessionId = computed(() => session.value?.id ?? null);

const selectedLang = useLocalStorage<CaptionLang | null>('preklad-lang', null);
const fontStep = useLocalStorage<number>('preklad-font', 0);

const ui = computed(() => UI_STRINGS[selectedLang.value ?? 'cs']);
const showPicker = computed(
    () => phase.value === 'live' && !selectedLang.value,
);

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

const { connectionState, onCaption, leave } = usePrekladChannel(sessionId);

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

    <div class="flex min-h-screen flex-col bg-neutral-950 text-neutral-100">
        <!-- Top bar -->
        <header
            class="flex items-center justify-between border-b border-white/10 px-4 py-3"
        >
            <span class="text-sm font-semibold tracking-wide text-neutral-400"
                >Církev Kolín</span
            >
            <div
                v-if="phase === 'live' && selectedLang"
                class="flex items-center gap-2"
            >
                <button
                    class="rounded-full border border-white/15 px-3 py-1.5 text-sm font-semibold"
                    :aria-label="ui.fontSize"
                    @click="cycleFont"
                >
                    A<span class="text-xs">+</span>
                </button>
                <button
                    class="flex items-center gap-1.5 rounded-full border border-white/15 px-3 py-1.5 text-sm font-semibold"
                    @click="selectedLang = null"
                >
                    <Languages class="h-4 w-4" />
                    {{ langOption(selectedLang).flag }}
                </button>
            </div>
        </header>

        <!-- Loading -->
        <div
            v-if="phase === 'loading'"
            class="flex flex-1 items-center justify-center p-8"
        >
            <div
                class="h-10 w-10 animate-spin rounded-full border-2 border-white/20 border-t-white/80"
            />
        </div>

        <!-- No live session -->
        <div
            v-else-if="phase === 'no-session'"
            class="flex flex-1 flex-col items-center justify-center gap-4 p-8 text-center"
        >
            <p class="text-2xl font-semibold">{{ ui.notLive }}</p>
            <p class="max-w-sm text-neutral-400">{{ ui.notLiveHint }}</p>
            <a
                href="/"
                class="mt-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold hover:bg-white/20"
            >
                {{ ui.churchSite }}
            </a>
            <p
                v-if="!isSupabaseConfigured"
                class="mt-4 text-xs text-amber-400/80"
            >
                Supabase není nakonfigurován (chybí VITE_SUPABASE_URL /
                VITE_SUPABASE_ANON_KEY).
            </p>
        </div>

        <!-- Language picker -->
        <div
            v-else-if="showPicker"
            class="flex flex-1 flex-col items-center justify-center gap-6 p-6"
        >
            <h1 class="text-center text-xl font-semibold text-neutral-300">
                {{ UI_STRINGS.en.chooseLanguage }}
            </h1>
            <div class="grid w-full max-w-md gap-3">
                <button
                    v-for="lang in ENABLED_LANGUAGES"
                    :key="lang.code"
                    class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-left transition-colors hover:bg-white/10"
                    @click="chooseLanguage(lang.code)"
                >
                    <span class="text-3xl">{{ lang.flag }}</span>
                    <span class="text-lg font-semibold">{{
                        lang.nativeName
                    }}</span>
                </button>
            </div>
        </div>

        <!-- Captions -->
        <div v-else class="relative flex flex-1 flex-col overflow-hidden">
            <div
                v-if="
                    connectionState === 'reconnecting' ||
                    connectionState === 'connecting'
                "
                class="bg-amber-500/20 py-1.5 text-center text-xs text-amber-200"
            >
                {{ ui.connecting }}
            </div>

            <div
                ref="scrollEl"
                class="flex-1 space-y-4 overflow-y-auto px-5 py-6 leading-relaxed"
                @scroll="onScroll"
            >
                <p
                    v-for="seg in segments"
                    :key="seg.seq"
                    :class="FONT_STEPS[fontStep]"
                >
                    <span>{{ seg.final }}</span>
                    <span v-if="seg.partial" class="text-neutral-500 italic">
                        {{ seg.partial }}</span
                    >
                </p>
                <p
                    v-if="segments.length === 0"
                    class="text-center text-neutral-600"
                >
                    …
                </p>
            </div>

            <button
                v-if="!autoScroll"
                class="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-1.5 rounded-full bg-white px-4 py-2 text-sm font-semibold text-neutral-900 shadow-lg"
                @click="jumpToLive"
            >
                <ArrowDown class="h-4 w-4" />
                {{ ui.liveButton }}
            </button>
        </div>
    </div>
</template>
