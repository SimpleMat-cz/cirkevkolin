<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { MapPin, Mail, Clock } from 'lucide-vue-next'
</script>

<template>
    <Head>
        <title>Kontakt — církev kolín</title>
        <meta name="description" content="V Zídkách 402, Kolín. E-mail: kolin@apostolskacirkev.cz. Neděle 10:00." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <h1 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">Kontakt</h1>
                <p class="mt-4 text-brand-ink/60">Jsme dostupní — napište, zavolejte nebo prostě přijďte.</p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <MapPin class="mt-1 h-5 w-5 shrink-0 text-brand-coral" />
                            <div>
                                <p class="font-semibold text-brand-ink">Adresa</p>
                                <p class="text-brand-ink/60">V Zídkách 402, Kolín 2<br>PSČ 280 02<br>Vchod z Benešovy ulice</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <Mail class="mt-1 h-5 w-5 shrink-0 text-brand-coral" />
                            <div>
                                <p class="font-semibold text-brand-ink">E-mail</p>
                                <a href="mailto:kolin@apostolskacirkev.cz" class="text-brand-primary-dark hover:underline">
                                    kolin@apostolskacirkev.cz
                                </a>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <Clock class="mt-1 h-5 w-5 shrink-0 text-brand-coral" />
                            <div>
                                <p class="font-semibold text-brand-ink">Neděle</p>
                                <p class="text-brand-ink/60">10:00 — cca 11:30</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2563.123!2d15.2001!3d50.0292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDAxJzQ1LjEiTiAxNcKwMTInMDAuNCJF!5e0!3m2!1scs!2scz!4v1234567890"
                            width="100%"
                            height="300"
                            style="border: 0"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Mapa církev kolín"
                        />
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
