<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
</script>

<template>
    <Head>
        <title>Neděle v 10:00 — církev kolín</title>
        <meta name="description" content="Každou neděli v 10:00 v V Zídkách 402, Kolín. Chvíle, kázání, káva — cca 90 minut." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <p class="text-sm font-medium uppercase tracking-wider text-brand-teal">Každou neděli</p>
                <h1 class="mt-2 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Neděle v 10:00</h1>
                <p class="mt-4 text-lg leading-relaxed text-brand-ink/60">
                    V Zídkách 402, Kolín (vchod z Benešovy ulice). Průměrná délka: 90 minut.
                </p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 space-y-8">
                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Jak to vypadá</h2>
                    <ul class="mt-4 space-y-3">
                        <li v-for="item in [
                            { time: '10:00', text: 'Začátek — chvíle uctívání (hudba, ~30 min)' },
                            { time: '10:30', text: 'Kázání (~40 min)' },
                            { time: '11:10', text: 'Závěr, modlitba, oznámení' },
                            { time: '11:30', text: 'Volný čas — káva, povídání' },
                        ]" :key="item.time" class="flex gap-4">
                            <span class="w-14 shrink-0 font-display text-sm font-semibold text-brand-primary-dark">{{ item.time }}</span>
                            <span class="text-brand-ink/70">{{ item.text }}</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Děti</h2>
                    <p class="mt-2 text-brand-ink/60 leading-relaxed">
                        Během nedělního setkání probíhá <strong class="text-brand-ink">Kidztown</strong> — program pro děti od batolat. Rodiče si mohou sednout a v klidu poslouchat.
                        WyldLife (10–13 let) probíhá v středu odpoledne.
                    </p>
                </div>

                <div class="flex gap-4 flex-wrap">
                    <Link href="/jsem-tu-poprve" class="rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white hover:opacity-90">
                        Přijdu poprvé
                    </Link>
                    <Link href="/co-delame" class="rounded-full border border-brand-ink/20 px-6 py-3 text-sm font-semibold text-brand-ink hover:bg-brand-cream">
                        Co ještě děláme
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
