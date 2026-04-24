<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
import { Copy, Check } from 'lucide-vue-next'
import { ref } from 'vue'

const props = defineProps<{
    iban: string
    accountNumber: string
}>()

const copied = ref(false)

async function copyIban() {
    await navigator.clipboard.writeText(props.iban)
    copied.value = true
    setTimeout(() => (copied.value = false), 2000)
}
</script>

<template>
    <Head>
        <title>Přispět — církev kolín</title>
        <meta name="description" content="Podpořte finansky církev kolín. Číslo účtu 435669379/0800, IBAN CZ6508000000004356693790." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-16">
            <div class="mx-auto max-w-2xl px-4 sm:px-6">
                <h1 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">Přispět</h1>
                <p class="mt-4 text-lg leading-relaxed text-brand-ink/60">
                    Váš dar pomáhá pokrývat provoz sboru, programy pro děti a mládež a aktivity komunity.
                </p>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-16">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 space-y-8">
                <!-- Bankovní převod -->
                <div class="rounded-2xl border border-brand-ink/10 p-6 space-y-4">
                    <h2 class="font-display text-xl font-bold text-brand-ink">Bankovním převodem</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-brand-ink/40">Číslo účtu</p>
                            <p class="font-display text-lg font-semibold text-brand-ink">{{ accountNumber }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-brand-ink/40">IBAN</p>
                            <div class="flex items-center gap-3">
                                <p class="font-mono text-sm text-brand-ink">{{ iban }}</p>
                                <button
                                    class="flex items-center gap-1.5 rounded-lg bg-brand-ink/5 px-3 py-1.5 text-xs font-medium text-brand-ink transition-colors hover:bg-brand-ink/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                                    :aria-label="copied ? 'Zkopírováno' : 'Kopírovat IBAN'"
                                    @click="copyIban"
                                >
                                    <Check v-if="copied" class="h-3.5 w-3.5 text-emerald-600" />
                                    <Copy v-else class="h-3.5 w-3.5" />
                                    {{ copied ? 'Zkopírováno' : 'Kopírovat' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Na co dary jdou -->
                <div>
                    <h2 class="font-display text-xl font-bold text-brand-ink">Na co dary jdou</h2>
                    <ul class="mt-4 space-y-2">
                        <li v-for="item in [
                            'Provoz a nájemné sborové budovy',
                            'Programy pro děti — Kidztown a WyldLife',
                            'Hudební vybavení a technika',
                            'Sociální pomoc lidem v nouzi',
                            'Komunální akce a evangelizace',
                        ]" :key="item" class="flex items-start gap-2 text-brand-ink/60">
                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-brand-coral" />
                            {{ item }}
                        </li>
                    </ul>
                </div>

                <p class="text-sm text-brand-ink/40">
                    Dary fyzických osob nejsou daňově uznatelné. Právnické osoby mohou kontaktovat sbor pro vystavení potvrzení.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
