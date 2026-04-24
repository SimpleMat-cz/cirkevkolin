<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { Menu, X } from 'lucide-vue-next'
import BrandLogo from '@/components/BrandLogo.vue'

const isScrolled = ref(false)
const isMenuOpen = ref(false)

function handleScroll() {
    isScrolled.value = window.scrollY > 16
}

onMounted(() => {
    handleScroll()
    window.addEventListener('scroll', handleScroll, { passive: true })
})
onUnmounted(() => window.removeEventListener('scroll', handleScroll))

// Lock scroll when mobile menu is open
watch(isMenuOpen, (v) => {
    document.documentElement.style.overflow = v ? 'hidden' : ''
})

const navLinks = [
    { label: 'Neděle', href: '/nedele' },
    { label: 'Jsem tu poprvé', href: '/jsem-tu-poprve' },
    { label: 'Co děláme', href: '/co-delame' },
    { label: 'Kázání', href: '/kazani' },
    { label: 'Akce', href: '/akce' },
    { label: 'Kontakt', href: '/kontakt' },
]
</script>

<template>
    <header
        class="fixed top-0 z-50 w-full transition-all duration-300"
        :class="[
            isScrolled || isMenuOpen
                ? 'bg-brand-cream/92 shadow-[0_2px_20px_-8px_rgba(42,42,42,0.12)] backdrop-blur-md'
                : 'bg-transparent',
        ]"
    >
        <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 sm:py-4">
            <Link
                href="/"
                class="shrink-0 transition-transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-4 focus-visible:ring-offset-brand-cream"
                aria-label="Domů — církev kolín"
            >
                <BrandLogo variant="B" color="primary" :size="150" />
            </Link>

            <ul class="hidden items-center gap-7 lg:flex">
                <li v-for="link in navLinks" :key="link.href">
                    <Link
                        :href="link.href"
                        class="group relative text-[15px] font-medium text-brand-ink transition-colors hover:text-brand-primary focus-visible:outline-none focus-visible:text-brand-primary"
                    >
                        {{ link.label }}
                        <span
                            class="absolute -bottom-1 left-0 h-[2px] w-full origin-left scale-x-0 bg-brand-coral transition-transform duration-300 group-hover:scale-x-100"
                        />
                    </Link>
                </li>
            </ul>

            <div class="flex items-center gap-3">
                <Link
                    href="/prispet"
                    class="btn-coral hidden rounded-full bg-brand-coral px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-brand-coral-dark hover:shadow-lg hover:shadow-brand-coral/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-coral focus-visible:ring-offset-2 sm:block"
                >
                    Přispět
                </Link>
                <button
                    class="rounded-full p-2 text-brand-ink transition-colors hover:bg-brand-ink/5 lg:hidden"
                    :aria-label="isMenuOpen ? 'Zavřít menu' : 'Otevřít menu'"
                    :aria-expanded="isMenuOpen"
                    @click="isMenuOpen = !isMenuOpen"
                >
                    <X v-if="isMenuOpen" class="h-6 w-6" />
                    <Menu v-else class="h-6 w-6" />
                </button>
            </div>
        </nav>

        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-show="isMenuOpen"
                class="border-t border-brand-ink/5 bg-brand-cream lg:hidden"
                role="navigation"
                aria-label="Mobilní navigace"
            >
                <ul class="mx-auto max-w-6xl space-y-1 px-4 py-4 sm:px-6">
                    <li v-for="link in navLinks" :key="link.href">
                        <Link
                            :href="link.href"
                            class="block rounded-xl px-4 py-3 text-base font-medium text-brand-ink transition-colors hover:bg-brand-primary/10 hover:text-brand-primary focus-visible:outline-none focus-visible:bg-brand-primary/10"
                            @click="isMenuOpen = false"
                        >
                            {{ link.label }}
                        </Link>
                    </li>
                    <li class="pt-2">
                        <Link
                            href="/prispet"
                            class="block rounded-full bg-brand-coral px-4 py-3 text-center text-sm font-semibold text-white transition-colors hover:bg-brand-coral-dark"
                            @click="isMenuOpen = false"
                        >
                            Přispět
                        </Link>
                    </li>
                </ul>
            </div>
        </Transition>
    </header>
</template>
