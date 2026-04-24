<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { MapPin, Users, Heart, MessageCircle } from 'lucide-vue-next'
</script>

<template>
    <Head>
        <title>Skupinky — církev kolín</title>
        <meta name="description" content="Skupinky jsou srdcem naší komunity. Menší skupiny lidí, kteří se pravidelně setkávají, studují Bibli a žijí život spolu." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-primary/10 pt-32 pb-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/40 hover:text-brand-ink">← Co děláme</Link>
                <div class="mt-4 inline-block rounded-full bg-brand-primary px-3 py-1 text-xs font-bold uppercase tracking-widest text-white">
                    Komunita
                </div>
                <h1 class="mt-3 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Skupinky</h1>
                <p class="mt-4 text-brand-ink/60 text-lg max-w-2xl">
                    Neděle je úžasná. Ale skutečný život — a skutečné přátelství — se odehrává v menších skupinkách. Tady víme jeden o druhém, modlíme se spolu a neseme se navzájem.
                </p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Jak skupinka funguje?</h2>
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div
                        v-for="item in [
                            { icon: Users, title: '6–12 lidí', desc: 'Skupinka je dost malá, aby každý mohl mluvit. Dost velká, aby bylo pestro.' },
                            { icon: MapPin, title: 'Různé lokality', desc: 'Skupinky se scházejí po domácnostech v Kolíně a okolí. Najdi tu nejbližší k tobě.' },
                            { icon: MessageCircle, title: 'Studium a diskuse', desc: 'Probíráme Bibli, kázání z neděle, nebo aktuální témata. Otázky jsou vítané.' },
                            { icon: Heart, title: 'Vzájemná podpora', desc: 'Radosti i trápení sdílíme spolu. Modlíme se za sebe a pomáháme si prakticky.' },
                        ]"
                        :key="item.title"
                        class="flex gap-4 rounded-2xl bg-brand-cream p-5"
                    >
                        <component :is="item.icon" class="mt-0.5 h-5 w-5 flex-none text-brand-primary" />
                        <div>
                            <p class="font-semibold text-brand-ink">{{ item.title }}</p>
                            <p class="mt-1 text-sm text-brand-ink/60">{{ item.desc }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 rounded-2xl bg-brand-primary/10 p-8">
                    <h2 class="font-display text-xl font-bold text-brand-ink">Kdy se skupinky scházejí?</h2>
                    <p class="mt-3 text-brand-ink/60">
                        Skupinky se scházejí obvykle jednou za 14 dní, večer v týdnu (nejčastěji úterý nebo čtvrtek). Přesný čas a lokace závisí na konkrétní skupince — domluvíme se přímo s tebou.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-brand-cream py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 items-center">
                    <div>
                        <h2 class="font-display text-2xl font-bold text-brand-ink">Chci se přidat</h2>
                        <p class="mt-4 text-brand-ink/60 leading-relaxed">
                            Napiš nám přes kontaktní formulář nebo se zeptej na neděli. Zařadíme tě do skupinky, která ti bude geograficky nebo životně nejbližší — rodiny s dětmi, singles, smíšené skupiny.
                        </p>
                        <p class="mt-4 text-brand-ink/60 leading-relaxed">
                            Pokud máš chuť začít novou skupinku, rádi tě proškolíme jako vedoucího.
                        </p>
                        <Link
                            href="/kontakt"
                            class="mt-6 inline-block rounded-full bg-brand-primary px-8 py-3 text-sm font-semibold text-white hover:opacity-90"
                        >
                            Chci do skupinky →
                        </Link>
                    </div>
                    <div class="rounded-2xl bg-white p-8 shadow-sm">
                        <h3 class="font-display text-lg font-bold text-brand-ink">Nemáš skupinku, ale chceš ji vést?</h3>
                        <p class="mt-3 text-sm text-brand-ink/60 leading-relaxed">
                            Hledáme lidi, kteří by chtěli otevřít svůj dům (nebo obývák) ostatním. Nemusíš mít teologické vzdělání — stačí srdce pro lidi a chuť naslouchat.
                        </p>
                        <Link
                            href="/kontakt"
                            class="mt-4 inline-block text-sm font-medium text-brand-primary hover:underline"
                        >
                            Říct nám o tom →
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
