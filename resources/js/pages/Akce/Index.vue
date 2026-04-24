<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import PageHero from '@/components/PageHero.vue'
import EventCard from '@/components/EventCard.vue'
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
        <PageHero
            eyebrow="Kalendář"
            title="Co se"
            title-accent="u nás chystá."
            accent-color="coral"
            description="Nedělní setkání, WyldLife, Kidztown a další. Přijď, kam ti to sedí — každá akce je otevřená."
        />

        <!-- Filter -->
        <section class="bg-brand-cream pb-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <div class="reveal flex flex-wrap gap-2">
                    <button
                        class="rounded-full px-5 py-2 text-sm font-semibold transition-all"
                        :class="category === '' ? 'bg-brand-ink text-white shadow-md' : 'bg-white text-brand-ink-soft hover:bg-brand-ink/5'"
                        @click="category = ''"
                    >
                        Vše
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        class="rounded-full px-5 py-2 text-sm font-semibold capitalize transition-all"
                        :class="category === cat ? 'bg-brand-coral text-white shadow-md' : 'bg-white text-brand-ink-soft hover:bg-brand-ink/5'"
                        @click="category = cat"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>
        </section>

        <section class="bg-brand-cream py-12 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <div v-if="allEvents.length" class="flex flex-col gap-4">
                    <div v-for="(event, i) in allEvents" :key="`${event.id}-${i}`" :class="['reveal', `reveal-delay-${(i % 3) + 1}`]">
                        <EventCard :event="event" />
                    </div>
                </div>
                <div v-else class="rounded-3xl border-2 border-dashed border-brand-ink/10 bg-white py-20 text-center">
                    <p class="font-display text-2xl text-brand-ink/40">Žádné akce nenalezeny.</p>
                </div>

                <div v-if="events.last_page > 1" class="mt-10 flex justify-center gap-3">
                    <Link
                        v-if="events.prev_page_url"
                        :href="events.prev_page_url"
                        class="rounded-full border-2 border-brand-ink/10 bg-white px-5 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:border-brand-primary hover:text-brand-primary"
                    >
                        ← Předchozí
                    </Link>
                    <Link
                        v-if="events.next_page_url"
                        :href="events.next_page_url"
                        class="rounded-full border-2 border-brand-ink/10 bg-white px-5 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:border-brand-primary hover:text-brand-primary"
                    >
                        Další →
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
