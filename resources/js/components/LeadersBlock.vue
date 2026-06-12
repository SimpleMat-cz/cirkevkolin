<script setup lang="ts">
import { Mail, Phone } from 'lucide-vue-next';
import type { PageLeader } from '@/types';

/**
 * Zobrazuje vedoucí dané aktivity (libovolný počet).
 * Obrázky: lokální path nebo externí URL (z brand assets).
 * Pokud není fotka, zobrazí se kruh s iniciálou.
 */
withDefaults(
    defineProps<{
        title?: string;
        subtitle?: string;
        leaders: PageLeader[];
    }>(),
    {
        title: 'Kdo to vede',
        subtitle: 'Ozvi se komukoliv z nás — rádi tě potkáme.',
    },
);

function initial(name: string): string {
    return name
        .trim()
        .split(' ')
        .map((w) => w[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
}
</script>

<template>
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6">
            <div class="reveal text-center">
                <span
                    class="text-xs font-bold tracking-[0.2em] text-brand-coral uppercase"
                    >{{ title }}</span
                >
                <h2
                    class="mt-3 font-display text-3xl text-brand-ink sm:text-4xl"
                >
                    {{ subtitle }}
                </h2>
            </div>

            <div
                :class="[
                    'mt-10 grid gap-6',
                    leaders.length === 1
                        ? 'mx-auto max-w-sm grid-cols-1'
                        : leaders.length === 2
                          ? 'grid-cols-1 sm:grid-cols-2'
                          : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
                ]"
            >
                <div
                    v-for="(leader, i) in leaders"
                    :key="leader.name"
                    :class="[
                        'reveal hover-lift flex flex-col items-center gap-4 rounded-3xl bg-brand-cream p-6 ring-1 ring-brand-ink/5 sm:p-8',
                        `reveal-delay-${Math.min(i + 1, 3)}`,
                    ]"
                >
                    <div
                        class="relative h-36 w-36 overflow-hidden rounded-full shadow-[0_18px_40px_-18px_rgba(42,42,42,0.35)] ring-4 ring-white"
                    >
                        <img
                            v-if="leader.photo"
                            :src="leader.photo"
                            :alt="leader.name"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-coral via-brand-sunny to-brand-mint font-display text-4xl text-white"
                        >
                            {{ initial(leader.name) }}
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="font-display text-xl text-brand-ink">
                            {{ leader.name }}
                        </h3>
                        <p
                            v-if="leader.role"
                            class="mt-1 text-sm text-brand-ink-soft"
                        >
                            {{ leader.role }}
                        </p>
                        <div
                            v-if="leader.phone || leader.email"
                            class="mt-3 flex flex-col items-center gap-1.5"
                        >
                            <a
                                v-if="leader.phone"
                                :href="`tel:${leader.phone.replace(/\s/g, '')}`"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-primary-dark hover:underline"
                            >
                                <Phone class="h-3.5 w-3.5" />
                                {{ leader.phone }}
                            </a>
                            <a
                                v-if="leader.email"
                                :href="`mailto:${leader.email}`"
                                class="inline-flex items-center gap-1.5 text-sm text-brand-ink-soft hover:underline"
                            >
                                <Mail class="h-3.5 w-3.5" />
                                {{ leader.email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
