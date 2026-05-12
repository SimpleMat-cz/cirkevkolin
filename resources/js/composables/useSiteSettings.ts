import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { SiteSettings } from '@/types';

/**
 * Access globally shared site settings (set via HandleInertiaRequests).
 * Use `site('key')` to read a value, with optional fallback.
 */
export function useSiteSettings() {
    const page = usePage();

    const settings = computed<SiteSettings>(() => (page.props.site as SiteSettings | undefined) ?? {});

    function site(key: string, fallback: string = ''): string {
        return settings.value[key] ?? fallback;
    }

    return { settings, site };
}
