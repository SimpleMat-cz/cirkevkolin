<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import Blob from '@/components/Blob.vue'
import { ArrowRight, Baby, Music, Mic, Coffee } from 'lucide-vue-next'

const agenda = [
    { time: '10:00', icon: Music, title: 'Chvály', text: 'Pár písní, volné zapojení. Nikdo nemusí zpívat, kdo nechce.' },
    { time: '10:30', icon: Mic, title: 'Kázání', text: '~40 min, srozumitelně, bez religiózního slangu.' },
    { time: '11:10', icon: Baby, title: 'Modlitba & oznámení', text: 'Krátce. Kdo chce, může přijít na modlitbu dopředu.' },
    { time: '11:30', icon: Coffee, title: 'Káva a pohoda', text: 'Tohle je ta nejlepší část. Zůstaň, povídáme si.' },
]
</script>

<template>
    <Head>
        <title>Neděle v 10:00 — církev kolín</title>
        <meta name="description" content="Každou neděli v 10:00 V Zídkách 402, Kolín. Chvály, kázání, káva — cca 90 minut. Program pro děti i mládež." />
    </Head>

    <PublicLayout>
        <PageHero
            eyebrow="Každou neděli"
            title="Neděle"
            title-accent="v 10:00."
            accent-color="coral"
            description="V Zídkách 402, Kolín — vchod z Benešovy ulice. Průměrná délka 90 minut. Program pro děti i mládež běží paralelně."
        />

        <!-- Agenda -->
        <section class="relative bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Jak to vypadá</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">
                        Program neděle,<br class="hidden sm:block" /> minuta po minutě.
                    </h2>
                </div>
                <ol class="mt-14 space-y-4">
                    <li
                        v-for="(item, i) in agenda"
                        :key="item.time"
                        :class="['reveal relative flex gap-6 rounded-3xl bg-brand-cream p-6 ring-1 ring-brand-ink/5', `reveal-delay-${i + 1}`]"
                    >
                        <div class="flex flex-col items-center">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-coral text-white">
                                <component :is="item.icon" class="h-6 w-6" />
                            </div>
                            <span class="mt-2 font-display text-lg text-brand-primary">{{ item.time }}</span>
                        </div>
                        <div class="flex-1 pt-1">
                            <h3 class="font-display text-xl text-brand-ink">{{ item.title }}</h3>
                            <p class="mt-1 leading-relaxed text-brand-ink-soft">{{ item.text }}</p>
                        </div>
                    </li>
                </ol>
            </div>
        </section>

        <!-- Děti -->
        <section class="relative overflow-hidden bg-brand-cream py-20 sm:py-28">
            <Blob color="#f7d75c" :size="320" variant="2" float="slow" :opacity="0.35" class="-right-24 top-16" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal grid grid-cols-1 gap-10 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Program pro rodiny</span>
                        <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">
                            Dětem dáme <span class="text-brand-primary">jejich prostor,</span> rodičům klid.
                        </h2>
                        <p class="mt-5 text-lg leading-relaxed text-brand-ink-soft">
                            Během nedělního setkání probíhá <strong class="text-brand-ink">besídka</strong> — program pro děti od batolat až po školáky. Rodiče si mohou sednout a v klidu poslouchat.
                            <strong class="text-brand-ink">WyldLife</strong> (9–13 let) probíhá ve středu odpoledne.
                        </p>
                        <Link
                            href="/co-delame"
                            class="mt-6 inline-flex items-center gap-2 font-semibold text-brand-primary hover:underline"
                        >
                            Všechno, co děláme během týdne
                            <ArrowRight class="h-4 w-4" />
                        </Link>
                    </div>
                    <div class="hidden flex-col items-center justify-center rounded-3xl bg-white p-8 text-center shadow-[0_30px_60px_-30px_rgba(42,42,42,0.25)] md:flex">
                        <span class="text-6xl">🧒</span>
                        <span class="mt-3 font-display text-lg text-brand-ink">Besídka</span>
                        <span class="text-sm text-brand-ink-soft">Každou neděli</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <h2 class="reveal font-display text-4xl text-brand-ink sm:text-5xl">Vidíme se v neděli?</h2>
                <p class="reveal reveal-delay-1 mt-4 text-brand-ink-soft">Stačí přijít. Ale pokud chceš, napiš nám předem.</p>
                <div class="reveal reveal-delay-2 mt-8 flex flex-wrap justify-center gap-4">
                    <Link
                        href="/jsem-tu-poprve"
                        class="btn-coral inline-flex items-center gap-2 rounded-full bg-brand-coral px-7 py-3.5 text-sm font-semibold text-white shadow-[0_10px_24px_-10px_rgba(255,140,105,0.6)] transition-all hover:-translate-y-0.5 hover:bg-brand-coral-dark"
                    >
                        Přijdu poprvé
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                    <Link
                        href="/co-delame"
                        class="rounded-full border-2 border-brand-ink/15 px-7 py-3.5 text-sm font-semibold text-brand-ink transition-colors hover:border-brand-primary hover:text-brand-primary"
                    >
                        Co ještě děláme
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
