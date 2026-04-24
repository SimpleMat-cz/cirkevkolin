<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import Blob from '@/components/Blob.vue'
import SermonCard from '@/components/SermonCard.vue'
import EventCard from '@/components/EventCard.vue'
import { Calendar, Music, Coffee, Users, Baby, Bike } from 'lucide-vue-next'

defineProps<{
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
</script>

<template>
    <Head>
        <title>církev kolín — JAKO DOMA</title>
        <meta name="description" content="Apoštolská církev Kolín. Přijďte v neděli v 10:00 do V Zídkách 402, Kolín. Místo, kde se cítíte jako doma." />
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ReligiousOrganization",
            "name": "Apoštolská církev Kolín",
            "alternateName": "církev kolín",
            "url": "https://www.cirkevkolin.cz",
            "logo": "https://www.cirkevkolin.cz/favicon.svg",
            "email": "kolin@apostolskacirkev.cz",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "V Zídkách 402",
                "addressLocality": "Kolín",
                "postalCode": "280 02",
                "addressCountry": "CZ"
            },
            "openingHours": "Su 10:00-11:30",
            "sameAs": [
                "https://www.facebook.com/cirkevkolin",
                "https://www.instagram.com/cirkevkolin",
                "https://www.youtube.com/channel/UCnsKOpdlWx4wS0mos_PXfDg"
            ]
        }
        </script>
    </Head>

    <PublicLayout>
        <!-- Hero -->
        <section class="relative flex min-h-[85vh] items-center justify-center overflow-hidden bg-brand-ink">
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/40" />
            <Blob color="#ff8c69" :size="400" position="top-right" />

            <div class="relative z-10 mx-auto max-w-4xl px-4 text-center sm:px-6">
                <h1
                    class="font-display font-bold uppercase leading-none text-white"
                    style="font-size: clamp(3rem, 8vw, 8rem)"
                >
                    Jako doma
                </h1>
                <p class="mt-6 text-lg text-white/80 sm:text-xl">
                    Neděle v 10:00 — V Zídkách 402, Kolín
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <Link
                        href="/jsem-tu-poprve"
                        class="rounded-full bg-brand-coral px-8 py-3 text-base font-semibold text-white transition-opacity hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    >
                        Chci přijít poprvé
                    </Link>
                    <Link
                        href="/kazani"
                        class="rounded-full border border-white/40 px-8 py-3 text-base font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    >
                        Poslední kázání
                    </Link>
                </div>
            </div>
        </section>

        <!-- Wave oddělovač -->
        <Wave color="#ffffff" :flip="false" />

        <!-- Info pás -->
        <section class="bg-white py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div
                        v-for="card in [
                            { icon: Calendar, title: 'Začínáme v 10:00', text: 'Každou neděli v desét ráno. Trvá to zhruba 90 minut — chvály, kázání, káva.' },
                            { icon: Baby, title: 'Program i pro děti', text: 'Kidztown pro nejmenší, WyldLife pro starší. Rodiče si mohou sednout a opravdu poslouchat.' },
                            { icon: Coffee, title: 'Káva a pohoda po', text: 'Po každé neděli zůstáváme, povídáme a sdílíme. Nejlepší část pro nové lidi.' },
                        ]"
                        :key="card.title"
                        class="flex flex-col items-start gap-3 rounded-2xl bg-brand-cream p-6"
                    >
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-primary/20">
                            <component :is="card.icon" class="h-5 w-5 text-brand-primary-dark" />
                        </div>
                        <h3 class="font-display text-lg font-semibold text-brand-ink">{{ card.title }}</h3>
                        <p class="text-sm leading-relaxed text-brand-ink/60">{{ card.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Wave oddělovač -->
        <Wave color="#f5f5dc" :flip="true" />

        <!-- Pro koho to děláme -->
        <section class="bg-brand-cream py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">Pro koho to děláme</h2>
                <p class="mt-3 text-brand-ink/60">Přijdou sem lidé z celého spektra. Nikdo není vylučován.</p>
                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="group in [
                            { emoji: '👨‍👩‍👧', title: 'Rodiny', text: 'Prostor pro každého — od nejmenšího po nejstaršího.' },
                            { emoji: '🧒', title: 'Děti — Kidztown', text: 'Batolata mají svůj program každý čtvrtek i v neděli.' },
                            { emoji: '🏄', title: 'Mládež — WyldLife', text: 'Klub pro 10–13 leté, středa 16:30–18:00.' },
                            { emoji: '🧑', title: 'Dospělí', text: 'Lidé hledající komunitu, smysl nebo prostě dobrou kávu.' },
                        ]"
                        :key="group.title"
                        class="flex flex-col gap-3 rounded-2xl bg-white p-6 shadow-sm"
                    >
                        <span class="text-3xl">{{ group.emoji }}</span>
                        <h3 class="font-display text-base font-semibold text-brand-ink">{{ group.title }}</h3>
                        <p class="text-sm text-brand-ink/60">{{ group.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Wave oddělovač -->
        <Wave color="#ffffff" :flip="false" />

        <!-- Poslední kázání -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">Kázání</h2>
                        <p class="mt-2 text-brand-ink/60">Poslechněte si, co se u nás děje.</p>
                    </div>
                    <Link href="/kazani" class="text-sm font-medium text-brand-primary-dark hover:underline">
                        Všechna kázání →
                    </Link>
                </div>
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <SermonCard v-for="sermon in latestSermons" :key="sermon.id" :sermon="sermon" />
                </div>
                <div v-if="!latestSermons.length" class="mt-8 text-center text-brand-ink/40">
                    Kázání brzy přibydou.
                </div>
            </div>
        </section>

        <!-- Wave oddělovač -->
        <Wave color="#f5f5dc" :flip="true" />

        <!-- Nejbližší akce -->
        <section class="bg-brand-cream py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">Nejbližší akce</h2>
                        <p class="mt-2 text-brand-ink/60">Co se u nás chystá.</p>
                    </div>
                    <Link href="/akce" class="text-sm font-medium text-brand-primary-dark hover:underline">
                        Celý kalendář →
                    </Link>
                </div>
                <div class="mt-8 flex flex-col gap-3 sm:max-w-2xl">
                    <EventCard v-for="event in upcomingEvents" :key="event.id" :event="event" />
                </div>
                <div v-if="!upcomingEvents.length" class="mt-8 text-brand-ink/40">
                    Žádné akce v nejbližším období.
                </div>
            </div>
        </section>

        <!-- Wave oddělovač -->
        <Wave color="#ffffff" :flip="false" />

        <!-- Jsme součástí Apoštolské církve -->
        <section class="bg-white py-16">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <p class="text-sm font-medium uppercase tracking-wider text-brand-ink/40">Součást rodiny</p>
                <h2 class="mt-2 font-display text-2xl font-bold text-brand-ink">Jsme součástí Apoštolské církve</h2>
                <p class="mt-4 text-brand-ink/60 leading-relaxed">
                    Náš sbor je součástí Apoštolské církve v České republice — společenství více než 100 sborů po celé zemi, které sdílí stejné hodnoty, víru a vizi.
                </p>
                <a
                    href="https://www.apostolskacirkev.cz"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-6 inline-block text-sm font-medium text-brand-primary-dark hover:underline"
                >
                    Zjistit více o Apoštolské církvi →
                </a>
            </div>
        </section>
    </PublicLayout>
</template>
