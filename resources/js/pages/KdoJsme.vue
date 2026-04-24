<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
</script>

<template>
    <Head>
        <title>Kdo jsme — církev kolín</title>
        <meta name="description" content="Jsme parta lidí, kteří věří, že víra se žije v každodennosti. Apoštolská církev Kolín, pastor Martin Fridrich." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <p class="text-sm font-medium uppercase tracking-wider text-brand-teal">O nás</p>
                <h1 class="mt-2 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Kdo jsme</h1>
                <p class="mt-4 text-lg leading-relaxed text-brand-ink/60">
                    Jsme otevřená komunita v Kolíně, která podporuje život v celé jeho šíři. Doprovázíme člověka ve všech jeho etapách — vývoj ducha, duše i těla.
                </p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 space-y-12">
                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Naše vize</h2>
                    <p class="mt-4 text-brand-ink/60 leading-relaxed">
                        Věříme, že každý člověk má hodnotu a zaslouží si místo, kde se cítí přijatý — bez ohledu na to, kde je na své cestě víry. Nedělíme lidi na věřící a nevěřící. Přijde každý, kdo hledá.
                    </p>
                    <p class="mt-4 text-brand-ink/60 leading-relaxed">
                        Usilujeme o rozvoj ducha, duše i těla a vytváříme prostor pro setkávání lidí, sdílení života a víry.
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Pastor Martin Fridrich</h2>
                    <p class="mt-4 text-brand-ink/60 leading-relaxed">
                        Martin Fridrich vede sbor společně se svou manželkou. Věří, že víra se žije v každodennosti — v práci, rodině i vztazích. Je otcem, manželem a člověkem, který má rád lidi.
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Jsme součástí Apoštolské církve</h2>
                    <p class="mt-4 text-brand-ink/60 leading-relaxed">
                        Náš sbor je součástí Apoštolské církve v České republice — společenství více než 100 sborů po celé zemi. Sdílíme stejné hodnoty, víru a touhu žít autenticky.
                    </p>
                    <a
                        href="https://www.apostolskacirkev.cz"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-block text-sm font-medium text-brand-primary-dark hover:underline"
                    >
                        apostolskacirkev.cz →
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
