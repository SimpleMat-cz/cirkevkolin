<script setup lang="ts">
import AppNavbar from '@/components/AppNavbar.vue'
import AppFooter from '@/components/AppFooter.vue'
import { useReveal } from '@/composables/useReveal'

defineProps<{
    title?: string
}>()

useReveal('.reveal')
</script>

<template>
    <div class="flex min-h-screen flex-col bg-brand-cream text-brand-ink">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-md focus:bg-brand-primary focus:px-4 focus:py-2 focus:text-white focus:shadow-lg"
        >
            Přejít na hlavní obsah
        </a>
        <AppNavbar />
        <main id="main-content" class="flex-1">
            <slot />
        </main>
        <AppFooter />
    </div>
</template>
