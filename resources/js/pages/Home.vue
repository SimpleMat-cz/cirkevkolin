<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import SermonCard from '@/components/SermonCard.vue'
import EventCard from '@/components/EventCard.vue'
import { computed, ref } from 'vue'
import { Calendar, Coffee, Heart, Users, Sparkles, Play, ArrowRight, MapPin, Youtube, ChevronDown, Film, Mountain, Sun, Briefcase, Flame } from 'lucide-vue-next'

const jsonLd = JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'ReligiousOrganization',
    name: 'Apoštolská církev Kolín',
    alternateName: 'církev kolín',
    url: 'https://www.cirkevkolin.cz',
    logo: 'https://www.cirkevkolin.cz/favicon.svg',
    email: 'kolin@apostolskacirkev.cz',
    address: {
        '@type': 'PostalAddress',
        streetAddress: 'V Zídkách 402',
        addressLocality: 'Kolín',
        postalCode: '280 02',
        addressCountry: 'CZ',
    },
    openingHours: 'Su 10:00-11:30',
    sameAs: [
        'https://www.facebook.com/cirkevkolin',
        'https://www.instagram.com/cirkevkolin',
        'https://www.youtube.com/channel/UCnsKOpdlWx4wS0mos_PXfDg',
    ],
})

const props = defineProps<{
    latestSermons: Array<{
        id: number
        title: string
        slug: string
        description?: string
        thumbnail_url?: string
        published_at?: string
        duration_seconds?: number
        speaker?: { name: string }
        series?: { title: string }
    }>
    upcomingEvents: Array<{
        id: number
        title: string
        slug: string
        description?: string
        starts_at: string
        ends_at?: string
        category?: string
        location?: string
    }>
}>()

const heroSermon = computed(() => props.latestSermons?.[0])

function formatHeroDate(date?: string): string {
    if (!date) {
        return ''
    }
    return new Date(date).toLocaleDateString('cs-CZ', { day: 'numeric', month: 'long', year: 'numeric' })
}

function formatDuration(seconds?: number): string {
    if (!seconds) {
        return ''
    }
    return `${Math.floor(seconds / 60)} min`
}

const whatToExpect = [
    { icon: Calendar, title: 'Začínáme v 10:00', text: 'Každou neděli. Chvály, krátké kázání, modlitby — trvá to kolem 90 minut.' },
    { icon: Users, title: 'Program pro děti', text: 'Kidztown pro nejmenší, WyldLife pro starší. Rodiče si sednou a poslouchají.' },
    { icon: Coffee, title: 'Káva a pohoda po', text: 'Po každé neděli zůstáváme, povídáme a sdílíme. Tohle je ta nejlepší část.' },
]

const audiences = [
    { emoji: '👨‍👩‍👧', color: 'bg-brand-coral/15', title: 'Rodiny', text: 'Prostor pro každého — od nejmenšího po nejstaršího.' },
    { emoji: '🧒', color: 'bg-brand-mint/25', title: 'Děti • Kidztown', text: 'Batolata mají svůj program každý čtvrtek i v neděli.' },
    { emoji: '🏄', color: 'bg-brand-sunny/30', title: 'Mládež • WyldLife', text: 'Klub pro 10–13 leté, středa 16:30–18:00.' },
    { emoji: '🧑', color: 'bg-brand-teal/20', title: 'Dospělí', text: 'Lidé hledající komunitu, smysl nebo prostě dobrou kávu.' },
]

// Další akce, co u nás během roku probíhají (rozklikávací sekce)
const otherEvents = [
    { icon: Flame, color: 'bg-brand-coral/15 text-brand-coral', title: 'Limity', text: 'Mužská skupina, která jde k jádru věci. Vede Martin Fridrich.' },
    { icon: Briefcase, color: 'bg-brand-primary/15 text-brand-primary', title: 'Business chill', text: 'Setkání podnikatelů a manažerů. Sdílíme výzvy, modlíme se za byznys.' },
    { icon: Film, color: 'bg-brand-teal/20 text-brand-teal', title: 'Filmové večery', text: 'Sborový film, popcorn a pak rozhovor o tom, co z toho plyne.' },
    { icon: Mountain, color: 'bg-brand-mint/25 text-brand-teal', title: 'Sborové dovolené', text: 'Jedeme spolu na pár dní — hory, jídlo, hry, modlitby. Ročně.' },
    { icon: Sun, color: 'bg-brand-sunny/30 text-amber-700', title: 'CityCamp', text: 'Příměstský tábor pro děti — léto v Kolíně plné dobrodružství.' },
]

