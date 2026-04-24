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
        class="group flex gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-brand-ink/5 transition-all hover:shadow-md hover:ring-brand-primary/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
    >
        <!-- Date block -->
        <div class="flex w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-cream py-2 text-center">
            <span class="text-xs font-medium uppercase text-brand-ink/50">
                {{ new Date(event.starts_at).toLocaleDateString('cs-CZ', { month: 'short' }) }}
            </span>
            <span class="font-display text-2xl font-bold text-brand-ink leading-none">
                {{ new Date(event.starts_at).getDate() }}
            </span>
        </div>

        <!-- Content -->
        <div class="flex flex-1 flex-col gap-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
                <h3 class="font-display text-sm font-semibold text-brand-ink group-hover:text-brand-primary-dark line-clamp-1">
                    {{ event.title }}
                </h3>
                <span
                    v-if="event.category"
                    class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium"
                    :class="categoryColors[event.category] ?? 'bg-brand-ink/10 text-brand-ink/70'"
                >
                    {{ event.category }}
                </span>
            </div>
            <div class="flex flex-wrap gap-3 text-xs text-brand-ink/50">
                <span class="flex items-center gap-1">
                    <Clock class="h-3 w-3" />
                    {{ formatTime(event.starts_at) }}
                </span>
                <span v-if="event.location" class="flex items-center gap-1 truncate">
                    <MapPin class="h-3 w-3" />
                    {{ event.location }}
                </span>
            </div>
        </div>
    </Link>
</template>
