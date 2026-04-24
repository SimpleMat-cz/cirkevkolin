<script setup lang="ts">
withDefaults(
    defineProps<{
        color?: string
        flip?: boolean
        height?: number
    }>(),
    {
        color: '#f5f5dc',
        flip: false,
        height: 80,
    },
)
</script>

<template>
    <div
        class="w-full overflow-hidden leading-none"
        :class="{ 'scale-y-[-1]': flip }"
        aria-hidden="true"
    >
        <svg
            :height="height"
            viewBox="0 0 1440 80"
            preserveAspectRatio="none"
            xmlns="http://www.w3.org/2000/svg"
            class="w-full"
        >
            <path
                :fill="color"
                d="M0,40 C180,80 360,0 540,40 C720,80 900,0 1080,40 C1260,80 1350,20 1440,40 L1440,80 L0,80 Z"
            />
        </svg>
    </div>
</template>
