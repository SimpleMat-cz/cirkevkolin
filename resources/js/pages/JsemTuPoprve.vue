<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Form } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { ChevronDown } from 'lucide-vue-next'
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
        <!-- Hero -->
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <p class="text-sm font-medium uppercase tracking-wider text-brand-teal">Vítejte</p>
                <h1 class="mt-2 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Jsem tu poprvé</h1>
                <p class="mt-4 text-lg leading-relaxed text-brand-ink/60">
                    Rozumíme, že přijít někam poprvé může být trochu divné. Proto jsme připravili odpovědi na otázky, které vás asi napadají.
                </p>
            </div>
        </section>

        <Wave color="#ffffff" :flip="false" />

        <!-- FAQ -->
        <section class="bg-white py-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <dl class="space-y-4">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="rounded-2xl border border-brand-ink/10 overflow-hidden"
                    >
                        <dt>
                            <button
                                class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left font-display font-semibold text-brand-ink hover:bg-brand-cream/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-primary"
                                :aria-expanded="openFaq === index"
                                @click="openFaq = openFaq === index ? null : index"
                            >
                                <span>{{ faq.question }}</span>
                                <ChevronDown
                                    class="h-5 w-5 shrink-0 text-brand-primary transition-transform"
                                    :class="{ 'rotate-180': openFaq === index }"
                                />
                            </button>
                        </dt>
                        <dd v-show="openFaq === index" class="px-6 pb-5 text-brand-ink/60 leading-relaxed">
                            {{ faq.answer }}
                        </dd>
                    </div>
                </dl>
            </div>
        </section>

        <Wave color="#f5f5dc" :flip="true" />

        <!-- Mapa -->
        <section class="bg-brand-cream py-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Kde nás najdete</h2>
                <p class="mt-2 text-brand-ink/60">V Zídkách 402, Kolín 2 (vchod z Benešovy ulice)</p>
                <div class="mt-6 overflow-hidden rounded-2xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2563.123!2d15.2001!3d50.0292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDAxJzQ1LjEiTiAxNcKwMTInMDAuNCJF!5e0!3m2!1scs!2scz!4v1234567890"
                        width="100%"
                        height="350"
                        style="border: 0"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mapa církev kolín"
                    />
                </div>
            </div>
        </section>

        <Wave color="#ffffff" :flip="false" />

        <!-- Formulář -->
        <section class="bg-white py-16">
            <div class="mx-auto max-w-xl px-4 sm:px-6">
                <h2 class="font-display text-2xl font-bold text-brand-ink">Plánuji návštěvu</h2>
                <p class="mt-2 text-brand-ink/60">
                    Dejte nám vědět — přivítáme vás osobně. Není to povinné, ale rádi to víme.
                </p>

                <Form
                    action="/jsem-tu-poprve/prihlaseni"
                    method="post"
                    class="mt-8 space-y-4"
                    #default="{ errors, processing, wasSuccessful }"
                >
                    <div v-if="wasSuccessful" class="rounded-xl bg-brand-mint/20 p-4 text-sm text-emerald-800">
                        Díky! Brzy se ozveme. 🙌
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1 block text-sm font-medium text-brand-ink">Jméno *</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                required
                                class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
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
                                class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
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
                                class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
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
                                class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="planned_visit_date" class="mb-1 block text-sm font-medium text-brand-ink">Plánované datum</label>
                        <input
                            id="planned_visit_date"
                            type="date"
                            name="planned_visit_date"
                            class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                        />
                    </div>

                    <div>
                        <label for="note" class="mb-1 block text-sm font-medium text-brand-ink">Poznámka</label>
                        <textarea
                            id="note"
                            name="note"
                            rows="3"
                            class="w-full rounded-xl border border-brand-ink/20 px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                            placeholder="Cokoliv, co chcete, abychom věděli..."
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="processing"
                        class="w-full rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-coral"
                    >
                        {{ processing ? 'Odesílám...' : 'Odeslat přihlášení' }}
                    </button>
                </Form>
            </div>
        </section>
    </PublicLayout>
</template>
