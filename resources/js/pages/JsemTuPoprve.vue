<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Form } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import { ChevronDown, Send, CheckCircle2 } from 'lucide-vue-next'
import { ref } from 'vue'

const openFaq = ref<number | null>(0)

const faqs = [
    {
        question: 'Co mě čeká, když přijdu?',
        answer: 'Chvíle uctívání hudbou (~30 min), kázání (~40 min) a neformální čas po s kávou. Žádné divné rituály, žádný nátlak. Lidé jsou oblečeni běžně — džíny jsou OK.',
    },
    {
        question: 'Co si mám vzít s sebou?',
        answer: 'Nic zvláštního. Sami sebe. Pokud máte Bibli a chcete ji přinést, super — ale není to nutné. Bible jsou k dispozici i u nás.',
    },
    {
        question: 'Co bude s mými dětmi?',
        answer: 'V neděli během setkání mají děti vlastní program (Kidztown). Malé batolata mohou být s vámi nebo v dětském koutku. Předem nemusíte nic registrovat.',
    },
    {
        question: 'Budu muset něco dělat nebo říkat?',
        answer: 'Vůbec ne. Přijďte, posaďte se, poslouchejte. Nikdo vás nebude nutit vstávat, zpívat, mluvit ani nic podepisovat. Jste hosté.',
    },
    {
        question: 'Co jste za lidi?',
        answer: 'Jsme parta různých lidí — mladí, starší, rodiny, singles, lidé hledající, lidé věřící. Nedělíme lidi na věřící a nevěřící. Přijde každý, kdo chce.',
    },
    {
        question: 'Kde zaparkuji?',
        answer: 'Parking je dostupný na ulici Benešova (modrá zóna — neděle je zdarma). Vstup do budovy je z Benešovy ulice, ne ze Z Zídkách.',
    },
]
</script>

