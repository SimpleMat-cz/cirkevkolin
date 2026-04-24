<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/public.vue'
import Wave from '@/components/Wave.vue'
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
    has_registration: boolean
}

defineProps<{ event: Event }>()

function formatDateTime(dateStr: string): string {
    return new Date(dateStr).toLocaleString('cs-CZ', {
        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit',
    })
}
</script>

<template>
    <Head>
        <title>{{ event.title }} — církev kolín</title>
        <meta name="description" :content="event.description ?? event.title" />
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Event",
            "name": "{{ event.title }}",
            "startDate": "{{ event.starts_at }}",
            "endDate": "{{ event.ends_at ?? event.starts_at }}",
            "location": {
                "@type": "Place",
                "name": "{{ event.location ?? 'V Zídkách 402, Kolín' }}",
                "address": "V Zídkách 402, 280 02 Kolín"
            },
            "organizer": {
                "@type": "Organization",
                "name": "Apoštolská církev Kolín"
            }
        }
        </script>
    </Head>

    <PublicLayout>
        <section class="bg-brand-cream pt-32 pb-12">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <Link href="/akce" class="text-sm text-brand-ink/40 hover:text-brand-ink">← Všechny akce</Link>
                <h1 class="mt-4 font-display text-4xl font-bold text-brand-ink sm:text-5xl">{{ event.title }}</h1>
                <div class="mt-4 flex flex-wrap gap-4 text-sm text-brand-ink/60">
                    <span class="flex items-center gap-1.5">
                        <Calendar class="h-4 w-4 text-brand-coral" />
                        {{ formatDateTime(event.starts_at) }}
                    </span>
                    <span v-if="event.location" class="flex items-center gap-1.5">
                        <MapPin class="h-4 w-4 text-brand-coral" />
                        {{ event.location }}
                    </span>
                </div>
            </div>
        </section>

        <Wave color="#ffffff" />

        <section class="bg-white py-12">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                <p v-if="event.description" class="text-brand-ink/70 leading-relaxed whitespace-pre-line">
                    {{ event.description }}
                </p>
                <p v-else class="text-brand-ink/40">Popis není k dispozici.</p>
            </div>
        </section>
    </PublicLayout>
</template>
