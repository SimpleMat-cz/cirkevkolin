<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Coffee, Calendar, Heart } from 'lucide-vue-next'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import PublicLayout from '@/layouts/public.vue'

const leaders = [
    { name: 'Pája', role: 'Hlavní barista — stojí za nejlepší kávou v Kolíně' },
]
</script>

<template>
    <Head>
        <title>Kavárna — církev kolín</title>
        <meta name="description" content="Výběrová káva Fathers, připravovaná s péčí našimi baristy. V neděli, při KidzTownu, na Blešáku a dalších akcích v Kolíně." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-teal/15 pt-32 pb-16 sm:pt-40">
            <Blob color="#4db6ac" :size="360" variant="2" float="slow" :opacity="0.5" class="-right-20 -top-16" />
            <Blob color="#f7d75c" :size="240" variant="3" float="none" :opacity="0.5" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-brand-teal px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    <Coffee class="h-3 w-3" />
                    Nejlepší kávu v Kolíně
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Kavárna.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Výběrová káva <strong class="text-brand-ink">Fathers</strong>, připravovaná s&nbsp;péčí a&nbsp;vášní. Káva, ke&nbsp;které se budeš rád vracet.
                </p>
            </div>
        </section>

        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">O kavárně</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Káva s příběhem.</h2>
                </div>
                <div class="reveal reveal-delay-1 mt-8 space-y-5 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Naše kavárna nabízí výběrovou kávu <strong class="text-brand-ink">Fathers</strong>, připravovanou s&nbsp;péčí a&nbsp;vášní našimi skvělými baristy v&nbsp;čele s&nbsp;<strong class="text-brand-ink">Pájou</strong>. Je to káva, ke&nbsp;které se budete rádi vracet znovu a&nbsp;znovu.
                    </p>
                    <p>
                        Z&nbsp;výtěžku provozu kavárny podporujeme misijní práci Zuzky v&nbsp;masajské stepi.
                    </p>
                </div>

                <!-- Kdy najít kavárnu -->
                <div class="mt-14 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div
                        v-for="(slot, i) in [
                            { icon: Calendar, title: 'Každá neděle', desc: 'od 9:30 — před bohoslužbou i po ní.' },
                            { icon: Heart, title: 'KidzTown', desc: 'Středa a čtvrtek  dopoledne — káva pro rodiče, zatímco si děti hrají.' },
                            { icon: Coffee, title: 'Na akcích', desc: 'Najdeš nás na Blešáku a dalších městských akcích' },
                        ]"
                        :key="slot.title"
                        :class="['reveal hover-lift rounded-2xl bg-brand-cream p-6', `reveal-delay-${i + 1}`]"
                    >
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-teal/20 text-brand-teal">
                            <component :is="slot.icon" class="h-5 w-5" />
                        </div>
                        <h3 class="mt-4 font-display text-lg text-brand-ink">{{ slot.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-brand-ink-soft">{{ slot.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Kdo ti kávu připraví" />
    </PublicLayout>
</template>
