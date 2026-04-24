<script setup lang="ts">
import Blob from '@/components/Blob.vue'

/**
 * Sdílený hero pro vnitřní stránky. Cream pozadí + 2 organic blobs,
 * velký display nadpis v Archivo Black + eyebrow + podnadpis.
 */
withDefaults(
    defineProps<{
        eyebrow?: string
        title: string
        titleAccent?: string
        description?: string
        accentColor?: 'coral' | 'teal' | 'sunny' | 'mint'
    }>(),
    {
        accentColor: 'coral',
    },
)

const accentMap = {
    coral: 'text-brand-coral',
    teal: 'text-brand-teal',
    sunny: 'text-brand-sunny',
    mint: 'text-brand-mint',
}

const blobMap = {
    coral: { primary: '#ff8c69', secondary: '#f7d75c' },
    teal: { primary: '#4db6ac', secondary: '#8cc9a0' },
    sunny: { primary: '#f7d75c', secondary: '#ff8c69' },
    mint: { primary: '#8cc9a0', secondary: '#4db6ac' },
}
</script>

<template>
    <section class="relative overflow-hidden bg-brand-cream pt-32 pb-16 sm:pt-40 sm:pb-20">
        <Blob :color="blobMap[accentColor].primary" :size="420" variant="2" float="slow" :opacity="0.65" class="-right-24 -top-24" />
        <Blob :color="blobMap[accentColor].secondary" :size="280" variant="3" float="none" :opacity="0.45" class="-left-20 bottom-0" />

        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6">
            <p v-if="eyebrow" class="reveal text-xs font-bold uppercase tracking-[0.22em] text-brand-coral">
                {{ eyebrow }}
            </p>
            <h1 class="reveal reveal-delay-1 mt-4 hero-display text-brand-ink" style="font-size: clamp(2.5rem, 8vw, 6rem)">
                {{ title }}
                <span v-if="titleAccent" :class="['block', accentMap[accentColor]]">{{ titleAccent }}</span>
            </h1>
            <p v-if="description" class="reveal reveal-delay-2 mt-6 max-w-2xl text-lg leading-relaxed text-brand-ink-soft sm:text-xl">
                {{ description }}
            </p>
        </div>
    </section>
</template>
