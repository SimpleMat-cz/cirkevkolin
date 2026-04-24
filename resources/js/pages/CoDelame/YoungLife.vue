<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Blob from '@/components/Blob.vue'
import LeadersBlock from '@/components/LeadersBlock.vue'
import { Clock, MapPin, Users, Flame, ArrowRight } from 'lucide-vue-next'

const leaders = [
    { name: 'Jméno vedoucího', role: 'Vedoucí Young Life — doplníme' },
    { name: 'Jméno vedoucí', role: 'Vedoucí Young Life — doplníme' },
]
</script>

<template>
    <Head>
        <title>Young Life — církev kolín</title>
        <meta name="description" content="Young Life pro teenagery 14–19 let. Pátky 17:30–19:30 v Kolíně. Hry, rozhovory o životě i víře, přátelství." />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-coral/15 pt-32 pb-16 sm:pt-40">
            <Blob color="#ff8c69" :size="380" variant="2" float="slow" :opacity="0.8" class="-right-20 -top-16" />
            <Blob color="#f7d75c" :size="240" variant="3" float="none" :opacity="0.6" class="-left-16 bottom-8" />

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/50 hover:text-brand-ink">← Co děláme</Link>
                <span class="mt-4 inline-block rounded-full bg-brand-coral px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                    Pro 14–19 let
                </span>
                <h1 class="mt-4 hero-display text-5xl text-brand-ink sm:text-6xl lg:text-7xl">
                    Young <span class="text-brand-coral">Life</span>.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft">
                    Pro teenagery, kteří hledají, kam patří. Prostor pro zábavu i&nbsp;vážnější rozhovory o&nbsp;životě a&nbsp;víře. Tady můžeš být takový, jaký doopravdy jsi.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Clock class="h-4 w-4 text-brand-coral" />
                        Pátek 17:30–19:30
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <MapPin class="h-4 w-4 text-brand-coral" />
                        V Zídkách 402, Kolín
                    </span>
                    <span class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-brand-ink/5">
                        <Users class="h-4 w-4 text-brand-coral" />
                        14–19 let
                    </span>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">O čem to je</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Najdi si svý lidi.</h2>
                </div>
                <div class="reveal reveal-delay-1 mt-8 space-y-5 text-lg leading-relaxed text-brand-ink-soft">
                    <p>
                        Young Life je místo pro teenagery od&nbsp;14 do&nbsp;19 let. Trávíme spolu čas, hrajeme hry, povídáme si a&nbsp;podnikáme společně věci, které nás baví a&nbsp;spojují.
                    </p>
                    <p>
                        Přejeme si, aby u&nbsp;nás mohl <strong class="text-brand-ink">každý zažít pocit, že někam patří</strong>. Že je přijatý takový, jaký je. A&nbsp;že nemusí na nic hrát.
                    </p>
                    <p class="font-semibold text-brand-ink">
                        Neváhej dorazit — první návštěva je bez závazků.
                    </p>
                </div>
            </div>
        </section>

        <LeadersBlock :leaders="leaders" subtitle="Koho tady potkáš" />

        <section class="bg-brand-cream py-16 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-coral text-white">
                    <Flame class="h-6 w-6" />
                </div>
                <h2 class="mt-6 font-display text-3xl text-brand-ink sm:text-4xl">Chceš vědět, co se chystá?</h2>
                <p class="mt-4 text-brand-ink-soft">
                    Ozvi se a&nbsp;pošleme ti aktuální plán akcí. Nebo jen v&nbsp;pátek přijď — stačí otevřít dveře.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <Link
                        href="/kontakt"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white hover:bg-brand-coral-dark"
                    >
                        Napsat nám
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
