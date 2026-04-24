<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { MapPin, Mail, CreditCard } from 'lucide-vue-next'
import BrandLogo from '@/components/BrandLogo.vue'
import Blob from '@/components/Blob.vue'
</script>

<template>
    <footer class="relative overflow-hidden bg-brand-ink text-white">
        <!-- Organic accent shapes -->
        <Blob color="#ff8c69" :size="360" :opacity="0.14" variant="2" float="slow" class="-left-24 -top-24" />
        <Blob color="#4db6ac" :size="300" :opacity="0.12" variant="3" float="none" class="-right-20 top-40" />

        <div class="relative mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:py-20">
            <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-12">
                <!-- Brand -->
                <div class="lg:col-span-5">
                    <BrandLogo variant="B" color="light" :size="160" />
                    <p class="mt-6 max-w-md text-base leading-relaxed text-white/70">
                        Apoštolská církev Kolín. Místo, kde se cítíte jako doma — bez ohledu na to, kdo jste nebo odkud přicházíte.
                    </p>

                    <!-- Socials -->
                    <div class="mt-8 flex gap-3">
                        <a
                            v-for="s in [
                                { href: 'https://www.facebook.com/cirkevkolin', label: 'Facebook', path: 'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z' },
                                { href: 'https://www.instagram.com/cirkevkolin', label: 'Instagram', path: 'M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z' },
                                { href: 'https://www.youtube.com/channel/UCnsKOpdlWx4wS0mos_PXfDg', label: 'YouTube', path: 'M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z' },
                            ]"
                            :key="s.label"
                            :href="s.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:-translate-y-0.5 hover:bg-brand-coral hover:text-white"
                            :aria-label="s.label"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path :d="s.path" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Contact -->
                <div class="lg:col-span-4">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-coral">Kontakt</h3>
                    <ul class="mt-5 space-y-4">
                        <li class="flex items-start gap-3">
                            <MapPin class="mt-0.5 h-5 w-5 shrink-0 text-brand-coral" />
                            <span class="text-sm leading-relaxed text-white/80">
                                V Zídkách 402, Kolín 2<br>
                                <span class="text-white/50">(vchod z Benešovy ulice)</span><br>
                                PSČ 280 02
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Mail class="h-5 w-5 shrink-0 text-brand-coral" />
                            <a
                                href="mailto:kolin@apostolskacirkev.cz"
                                class="text-sm text-white/80 transition-colors hover:text-white"
                            >
                                kolin@apostolskacirkev.cz
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <CreditCard class="h-5 w-5 shrink-0 text-brand-coral" />
                            <span class="text-sm text-white/80">č.ú. 435669379 / 0800</span>
                        </li>
                    </ul>
                </div>

                <!-- Links -->
                <div class="lg:col-span-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-coral">Stránky</h3>
                    <ul class="mt-5 space-y-3">
                        <li v-for="link in [
                            { label: 'Neděle', href: '/nedele' },
                            { label: 'Jsem tu poprvé', href: '/jsem-tu-poprve' },
                            { label: 'Kázání', href: '/kazani' },
                            { label: 'Akce', href: '/akce' },
                            { label: 'Kdo jsme', href: '/kdo-jsme' },
                            { label: 'Přispět', href: '/prispet' },
                        ]" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-sm text-white/70 transition-colors hover:text-white"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-14 flex flex-col gap-3 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-white/40">
                    © {{ new Date().getFullYear() }} Apoštolská církev Kolín — součást Apoštolské církve v ČR.
                </p>
                <div class="flex gap-5 text-xs text-white/40">
                    <a href="/cookies" class="transition-colors hover:text-white/70">Cookies</a>
                    <a href="/gdpr" class="transition-colors hover:text-white/70">GDPR</a>
                    <a href="/pristupnost" class="transition-colors hover:text-white/70">Přístupnost</a>
                </div>
            </div>
        </div>
    </footer>
</template>
