<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
</script>

<template>
    <Head>
        <title>Co děláme — církev kolín</title>
        <meta name="description" content="Neděle, skupinky, WyldLife, Kidztown — co všechno děláme v církev kolín." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <h1 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">Co děláme</h1>
                <p class="mt-4 text-brand-ink/60 text-lg">Nejsme jen neděle. Jsme komunita, která žije celý týden.</p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <Link
                    v-for="item in [
                        { href: '/co-delame/nedelni-setkani', title: 'Nedělní setkání', desc: 'Každou neděli v 10:00 — chvíle, kázání, káva.' },
                        { href: '/co-delame/kidztown', title: 'Kidztown', desc: 'Program pro batolata a děti. Čtvrtky a neděle.' },
                        { href: '/co-delame/wyldlife', title: 'WyldLife', desc: 'Klub pro 10–13 leté. Středa 16:30–18:00.' },
                        { href: '/co-delame/skupinky', title: 'Skupinky', desc: 'Menší komunita, hlubší vztahy. Různé lokality.' },
                    ]"
                    :key="item.href"
                    :href="item.href"
                    class="group flex flex-col gap-2 rounded-2xl bg-brand-cream p-6 transition-shadow hover:shadow-md"
                >
                    <h2 class="font-display text-xl font-bold text-brand-ink group-hover:text-brand-primary-dark">{{ item.title }}</h2>
                    <p class="text-sm text-brand-ink/60">{{ item.desc }}</p>
                    <span class="mt-2 text-sm font-medium text-brand-primary-dark">Zjistit více →</span>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
