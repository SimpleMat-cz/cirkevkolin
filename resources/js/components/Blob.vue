<script setup lang="ts">
/**
 * Organický asymetrický blob z brand manuálu.
 * Několik path-variant, animovaná morph i plovoucí pohyb.
 * Dekorativní, aria-hidden, reaguje na prefers-reduced-motion.
 */
const props = withDefaults(
    defineProps<{
        color?: string
        size?: number | string
        variant?: 1 | 2 | 3 | 4 | '1' | '2' | '3' | '4'
        opacity?: number
        float?: 'fast' | 'slow' | 'none'
        /** Směr + rychlost rotace SVG (v sekundách na oběh). 0 = bez rotace. */
        spin?: 'cw' | 'ccw' | 'none'
        spinDuration?: number
        class?: string
    }>(),
    {
        color: '#ff8c69',
        size: 320,
        variant: 1,
        opacity: 1,
        float: 'slow',
        spin: 'cw',
        spinDuration: 60,
    },
)

const paths: Record<number, string> = {
    1: 'M44.7,-76.4C58.7,-69.1,70.8,-58.3,78.3,-44.7C85.9,-31.1,89,-14.8,87.4,0.9C85.9,16.6,79.6,31.4,70.5,43.7C61.3,56,49.3,65.8,35.7,72.2C22.1,78.6,6.9,81.5,-8.3,80.5C-23.6,79.5,-38.9,74.6,-51.7,65.9C-64.5,57.3,-74.9,45,-80.7,30.5C-86.5,16,-87.7,-0.7,-83.9,-15.8C-80.1,-30.9,-71.3,-44.5,-59.9,-53.7C-48.4,-62.9,-34.4,-67.7,-20.7,-74.8C-7,-81.9,6.4,-91.3,20.3,-91.1C34.2,-90.9,30.7,-83.7,44.7,-76.4Z',
    2: 'M38.4,-66.3C50.8,-57.8,62.3,-49.1,69.8,-37.4C77.3,-25.7,80.9,-11,80.9,4C80.9,19,77.2,34.3,68.5,45.8C59.7,57.3,45.9,65,31.4,70.7C16.9,76.4,1.7,80.2,-13.5,78.6C-28.7,77,-43.9,70,-56.4,59.4C-68.9,48.7,-78.7,34.4,-82.6,18.6C-86.5,2.8,-84.5,-14.6,-77.2,-28.7C-69.9,-42.8,-57.3,-53.6,-43.6,-62.2C-29.8,-70.8,-14.9,-77.3,-0.9,-75.9C13.1,-74.5,26,-74.9,38.4,-66.3Z',
    3: 'M47.1,-69.3C59.5,-60.5,67.3,-45.2,71.6,-30.1C75.9,-15,76.8,-0.1,74.2,14.4C71.7,29,65.7,43.1,55.6,54.5C45.5,65.8,31.4,74.3,15.6,78.2C-0.2,82.1,-17.7,81.3,-32.4,74.7C-47.1,68.1,-59,55.7,-67.9,41.1C-76.9,26.6,-82.9,9.9,-82.1,-6.4C-81.3,-22.7,-73.6,-38.6,-62.1,-49C-50.6,-59.4,-35.2,-64.3,-20.4,-69.6C-5.6,-74.9,8.7,-80.5,22.8,-79.1C36.9,-77.7,34.7,-78.1,47.1,-69.3Z',
    4: 'M54.2,-71.3C68.4,-62.9,76.1,-44.8,78.6,-27.3C81.1,-9.7,78.5,7.3,72.4,22.3C66.3,37.4,56.7,50.4,43.8,59.5C30.8,68.6,14.4,73.7,-1.6,76C-17.6,78.2,-33.3,77.6,-46,70.2C-58.7,62.7,-68.5,48.4,-73.5,32.9C-78.5,17.3,-78.7,0.6,-76.5,-15.8C-74.4,-32.2,-70,-48.2,-59.6,-57.5C-49.3,-66.7,-33,-69.2,-17.7,-71.9C-2.5,-74.5,11.5,-77.3,26.1,-76.1C40.6,-74.9,56,-69.7,54.2,-71.3Z',
}

const floatClass: Record<string, string> = {
    fast: 'motion-safe:animate-[blob-float_14s_ease-in-out_infinite]',
    slow: 'motion-safe:animate-[blob-float-slow_22s_ease-in-out_infinite]',
    none: '',
}

const spinStyle = props.spin === 'none'
    ? undefined
    : {
        animation: `${props.spin === 'cw' ? 'blob-spin' : 'blob-spin-reverse'} ${props.spinDuration}s linear infinite`,
        transformOrigin: 'center',
    }
</script>

<template>
    <div
        :class="[
            'pointer-events-none absolute',
            floatClass[float],
            $props.class,
        ]"
        aria-hidden="true"
    >
        <svg
            :width="size"
            :height="size"
            viewBox="-100 -100 200 200"
            xmlns="http://www.w3.org/2000/svg"
            class="overflow-visible motion-reduce:!animate-none"
            :style="spinStyle"
        >
            <path
                :fill="color"
                :d="paths[Number(variant)]"
                :opacity="opacity"
            />
        </svg>
    </div>
</template>
