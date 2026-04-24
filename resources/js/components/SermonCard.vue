<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Calendar } from 'lucide-vue-next'

interface Sermon {
    id: number
    title: string
    slug: string
    description?: string
    thumbnail_url?: string
    youtube_id?: string
    published_at?: string
    duration_seconds?: number
    speaker?: { name: string }
    series?: { title: string }
}

const props = defineProps<{ sermon: Sermon }>()

function formatDuration(seconds?: number): string {
    if (!seconds) {
        return ''
    }
    const m = Math.floor(seconds / 60)
    return `${m} min`
}

function formatDate(dateStr?: string): string {
    if (!dateStr) {
        return ''
    }
    return new Date(dateStr).toLocaleDateString('cs-CZ', { day: 'numeric', month: 'long', year: 'numeric' })
}
</script>

<template>
    <Link
        :href="`/kazani/${sermon.slug}`"
        class="group hover-lift flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-brand-ink/5 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
    >
        <div class="relative aspect-video overflow-hidden bg-brand-cream-deep">
            <img
                v-if="sermon.thumbnail_url"
                :src="sermon.thumbnail_url"
                :alt="sermon.title"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.06]"
                loading="lazy"
            />
            <div v-else class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary/20 to-brand-teal/20">
                <div class="h-14 w-14 rounded-full bg-white/90 shadow-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-brand-primary translate-x-0.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>
            <!-- Play overlay on hover -->
            <div class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/0 transition-colors duration-300 group-hover:bg-black/30">
                <div class="flex h-14 w-14 scale-90 items-center justify-center rounded-full bg-white/95 opacity-0 shadow-lg transition-all duration-300 group-hover:scale-100 group-hover:opacity-100">
                    <svg class="h-6 w-6 translate-x-0.5 text-brand-primary" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col gap-2 p-5">
            <div v-if="sermon.series" class="text-[11px] font-semibold uppercase tracking-[0.15em] text-brand-teal">
                {{ sermon.series.title }}
            </div>
            <h3 class="font-display text-lg leading-tight text-brand-ink line-clamp-2 transition-colors group-hover:text-brand-primary">
                {{ sermon.title }}
            </h3>
            <p v-if="sermon.description" class="line-clamp-2 text-sm text-brand-ink-soft">
                {{ sermon.description }}
            </p>
            <div class="mt-auto flex items-center justify-between pt-3 text-xs text-brand-ink/50">
                <span v-if="sermon.speaker" class="font-medium">{{ sermon.speaker.name }}</span>
                <span v-if="sermon.published_at" class="flex items-center gap-1">
                    <Calendar class="h-3 w-3" />
                    {{ formatDate(sermon.published_at) }}
                </span>
            </div>
        </div>
    </Link>
</template>
