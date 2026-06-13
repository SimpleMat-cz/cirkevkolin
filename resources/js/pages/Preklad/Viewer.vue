<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useLocalStorage } from '@vueuse/core';
import { ChevronDown, Languages, Search, Type } from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, reactive, ref, watch } from 'vue';
import Blob from '@/components/Blob.vue';
import { usePrekladChannel } from '@/composables/usePrekladChannel';
import {
    EXTENDED_LANGUAGES,
    FAVORITE_LANGUAGES,
    langOption,
    uiFor,
} from '@/lib/preklad/languages';
import type {
    CaptionEvent,
    CaptionLang,
    SessionInfo,
} from '@/lib/preklad/types';
import { getSupabase, isSupabaseConfigured } from '@/lib/supabase';

type Phase = 'loading' | 'no-session' | 'live';

const MAX_SEGMENTS = 50;
/** Kolik posledních vět teleprompter drží na obrazovce (zbytek odplyne nahoru). */
const VISIBLE_SEGMENTS = 6;
/** Session je živá jen s čerstvým heartbeatem — jinak (zavřený panel) ji pustíme. */
const FRESH_MS = 35000;
const FONT_STEPS = ['text-2xl', 'text-3xl', 'text-4xl'] as const;

const phase = ref<Phase>('loading');
const session = ref<SessionInfo | null>(null);
const sessionId = computed(() => session.value?.id ?? null);

const selectedLang = useLocalStorage<CaptionLang | null>('preklad-lang', null);
const fontStep = useLocalStorage<number>('preklad-font', 1);

const ui = computed(() => uiFor(selectedLang.value));
const showPicker = computed(
    () => phase.value === 'live' && !selectedLang.value,
);

const showAllLanguages = ref(false);
const langQuery = ref('');
const filteredExtended = computed(() => {
    const q = langQuery.value.trim().toLowerCase();

    if (!q) {
        return EXTENDED_LANGUAGES;
    }

    return EXTENDED_LANGUAGES.filter(
        (l) =>
            l.nativeName.toLowerCase().includes(q) ||
            l.code.toLowerCase().includes(q),
    );
});

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

/** Jen posledních pár vět — teleprompter ukotvený dole, bez scrollování. */
const visibleSegments = computed<CaptionEvent[]>(() =>
    segments.value.slice(-VISIBLE_SEGMENTS),
);

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

    let result = await supabase
        .from('sermon_sessions')
        .select('id, title, status, last_seen_at')
        .eq('status', 'live')
        .order('started_at', { ascending: false })
        .limit(1)
        .maybeSingle();

    if (result.error && /last_seen_at/i.test(result.error.message)) {
        // Sloupec heartbeat ještě nemusí v DB existovat (před migrací).
        result = await supabase
            .from('sermon_sessions')
            .select('id, title, status')
            .eq('status', 'live')
            .order('started_at', { ascending: false })
            .limit(1)
            .maybeSingle();
    }

    const data = result.data as SessionInfo | null;
    const fresh =
        !!data &&
        (!data.last_seen_at ||
            Date.now() - new Date(data.last_seen_at).getTime() < FRESH_MS);

    if (data && fresh) {
        session.value = data;
        phase.value = 'live';
    } else {
        session.value = null;
        phase.value = 'no-session';
    }
}

function cycleFont(): void {
    fontStep.value = (fontStep.value + 1) % FONT_STEPS.length;
}

