<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { renderSVG } from 'uqr';
import { computed } from 'vue';
import Blob from '@/components/Blob.vue';
import { FAVORITE_LANGUAGES, UNDERSTAND_INVITE } from '@/lib/preklad/languages';

/** Veřejná adresa živého přepisu — co host po naskenování QR otevře. */
const TARGET_PATH = '/preklad';

const targetUrl = computed(() => {
    const origin =
        typeof window !== 'undefined'
            ? window.location.origin
            : 'https://cirkevkolin.vercel.app';

    return `${origin}${TARGET_PATH}`;
});

/** Adresa pod QR — odvozená ze stejného originu jako QR (i na vlastní doméně). */
const displayUrl = computed(() => targetUrl.value.replace(/^https?:\/\//, ''));

/** Lokálně generované SVG QR — žádný externí požadavek, bezpečné pro v-html. */
const qrSvg = computed(() =>
    renderSVG(targetUrl.value, {
        ecc: 'M',
        border: 2,
        whiteColor: '#ffffff',
        blackColor: '#2a2a2a',
    }),
);

interface CardInvite {
    code: string;
    flag: string;
    text: string;
}

interface CardConfig {
    key: string;
    title: string;
    subtitle: string;
    message: string;
    note?: string;
    chips: { code: string; flag: string; nativeName: string }[];
    invites: CardInvite[];
}

/** Cizojazyčné oblíbené (bez češtiny) — pro kartičku „Špatně rozumíte?". */
const foreignFavorites = FAVORITE_LANGUAGES.filter((l) => l.code !== 'cs');

const understandInvites: CardInvite[] = foreignFavorites
    .filter((lang) => UNDERSTAND_INVITE[lang.code])
    .map((lang) => ({
        code: lang.code,
        flag: lang.flag,
        text: UNDERSTAND_INVITE[lang.code],
    }));

/**
 * Dvě různé kartičky na jeden list A4:
 *  1. „Špatně slyšíte?" — pro Čechy, kteří hůř slyší (živý přepis v češtině).
 *  2. „Špatně rozumíte?" — pro cizince (živý překlad do jejich jazyka).
 */
const cards: CardConfig[] = [
    {
        key: 'hearing',
        title: 'Špatně slyšíte?',
        subtitle: 'Pro všechny, kdo hůř slyší',
        message:
            'Naskenujte QR kód a čtěte živý přepis kázání přímo ve svém telefonu.',
        note: '🇨🇿 Přepis běží v češtině, slovo po slovu.',
        chips: [],
        invites: [],
    },
    {
        key: 'understand',
        title: 'Špatně rozumíte?',
        subtitle:
            "Don't understand Czech? · Не розумієте? · Nie rozumiesz? · Не понимаете?",
        message:
            'Scan the QR code and read a live translation of the sermon in your own language.',
        chips: foreignFavorites,
        invites: understandInvites,
    },
];

function handlePrint(): void {
    window.print();
}
</script>

<template>
    <div
        class="relative min-h-screen overflow-hidden bg-brand-cream px-4 py-8 text-brand-ink print:min-h-0 print:bg-white print:p-0"
    >
        <Head title="Kartičky — živý přepis a překlad">
            <meta name="robots" content="noindex" />
        </Head>

        <Blob
            color="#ff8c69"
            :size="360"
            :variant="2"
            :opacity="0.12"
            float="slow"
            class="-top-24 -left-24 print:hidden"
        />
        <Blob
            color="#4db6ac"
            :size="300"
            :variant="3"
            :opacity="0.1"
            float="slow"
            class="-right-20 bottom-10 print:hidden"
        />

        <div class="relative mx-auto max-w-md">
            <div class="mb-6 flex flex-col items-center gap-2 print:hidden">
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-brand-coral px-6 py-3 font-display text-sm tracking-wide text-white shadow-sm transition hover:bg-brand-coral-dark focus-visible:ring-2 focus-visible:ring-brand-coral/50 focus-visible:ring-offset-2 focus-visible:ring-offset-brand-cream focus-visible:outline-none"
                    @click="handlePrint"
                >
                    <svg
                        class="size-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M6 9V2h12v7" />
                        <path
                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"
                        />
                        <path d="M6 14h12v8H6z" />
                    </svg>
                    Vytisknout obě kartičky
                </button>
                <p class="text-xs text-brand-ink-soft">
                    Dvě kartičky na jeden list A4 — rozstřihněte uprostřed.
                </p>
            </div>

            <div class="cut-sheet space-y-6 print:space-y-0">
                <article
                    v-for="(card, i) in cards"
                    :key="card.key"
                    class="card-copy rounded-3xl bg-white p-6 shadow-sm ring-1 ring-brand-ink/5 print:break-inside-avoid print:shadow-none print:ring-0"
                    :class="i === 0 ? 'card-cut-top' : ''"
                >
                    <header class="text-center">
                        <p
                            class="font-display text-xs tracking-[0.2em] text-brand-coral lowercase"
                        >
                            církev kolín
                        </p>
                        <h1
                            class="mt-3 font-display text-3xl leading-tight text-brand-ink"
                        >
                            {{ card.title }}
                        </h1>
                        <p class="mt-1 text-sm text-brand-ink-soft">
                            {{ card.subtitle }}
                        </p>
                    </header>

                    <div class="mt-5 flex flex-col items-center">
                        <div
                            class="rounded-2xl bg-white p-3 ring-1 ring-brand-ink/10 print:ring-brand-ink/20"
                        >
                            <!-- eslint-disable-next-line vue/no-v-html -- QR SVG je generován lokálně knihovnou uqr, žádný uživatelský vstup -->
                            <div
                                class="size-40 [&>svg]:size-full"
                                v-html="qrSvg"
                            />
                        </div>
                        <p
                            class="mt-3 max-w-[18rem] text-center text-sm leading-snug text-brand-ink"
                        >
                            {{ card.message }}
                        </p>
                        <p
                            v-if="card.note"
                            class="mt-2 text-center text-xs text-brand-ink-soft"
                        >
                            {{ card.note }}
                        </p>
                        <p
                            class="mt-2 font-mono text-xs tracking-tight text-brand-ink-soft"
                        >
                            {{ displayUrl }}
                        </p>
                    </div>

                    <ul
                        v-if="card.chips.length"
                        class="mt-5 flex flex-wrap justify-center gap-1.5"
                        aria-label="Dostupné jazyky"
                    >
                        <li
                            v-for="lang in card.chips"
                            :key="lang.code"
                            class="inline-flex items-center gap-1.5 rounded-full bg-brand-cream-deep px-2.5 py-1 text-xs text-brand-ink print:bg-brand-cream"
                        >
                            <span aria-hidden="true">{{ lang.flag }}</span>
                            <span>{{ lang.nativeName }}</span>
                        </li>
                    </ul>

                    <ul
                        v-if="card.invites.length"
                        class="mt-5 space-y-1 border-t border-brand-ink/5 pt-4"
                    >
                        <li
                            v-for="invite in card.invites"
                            :key="invite.code"
                            class="flex items-start gap-2 text-[0.7rem] leading-snug text-brand-ink-soft"
                        >
                            <span aria-hidden="true" class="shrink-0">{{
                                invite.flag
                            }}</span>
                            <span>{{ invite.text }}</span>
                        </li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media print {
    /* Dvě kartičky na výšku A4, s místem na rozstřižení mezi nimi. */
    @page {
        margin: 12mm;
    }

    .cut-sheet {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: calc(297mm - 24mm);
    }

    .card-copy {
        background: #ffffff;
        page-break-inside: avoid;
    }

    /* Čárkovaná linka řezu mezi oběma kartičkami. */
    .card-cut-top {
        position: relative;
        margin-bottom: 8mm;
        padding-bottom: 8mm;
        border-bottom: 1px dashed #b9b2a0;
    }
}
</style>
