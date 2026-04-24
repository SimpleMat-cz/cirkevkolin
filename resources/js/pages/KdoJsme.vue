<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import Blob from '@/components/Blob.vue'
import { Heart, Users, BookOpen, ArrowRight } from 'lucide-vue-next'

const beliefs = [
    { icon: Heart, title: 'Bůh je Stvořitel', text: 'Věříme, že všechno, co je kolem nás — a my sami — máme od Boha. A že o nás stojí.' },
    { icon: Users, title: 'Ježíš je přítel i zachránce', text: 'Věříme, že Ježíš Kristus není jen postava z dějin, ale osobní zachránce a přítel pro každého, kdo ho pustí dál.' },
    { icon: BookOpen, title: 'Bible nás vede', text: 'Učíme se z Bible o životě, naději a smyslu. Je pro nás mapou i kompasem.' },
]
</script>

<template>
    <Head>
        <title>Kdo jsme — církev kolín</title>
        <meta name="description" content="Jsme otevřená komunita v Kolíně, která podporuje život v celé jeho šíři. Apoštolská církev Kolín, pastor Martin Fridrich." />
    </Head>

    <PublicLayout>
        <PageHero
            eyebrow="O nás"
            title="Kdo jsme"
            title-accent="a čemu věříme."
            accent-color="teal"
            description="Jsme místní komunita lidí, kterou spojuje víra v Boha a touha být užiteční lidem kolem nás. S radostí vítáme každého, kdo se chce přidat — nebo se jen přijít podívat."
        />

        <!-- Vize -->
        <section class="relative bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Kdo jsme</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">
                        Místní komunita, <br class="hidden sm:block" />
                        <span class="text-brand-primary">co má rada lidi.</span>
                    </h2>
                </div>
                <div class="reveal reveal-delay-1 mt-8 space-y-5 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Jsme místní komunita lidí, kterou spojuje víra v&nbsp;Boha a&nbsp;touha být užiteční lidem kolem nás. Věříme, že Bůh je Stvořitel všeho a&nbsp;Ježíš Kristus je naším osobním zachráncem i&nbsp;přítelem.
                    </p>
                    <p>
                        To, co nás učí o&nbsp;životě, naději a&nbsp;smyslu, nacházíme v&nbsp;Bibli. Věříme, že Bůh dává lidem dary i&nbsp;schopnosti, které používáme k&nbsp;vzájemné pomoci a&nbsp;službě druhým.
                    </p>
                    <p class="font-semibold text-brand-ink">
                        S&nbsp;radostí vítáme každého, kdo by se k&nbsp;nám chtěl připojit — nebo se chtěl jen přijít podívat.
                    </p>
                </div>
            </div>
        </section>

        <!-- Čemu věříme -->
        <section class="relative overflow-hidden bg-brand-cream py-20 sm:py-28">
            <Blob color="#4db6ac" :size="320" variant="3" float="slow" :opacity="0.2" class="-right-20 top-20" />

            <div class="relative mx-auto max-w-5xl px-4 sm:px-6">
                <div class="reveal text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Čemu věříme</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Tři věci, na kterých stavíme</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div
                        v-for="(b, i) in beliefs"
                        :key="b.title"
                        :class="['reveal hover-lift rounded-3xl bg-white p-8 ring-1 ring-brand-ink/5', `reveal-delay-${i + 1}`]"
                    >
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-teal/15 text-brand-teal">
                            <component :is="b.icon" class="h-7 w-7" />
                        </div>
                        <h3 class="mt-5 font-display text-2xl text-brand-ink">{{ b.title }}</h3>
                        <p class="mt-3 leading-relaxed text-brand-ink-soft">{{ b.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Martin & Slávka -->
        <section class="relative bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal grid grid-cols-1 gap-10 md:grid-cols-[auto_1fr] md:items-start">
                    <div class="flex h-32 w-32 items-center justify-center rounded-3xl bg-brand-coral text-5xl text-white shadow-[0_20px_40px_-20px_rgba(255,140,105,0.5)]">
                        👋
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Vedení sboru</span>
                        <h2 class="mt-2 font-display text-4xl text-brand-ink sm:text-5xl">Martin &amp; Slávka Fridrichovi</h2>
                        <p class="mt-5 text-lg leading-relaxed text-brand-ink-soft">
                            Martin vede sbor společně se&nbsp;svou manželkou Slávkou. Věří, že víra se&nbsp;žije v&nbsp;každodennosti — v&nbsp;práci, v&nbsp;rodině i&nbsp;ve&nbsp;vztazích. Jsou rodiče, manželé a&nbsp;lidé, kteří mají rádi lidi.
                        </p>
                        <p class="mt-4 text-sm italic text-brand-ink/50">
                            (Delší představení Martina a&nbsp;Slávky — doplníme.)
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Apoštolská církev -->
        <section class="relative overflow-hidden bg-brand-ink py-20 text-white sm:py-28">
            <Blob color="#ff8c69" :size="360" variant="2" float="slow" :opacity="0.18" class="-left-20 -top-16" />
            <Blob color="#4db6ac" :size="280" variant="3" float="none" :opacity="0.12" class="-right-16 bottom-10" />

            <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6">
                <span class="reveal text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Součást rodiny</span>
                <h2 class="reveal reveal-delay-1 mt-4 hero-display text-4xl sm:text-5xl lg:text-6xl">
                    Jsme součástí Apoštolské církve v ČR.
                </h2>
                <p class="reveal reveal-delay-2 mx-auto mt-6 max-w-xl text-lg text-white/70">
                    Společenství víc než 100 sborů po celé zemi. Sdílíme stejné hodnoty, víru a touhu žít autenticky.
                </p>
                <a
                    href="https://www.apostolskacirkev.cz"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="reveal reveal-delay-3 mt-8 inline-flex items-center gap-2 rounded-full border-2 border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition-colors hover:bg-white/10"
                >
                    apostolskacirkev.cz
                    <ArrowRight class="h-4 w-4" />
                </a>
            </div>
        </section>
    </PublicLayout>
</template>