function chooseLanguage(code: CaptionLang): void {
    selectedLang.value = code;
}

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
        class="relative flex h-[100dvh] flex-col overflow-hidden bg-brand-cream text-brand-ink"
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
            <div class="flex items-baseline gap-2">
                <span
                    class="font-display text-lg tracking-tight text-brand-ink lowercase"
                    >církev kolín</span
                >
                <span class="text-sm font-semibold text-brand-coral">{{
                    ui.tagline
                }}</span>
            </div>
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
            class="relative z-10 flex flex-1 flex-col items-center overflow-y-auto px-6 py-8"
        >
            <div class="w-full max-w-md">
                <div class="text-center">
                    <span
                        class="text-xs font-bold tracking-[0.2em] text-brand-coral uppercase"
                        >Live translation</span
                    >
                    <h1
                        class="mt-2 font-display text-3xl text-brand-ink sm:text-4xl"
                    >
                        {{ uiFor('en').chooseLanguage }}
                    </h1>
                    <p class="mt-1 text-brand-ink-soft">Vyber si jazyk</p>
                </div>

                <div class="mt-6 grid gap-3">
                    <button
                        v-for="lang in FAVORITE_LANGUAGES"
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

                <!-- Rozšířený výběr -->
                <button
                    class="mt-3 flex w-full items-center justify-center gap-1.5 rounded-2xl px-4 py-3 text-sm font-semibold text-brand-ink-soft transition-colors hover:bg-white/60"
                    @click="showAllLanguages = !showAllLanguages"
                >
                    {{ ui.moreLanguages }}
                    <ChevronDown
                        class="h-4 w-4 transition-transform"
                        :class="{ 'rotate-180': showAllLanguages }"
                    />
                </button>

                <div v-if="showAllLanguages" class="mt-2">
                    <div class="relative">
                        <Search
                            class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-brand-ink/40"
                        />
                        <input
                            v-model="langQuery"
                            type="text"
                            placeholder="Hledat jazyk…"
                            class="w-full rounded-2xl border border-brand-ink/10 bg-white py-2.5 pr-3 pl-9 text-sm text-brand-ink focus:border-brand-coral focus:ring-2 focus:ring-brand-coral/20 focus:outline-none"
                        />
                    </div>
                    <div class="mt-2 grid max-h-72 gap-2 overflow-y-auto pr-1">
                        <button
                            v-for="lang in filteredExtended"
                            :key="lang.code"
                            class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-left ring-1 ring-brand-ink/5 transition-colors hover:bg-brand-cream-deep"
                            @click="chooseLanguage(lang.code)"
                        >
                            <span class="text-2xl">{{ lang.flag }}</span>
                            <span class="font-medium text-brand-ink">{{
                                lang.nativeName
                            }}</span>
                        </button>
                        <p
                            v-if="filteredExtended.length === 0"
                            class="py-4 text-center text-sm text-brand-ink/40"
                        >
                            Nic nenalezeno.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Captions — teleprompter: ukotveno dole, mění se samo, bez scrollu -->
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
                v-if="visibleSegments.length === 0"
                class="flex flex-1 flex-col items-center justify-center gap-3 text-center text-brand-ink/40"
            >
                <div
                    class="h-8 w-8 animate-spin rounded-full border-2 border-brand-coral/30 border-t-brand-coral"
                />
                <p class="text-sm">{{ ui.connecting }}</p>
            </div>

            <transition-group
                v-else
                tag="div"
                name="caption"
                class="preklad-stream flex flex-1 flex-col justify-end gap-3 overflow-hidden px-5 py-8 sm:px-8"
            >
                <p
                    v-for="(seg, i) in visibleSegments"
                    :key="seg.seq"
                    :class="[
                        FONT_STEPS[fontStep],
                        i === visibleSegments.length - 1
                            ? 'text-brand-ink'
                            : 'text-brand-ink/45',
                    ]"
                    class="leading-snug font-semibold transition-colors duration-500"
                >
                    <span>{{ seg.final }}</span>
                    <span v-if="seg.partial" class="text-brand-ink/40 italic">
                        {{ seg.partial }}</span
                    >
                </p>
            </transition-group>
        </div>
    </div>
</template>

<style scoped>
/* Horní okraj toku titulků plynule mizí — staré věty se „rozplynou" nahoře. */
.preklad-stream {
    -webkit-mask-image: linear-gradient(
        to bottom,
        transparent 0,
        rgba(0, 0, 0, 0.35) 14%,
        black 38%
    );
    mask-image: linear-gradient(
        to bottom,
        transparent 0,
        rgba(0, 0, 0, 0.35) 14%,
        black 38%
    );
}

/* Nová věta naskočí zespodu, ostatní se plynule posunou nahoru. */
.caption-enter-active {
    transition:
        opacity 0.45s ease,
        transform 0.45s ease;
}

.caption-enter-from {
    opacity: 0;
    transform: translateY(12px);
}

.caption-move {
    transition: transform 0.45s ease;
}

@media (prefers-reduced-motion: reduce) {
    .caption-enter-active,
    .caption-move {
        transition: none;
    }
}
</style>
