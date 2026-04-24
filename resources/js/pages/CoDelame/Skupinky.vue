<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Users, MessageCircle, Heart, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Martin Fridrich', role: 'Vede skupinu Limity pro muže' },
    { name: 'Martin Penc', role: 'Vede Business setkání' },
]
</script>

<template>
    <Head>
        <title>Menší skupiny — církev kolín</title>
        <meta name="description" content="Kromě velké neděle se v týdnu scházíme v menších skupinách. Tam je prostor jít do hloubky — Limity pro muže a další." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-mint/20 pt-32 pb-16 sm:pt-40">
            <Blob color="#8cc9a0" :size="340" variant="2" float="slow" :opacity="0.4" class="-right-20 -top-16" />
            <Blob color="#ff8c69" :size="240" variant="3" float="none" :opacity="0.35" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-brand-teal px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    <Users class="h-3 w-3" />
                    Komunita v týdnu
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Menší <br class="hidden sm:block" />
                    <span class="text-brand-teal">skupiny.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Neděle je úžasná, ale skutečný život — a&nbsp;skutečné přátelství — se často odehrává v&nbsp;menších skupinkách. Tady víme jeden o&nbsp;druhém, modlíme se spolu a&nbsp;neseme se navzájem.
                </p>
            </div>
        </section>

        <!-- Current running groups -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Co se scházíme</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Skupiny, které právě běží</h2>
                </div>

                <div class="mt-10 space-y-5">
                    <div class="reveal hover-lift rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-coral/20 text-brand-coral">
                                <Heart class="h-6 w-6" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-display text-xl text-brand-ink">Limity — pro muže</h3>
                                <p class="mt-2 text-brand-ink-soft">
                                    Mužská skupina, která se baví o&nbsp;tom, co se v&nbsp;hluku všedního dne těžko říká. Vede ji&nbsp;Martin Fridrich.
                                </p>
                                <p class="mt-3 text-sm italic text-brand-ink/50">
                                    Termín a&nbsp;místo — napiš si o&nbsp;něj.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="reveal reveal-delay-1 hover-lift rounded-3xl bg-brand-cream p-6 sm:p-8">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-primary/15 text-brand-primary">
                                <MessageCircle class="h-6 w-6" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-display text-xl text-brand-ink">Business setkání</h3>
                                <p class="mt-2 text-brand-ink-soft">
                                    Středy ráno pro podnikatele a&nbsp;manažery. Sdílení, inspirace, modlitby za byznys.
                                </p>
                                <Link href="/co-delame/business" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-brand-primary hover:underline">
                                    Víc info
                                    <ArrowRight class="h-4 w-4" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How groups work -->
                <div class="mt-14 rounded-3xl bg-white ring-1 ring-brand-ink/5 p-8 sm:p-10">
                    <h3 class="font-display text-2xl text-brand-ink">Jak skupinka vypadá?</h3>
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="flex gap-3">
                            <Users class="mt-1 h-5 w-5 flex-none text-brand-teal" />
                            <p class="text-sm leading-relaxed text-brand-ink-soft">
                                <strong class="text-brand-ink">Menší počet lidí.</strong> Dost malá, aby každý mohl mluvit. Dost velká, aby bylo pestro.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <MessageCircle class="mt-1 h-5 w-5 flex-none text-brand-teal" />
                            <p class="text-sm leading-relaxed text-brand-ink-soft">
                                <strong class="text-brand-ink">Příběhy a&nbsp;Bible.</strong> Mluvíme o&nbsp;tom, co prožíváme — a&nbsp;o&nbsp;tom, co k&nbsp;tomu říká Bible.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <Heart class="mt-1 h-5 w-5 flex-none text-brand-teal" />
                            <p class="text-sm leading-relaxed text-brand-ink-soft">
                                <strong class="text-brand-ink">Opravdu spolu.</strong> Radosti i&nbsp;trápení si neseme — modlíme se za sebe a&nbsp;pomáháme si.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <Users class="mt-1 h-5 w-5 flex-none text-brand-teal" />
                            <p class="text-sm leading-relaxed text-brand-ink-soft">
                                <strong class="text-brand-ink">Každý týden nebo čtrnáct dní.</strong> Obvykle večer. Přesný čas záleží na skupině.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Vedoucí skupin — ozvi se jim" />

        <section class="bg-brand-mint/20 py-16 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <h2 class="font-display text-3xl text-brand-ink sm:text-4xl">Chci do skupiny</h2>
                <p class="mt-4 text-brand-ink-soft">
                    Napiš nebo se zeptej v&nbsp;neděli. Doladíme spolu, co by ti nejvíc sedlo — ať už to je Limity, Business, nebo něco nového.
                </p>
                <Link
                    href="/kontakt"
                    class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-teal px-6 py-3 text-sm font-semibold text-white hover:opacity-90"
                >
                    Napsat nám
                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
