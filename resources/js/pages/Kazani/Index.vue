<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import SermonCard from '@/components/SermonCard.vue'
import Wave from '@/components/Wave.vue'
import { Search } from 'lucide-vue-next'
import { ref, watch } from 'vue'

interface Sermon {
    id: number
    title: string
    slug: string
    description?: string
    thumbnail_url?: string
    published_at?: string
    duration_seconds?: number
    speaker?: { name: string }
    series?: { title: string }
    topics?: Array<{ id: number; name: string }>
}

interface Paginator {
    data: Sermon[]
    current_page: number
    last_page: number
    next_page_url: string | null
    prev_page_url: string | null
}

const props = defineProps<{
    sermons: Paginator
    speakers: Array<{ id: number; name: string }>
    series: Array<{ id: number; title: string }>
    topics: Array<{ id: number; name: string }>
    filters: { q?: string; speaker?: string; series?: string; topic?: string; year?: string }
}>()

const search = ref(props.filters.q ?? '')
const speaker = ref(props.filters.speaker ?? '')
const series = ref(props.filters.series ?? '')
const topic = ref(props.filters.topic ?? '')
const year = ref(props.filters.year ?? '')

let searchTimeout: ReturnType<typeof setTimeout>

function applyFilters() {
    router.get('/kazani', {
        q: search.value || undefined,
        speaker: speaker.value || undefined,
        series: series.value || undefined,
        topic: topic.value || undefined,
        year: year.value || undefined,
    }, { preserveState: true, replace: true })
}

watch(search, () => {
    clearTimeout(searchTimeout)
    searchTimeout = setTimeout(applyFilters, 400)
})

watch([speaker, series, topic, year], applyFilters)

function resetFilters() {
    search.value = ''
    speaker.value = ''
    series.value = ''
    topic.value = ''
    year.value = ''
    router.get('/kazani', {}, { preserveState: false })
}
</script>

<template>
    <Head>
        <title>Kázání — církev kolín</title>
        <meta name="description" content="Poslechněte si kázání z Apoštolské církve Kolín. Filtrujte podle řečníka, série nebo tématu." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h1 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">Kázání</h1>
                <p class="mt-3 text-brand-ink/60">Záznamy nedělních setkání a dalších přednášek.</p>

                <!-- Filtry -->
                <div class="mt-8 flex flex-wrap gap-3">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-brand-ink/40" />
                        <input
                            v-model="search"
                            type="search"
                            placeholder="Hledat kázání..."
                            class="rounded-xl border border-brand-ink/20 bg-white pl-9 pr-4 py-2 text-sm focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                        />
                    </div>

                    <select
                        v-model="speaker"
                        class="rounded-xl border border-brand-ink/20 bg-white px-3 py-2 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všichni řečníci</option>
                        <option v-for="s in speakers" :key="s.id" :value="s.id">{{ s.name }}</option>
                    </select>

                    <select
                        v-model="series"
                        class="rounded-xl border border-brand-ink/20 bg-white px-3 py-2 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všechny série</option>
                        <option v-for="s in series" :key="s.id" :value="s.id">{{ s.title }}</option>
                    </select>

                    <select
                        v-model="topic"
                        class="rounded-xl border border-brand-ink/20 bg-white px-3 py-2 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všechna témata</option>
                        <option v-for="t in topics" :key="t.id" :value="t.id">{{ t.name }}</option>
                    </select>

                    <button
                        v-if="search || speaker || series || topic || year"
                        class="rounded-xl border border-brand-ink/20 bg-white px-3 py-2 text-sm text-brand-ink/60 hover:bg-brand-ink/5"
                        @click="resetFilters"
                    >
                        Zrušit filtry
                    </button>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div v-if="sermons.data.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <SermonCard v-for="sermon in sermons.data" :key="sermon.id" :sermon="sermon" />
                </div>

                <div v-else class="py-16 text-center text-brand-ink/40">
                    Žádná kázání nenalezena. Zkuste jiné filtry.
                </div>

                <!-- Pagination -->
                <div v-if="sermons.last_page > 1" class="mt-12 flex justify-center gap-2">
                    <Link
                        v-if="sermons.prev_page_url"
                        :href="sermons.prev_page_url"
                        class="rounded-xl border border-brand-ink/20 px-4 py-2 text-sm text-brand-ink hover:bg-brand-cream"
                    >
                        ← Předchozí
                    </Link>
                    <span class="flex items-center px-4 text-sm text-brand-ink/40">
                        {{ sermons.current_page }} / {{ sermons.last_page }}
                    </span>
                    <Link
                        v-if="sermons.next_page_url"
                        :href="sermons.next_page_url"
                        class="rounded-xl border border-brand-ink/20 px-4 py-2 text-sm text-brand-ink hover:bg-brand-cream"
                    >
                        Další →
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
