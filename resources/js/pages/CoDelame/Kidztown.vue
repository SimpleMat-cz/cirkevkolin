<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Clock, MapPin, Shield, Heart, ExternalLink, Facebook, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Jméno vedoucí', role: 'Vedoucí Kidztown — doplníme' },
    { name: 'Jméno vedoucí', role: 'Vedoucí Kidztown — doplníme' },
]
</script>

<template>
    <Head>
        <title>Kidztown — církev kolín</title>
        <meta name="description" content="Kidztown — mateřské centrum pro batolata a jejich rodiče. Středy a čtvrtky dopoledne, navíc program pro děti v neděli při bohoslužbě." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-mint/25 pt-32 pb-16 sm:pt-40">
            <Blob color="#8cc9a0" :size="360" variant="2" float="slow" :opacity="0.5" class="-right-20 -top-16" />
            <Blob color="#4db6ac" :size="260" variant="3" float="none" :opacity="0.35" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-block rounded-full bg-brand-teal px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    Pro děti 0–3 + rodiče
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Kidztown.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Mateřské centrum, kde se děti radují z&nbsp;objevování světa a&nbsp;rodiče najdou podporu, společnost a&nbsp;novou kávu.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Clock class="h-4 w-4 text-brand-teal" />
                        Středa a čtvrtek 10:30–12:30
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <MapPin class="h-4 w-4 text-brand-teal" />
                        V Zídkách 402, Kolín
                    </span>
                </div>
            </div>
        </section>

        <!-- Popis -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Co se v Kidztownu děje</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Hraní, vyrábění, káva pro rodiče.</h2>
                </div>
                <div class="reveal reveal-delay-1 mt-8 space-y-5 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Scházíme se ve&nbsp;středu a&nbsp;čtvrtek dopoledne ke&nbsp;společnému hraní, vyrábění a&nbsp;sdílení času s&nbsp;dětmi. Zároveň dáváme prostor maminkám (i&nbsp;tatínkům), aby si mohli v&nbsp;klidu vypít skvělou kávu.
                    </p>
                    <p>
                        Kidztown je <strong class="text-brand-ink">bezpečné a&nbsp;přátelské místo</strong>, kde se děti můžou radovat z&nbsp;objevování světa a&nbsp;rodiče najdou podporu, společnost a&nbsp;nové přátele.
                    </p>
                </div>

                <!-- Bezpečnost + neděle -->
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="reveal rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-teal/20 text-brand-teal">
                            <Shield class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 font-display text-xl text-brand-ink">Bezpečnost na prvním místě</h3>
                        <p class="mt-3 text-sm leading-relaxed text-brand-ink-soft">
                            Vedoucí mají platný výpis z&nbsp;rejstříku trestů a&nbsp;prošli školením ochrany dětí. V&nbsp;neděli pracujeme ve&nbsp;dvojicích, dítě předáváme vždy zpátky rodiči.
                        </p>
                    </div>
                    <div class="reveal reveal-delay-1 rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-coral/20 text-brand-coral">
                            <Heart class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 font-display text-xl text-brand-ink">I v neděli</h3>
                        <p class="mt-3 text-sm leading-relaxed text-brand-ink-soft">
                            V&nbsp;neděli paralelně s&nbsp;kázáním probíhá samostatný program pro děti. Rodiče mají klid na setkání, děti mají svoje.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Kdo vede Kidztown" />

        <!-- CTA -->
        <section class="bg-brand-mint/25 py-16 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <h2 class="font-display text-3xl text-brand-ink sm:text-4xl">Víc na vlastních stránkách</h2>
                <p class="mt-4 text-brand-ink-soft">
                    Kidztown má vlastní web a&nbsp;Facebook — tam najdeš aktuální program, fotky i&nbsp;praktické info.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a
                        href="https://www.kidztown.cz"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-teal px-6 py-3 text-sm font-semibold text-white hover:opacity-90"
                    >
                        kidztown.cz
                        <ExternalLink class="h-4 w-4" />
                    </a>
                    <a
                        href="https://www.facebook.com/kidztownkolin"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full border-2 border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink hover:border-brand-teal hover:text-brand-teal"
                    >
                        <Facebook class="h-4 w-4" />
                        Facebook
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
