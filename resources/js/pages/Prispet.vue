<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import Blob from '@/components/Blob.vue'
import { Copy, Check, Heart, Home, Music, Users } from 'lucide-vue-next'
import { ref } from 'vue'

const props = defineProps<{
    iban: string
    accountNumber: string
}>()

const copied = ref<'iban' | 'account' | null>(null)

async function copy(value: string, which: 'iban' | 'account') {
    await navigator.clipboard.writeText(value)
    copied.value = which
    setTimeout(() => (copied.value = null), 2000)
}

const uses = [
    { icon: Home, title: 'Sborová budova', text: 'Provoz, nájem, energie — abys mohl přijít do teplé místnosti.' },
    { icon: Users, title: 'Program pro děti', text: 'Kidztown, WyldLife — materiály, vybavení, akce.' },
    { icon: Music, title: 'Hudba a technika', text: 'Nástroje, mixpult, mikrofony — aby zvuk seděl.' },
    { icon: Heart, title: 'Sociální pomoc', text: 'Akutní pomoc lidem v nouzi z našeho okolí.' },
]
</script>

<template>
    <Head>
        <title>Přispět — církev kolín</title>
        <meta name="description" content="Podpořte finančně církev kolín. Číslo účtu 435669379/0800, IBAN CZ6508000000004356693790." />
    </Head>

    <PublicLayout>
        <PageHero
            eyebrow="Přispět"
            title="Děkujeme."
            title-accent="Vážně."
            accent-color="sunny"
            description="Váš dar pomáhá pokrývat provoz sboru, programy pro děti a mládež, a také podporu lidí v tíživé životní situaci. Každá koruna počítá."
        />

        <!-- Platba -->
        <section class="bg-white py-20 sm:py-28">
            <div class="mx-auto max-w-2xl px-4 sm:px-6">
                <div class="reveal rounded-3xl bg-gradient-to-br from-brand-cream to-white p-8 shadow-[0_30px_60px_-30px_rgba(42,42,42,0.15)] ring-1 ring-brand-ink/5">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Bankovním převodem</span>
                    <h2 class="mt-3 font-display text-3xl text-brand-ink sm:text-4xl">Kam poslat dar</h2>

                    <div class="mt-8 space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.15em] text-brand-ink/50">Číslo účtu</p>
                            <div class="mt-2 flex items-center justify-between gap-3 rounded-2xl bg-white p-4 ring-1 ring-brand-ink/10">
                                <p class="font-display text-2xl text-brand-ink">{{ accountNumber }}</p>
                                <button
                                    class="flex items-center gap-1.5 rounded-full bg-brand-ink text-white px-4 py-2 text-xs font-semibold transition-colors hover:bg-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                                    @click="copy(accountNumber, 'account')"
                                >
                                    <Check v-if="copied === 'account'" class="h-3.5 w-3.5" />
                                    <Copy v-else class="h-3.5 w-3.5" />
                                    {{ copied === 'account' ? 'Zkopírováno' : 'Kopírovat' }}
                                </button>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.15em] text-brand-ink/50">IBAN (pro zahraniční platby)</p>
                            <div class="mt-2 flex items-center justify-between gap-3 rounded-2xl bg-white p-4 ring-1 ring-brand-ink/10">
                                <p class="font-mono text-sm text-brand-ink sm:text-base">{{ iban }}</p>
                                <button
                                    class="flex shrink-0 items-center gap-1.5 rounded-full bg-brand-ink text-white px-4 py-2 text-xs font-semibold transition-colors hover:bg-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                                    @click="copy(iban, 'iban')"
                                >
                                    <Check v-if="copied === 'iban'" class="h-3.5 w-3.5" />
                                    <Copy v-else class="h-3.5 w-3.5" />
                                    {{ copied === 'iban' ? 'OK' : 'Kopírovat' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Na co dary jdou -->
        <section class="relative overflow-hidden bg-brand-cream py-20 sm:py-28">
            <Blob color="#f7d75c" :size="300" variant="2" float="slow" :opacity="0.35" class="-left-16 top-20" />
            <Blob color="#ff8c69" :size="260" variant="3" float="none" :opacity="0.3" class="-right-16 bottom-10" />

            <div class="relative mx-auto max-w-5xl px-4 sm:px-6">
                <div class="reveal text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">Na co dary jdou</span>
                    <h2 class="mt-3 font-display text-4xl text-brand-ink sm:text-5xl">Každá koruna má adresu</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(u, i) in uses"
                        :key="u.title"
                        :class="['reveal hover-lift rounded-3xl bg-white p-6 ring-1 ring-brand-ink/5', `reveal-delay-${i + 1}`]"
                    >
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-primary/10 text-brand-primary">
                            <component :is="u.icon" class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 font-display text-xl text-brand-ink">{{ u.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-brand-ink-soft">{{ u.text }}</p>
                    </div>
                </div>

                <p class="reveal reveal-delay-5 mx-auto mt-14 max-w-2xl text-center text-sm text-brand-ink/50">
                    Dary fyzických osob nejsou daňově uznatelné. Právnické osoby mohou kontaktovat sbor pro vystavení potvrzení.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
