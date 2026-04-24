import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

// Wayfinder potřebuje PHP CLI, které na Vercelu při npm run build není k dispozici.
// Vygenerované soubory (`resources/js/actions`, `resources/js/routes`) commitujeme do repa,
// plugin proto na CI/Vercelu vypneme a spoléháme na statická routes.
const useWayfinder = process.env.VERCEL !== '1' && process.env.CI !== 'true';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        ...(useWayfinder ? [wayfinder({ formVariants: true })] : []),
    ],
});
