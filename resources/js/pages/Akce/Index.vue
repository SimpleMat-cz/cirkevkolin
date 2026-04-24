<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import EventCard from '@/components/EventCard.vue'
import Wave from '@/components/Wave.vue'
import { ref, watch, computed } from 'vue'

interface Event {
    id: number
    title: string
    slug: string
    description?: string
    starts_at: string
    ends_at?: string
    category?: string
    location?: string
    is_recurring?: boolean
}

interface Paginator {
    data: Event[]
    current_page: number
    last_page: number
    next_page_url: string | null
    prev_page_url: string | null
}

const props = defineProps<{
    events: Paginator
    recurring: Event[]
    filters: { category?: string }
}>()

const categories = ['neděle', 'wyldlife', 'kidztown', 'skupinky', 'akce']
const category = ref(props.filters.category ?? '')

watch(category, (val) => {
    router.get('/akce', { category: val || undefined }, { preserveState: true, replace: true })
})

// Merge one-time and recurring events, sorted by starts_at
const allEvents = computed(() => {
    const combined = [
        ...props.events.data,
        ...props.recurring,
    ]
    return combined.sort((a, b) => new Date(a.starts_at).getTime() - new Date(b.starts_at).getTime())
})
</script>

<template>
    <Head>
        <title>Akce — církev kolín</title>
        <meta name="description" content="Přehled akcí Apoštolské církve Kolín — neděle, WyldLife, Kidztown, skupinky a další." />
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-12">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <h1 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">Akce</h1>
                <p class="mt-3 text-brand-ink/60">Co se u nás chystá.</p>

                <!-- Kategorie filtr -->
                <div class="mt-6 flex flex-wrap gap-2">
                    <button
                        class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                        :class="category === '' ? 'bg-brand-ink text-white' : 'bg-white text-brand-ink/60 hover:bg-brand-ink/5'"
                        @click="category = ''"
                    >
                        Vše
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        class="rounded-full px-4 py-1.5 text-sm font-medium capitalize transition-colors"
                        :class="category === cat ? 'bg-brand-ink text-white' : 'bg-white text-brand-ink/60 hover:bg-brand-ink/5'"
                        @click="category = cat"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6">
                <div v-if="allEvents.length" class="flex flex-col gap-3">
                    <EventCard v-for="(event, i) in allEvents" :key="`${event.id}-${i}`" :event="event" />
                </div>
                <div v-else class="py-16 text-center text-brand-ink/40">
                    Žádné akce nenalezeny.
                </div>

                <!-- Pagination for one-time events -->
                <div v-if="events.last_page > 1" class="mt-10 flex justify-center gap-2">
                    <Link
                        v-if="events.prev_page_url"
                        :href="events.prev_page_url"
                        class="rounded-xl border border-brand-ink/20 px-4 py-2 text-sm hover:bg-brand-cream"
                    >
                        ← Předchozí
                    </Link>
                    <Link
                        v-if="events.next_page_url"
                        :href="events.next_page_url"
                        class="rounded-xl border border-brand-ink/20 px-4 py-2 text-sm hover:bg-brand-cream"
                    >
                        Další →
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
