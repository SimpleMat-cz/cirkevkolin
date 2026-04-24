<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Clock, Calendar } from 'lucide-vue-next'

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
        class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-brand-ink/5 transition-all hover:shadow-md hover:ring-brand-primary/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
    >
        <!-- Thumbnail -->
        <div class="relative aspect-video overflow-hidden bg-brand-ink/5">
            <img
                v-if="sermon.thumbnail_url"
                :src="sermon.thumbnail_url"
                :alt="sermon.title"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            />
            <div v-else class="flex h-full items-center justify-center">
                <div class="h-12 w-12 rounded-full bg-brand-primary/20" />
            </div>
            <!-- Duration badge -->
            <span
                v-if="sermon.duration_seconds"
                class="absolute bottom-2 right-2 flex items-center gap-1 rounded bg-black/70 px-2 py-0.5 text-xs text-white"
            >
                <Clock class="h-3 w-3" />
                {{ formatDuration(sermon.duration_seconds) }}
            </span>
        </div>

        <!-- Content -->
        <div class="flex flex-1 flex-col gap-2 p-4">
            <div v-if="sermon.series" class="text-xs font-medium uppercase tracking-wider text-brand-teal">
                {{ sermon.series.title }}
            </div>
            <h3 class="font-display text-base font-semibold leading-snug text-brand-ink line-clamp-2 group-hover:text-brand-primary-dark">
                {{ sermon.title }}
            </h3>
            <p v-if="sermon.description" class="line-clamp-2 text-sm text-brand-ink/60">
                {{ sermon.description }}
            </p>
            <div class="mt-auto flex items-center justify-between pt-2 text-xs text-brand-ink/40">
                <span v-if="sermon.speaker">{{ sermon.speaker.name }}</span>
                <span v-if="sermon.published_at" class="flex items-center gap-1">
                    <Calendar class="h-3 w-3" />
                    {{ formatDate(sermon.published_at) }}
                </span>
            </div>
        </div>
    </Link>
</template>