const showOtherEvents = ref(false)

const values = [
    { num: '01', title: 'Učíme se o Ježíši', text: 'Bible, která mluví do dnešního života. Srozumitelně a bez předstírání.' },
    { num: '02', title: 'Milujeme lidi', text: 'Každý je vítaný — ať už jsi teprve hledá nebo věříš celý život.' },
    { num: '03', title: 'Žijeme jako rodina', text: 'Nejsme jen program v neděli. Scházíme se během týdne, pomáháme si.' },
]

const marqueeItems = ['JAKO DOMA', 'POJĎ DÁL', 'BUĎ TU', 'TVŮJ ČAS', 'KAŽDÝ JE VÍTÁN']
</script>

<template>
    <Head>
        <title>církev kolín — jako doma</title>
        <meta name="description" content="Apoštolská církev Kolín. Neděle v 10:00, V Zídkách 402. Otevřená komunita, kde se cítíš jako doma — ať jsi tu poprvé nebo odjakživa." />
        <component :is="'script'" type="application/ld+json" v-html="jsonLd" />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden bg-brand-cream pt-28 pb-16 sm:pt-36 sm:pb-20 lg:pt-40 lg:pb-24">
            <!-- Organic shapes (brand manual style) -->
            <Blob color="#ff8c69" :size="560" variant="2" float="slow" :opacity="0.9" class="-right-32 -top-32" />
            <Blob color="#4db6ac" :size="360" variant="3" float="none" :opacity="0.55" class="-left-24 top-40" />
            <Blob color="#f7d75c" :size="280" variant="4" float="none" :opacity="0.7" class="bottom-20 right-32" />

            <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6">
                <!-- Eyebrow chip -->
                <div class="reveal flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-ink shadow-sm ring-1 ring-brand-ink/5 backdrop-blur">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-coral opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-brand-coral"></span>
                        </span>
                        Neděle 10:00 · živě i online
                    </span>
                </div>

                <!-- Big hero display -->
                <h1 class="reveal reveal-delay-1 mt-6 hero-display text-brand-ink" style="font-size: clamp(3.5rem, 13vw, 11.5rem)">
                    <span class="block">Pojď dál</span>
                    <span class="block text-brand-coral">a buď tu</span>
                    <span class="block whitespace-nowrap text-brand-ink">jako doma.</span>
                </h1>

                <p class="reveal reveal-delay-2 mt-8 max-w-2xl text-lg text-brand-ink-soft sm:text-xl">
                    Otevřená komunita Apoštolské církve v Kolíně. Scházíme se každou neděli v 10:00
                    <span class="font-semibold text-brand-ink">V Zídkách 402</span>. Chvály, slovo, káva, lidi.
                </p>

                <!-- CTA row -->
                <div class="reveal reveal-delay-3 mt-10 flex flex-wrap items-center gap-4">
                    <Link
                        href="/jsem-tu-poprve"
                        class="btn-coral group inline-flex items-center gap-2 rounded-full bg-brand-coral px-8 py-4 text-base font-semibold text-white shadow-[0_12px_30px_-10px_rgba(255,140,105,0.6)] transition-all hover:-translate-y-0.5 hover:bg-brand-coral-dark hover:shadow-[0_18px_36px_-10px_rgba(255,140,105,0.7)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-coral focus-visible:ring-offset-4 focus-visible:ring-offset-brand-cream"
                    >
                        Chci přijít poprvé
                        <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </Link>
                    <Link
                        href="/kazani"
                        class="group inline-flex items-center gap-2 rounded-full border-2 border-brand-ink/20 bg-white/60 px-7 py-3.5 text-base font-semibold text-brand-ink backdrop-blur transition-all hover:border-brand-primary hover:text-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                    >
                        <Play class="h-4 w-4 fill-current" />
                        Poslední kázání
                    </Link>
                </div>

                <!-- Quick facts row -->
                <dl class="reveal reveal-delay-4 mt-16 grid grid-cols-2 gap-6 sm:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-brand-ink/50">Začátek</dt>
                        <dd class="mt-1 font-display text-2xl text-brand-ink">10:00</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-brand-ink/50">Dress code</dt>
                        <dd class="mt-1 font-display text-2xl text-brand-ink">Libovolný</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-brand-ink/50">Děti</dt>
                        <dd class="mt-1 font-display text-2xl text-brand-ink">Postaráme se 👶</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-brand-ink/50">Káva</dt>
                        <dd class="mt-1 font-display text-2xl text-brand-ink">Vždy ☕</dd>
                    </div>
                </dl>
            </div>

        </section>

        <!-- WATCH LIVE / LATEST SERMON -->
        <section class="relative bg-brand-cream pb-16 sm:pb-20 -mt-4 sm:-mt-6">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <Link
                    :href="heroSermon ? `/kazani/${heroSermon.slug}` : '/kazani'"
                    class="reveal hover-lift group block overflow-hidden rounded-3xl bg-white shadow-[0_30px_60px_-30px_rgba(42,42,42,0.25)] ring-1 ring-brand-ink/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                >
                    <div class="grid grid-cols-1 md:grid-cols-[1.7fr_1fr]">
                        <!-- Thumbnail -->
                        <div class="relative aspect-video overflow-hidden bg-brand-ink md:aspect-auto">
                            <img
                                v-if="heroSermon?.thumbnail_url"
                                :src="heroSermon.thumbnail_url"
                                :alt="heroSermon.title"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div v-else class="h-full w-full bg-gradient-to-br from-brand-primary via-brand-teal to-brand-ink" />

                            <!-- Play button -->
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20 transition-colors group-hover:bg-black/40">
                                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-brand-coral text-white shadow-xl transition-transform duration-300 group-hover:scale-110">
                                    <Play class="h-8 w-8 translate-x-0.5 fill-current" />
                                </span>
                            </div>

                        </div>

                        <!-- Info panel -->
                        <div class="flex flex-col justify-center gap-3 p-6 sm:p-8">
                            <!-- "Poslední záznam" badge přesunut MIMO obrázek, do info panelu -->
                            <span class="inline-flex w-max items-center gap-2 rounded-full bg-brand-coral/15 px-3 py-1.5 text-[11px] font-bold uppercase tracking-[0.15em] text-brand-coral">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-coral opacity-75" />
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-brand-coral" />
                                </span>
                                Poslední záznam
                            </span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-ink/40">Pustit hned</span>
                            <h2 class="font-display text-2xl leading-tight text-brand-ink sm:text-3xl">
                                {{ heroSermon?.title ?? 'Podívej se na poslední kázání' }}
                            </h2>
                            <div v-if="heroSermon" class="flex flex-wrap items-center gap-2 text-sm text-brand-ink-soft">
                                <span v-if="heroSermon.speaker" class="font-semibold text-brand-ink">{{ heroSermon.speaker.name }}</span>
                                <span v-if="heroSermon.speaker && heroSermon.published_at" class="text-brand-ink/30">·</span>
                                <span v-if="heroSermon.published_at">{{ formatHeroDate(heroSermon.published_at) }}</span>
                            </div>
                            <p v-else class="text-sm text-brand-ink-soft">
                                Prohlédni si archiv nedělních kázání.
                            </p>
                            <div class="mt-2 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-primary transition-transform group-hover:translate-x-1">
                                Všechna kázání
                                <ArrowRight class="h-4 w-4" />
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </section>

        <!-- MARQUEE BAND -->
        <div class="relative overflow-hidden bg-brand-coral py-6">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-brand-coral to-transparent" />
            <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-brand-coral to-transparent" />

            <div class="flex min-w-max gap-14 marquee-track">
                <template v-for="n in 2" :key="n">
                    <span
                        v-for="item in marqueeItems"
                        :key="`${n}-${item}`"
                        class="flex items-center gap-14 whitespace-nowrap font-display text-xl text-white/95 sm:text-2xl"
                    >
                        {{ item }}
                        <svg class="h-7 w-7 shrink-0 text-brand-sunny" viewBox="-50 -50 100 100" aria-hidden="true">
                            <path
                                d="M22,-37C28,-30,31,-22,34,-13C36,-5,38,5,35,14C33,23,25,32,15,37C5,41,-6,42,-15,38C-25,34,-32,25,-36,15C-39,5,-40,-7,-36,-17C-32,-27,-23,-36,-14,-39C-5,-41,5,-37,14,-36Z"
                                fill="currentColor"
                            />
                        </svg>
                    </span>
                </template>
            </div>
        </div>

        <!-- WHAT TO EXPECT -->
        <section class="relative bg-white py-28 sm:py-36 lg:py-40">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal mx-auto max-w-2xl text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Co tě čeká</span>
                    <h2 class="mt-3 hero-display text-4xl text-brand-ink sm:text-5xl lg:text-6xl">
                        První neděle <br class="hidden sm:block" /> u nás
                    </h2>
                    <p class="mt-6 text-lg text-brand-ink-soft">
                        Víme, že přijít poprvé do kostela může být trochu nervy. Řekneme ti všechno, ať víš, do čeho jdeš.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(card, i) in whatToExpect"
                        :key="card.title"
                        :class="[
                            'reveal hover-lift relative overflow-hidden rounded-3xl bg-brand-cream p-8',
                            `reveal-delay-${i + 1}`,
                        ]"
                    >
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-primary/10 text-brand-primary">
                            <component :is="card.icon" class="h-7 w-7" />
                        </div>
                        <h3 class="mt-6 font-display text-2xl text-brand-ink">{{ card.title }}</h3>
                        <p class="mt-3 leading-relaxed text-brand-ink-soft">{{ card.text }}</p>
                        <div class="pointer-events-none absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-brand-coral/10 transition-transform duration-500 group-hover:scale-150" />
                    </div>
                </div>

                <div class="reveal reveal-delay-4 mt-12 text-center">
                    <Link
                        href="/jsem-tu-poprve"
                        class="inline-flex items-center gap-2 font-semibold text-brand-primary hover:underline"
                    >
                        Celý průvodce pro první návštěvu
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- AUDIENCES -->
        <section class="relative overflow-hidden bg-brand-cream py-28 sm:py-36 lg:py-40">
            <Blob color="#4db6ac" :size="300" variant="2" float="none" :opacity="0.22" class="-left-24 top-20" />
            <Blob color="#f7d75c" :size="240" variant="1" float="none" :opacity="0.28" class="-right-16 bottom-10" />

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Pro koho to děláme</span>
                        <h2 class="mt-3 hero-display text-4xl text-brand-ink sm:text-5xl lg:text-6xl">
                            Každý je tu <br class="hidden sm:block" />
                            <span class="text-brand-primary">vítaný.</span>
                        </h2>
                    </div>
                    <p class="max-w-sm text-brand-ink-soft">
                        Přijdou sem lidé z celého spektra — studenti, rodiny s dětmi, podnikatelé i pensisti. Nikdo není vylučován.
                    </p>
                </div>

                <div class="mt-14 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(group, i) in audiences"
                        :key="group.title"
                        :class="[
                            'reveal hover-lift flex flex-col gap-4 rounded-3xl bg-white p-7 ring-1 ring-brand-ink/5',
                            `reveal-delay-${i + 1}`,
                        ]"
                    >
                        <div :class="['flex h-14 w-14 items-center justify-center rounded-2xl text-3xl', group.color]">
                            <span>{{ group.emoji }}</span>
                        </div>
                        <h3 class="font-display text-xl text-brand-ink">{{ group.title }}</h3>
                        <p class="text-sm leading-relaxed text-brand-ink-soft">{{ group.text }}</p>
                    </div>
                </div>

                <!-- Toggle — další akce přes rok -->
                <div class="reveal mt-10 flex justify-center">
                    <button
                        type="button"
                        class="group inline-flex items-center gap-2 rounded-full border-2 border-brand-ink/10 bg-white px-6 py-3 text-sm font-semibold text-brand-ink transition-all hover:border-brand-primary hover:text-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                        :aria-expanded="showOtherEvents"
                        aria-controls="other-events"
                        @click="showOtherEvents = !showOtherEvents"
                    >
                        {{ showOtherEvents ? 'Schovat další akce' : 'A co ještě během roku?' }}
                        <ChevronDown class="h-4 w-4 transition-transform" :class="{ 'rotate-180': showOtherEvents }" />
                    </button>
                </div>

                <Transition
                    enter-active-class="transition-all duration-500 ease-out"
                    enter-from-class="opacity-0 -translate-y-4"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition-all duration-300 ease-in"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-4"
                >
                    <div
                        v-show="showOtherEvents"
                        id="other-events"
                        class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5"
                    >
                        <div
                            v-for="event in otherEvents"
                            :key="event.title"
                            class="hover-lift flex flex-col gap-3 rounded-2xl bg-white p-6 ring-1 ring-brand-ink/5"
                        >
                            <div :class="['flex h-11 w-11 items-center justify-center rounded-xl', event.color]">
                                <component :is="event.icon" class="h-5 w-5" />
                            </div>
                            <h3 class="font-display text-base text-brand-ink">{{ event.title }}</h3>
                            <p class="text-sm leading-relaxed text-brand-ink-soft">{{ event.text }}</p>
                        </div>
                    </div>
                </Transition>
            </div>
        </section>

        <!-- LATEST SERMONS -->
        <section class="bg-white py-28 sm:py-36 lg:py-40">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Poslouchej</span>
                        <h2 class="mt-3 hero-display text-4xl text-brand-ink sm:text-5xl lg:text-6xl">Nejnovější kázání</h2>
                        <p class="mt-4 max-w-lg text-brand-ink-soft">Každou neděli tu máme nové slovo. Můžeš si ho pustit i zpětně — kdykoliv.</p>
                    </div>
                    <Link
                        href="/kazani"
                        class="group inline-flex items-center gap-2 self-start rounded-full border-2 border-brand-ink/10 px-5 py-2.5 text-sm font-semibold text-brand-ink transition-all hover:border-brand-primary hover:text-brand-primary sm:self-auto"
                    >
                        Všechna kázání
                        <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </Link>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="(sermon, i) in latestSermons" :key="sermon.id" :class="['reveal', `reveal-delay-${(i % 3) + 1}`]">
                        <SermonCard :sermon="sermon" />
                    </div>
                </div>
                <div v-if="!latestSermons.length" class="mt-12 rounded-3xl border-2 border-dashed border-brand-ink/10 bg-brand-cream p-12 text-center text-brand-ink/50">
                    <Youtube class="mx-auto h-12 w-12 text-brand-primary/60" />
                    <p class="mt-4 font-display text-xl">Kázání brzy přibydou</p>
                    <p class="mt-1 text-sm">Mezitím se koukni na náš YouTube kanál.</p>
                </div>
            </div>
        </section>

        <!-- VALUES -->
        <section class="relative overflow-hidden bg-brand-ink py-28 text-white sm:py-36 lg:py-40">
            <Blob color="#ff8c69" :size="400" variant="3" float="slow" :opacity="0.18" class="-right-32 -top-24" />
            <Blob color="#4db6ac" :size="340" variant="4" float="none" :opacity="0.14" class="-left-24 bottom-0" />

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal mx-auto max-w-3xl text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Tři věci, které nás drží</span>
                    <h2 class="mt-4 hero-display text-4xl sm:text-5xl lg:text-6xl">
                        Učíme o Ježíši. <br />
                        Milujeme lidi. <br />
                        <span class="text-brand-primary">Žijeme jako rodina.</span>
                    </h2>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        v-for="(v, i) in values"
                        :key="v.num"
                        :class="['reveal rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur', `reveal-delay-${i + 1}`]"
                    >
                        <div class="font-display text-5xl text-brand-sunny">{{ v.num }}</div>
                        <h3 class="mt-4 font-display text-2xl text-white">{{ v.title }}</h3>
                        <p class="mt-3 leading-relaxed text-white/70">{{ v.text }}</p>
                    </div>
                </div>

                <div class="reveal reveal-delay-4 mt-12 text-center">
                    <Link href="/kdo-jsme" class="inline-flex items-center gap-2 text-sm font-semibold text-white/80 hover:text-white">
                        Přečti si, kdo jsme a čemu věříme
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- UPCOMING EVENTS -->
        <section class="relative overflow-hidden bg-brand-cream py-28 sm:py-36 lg:py-40">
            <Blob color="#ff8c69" :size="240" variant="2" float="none" :opacity="0.28" class="-right-20 top-24" />

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Plán týdne</span>
                        <h2 class="mt-3 hero-display text-4xl text-brand-ink sm:text-5xl lg:text-6xl">Nejbližší akce</h2>
                        <p class="mt-4 max-w-lg text-brand-ink-soft">Neděle je jen začátek. Přes týden jsou skupinky, mládež a dětský klub.</p>
                    </div>
                    <Link
                        href="/akce"
                        class="group inline-flex items-center gap-2 self-start rounded-full border-2 border-brand-ink/10 bg-white px-5 py-2.5 text-sm font-semibold text-brand-ink transition-all hover:border-brand-primary hover:text-brand-primary sm:self-auto"
                    >
                        Celý kalendář
                        <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </Link>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div v-for="(event, i) in upcomingEvents" :key="event.id" :class="['reveal', `reveal-delay-${(i % 3) + 1}`]">
                        <EventCard :event="event" />
                    </div>
                </div>
                <div v-if="!upcomingEvents.length" class="mt-12 rounded-3xl border-2 border-dashed border-brand-ink/10 bg-white p-12 text-center text-brand-ink/50">
                    Žádné plánované akce. Zkontroluj to příští týden!
                </div>
            </div>
        </section>

        <!-- FINAL CTA -->
        <section class="relative overflow-hidden bg-brand-coral py-28 text-white sm:py-40">
            <Blob color="#ffffff" :size="540" variant="2" float="slow" :opacity="0.12" class="-right-40 -top-40" />
            <Blob color="#f7d75c" :size="320" variant="3" float="none" :opacity="0.4" class="-left-20 -bottom-20" />

            <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6">
                <Heart class="reveal mx-auto h-12 w-12 text-white/80" />
                <h2 class="reveal reveal-delay-1 mt-6 hero-display text-5xl sm:text-6xl lg:text-8xl">
                    Vidíme se <br />
                    <span class="text-brand-sunny">v neděli?</span>
                </h2>
                <p class="reveal reveal-delay-2 mx-auto mt-8 max-w-xl text-lg text-white/90 sm:text-xl">
                    V 10:00 ve <span class="font-semibold underline decoration-brand-sunny decoration-4 underline-offset-4">V Zídkách 402</span>, Kolín. Přijď, jak jsi — kavárna je otevřená od 9:30.
                </p>
                <div class="reveal reveal-delay-3 mt-10 flex flex-wrap items-center justify-center gap-4">
                    <Link
                        href="/jsem-tu-poprve"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-brand-coral shadow-xl transition-all hover:-translate-y-0.5 hover:shadow-2xl"
                    >
                        Přijdu poprvé
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                    <a
                        href="https://maps.apple.com/?q=V+Z%C3%ADdk%C3%A1ch+402%2C+Kol%C3%ADn"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full border-2 border-white/40 px-7 py-3.5 text-base font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/10"
                    >
                        <MapPin class="h-4 w-4" />
                        Jak se k nám dostanete
                    </a>
                </div>
            </div>
        </section>

        <!-- APOSTOLIC CHURCH MENTION -->
        <section class="bg-brand-cream py-14">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-ink/40">Součást rodiny</p>
                <p class="mt-3 text-brand-ink-soft">
                    Náš sbor je součástí <a href="https://www.apostolskacirkev.cz" target="_blank" rel="noopener noreferrer" class="font-semibold text-brand-primary hover:underline">Apoštolské církve v ČR</a> —
                    společenství víc než 100 sborů po celé zemi, které sdílí stejné hodnoty, víru a vizi.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
