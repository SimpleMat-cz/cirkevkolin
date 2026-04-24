<script setup lang="ts">
/**
 * Zobrazuje 2 osoby, které vedou danou aktivitu.
 * Obrázky: lokální path nebo externí URL (z brand assets).
 * Pokud není fotka, zobrazí se kruh s iniciálou.
 */
interface Leader {
    name: string
    role?: string
    photo?: string
}

withDefaults(
    defineProps<{
        title?: string
        subtitle?: string
        leaders: Leader[]
    }>(),
    {
        title: 'Kdo to vede',
        subtitle: 'Ozvi se komukoliv z nás — rádi tě potkáme.',
    },
)

function initial(name: string): string {
    return name.trim().split(' ').map((w) => w[0]).join('').slice(0, 2).toUpperCase()
}
</script>

<template>
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6">
            <div class="reveal text-center">
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-brand-coral">{{ title }}</span>
                <h2 class="mt-3 font-display text-3xl text-brand-ink sm:text-4xl">{{ subtitle }}</h2>
            </div>

            <div
                :class="[
                    'mt-10 grid gap-6',
                    leaders.length === 1 ? 'grid-cols-1 max-w-sm mx-auto' : 'grid-cols-1 sm:grid-cols-2',
                ]"
            >
                <div
                    v-for="(leader, i) in leaders"
                    :key="leader.name"
                    :class="['reveal hover-lift flex flex-col items-center gap-4 rounded-3xl bg-brand-cream p-6 sm:p-8 ring-1 ring-brand-ink/5', `reveal-delay-${i + 1}`]"
                >
                    <div class="relative h-36 w-36 overflow-hidden rounded-full ring-4 ring-white shadow-[0_18px_40px_-18px_rgba(42,42,42,0.35)]">
                        <img
                            v-if="leader.photo"
                            :src="leader.photo"
                            :alt="leader.name"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-coral via-brand-sunny to-brand-mint font-display text-4xl text-white"
                        >
                            {{ initial(leader.name) }}
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="font-display text-xl text-brand-ink">{{ leader.name }}</h3>
                        <p v-if="leader.role" class="mt-1 text-sm text-brand-ink-soft">{{ leader.role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
