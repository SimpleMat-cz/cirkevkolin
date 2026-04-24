<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Calendar, MapPin, Clock } from 'lucide-vue-next'

interface Event {
    id: number
    title: string
    slug: string
    description?: string
    starts_at: string
    ends_at?: string
    category?: string
    location?: string
}

const props = defineProps<{ event: Event }>()

function formatDate(dateStr: string): string {
    return new Date(dateStr).toLocaleDateString('cs-CZ', { weekday: 'short', day: 'numeric', month: 'long' })
}

function formatTime(dateStr: string): string {
    return new Date(dateStr).toLocaleTimeString('cs-CZ', { hour: '2-digit', minute: '2-digit' })
}

const categoryColors: Record<string, string> = {
    neděle: 'bg-brand-primary/10 text-brand-primary-dark',
    wyldlife: 'bg-brand-coral/10 text-brand-coral',
    kidztown: 'bg-brand-mint/20 text-emerald-700',
    skupinky: 'bg-brand-sunny/20 text-amber-700',
    akce: 'bg-brand-teal/20 text-teal-700',
}
</script>

<template>
    <Link
        :href="`/akce/${event.slug}`"
        class="group hover-lift flex items-center gap-5 rounded-2xl bg-white p-4 ring-1 ring-brand-ink/5 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary sm:p-5"
    >
        <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-2xl bg-brand-coral py-2 text-center text-white shadow-[0_8px_20px_-8px_rgba(255,140,105,0.6)]">
            <span class="text-[10px] font-bold uppercase tracking-[0.15em]">
                {{ new Date(event.starts_at).toLocaleDateString('cs-CZ', { month: 'short' }).replace('.', '') }}
            </span>
            <span class="font-display text-3xl leading-none">
                {{ new Date(event.starts_at).getDate() }}
            </span>
        </div>

        <div class="flex min-w-0 flex-1 flex-col gap-1">
            <div class="flex items-start justify-between gap-2">
                <h3 class="font-display text-lg leading-tight text-brand-ink transition-colors group-hover:text-brand-primary line-clamp-1">
                    {{ event.title }}
                </h3>
                <span
                    v-if="event.category"
                    class="shrink-0 rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-wider"
                    :class="categoryColors[event.category] ?? 'bg-brand-ink/10 text-brand-ink/70'"
                >
                    {{ event.category }}
                </span>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-brand-ink-soft">
                <span class="flex items-center gap-1.5">
                    <Clock class="h-3.5 w-3.5 text-brand-teal" />
                    {{ formatTime(event.starts_at) }}
                </span>
                <span v-if="event.location" class="flex items-center gap-1.5 truncate">
                    <MapPin class="h-3.5 w-3.5 text-brand-teal" />
                    {{ event.location }}
                </span>
            </div>
        </div>

        <svg class="hidden shrink-0 text-brand-ink/30 transition-all group-hover:translate-x-1 group-hover:text-brand-primary sm:block" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M5 10h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </Link>
</template>
