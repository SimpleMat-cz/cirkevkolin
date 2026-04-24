<script setup lang="ts">
withDefaults(
    defineProps<{
        color?: string
        size?: number
        position?: 'top-left' | 'top-right' | 'bottom-left' | 'bottom-right'
    }>(),
    {
        color: '#ff8c69',
        size: 300,
        position: 'top-right',
    },
)
</script>

<template>
    <div
        class="pointer-events-none absolute overflow-hidden"
        :class="{
            'right-0 top-0': position === 'top-right',
            'left-0 top-0': position === 'top-left',
            'bottom-0 right-0': position === 'bottom-right',
            'bottom-0 left-0': position === 'bottom-left',
        }"
        aria-hidden="true"
    >
        <svg
            :width="size"
            :height="size"
            viewBox="0 0 200 200"
            xmlns="http://www.w3.org/2000/svg"
            class="motion-safe:animate-[blob_8s_ease-in-out_infinite] opacity-20"
        >
            <path
                :fill="color"
                d="M44.7,-76.4C58.7,-69.1,70.8,-58.3,78.3,-44.7C85.9,-31.1,89,-14.8,87.4,0.9C85.9,16.6,79.6,31.4,70.5,43.7C61.3,56,49.3,65.8,35.7,72.2C22.1,78.6,6.9,81.5,-8.3,80.5C-23.6,79.5,-38.9,74.6,-51.7,65.9C-64.5,57.3,-74.9,45,-80.7,30.5C-86.5,16,-87.7,-0.7,-83.9,-15.8C-80.1,-30.9,-71.3,-44.5,-59.9,-53.7C-48.4,-62.9,-34.4,-67.7,-20.7,-74.8C-7,-81.9,6.4,-91.3,20.3,-91.1C34.2,-90.9,30.7,-83.7,44.7,-76.4Z"
                transform="translate(100 100)"
            />
        </svg>
    </div>
</template>
