<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Clock, MapPin, Users, Zap, Facebook, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Jméno vedoucího', role: 'Vedoucí WyldLife — doplníme' },
    { name: 'Jméno vedoucí', role: 'Vedoucí WyldLife — doplníme' },
]
</script>

<template>
    <Head>
        <title>WyldLife — církev kolín</title>
        <meta name="description" content="WyldLife je klub pro děti 9–13 let. Každou středu 16:30–18:00 v Kolíně. Hry, zážitky, kamarádství, občas i vážnější rozhovor." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-sunny/20 pt-32 pb-16 sm:pt-40">
            <Blob color="#f7d75c" :size="340" variant="2" float="slow" :opacity="0.5" class="-right-20 -top-16" />
            <Blob color="#ff8c69" :size="260" variant="3" float="none" :opacity="0.4" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-block rounded-full bg-brand-coral px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    Pro 9–13 let
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    WyldLife
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Klub pro děti mezi dětstvím a&nbsp;dospíváním. Bezpečné, přátelské místo, kde mohou trávit čas s&nbsp;kamarády, zažívat nové věci a&nbsp;rozvíjet vztahy.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Clock class="h-4 w-4 text-brand-coral" />
                        Středa 16:30–18:00
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <MapPin class="h-4 w-4 text-brand-coral" />
                        V Zídkách 402, Kolín
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Users class="h-4 w-4 text-brand-coral" />
                        9–13 let
                    </span>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                    <div class="reveal">
                        <h2 class="font-display text-3xl text-brand-ink">Co se na WyldLife děje?</h2>
                        <p class="mt-4 leading-relaxed text-brand-ink-soft">
                            Každé setkání má jiný program — hry, vyrábění i&nbsp;speciální akce. Aktuální plán na měsíc dáváme vždycky na Facebook, ať víš, na co se těšit.
                        </p>
                        <ul class="mt-6 space-y-3">
                            <li
                                v-for="item in [
                                    'Hry, soutěže a občas trochu šílenosti',
                                    'Témata, která dávají smysl v reálném životě',
                                    'Čas na pokec, když se chce',
                                    'Výpravy a speciální akce během roku',
                                    'Bezpečný prostor pro otázky i pochybnosti',
                                ]"
                                :key="item"
                                class="flex items-start gap-2 text-brand-ink-soft"
                            >
                                <Zap class="mt-1 h-4 w-4 flex-none text-brand-coral" />
                                {{ item }}
                            </li>
                        </ul>
                    </div>

                    <div class="reveal reveal-delay-1">
                        <h2 class="font-display text-3xl text-brand-ink">Přijít můžeš kdykoliv</h2>
                        <p class="mt-4 leading-relaxed text-brand-ink-soft">
                            WyldLife je pro všechny děti ve&nbsp;věku 9–13 let — nezáleží na tom, jestli do církve chodíš, nebo ne. Vítáme každého, i&nbsp;v&nbsp;průběhu roku.
                        </p>
                        <p class="mt-4 leading-relaxed text-brand-ink-soft">
                            Vedoucí jsou dobrovolníci, kteří to dělají, protože jim na dětech záleží. Jsou proškolení, prověření a&nbsp;hlavně — mají rádi legraci.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Kdo má WyldLife na starosti" />

        <section class="bg-brand-coral/10 py-16 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <h2 class="font-display text-3xl text-brand-ink sm:text-4xl">Chceš vědět víc?</h2>
                <p class="mt-4 text-brand-ink-soft">
                    Aktuální program a&nbsp;novinky najdeš na Facebooku. Můžeš se ale taky jen tak stavit — první návštěva je bez závazků.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a
                        href="https://www.facebook.com/wyldlifekolin"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white hover:bg-brand-coral-dark"
                    >
                        <Facebook class="h-4 w-4" />
                        WYLD LIFE Kolín na FB
                    </a>
                    <Link
                        href="/kontakt"
                        class="inline-flex items-center gap-2 rounded-full border-2 border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink hover:border-brand-primary hover:text-brand-primary"
                    >
                        Napsat nám
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
