<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import SermonCard from '@/components/SermonCard.vue'
import { ref } from 'vue'
import { Calendar, User, BookOpen, MessageSquare } from 'lucide-vue-next'

interface Sermon {
    id: number
    title: string
    slug: string
    description?: string
    youtube_id?: string
    published_at?: string
    duration_seconds?: number
    bible_references?: string
    study_questions?: string
    speaker?: { name: string; slug: string }
    series?: { title: string; slug: string }
    topics?: Array<{ id: number; name: string; slug: string }>
}

const props = defineProps<{
    sermon: Sermon
    related: Sermon[]
}>()

const activeTab = ref<'summary' | 'bible' | 'questions'>('summary')
const consentGiven = ref(false)

function formatDate(dateStr?: string): string {
    if (!dateStr) {
        return ''
    }
    return new Date(dateStr).toLocaleDateString('cs-CZ', { day: 'numeric', month: 'long', year: 'numeric' })
}
</script>

<template>
    <Head>
        <title>{{ sermon.title }} — církev kolín</title>
        <meta name="description" :content="sermon.description ?? sermon.title" />
        <script v-if="sermon.youtube_id" type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "VideoObject",
            "name": "{{ sermon.title }}",
            "description": "{{ sermon.description }}",
            "thumbnailUrl": "https://i.ytimg.com/vi/{{ sermon.youtube_id }}/hqdefault.jpg",
            "uploadDate": "{{ sermon.published_at }}",
            "embedUrl": "https://www.youtube-nocookie.com/embed/{{ sermon.youtube_id }}"
        }
        </script>
    </Head>

    <PublicLayout>
        <article class="pt-24">
            <!-- YouTube embed -->
            <section class="bg-brand-ink">
                <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6">
                    <!-- Consent gate -->
                    <div v-if="sermon.youtube_id && !consentGiven" class="aspect-video overflow-hidden rounded-2xl bg-brand-ink/60 flex flex-col items-center justify-center gap-4 text-center p-8">
                        <p class="text-white/80 text-sm max-w-sm">
                            Video je uloženo na YouTube. Přehráním souhlasíte s tím, že YouTube může ukládat cookies.
                        </p>
                        <button
                            class="rounded-full bg-brand-coral px-6 py-3 text-sm font-semibold text-white hover:opacity-90"
                            @click="consentGiven = true"
                        >
                            Přehrát video
                        </button>
                    </div>

                    <div v-else-if="sermon.youtube_id && consentGiven" class="aspect-video overflow-hidden rounded-2xl">
                        <iframe
                            :src="`https://www.youtube-nocookie.com/embed/${sermon.youtube_id}?rel=0`"
                            class="h-full w-full"
                            allowfullscreen
                            :title="sermon.title"
                        />
                    </div>

                    <div v-else class="aspect-video overflow-hidden rounded-2xl bg-brand-ink/40 flex items-center justify-center">
                        <p class="text-white/40 text-sm">Video není dostupné</p>
                    </div>
                </div>
            </section>

            <!-- Meta -->
            <section class="bg-white py-10">
                <div class="mx-auto max-w-4xl px-4 sm:px-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span v-if="sermon.series" class="rounded-full bg-brand-teal/10 px-3 py-1 text-xs font-medium text-teal-700">
                            {{ sermon.series.title }}
                        </span>
                        <span
                            v-for="topic in sermon.topics"
                            :key="topic.id"
                            class="rounded-full bg-brand-sunny/20 px-3 py-1 text-xs font-medium text-amber-700"
                        >
                            {{ topic.name }}
                        </span>
                    </div>

                    <h1 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">{{ sermon.title }}</h1>

                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-brand-ink/50">
                        <span v-if="sermon.speaker" class="flex items-center gap-1.5">
                            <User class="h-4 w-4" />
                            {{ sermon.speaker.name }}
                        </span>
                        <span v-if="sermon.published_at" class="flex items-center gap-1.5">
                            <Calendar class="h-4 w-4" />
                            {{ formatDate(sermon.published_at) }}
                        </span>
                    </div>

                    <!-- Tabs -->
                    <div class="mt-8 border-b border-brand-ink/10">
                        <div class="flex gap-0">
                            <button
                                v-for="tab in [
                                    { key: 'summary', label: 'Shrnutí', icon: BookOpen },
                                    { key: 'bible', label: 'Bible verše', icon: BookOpen },
                                    { key: 'questions', label: 'Pro skupinku', icon: MessageSquare },
                                ]"
                                :key="tab.key"
                                class="flex items-center gap-2 px-4 py-3 text-sm font-medium transition-colors border-b-2 -mb-px"
                                :class="activeTab === tab.key
                                    ? 'border-brand-primary text-brand-primary-dark'
                                    : 'border-transparent text-brand-ink/50 hover:text-brand-ink'"
                                @click="activeTab = tab.key as typeof activeTab"
                            >
                                {{ tab.label }}
                            </button>
                        </div>
                    </div>

                    <div class="py-8">
                        <div v-if="activeTab === 'summary'" class="prose prose-sm max-w-none text-brand-ink/70 leading-relaxed">
                            {{ sermon.description || 'Popis není k dispozici.' }}
                        </div>
                        <div v-else-if="activeTab === 'bible'" class="text-brand-ink/70 leading-relaxed whitespace-pre-line">
                            {{ sermon.bible_references || 'Bible verše nejsou zadány.' }}
                        </div>
                        <div v-else class="text-brand-ink/70 leading-relaxed whitespace-pre-line">
                            {{ sermon.study_questions || 'Otázky pro skupinku nejsou zadány.' }}
                        </div>
                    </div>
                </div>
            </section>

            <!-- Related -->
            <section v-if="related.length" class="bg-brand-cream py-16">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <h2 class="font-display text-2xl font-bold text-brand-ink">Další kázání</h2>
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <SermonCard v-for="s in related" :key="s.id" :sermon="s" />
                    </div>
                </div>
            </section>
        </article>
    </PublicLayout>
</template>
