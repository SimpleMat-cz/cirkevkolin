<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import Blob from '@/components/Blob.vue'
import { ArrowRight } from 'lucide-vue-next'

const items = [
    { href: '/co-delame/nedelni-setkani', emoji: '🙌', color: 'bg-brand-coral/15', accent: 'bg-brand-coral', title: 'Nedělní dopoledne', desc: 'Každou neděli v 10:00 se scházíme úplně všichni. Chvály, kázání, káva — a nikdo nikam nepospíchá.' },
    { href: '/co-delame/kidztown', emoji: '🧸', color: 'bg-brand-mint/25', accent: 'bg-brand-mint', title: 'Kidztown', desc: 'Mateřské centrum pro batolata a jejich rodiče. Středy, čtvrtky a neděle — hraní, vyrábění, podpora.' },
    { href: '/co-delame/wyldlife', emoji: '🏄', color: 'bg-brand-sunny/30', accent: 'bg-brand-sunny', title: 'WyldLife', desc: 'Klub pro děti 9–13 let. Každou středu 16:30–18:00. Hry, smích, nové zážitky.' },
    { href: '/co-delame/young-life', emoji: '🔥', color: 'bg-brand-coral/15', accent: 'bg-brand-coral', title: 'Young Life', desc: 'Pro teenagery 14–19 let. Pátky 17:30–19:30. Hry, rozhovory o životě i víře, přátelství.' },
    { href: '/co-delame/kavarna', emoji: '☕', color: 'bg-brand-teal/20', accent: 'bg-brand-teal', title: 'Kavárna', desc: 'Výběrová káva Fathers. V neděli, u Kidztownu i na Blešáku — nejlepší kafe v Kolíně.' },
    { href: '/co-delame/business', emoji: '💼', color: 'bg-brand-primary/15', accent: 'bg-brand-primary', title: 'Business setkání', desc: 'Středy ráno — pro podnikatele a manažery. Inspirace, sdílení výzev, modlitby za byznys.' },
    { href: '/co-delame/skupinky', emoji: '🤝', color: 'bg-brand-mint/25', accent: 'bg-brand-mint', title: 'Menší skupiny', desc: 'Kromě velké neděle jsou tu menší skupinky — Limity pro muže a další. Tam se dá jít opravdu do hloubky.' },
]
</script>

<template>
    <Head>
        <title>Co děláme — církev kolín</title>
        <meta name="description" content="Neděle, skupinky, WyldLife, Kidztown — co všechno děláme v církev kolín. Komunita, která žije celý týden." />
    </Head>

    <PublicLayout>
        <PageHero
            eyebrow="Co děláme"
            title="Nejsme jen"
            title-accent="neděle."
            accent-color="mint"
            description="Kromě nedělního dopoledne se scházíme celý týden — děti, mládež, rodiče, podnikatelé. Přijď tam, kde to sedne tobě."
        />

        <section class="relative overflow-hidden bg-white py-20 sm:py-28">
            <Blob color="#8cc9a0" :size="300" variant="2" float="slow" :opacity="0.18" class="-right-20 top-20" />

            <div class="relative mx-auto max-w-5xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <Link
                        v-for="(item, i) in items"
                        :key="item.href"
                        :href="item.href"
                        :class="['reveal hover-lift group relative flex flex-col gap-4 overflow-hidden rounded-3xl bg-brand-cream p-8 ring-1 ring-brand-ink/5 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary', `reveal-delay-${i + 1}`]"
                    >
                        <div :class="['flex h-14 w-14 items-center justify-center rounded-2xl text-3xl', item.color]">
                            <span>{{ item.emoji }}</span>
                        </div>
                        <h2 class="font-display text-2xl text-brand-ink transition-colors group-hover:text-brand-primary">{{ item.title }}</h2>
                        <p class="text-brand-ink-soft">{{ item.desc }}</p>
                        <span class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-brand-primary">
                            Zjistit víc
                            <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                        </span>
                        <div :class="['pointer-events-none absolute -bottom-12 -right-12 h-32 w-32 rounded-full opacity-60 transition-transform duration-500 group-hover:scale-125', item.accent]" />
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
