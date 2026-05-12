<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import { MapPin, Mail, Clock, CreditCard, Facebook, Instagram, Youtube } from 'lucide-vue-next'
import { useSiteSettings } from '@/composables/useSiteSettings'
import type { Page } from '@/types'

const props = defineProps<{
    page?: Page | null
}>()

const { site } = useSiteSettings()

const heroAccent = computed(() => (props.page?.hero_accent_color ?? 'teal') as 'coral' | 'teal' | 'sunny' | 'mint' | 'primary')

const addressLines = computed(() => {
    const parts = [
        site('contact.address_street', 'V Zídkách 402'),
        `${site('contact.address_city', 'Kolín 2')}\nPSČ ${site('contact.address_zip', '280 02')}`,
        site('contact.address_note'),
    ]
    return parts.filter(Boolean).join('\n')
})

const serviceHours = computed(() => {
    const day = site('service.weekday', 'Neděle')
    const start = site('service.time_start', '10:00')
    const end = site('service.time_end', '11:30')
    const coffee = site('service.coffee_from', '9:30')
    return `${start} — cca ${end}\nKavárna od ${coffee}\n(${day})`
})

const items = computed(() => [
    { icon: MapPin, label: 'Adresa', value: addressLines.value, color: 'bg-brand-coral text-white' },
    { icon: Mail, label: 'E-mail', value: site('contact.email', 'kolin@apostolskacirkev.cz'), href: `mailto:${site('contact.email', 'kolin@apostolskacirkev.cz')}`, color: 'bg-brand-primary text-white' },
    { icon: Clock, label: 'Bohoslužba', value: serviceHours.value, color: 'bg-brand-teal text-white' },
    { icon: CreditCard, label: 'Účet', value: site('contact.bank_account', '435669379 / 0800 (ČS)'), color: 'bg-brand-sunny text-brand-ink' },
])

const socials = computed(() => [
    { icon: Facebook, href: site('social.facebook'), label: 'Facebook' },
    { icon: Instagram, href: site('social.instagram'), label: 'Instagram' },
    { icon: Youtube, href: site('social.youtube'), label: 'YouTube' },
].filter((s) => Boolean(s.href)))
</script>

<template>
    <Head>
        <title>{{ page?.meta_title ?? 'Kontakt — církev kolín' }}</title>
        <meta name="description" :content="page?.meta_description ?? 'V Zídkách 402, Kolín. E-mail kolin@apostolskacirkev.cz. Neděle 10:00.'" />
    </Head>

    <PublicLayout>
        <PageHero
            :eyebrow="page?.hero_eyebrow ?? 'Kontakt'"
            :title="page?.hero_title ?? 'Napiš.'"
            :title-accent="page?.hero_title_accent ?? 'Přijď. Ozvi se.'"
            :accent-color="heroAccent"
            :description="page?.hero_description ?? 'Jsme dostupní — napiš, zavolej nebo prostě přijď. Nejlíp v neděli v 10:00.'"
        />

        <section class="relative bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-5">
                    <!-- Kontaktní info -->
                    <div class="lg:col-span-2 space-y-4">
                        <div
                            v-for="(item, i) in items"
                            :key="item.label"
                            :class="['reveal hover-lift flex gap-5 rounded-3xl bg-brand-cream p-6 ring-1 ring-brand-ink/5', `reveal-delay-${i + 1}`]"
                        >
                            <div :class="['flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl', item.color]">
                                <component :is="item.icon" class="h-5 w-5" />
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-[0.15em] text-brand-ink/50">{{ item.label }}</p>
                                <template v-if="item.href">
                                    <a :href="item.href" class="mt-1 block font-display text-lg text-brand-ink transition-colors hover:text-brand-primary">
                                        {{ item.value }}
                                    </a>
                                </template>
                                <p v-else class="mt-1 whitespace-pre-line font-display text-lg text-brand-ink">
                                    {{ item.value }}
                                </p>
                            </div>
                        </div>

                        <div v-if="socials.length" class="reveal reveal-delay-5 flex gap-3 pt-2">
                            <a
                                v-for="s in socials"
                                :key="s.label"
                                :href="s.href!"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-ink text-white transition-all hover:-translate-y-0.5 hover:bg-brand-coral"
                                :aria-label="s.label"
                            >
                                <component :is="s.icon" class="h-4 w-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="reveal reveal-delay-2 lg:col-span-3">
                        <div class="overflow-hidden rounded-3xl shadow-[0_40px_80px_-40px_rgba(42,42,42,0.3)]">
                            <iframe
                                src="https://maps.google.com/maps?q=V+Z%C3%ADdk%C3%A1ch+402%2C+280+02+Kol%C3%ADn+2&t=&z=17&ie=UTF8&iwloc=&output=embed"
                                width="100%"
                                height="500"
                                style="border: 0"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Mapa — V Zídkách 402, Kolín"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tak vypadáme naživo -->
        <section class="bg-brand-cream py-20 sm:py-28">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal max-w-2xl">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Orientační body</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Takhle to u nás vypadá.</h2>
                    <p class="mt-4 text-brand-ink-soft">
                        Abys nás poznal(a), když přijdeš poprvé. Hledej prosklený vstup a&nbsp;černou tabuli „Vítejte CÍRKEV KOLÍN“.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-2">
                    <figure class="reveal hover-lift overflow-hidden rounded-3xl bg-white shadow-[0_30px_60px_-30px_rgba(42,42,42,0.25)]">
                        <img
                            src="/images/place/budova.jpg"
                            alt="Budova sboru církev kolín — V Zídkách 402, Kolín. Prosklený vstup, okrová fasáda, kaskáda tújí podél chodníku."
                            class="h-72 w-full object-cover sm:h-96"
                            loading="lazy"
                        />
                        <figcaption class="px-5 py-4 text-sm text-brand-ink-soft">
                            <span class="font-semibold text-brand-ink">Budova z ulice.</span>
                            Najdi prosklený vchod — přijdeš přes kovovou branku.
                        </figcaption>
                    </figure>
                    <figure class="reveal reveal-delay-1 hover-lift overflow-hidden rounded-3xl bg-white shadow-[0_30px_60px_-30px_rgba(42,42,42,0.25)]">
                        <img
                            src="/images/place/vstup-vitame-vas.jpg"
                            alt="Vstupní brána sboru s černou tabulí „Vítejte CÍRKEV KOLÍN“ napsanou křídou. Dlažba z kostek."
                            class="h-72 w-full object-cover sm:h-96"
                            loading="lazy"
                        />
                        <figcaption class="px-5 py-4 text-sm text-brand-ink-soft">
                            <span class="font-semibold text-brand-ink">„Vítejte“ u vstupu.</span>
                            Když vidíš tuhle tabuli, jsi na správným místě.
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
