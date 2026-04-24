<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { Clock, MapPin, Coffee, Music, BookOpen, Users } from 'lucide-vue-next'
</script>

<template>
    <Head>
        <title>Nedělní setkání — církev kolín</title>
        <meta name="description" content="Každou neděli v 10:00 v Kolíně. Chvíle chvály, kázání ze slova Božího, káva a přátelé." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/40 hover:text-brand-ink">← Co děláme</Link>
                <h1 class="mt-4 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Nedělní setkání</h1>
                <p class="mt-4 text-brand-ink/60 text-lg max-w-2xl">
                    Každou neděli se scházíme v 10:00. Přijď, jak jsi — bez nároků, bez dress code, bez povinnosti.
                </p>
                <div class="mt-6 flex flex-wrap gap-4 text-sm text-brand-ink/70">
                    <span class="flex items-center gap-1.5">
                        <Clock class="h-4 w-4 text-brand-primary" />
                        Každou neděli v 10:00
                    </span>
                    <span class="flex items-center gap-1.5">
                        <MapPin class="h-4 w-4 text-brand-primary" />
                        V Zídkách 402, Kolín
                    </span>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Jak setkání vypadá?</h2>
                <p class="mt-3 text-brand-ink/60">Setkání trvá přibližně hodinu a půl. Tady je rámcový program:</p>

                <div class="mt-8 space-y-4">
                    <div
                        v-for="item in [
                            { time: '10:00', icon: Music, title: 'Chvíle chvály', desc: 'Začínáme společným zpěvem. Hudba nám pomáhá naladit srdce — ať jsi zpěvák nebo ne.' },
                            { time: '10:30', icon: BookOpen, title: 'Kázání', desc: 'Čteme Bibli a hledáme, co nám říká dnes. Prakticky, upřímně, bez zbytečných církevních frází.' },
                            { time: '11:10', icon: Users, title: 'Modlitba a oznámení', desc: 'Modlíme se za sebe navzájem a sdílíme, co se děje v církvi.' },
                            { time: '11:30', icon: Coffee, title: 'Káva a povídání', desc: 'Nejlepší část! Kafe, čaj, sušenky a čas na rozhovor. Nikdo tě nevyhání domů.' },
                        ]"
                        :key="item.time"
                        class="flex gap-4 rounded-2xl bg-brand-cream p-5"
                    >
                        <div class="flex-none">
                            <span class="font-display text-sm font-bold text-brand-primary">{{ item.time }}</span>
                        </div>
                        <div class="flex gap-3">
                            <component :is="item.icon" class="mt-0.5 h-5 w-5 flex-none text-brand-ink/40" />
                            <div>
                                <p class="font-semibold text-brand-ink">{{ item.title }}</p>
                                <p class="mt-1 text-sm text-brand-ink/60">{{ item.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brand-cream py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 grid grid-cols-1 gap-8 sm:grid-cols-2">
                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Přijdeš poprvé?</h2>
                    <p class="mt-3 text-brand-ink/60">
                        Víme, že přijít do neznámého společenství může být nepříjemné. Proto máme přivítací tým, který tě u vchodu přivítá a provede vším, co potřebuješ vědět.
                    </p>
                    <Link
                        href="/jsem-tu-poprve"
                        class="mt-6 inline-block rounded-full bg-brand-primary px-6 py-3 text-sm font-semibold text-white hover:opacity-90"
                    >
                        Jsem tu poprvé →
                    </Link>
                </div>
                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Kde nás najdeš?</h2>
                    <p class="mt-3 text-brand-ink/60">
                        Scházíme se v prostorách sboru Apoštolské církve Kolín. Parkování je dostupné v ulici nebo na přilehlém parkovišti.
                    </p>
                    <a
                        href="https://maps.google.com/?q=V+Zídkách+402,+Kolín"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-block rounded-full border border-brand-ink/20 px-6 py-3 text-sm font-semibold text-brand-ink hover:bg-brand-ink/5"
                    >
                        Otevřít v Mapách →
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
