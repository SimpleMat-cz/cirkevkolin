<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { Clock, MapPin, Star } from 'lucide-vue-next'
</script>

<template>
    <Head>
        <title>Kidztown — církev kolín</title>
        <meta name="description" content="Kidztown je program pro batolata a děti do 10 let. Čtvrtky a neděle v Kolíně — bezpečné, zábavné, věkově přiměřené." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-mint/20 pt-32 pb-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <Link href="/co-delame" class="text-sm text-brand-ink/40 hover:text-brand-ink">← Co děláme</Link>
                <div class="mt-4 inline-block rounded-full bg-brand-mint px-3 py-1 text-xs font-bold uppercase tracking-widest text-white">
                    Pro děti
                </div>
                <h1 class="mt-3 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Kidztown</h1>
                <p class="mt-4 text-brand-ink/60 text-lg max-w-2xl">
                    Děti nejsou jen hosté — jsou součástí naší komunity. Kidztown je místo vytvořené přesně pro ně.
                </p>
                <div class="mt-6 flex flex-wrap gap-4 text-sm text-brand-ink/70">
                    <span class="flex items-center gap-1.5">
                        <Clock class="h-4 w-4 text-brand-teal" />
                        Čtvrtky + Neděle (paralelně s kázáním)
                    </span>
                    <span class="flex items-center gap-1.5">
                        <MapPin class="h-4 w-4 text-brand-teal" />
                        V Zídkách 402, Kolín
                    </span>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">
                    <div
                        v-for="group in [
                            { label: 'Batolata', age: '0–3 roky', desc: 'Bezpečná hrací místnost s vedoucí, kde mohou rodiče dát dítě a zároveň být v klidu na setkání.', color: 'bg-brand-sunny/20' },
                            { label: 'Předškoláci', age: '3–6 let', desc: 'Příběhy, pohyb, hudba a tvoření přizpůsobené malým dětem. Biblické postavy ожv', color: 'bg-brand-mint/20' },
                            { label: 'Školáci', age: '6–10 let', desc: 'Hloubkové příběhy, diskuse, aktivity a hry přizpůsobené věku. Bezpečné prostředí pro otázky.', color: 'bg-brand-teal/10' },
                        ]"
                        :key="group.label"
                        :class="['rounded-2xl p-6', group.color]"
                    >
                        <span class="text-2xl">
                            <Star class="h-6 w-6 text-brand-teal" />
                        </span>
                        <h3 class="mt-3 font-display text-lg font-bold text-brand-ink">{{ group.label }}</h3>
                        <p class="mt-1 text-xs font-medium text-brand-teal">{{ group.age }}</p>
                        <p class="mt-2 text-sm text-brand-ink/60 leading-relaxed">{{ group.desc }}</p>
                    </div>
                </div>

                <div class="mt-12 rounded-2xl bg-brand-cream p-8">
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Bezpečnost na prvním místě</h2>
                    <p class="mt-4 text-brand-ink/60 leading-relaxed">
                        Všichni vedoucí Kidztownu mají platný výpis z rejstříku trestů a prošli školením v oblasti ochrany dětí. Dítě vždy předáváme přímo rodiči nebo zákonnému zástupci.
                    </p>
                    <p class="mt-3 text-brand-ink/60 leading-relaxed">
                        Na programu v neděli pracují vedoucí ve dvojicích. Dveře nikdy nejsou zamčené. Pokud máte otázky k bezpečnostním opatřením, rádi vám odpovíme.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-brand-mint/20 py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 text-center">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Přijďte v neděli</h2>
                <p class="mt-3 text-brand-ink/60 max-w-xl mx-auto">
                    Kidztown probíhá každou neděli paralelně s kázáním pro dospělé od 10:30. Děti odevzdáte u registrace u vchodu.
                </p>
                <Link
                    href="/jsem-tu-poprve"
                    class="mt-6 inline-block rounded-full bg-brand-teal px-8 py-3 text-sm font-semibold text-white hover:opacity-90"
                >
                    Přijít poprvé →
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
