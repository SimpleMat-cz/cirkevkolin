<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import SermonCard from '@/components/SermonCard.vue'
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
        <PageHero
            eyebrow="Kázání"
            title="Poslechni si,"
            title-accent="co se u nás děje."
            accent-color="teal"
            description="Záznamy nedělních setkání a dalších přednášek. Filtruj podle řečníka, série nebo tématu — najdi, co tě chytne."
        />

        <!-- Filters -->
        <section class="bg-brand-cream pb-8">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="reveal flex flex-wrap items-center gap-3">
                    <div class="relative min-w-[240px] flex-1 sm:flex-none">
                        <Search class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-brand-ink/40" />
                        <input
                            v-model="search"
                            type="search"
                            placeholder="Hledat kázání…"
                            class="w-full rounded-full border border-brand-ink/10 bg-white pl-11 pr-4 py-2.5 text-sm text-brand-ink placeholder:text-brand-ink/40 focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/20"
                        />
                    </div>

                    <select
                        v-model="speaker"
                        class="rounded-full border border-brand-ink/10 bg-white px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všichni řečníci</option>
                        <option v-for="s in speakers" :key="s.id" :value="s.id">{{ s.name }}</option>
                    </select>

                    <select
                        v-model="series"
                        class="rounded-full border border-brand-ink/10 bg-white px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všechny série</option>
                        <option v-for="s in series" :key="s.id" :value="s.id">{{ s.title }}</option>
                    </select>

                    <select
                        v-model="topic"
                        class="rounded-full border border-brand-ink/10 bg-white px-4 py-2.5 text-sm focus:border-brand-primary focus:outline-none"
                    >
                        <option value="">Všechna témata</option>
                        <option v-for="t in topics" :key="t.id" :value="t.id">{{ t.name }}</option>
                    </select>

                    <button
                        v-if="search || speaker || series || topic || year"
                        class="rounded-full bg-brand-coral text-white px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-brand-coral-dark"
                        @click="resetFilters"
                    >
                        Zrušit filtry
                    </button>
                </div>
            </div>
        </section>

        <section class="bg-brand-cream py-12 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div v-if="sermons.data.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="(sermon, i) in sermons.data" :key="sermon.id" :class="['reveal', `reveal-delay-${(i % 3) + 1}`]">
                        <SermonCard :sermon="sermon" />
                    </div>
                </div>

                <div v-else class="rounded-3xl border-2 border-dashed border-brand-ink/10 bg-white py-20 text-center">
                    <p class="font-display text-2xl text-brand-ink/40">Žádná kázání nenalezena.</p>
                    <p class="mt-2 text-sm text-brand-ink-soft">Zkuste uvolnit filtry.</p>
                </div>

                <div v-if="sermons.last_page > 1" class="mt-14 flex items-center justify-center gap-3">
                    <Link
                        v-if="sermons.prev_page_url"
                        :href="sermons.prev_page_url"
                        class="rounded-full border-2 border-brand-ink/10 bg-white px-5 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:border-brand-primary hover:text-brand-primary"
                    >
                        ← Předchozí
                    </Link>
                    <span class="font-display text-sm text-brand-ink/50">
                        {{ sermons.current_page }} / {{ sermons.last_page }}
                    </span>
                    <Link
                        v-if="sermons.next_page_url"
                        :href="sermons.next_page_url"
                        class="rounded-full border-2 border-brand-ink/10 bg-white px-5 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:border-brand-primary hover:text-brand-primary"
                    >
                        Další →
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