<template>
    <Head>
        <title>Jsem tu poprvé — církev kolín</title>
        <meta name="description" content="Plánujete první návštěvu? Zjistěte, co vás čeká, kde zaparkovat, co s dětmi a jak to u nás chodí." />
    </Head>

    <PublicLayout>
        <PageHero
            eyebrow="Vítejte"
            title="Jsem tu"
            title-accent="poprvé."
            accent-color="coral"
            description="Rozumíme — přijít někam poprvé může být trochu divné. Proto jsme připravili odpovědi na otázky, které tě asi napadají. A pokud něco chybí, napiš nám."
        />

        <!-- FAQ -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal mb-10">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Časté otázky</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Co nejspíš řešíš</h2>
                </div>
                <dl class="space-y-3">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        :class="['overflow-hidden rounded-2xl bg-brand-cream ring-1 ring-brand-ink/5 transition-colors', openFaq === index && 'ring-brand-primary/20']"
                    >
                        <dt>
                            <button
                                class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left font-display text-lg text-brand-ink transition-colors hover:text-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-primary"
                                :aria-expanded="openFaq === index"
                                @click="openFaq = openFaq === index ? null : index"
                            >
                                <span>{{ faq.question }}</span>
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-primary/10 text-brand-primary transition-transform" :class="{ 'rotate-180': openFaq === index }">
                                    <ChevronDown class="h-4 w-4" />
                                </span>
                            </button>
                        </dt>
                        <Transition
                            enter-active-class="transition-all duration-300 ease-out overflow-hidden"
                            enter-from-class="opacity-0 max-h-0"
                            enter-to-class="opacity-100 max-h-96"
                            leave-active-class="transition-all duration-200 ease-in overflow-hidden"
                            leave-from-class="opacity-100 max-h-96"
                            leave-to-class="opacity-0 max-h-0"
                        >
                            <dd v-show="openFaq === index" class="px-6 pb-5 leading-relaxed text-brand-ink-soft">
                                {{ faq.answer }}
                            </dd>
                        </Transition>
                    </div>
                </dl>
            </div>
        </section>

        <!-- Mapa -->
        <section class="bg-brand-cream py-20">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div class="reveal">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Místo</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Kde nás najdeš</h2>
                    <p class="mt-3 text-brand-ink-soft">V Zídkách 402, Kolín 2 — vchod z Benešovy ulice. Modrá zóna v neděli zdarma.</p>
                </div>

                <!-- Ukázka, jak to vypadá naživo -->
                <div class="reveal reveal-delay-1 mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <figure class="hover-lift overflow-hidden rounded-2xl bg-white shadow-[0_20px_40px_-20px_rgba(42,42,42,0.2)]">
                        <img
                            src="/images/place/budova.jpg"
                            alt="Budova sboru církev kolín — prosklený vstup a okrová fasáda."
                            class="h-56 w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption class="px-4 py-3 text-xs text-brand-ink-soft">
                            <span class="font-semibold text-brand-ink">Tak vypadá budova zvenčí.</span>
                        </figcaption>
                    </figure>
                    <figure class="hover-lift overflow-hidden rounded-2xl bg-white shadow-[0_20px_40px_-20px_rgba(42,42,42,0.2)]">
                        <img
                            src="/images/place/vstup-vitame-vas.jpg"
                            alt="Tabule „Vítejte CÍRKEV KOLÍN“ u vchodu."
                            class="h-56 w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption class="px-4 py-3 text-xs text-brand-ink-soft">
                            <span class="font-semibold text-brand-ink">U vchodu tě čeká tahle tabule.</span>
                        </figcaption>
                    </figure>
                </div>
                <div class="reveal reveal-delay-1 mt-8 overflow-hidden rounded-3xl shadow-[0_30px_60px_-30px_rgba(42,42,42,0.25)]">
                    <iframe
                        src="https://maps.google.com/maps?q=V+Z%C3%ADdk%C3%A1ch+402%2C+280+02+Kol%C3%ADn+2&t=&z=17&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="400"
                        style="border: 0"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mapa — V Zídkách 402, Kolín"
                    />
                </div>
            </div>
        </section>

        <!-- Formulář -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-xl px-4 sm:px-6">
                <div class="reveal text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Napiš nám</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Plánuji návštěvu</h2>
                    <p class="mt-4 text-brand-ink-soft">
                        Není povinné, ale rádi budeme vědět, že přijdeš. Přivítáme tě osobně.
                    </p>
                </div>

                <Form
                    action="/jsem-tu-poprve/prihlaseni"
                    method="post"
                    class="reveal reveal-delay-1 mt-10 space-y-5 rounded-3xl bg-brand-cream p-6 sm:p-8"
                    #default="{ errors, processing, wasSuccessful }"
                >
                    <div v-if="wasSuccessful" class="flex items-center gap-3 rounded-2xl bg-brand-mint/25 p-4 text-sm font-medium text-emerald-900">
                        <CheckCircle2 class="h-5 w-5 text-emerald-700" />
                        Díky! Ozveme se ti brzy. Těšíme se na setkání.
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1 block text-sm font-medium text-brand-ink">Jméno *</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                required
                                class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                                :class="{ 'border-red-400': errors.name }"
                                placeholder="Vaše jméno"
                            />
                            <p v-if="errors.name" class="mt-1 text-xs text-red-600">{{ errors.name }}</p>
                        </div>
                        <div>
                            <label for="email" class="mb-1 block text-sm font-medium text-brand-ink">E-mail *</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required
                                class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                                :class="{ 'border-red-400': errors.email }"
                                placeholder="vas@email.cz"
                            />
                            <p v-if="errors.email" class="mt-1 text-xs text-red-600">{{ errors.email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-1 block text-sm font-medium text-brand-ink">Telefon</label>
                            <input
                                id="phone"
                                type="tel"
                                name="phone"
                                class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                                placeholder="+420 123 456 789"
                            />
                        </div>
                        <div>
                            <label for="people_count" class="mb-1 block text-sm font-medium text-brand-ink">Počet lidí *</label>
                            <input
                                id="people_count"
                                type="number"
                                name="people_count"
                                min="1"
                                max="20"
                                value="1"
                                class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="planned_visit_date" class="mb-1 block text-sm font-medium text-brand-ink">Plánované datum</label>
                        <input
                            id="planned_visit_date"
                            type="date"
                            name="planned_visit_date"
                            class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                        />
                    </div>

                    <div>
                        <label for="note" class="mb-1 block text-sm font-medium text-brand-ink">Poznámka</label>
                        <textarea
                            id="note"
                            name="note"
                            rows="3"
                            class="w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                            placeholder="Cokoliv, co chcete, abychom věděli..."
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="processing"
                        class="btn-coral flex w-full items-center justify-center gap-2 rounded-full bg-brand-coral px-6 py-4 text-sm font-semibold text-white shadow-[0_10px_24px_-10px_rgba(255,140,105,0.6)] transition-all hover:-translate-y-0.5 hover:bg-brand-coral-dark disabled:opacity-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-coral focus-visible:ring-offset-2"
                    >
                        <Send class="h-4 w-4" />
                        {{ processing ? 'Odesílám…' : 'Odeslat přihlášení' }}
                    </button>
                </Form>
            </div>
        </section>
    </PublicLayout>
</template>
