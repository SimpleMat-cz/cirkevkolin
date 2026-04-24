<script setup lang="ts">
/**
 * Typografické logo "církev kolín" podle logomanuálu.
 * Barva: brand-primary (#0eb0e5). Písmo: Archia Bold → náhrada Archivo Black.
 * Varianta A (stacked, 2 řádky) a B (single line).
 */
withDefaults(
    defineProps<{
        variant?: 'A' | 'B'
        color?: 'primary' | 'dark' | 'light'
        size?: number
    }>(),
    {
        variant: 'B',
        color: 'primary',
        size: 140,
    },
)

const colorMap = {
    primary: '#0eb0e5',
    dark: '#1a1a1a',
    light: '#ffffff',
}
</script>

<template>
    <span
        class="inline-flex select-none items-center leading-none"
        role="img"
        aria-label="církev kolín"
    >
        <svg
            v-if="variant === 'B'"
            :width="size"
            :height="size * 0.22"
            viewBox="0 0 280 62"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            class="overflow-visible"
        >
            <text
                x="0"
                y="46"
                :fill="colorMap[color]"
                font-family="'Archivo Black', 'Archivo', sans-serif"
                font-weight="900"
                font-size="54"
                letter-spacing="-1.5"
            >
                církev kolín
            </text>
        </svg>
        <svg
            v-else
            :width="size"
            :height="size * 0.56"
            viewBox="0 0 160 90"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            class="overflow-visible"
        >
            <text
                x="0"
                y="40"
                :fill="colorMap[color]"
                font-family="'Archivo Black', 'Archivo', sans-serif"
                font-weight="900"
                font-size="42"
                letter-spacing="-1"
            >
                církev
            </text>
            <text
                x="0"
                y="82"
                :fill="colorMap[color]"
                font-family="'Archivo Black', 'Archivo', sans-serif"
                font-weight="900"
                font-size="42"
                letter-spacing="-1"
            >
                kolín
            </text>
        </svg>
    </span>
</template>
