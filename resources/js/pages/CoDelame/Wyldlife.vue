<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { Clock, MapPin, Users, Zap } from 'lucide-vue-next'
</script>

<template>
    <Head>
        <title>WyldLife — církev kolín</title>
        <meta name="description" content="WyldLife je klub pro děti 10–13 let. Každou středu 16:30–18:00 v Kolíně. Hry, přátelé, dobrodružství." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-coral/10 pt-32 pb-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/40 hover:text-brand-ink">← Co děláme</Link>
                <div class="mt-4 inline-block rounded-full bg-brand-coral px-3 py-1 text-xs font-bold uppercase tracking-widest text-white">
                    Pro 10–13 let
                </div>
                <h1 class="mt-3 font-display text-4xl font-bold text-brand-ink sm:text-5xl">WyldLife</h1>
                <p class="mt-4 text-brand-ink/60 text-lg max-w-2xl">
                    Klub pro děti na přechodu mezi dětstvím a dospíváním. Bezpečné místo, kde je normální být sám sebou, ptát se a zažívat dobrodružství.
                </p>
                <div class="mt-6 flex flex-wrap gap-4 text-sm text-brand-ink/70">
                    <span class="flex items-center gap-1.5">
                        <Clock class="h-4 w-4 text-brand-coral" />
                        Každou středu 16:30–18:00
                    </span>
                    <span class="flex items-center gap-1.5">
                        <MapPin class="h-4 w-4 text-brand-coral" />
                        V Zídkách 402, Kolín
                    </span>
                    <span class="flex items-center gap-1.5">
                        <Users class="h-4 w-4 text-brand-coral" />
                        10–13 let
                    </span>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-12 sm:grid-cols-2">
                    <div>
                        <h2 class="font-display text-2xl font-bold text-brand-ink">Co na WyldLife děláme?</h2>
                        <ul class="mt-6 space-y-3">
                            <li
                                v-for="item in [
                                    'Hry, soutěže a šílenosti — vždy s plnou nasazeností',
                                    'Příběhy a témata, která dávají smysl v reálném životě',
                                    'Čas na povídání a kamarádství',
                                    'Výpravy a speciální akce během roku',
                                    'Bezpečný prostor pro otázky i pochybnosti',
                                ]"
                                :key="item"
                                class="flex items-start gap-2 text-brand-ink/70"
                            >
                                <Zap class="mt-0.5 h-4 w-4 flex-none text-brand-coral" />
                                {{ item }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-display text-2xl font-bold text-brand-ink">Pro koho to je?</h2>
                        <p class="mt-4 text-brand-ink/60 leading-relaxed">
                            WyldLife je pro všechny děti ve věku 10–13 let — ať chodíš do církve nebo ne. Není to povinná „náboženská hodina". Je to místo, kde se potkávají kamarádi a kde si každý může položit otázky o životě, víře a sobě samém.
                        </p>
                        <p class="mt-4 text-brand-ink/60 leading-relaxed">
                            Vedoucí jsou dobrovolníci, kteří to dělají, protože jim na dětech záleží. Jsou proškolení, prověření a mají rádi legraci.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brand-coral/10 py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 text-center">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Chceš vědět víc?</h2>
                <p class="mt-3 text-brand-ink/60 max-w-xl mx-auto">
                    Napiš nám nebo přijď na první schůzku — první návštěva je bez závazků. Stačí přijít ve středu v 16:30.
                </p>
                <Link
                    href="/kontakt"
                    class="mt-6 inline-block rounded-full bg-brand-coral px-8 py-3 text-sm font-semibold text-white hover:opacity-90"
                >
                    Kontaktovat nás →
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
