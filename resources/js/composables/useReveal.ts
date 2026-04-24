import { onMounted, onBeforeUnmount, nextTick } from 'vue'
import { router } from '@inertiajs/vue3'

/**
 * Scroll-reveal composable.
 * Přidá třídu `is-visible` všem prvkům s třídou `.reveal` (+ volitelně další selektory),
 * když vstoupí do viewportu. Respektuje prefers-reduced-motion.
 *
 * - Elementy už viditelné při mountu dostanou `is-visible` okamžitě.
 * - Re-mount při Inertia page transition (navigace).
 */
export function useReveal(selector = '.reveal') {
    let observer: IntersectionObserver | null = null
    let removeInertiaListener: (() => void) | null = null

    function revealNow(el: Element) {
        el.classList.add('is-visible')
    }

    function isInViewport(el: Element): boolean {
        const rect = el.getBoundingClientRect()
        return (
            rect.top < window.innerHeight &&
            rect.bottom > 0 &&
            rect.left < window.innerWidth &&
            rect.right > 0
        )
    }

    function bind() {
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
        const targets = document.querySelectorAll<HTMLElement>(selector)

        if (prefersReduced) {
            targets.forEach(revealNow)
            return
        }

        observer?.disconnect()
        observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        revealNow(entry.target)
                        observer?.unobserve(entry.target)
                    }
                })
            },
            { threshold: 0.01, rootMargin: '0px 0px -5% 0px' },
        )

        targets.forEach((el) => {
            if (el.classList.contains('is-visible')) {
                return
            }
            if (isInViewport(el)) {
                // Already in view on mount — reveal immediately, no fade.
                revealNow(el)
                return
            }
            observer!.observe(el)
        })
    }

    onMounted(() => {
        nextTick(() => requestAnimationFrame(bind))
        // Re-bind on Inertia navigation (new DOM).
        removeInertiaListener = router.on('success', () => {
            nextTick(() => requestAnimationFrame(bind))
        })
    })

    onBeforeUnmount(() => {
        observer?.disconnect()
        removeInertiaListener?.()
    })
}
