<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Clock, MapPin, Coffee, Music, BookOpen, Users, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Martin Fridrich', role: 'Pastor sboru — káže a vede setkání' },
    { name: 'Slávka Fridrichová', role: 'Manželka pastora — srdce rodiny a vítání' },
]
</script>

<template>
    <Head>
        <title>Nedělní dopoledne — církev kolín</title>
        <meta name="description" content="Každou neděli v 10:00 v Kolíně. Chvály, slovo od pastora, program pro děti a nejlepší káva v Kolíně po skončení." />
    </Head>

    <PublicLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden bg-brand-cream pt-32 pb-16 sm:pt-40">
            <Blob color="#ff8c69" :size="380" variant="2" float="slow" :opacity="0.9" class="-right-20 -top-20" />
            <Blob color="#4db6ac" :size="260" variant="3" float="none" :opacity="0.4" class="-left-16 bottom-10" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-block rounded-full bg-brand-coral px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    Srdce naší komunity
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Nedělní <br class="hidden sm:block" />
                    <span class="text-brand-coral">dopoledne.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Každou neděli v&nbsp;10:00 se scházíme všichni společně — a&nbsp;rádi mezi sebou přivítáme každého, i&nbsp;neohlášené hosty. U&nbsp;nás nedělíme lidi na věřící a&nbsp;nevěřící. <span class="font-semibold text-brand-ink">Každý, kdo přijde, je vítán.</span>
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Clock class="h-4 w-4 text-brand-primary" />
                        Neděle 10:00
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <MapPin class="h-4 w-4 text-brand-primary" />
                        V Zídkách 402, Kolín
                    </span>
                </div>
            </div>
        </section>

        <!-- Jak to u nás vypadá -->
        <section class="relative bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal max-w-2xl">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Jak to u nás vypadá</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Zamyšlení, chvály, a nikdo nikam nepospíchá.</h2>
                </div>

                <div class="mt-12 space-y-6 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Během „oficiálního“ programu si od našeho pastora poslechneme zamyšlení o&nbsp;tom, jak víra souvisí s&nbsp;našimi každodenními životy. Je to srozumitelně, prakticky a&nbsp;beze zbytečných frází.
                    </p>
                    <p>
                        Součástí programu je také hudba — této části říkáme <strong class="text-brand-ink">chvály</strong>. Na pódiu hraje kapela moderní písně vytvářející prostor pro rozjímání, vnitřní ztišení a&nbsp;napojení na Boha. Kdo chce, může se přidat zpěvem — nebo jen tiše poslouchat.
                    </p>
                    <p>
                        Ve stejné budově v&nbsp;prostorech mateřského centra <Link href="/co-delame/kidztown" class="font-semibold text-brand-primary hover:underline">KidzTown</Link> zároveň probíhá samostatný program pro děti, aby rodiče mohli být v&nbsp;klidu na setkání.
                    </p>
                    <p>
                        Po skončení bohoslužby to většinou nekončí — zůstáváme u&nbsp;<strong class="text-brand-ink">„nejlepší kávy v&nbsp;Kolíně“</strong> a&nbsp;domácího zákusku. Povídáme si, seznamujeme se a&nbsp;sdílíme život.
                    </p>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section class="bg-brand-cream py-20 sm:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal max-w-2xl">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Program</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Rámcově to vypadá takhle</h2>
                    <p class="mt-4 text-brand-ink-soft">Trvá to kolem hodiny a&nbsp;půl. Čas je přibližný — nespěcháme na nikoho.</p>
                </div>

                <div class="mt-12 space-y-4">
                    <div
                        v-for="(item, i) in [
                            { time: '10:00', icon: Music, title: 'Chvály', desc: 'Pár písniček pro naladění srdce. Kapela hraje moderní chválové písně, text se promítá — ať jsi zpěvák, nebo ne.' },
                            { time: '10:20', icon: BookOpen, title: 'Zamyšlení', desc: 'Pastor Martin (nebo host) otevře Bibli a hledá, co dnes říká nám. Lidsky, prakticky, upřímně.' },
                            { time: '11:10', icon: Users, title: 'Modlitba a oznámení', desc: 'Modlíme se za sebe navzájem a říkáme si, co se v komunitě děje během týdne.' },
                            { time: '11:30', icon: Coffee, title: 'Káva a pokec', desc: 'Nejlepší část. Kafe, čaj, domácí zákusek a čas na rozhovor. Nikdo tě nevyhání.' },
                        ]"
                        :key="item.time"
                        :class="['reveal flex gap-5 rounded-2xl bg-white p-6 ring-1 ring-brand-ink/5 hover-lift', `reveal-delay-${i + 1}`]"
                    >
                        <div class="flex-none w-16">
                            <span class="font-display text-lg text-brand-primary">{{ item.time }}</span>
                        </div>
                        <div class="flex gap-4 flex-1">
                            <component :is="item.icon" class="mt-1 h-5 w-5 flex-none text-brand-coral" />
                            <div>
                                <p class="font-display text-lg text-brand-ink">{{ item.title }}</p>
                                <p class="mt-1 text-sm leading-relaxed text-brand-ink-soft">{{ item.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Kdo tě v neděli přivítá" />

        <!-- CTA pair -->
        <section class="bg-brand-cream py-20 sm:py-28">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="reveal rounded-3xl bg-brand-coral/10 p-8 sm:p-10">
                        <h2 class="font-display text-3xl text-brand-ink">Přijdeš poprvé?</h2>
                        <p class="mt-4 leading-relaxed text-brand-ink-soft">
                            Přijít poprvé je úplně normální věc. U&nbsp;vchodu tě přivítáme, ukážeme ti, kde co je, a&nbsp;pokud chceš, posadíme tě k&nbsp;někomu, kdo tě provede.
                        </p>
                        <Link
                            href="/jsem-tu-poprve"
                            class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white hover:bg-brand-coral-dark"
                        >
                            Jsem tu poprvé
                            <ArrowRight class="h-4 w-4" />
                        </Link>
                    </div>
                    <div class="reveal reveal-delay-1 overflow-hidden rounded-3xl bg-brand-cream">
                        <img
                            src="/images/place/vstup-vitame-vas.jpg"
                            alt="Tabule „Vítejte CÍRKEV KOLÍN“ u vstupu do sboru."
                            class="h-48 w-full object-cover"
                            loading="lazy"
                        />
                        <div class="p-8 sm:p-10">
                            <h2 class="font-display text-3xl text-brand-ink">Kde nás najdeš</h2>
                            <p class="mt-4 leading-relaxed text-brand-ink-soft">
                                V&nbsp;Zídkách 402, Kolín 2 (vchod z&nbsp;Benešovy ulice). Hledej <strong class="text-brand-ink">tabuli „Vítejte“</strong> — a&nbsp;jsi na místě.
                            </p>
                            <a
                                href="https://maps.apple.com/?q=V+Z%C3%ADdk%C3%A1ch+402%2C+Kol%C3%ADn"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-6 inline-flex items-center gap-2 rounded-full border-2 border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink hover:border-brand-primary hover:text-brand-primary"
                            >
                                Otevřít v mapách
                                <ArrowRight class="h-4 w-4" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
