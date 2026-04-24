<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Briefcase, Clock, MessageCircle, Users, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Martin Penc', role: 'Vede Business setkání — ozvi se mu přímo' },
    { name: 'Michal Koudelka', role: 'Druhý pilíř setkání — taky se ho můžeš zeptat' },
]
</script>

<template>
    <Head>
        <title>Business setkání — církev kolín</title>
        <meta name="description" content="Středeční setkání podnikatelů a manažerů. Inspirace, sdílení výzev, modlitby za byznys. Hodinu ráno, pak zpět do práce." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-primary/10 pt-32 pb-16 sm:pt-40">
            <Blob color="#0eb0e5" :size="340" variant="2" float="slow" :opacity="0.25" class="-right-20 -top-16" />
            <Blob color="#ff8c69" :size="240" variant="3" float="none" :opacity="0.4" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-brand-primary px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    <Briefcase class="h-3 w-3" />
                    Pro podnikatele a manažery
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Business <br class="hidden sm:block" />
                    <span class="text-brand-primary">setkání.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Chceš se potkat s&nbsp;lidmi ve&nbsp;vedoucích pozicích, nechat se inspirovat a&nbsp;zároveň inspirovat ostatní, sdílet své výzvy a&nbsp;modlit se za své podnikání? Právě k&nbsp;tomu tyhle středy jsou.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Clock class="h-4 w-4 text-brand-primary" />
                        Středa ráno · ~60 min
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Users class="h-4 w-4 text-brand-primary" />
                        Malá skupina
                    </span>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Jak to probíhá</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Neformálně, organicky, podle zájmu.</h2>
                </div>
                <div class="reveal reveal-delay-1 mt-8 space-y-5 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Setkání probíhají <strong class="text-brand-ink">ve&nbsp;středu ráno</strong> — neformálně a&nbsp;organicky, podle toho, co aktuálně řešíme. Obvykle trvají přibližně hodinu, pak každý zpátky do práce.
                    </p>
                    <p>
                        Bavíme se o&nbsp;věcech, které v&nbsp;běžném pracovním hovoru nemají místo: dilema, které tě tíží, rozhodnutí, co tě čeká, vděčnost za průlom, prosba o&nbsp;modlitbu za lidi v&nbsp;týmu.
                    </p>
                    <p class="font-semibold text-brand-ink">
                        Pokud se chceš přidat, ozvi se Martinovi Pencovi nebo Michalu Koudelkovi.
                    </p>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="reveal rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <MessageCircle class="h-6 w-6 text-brand-primary" />
                        <h3 class="mt-4 font-display text-xl text-brand-ink">Martin Penc</h3>
                        <p class="mt-2 text-sm text-brand-ink-soft">Kontakt <span class="italic text-brand-ink/40">(doplníme)</span></p>
                    </div>
                    <div class="reveal reveal-delay-1 rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <MessageCircle class="h-6 w-6 text-brand-primary" />
                        <h3 class="mt-4 font-display text-xl text-brand-ink">Michal Koudelka</h3>
                        <p class="mt-2 text-sm text-brand-ink-soft">Kontakt <span class="italic text-brand-ink/40">(doplníme)</span></p>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Koho se můžeš zeptat" />

        <section class="bg-brand-primary/10 py-16 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <h2 class="font-display text-3xl text-brand-ink sm:text-4xl">Přijít se jen mrknout?</h2>
                <p class="mt-4 text-brand-ink-soft">
                    Jasně. Ozvi se předem, ať víme, že dorazíš — a&nbsp;připravíme dvě kávy.
                </p>
                <Link
                    href="/kontakt"
                    class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-primary px-6 py-3 text-sm font-semibold text-white hover:opacity-90"
                >
                    Napsat nám
                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
