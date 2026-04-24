<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import { Menu, X } from 'lucide-vue-next'

const isScrolled = ref(false)
const isMenuOpen = ref(false)

function handleScroll() {
    isScrolled.value = window.scrollY > 20
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))

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
        :class="isScrolled ? 'bg-white/90 shadow-sm backdrop-blur-md' : 'bg-transparent'"
    >
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <!-- Logo -->
            <Link href="/" class="font-display text-xl font-bold text-brand-ink lowercase tracking-tight">
                církev kolín
            </Link>

            <!-- Desktop nav -->
            <ul class="hidden items-center gap-6 lg:flex">
                <li v-for="link in navLinks" :key="link.href">
                    <Link
                        :href="link.href"
                        class="text-sm font-medium text-brand-ink/80 transition-colors hover:text-brand-primary-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
                    >
                        {{ link.label }}
                    </Link>
                </li>
            </ul>

            <!-- CTA + Hamburger -->
            <div class="flex items-center gap-3">
                <Link
                    href="/prispet"
                    class="hidden rounded-full bg-brand-coral px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90 sm:block"
                >
                    Přispět
                </Link>
                <button
                    class="rounded-md p-2 text-brand-ink/70 transition-colors hover:bg-brand-ink/5 lg:hidden"
                    :aria-label="isMenuOpen ? 'Zavřít menu' : 'Otevřít menu'"
                    :aria-expanded="isMenuOpen"
                    @click="isMenuOpen = !isMenuOpen"
                >
                    <X v-if="isMenuOpen" class="h-6 w-6" />
                    <Menu v-else class="h-6 w-6" />
                </button>
            </div>
        </nav>

        <!-- Mobile menu -->
        <div
            v-show="isMenuOpen"
            class="border-t border-brand-ink/10 bg-white/95 backdrop-blur-md lg:hidden"
            role="navigation"
            aria-label="Mobilní navigace"
        >
            <ul class="mx-auto max-w-6xl space-y-1 px-4 py-4 sm:px-6">
                <li v-for="link in navLinks" :key="link.href">
                    <Link
                        :href="link.href"
                        class="block rounded-md px-3 py-2 text-base font-medium text-brand-ink/80 transition-colors hover:bg-brand-primary/10 hover:text-brand-primary-dark"
                        @click="isMenuOpen = false"
                    >
                        {{ link.label }}
                    </Link>
                </li>
                <li class="pt-2">
                    <Link
                        href="/prispet"
                        class="block rounded-full bg-brand-coral px-4 py-2 text-center text-sm font-semibold text-white"
                        @click="isMenuOpen = false"
                    >
                        Přispět
                    </Link>
                </li>
            </ul>
        </div>
    </header>
</template>
