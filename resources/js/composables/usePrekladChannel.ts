import type { RealtimeChannel } from '@supabase/supabase-js'
import { onUnmounted, ref  } from 'vue'
import type {Ref} from 'vue';
import type { CaptionEvent, ConnectionState } from '@/lib/preklad/types'
import { getSupabase } from '@/lib/supabase'

const CAPTION_EVENT = 'caption'

export interface PrekladChannel {
    connectionState: Ref<ConnectionState>
    listenerCount: Ref<number>
    /** Broadcaster: publish a caption segment. */
    publish: (payload: CaptionEvent) => void
    /** Viewer: register a handler for incoming caption segments. */
    onCaption: (handler: (payload: CaptionEvent) => void) => void
    /** Viewer: announce presence so the broadcaster can count listeners. */
    trackPresence: () => void
    leave: () => void
}

/**
 * Subscribe to the private Realtime Broadcast channel `sermon:{id}`. Supabase's
 * client handles its own reconnect, so we only surface a connection indicator
 * (spec §9.8). Writes require a broadcaster JWT (set via `accessToken`); reads
 * work for the anon role.
 */
export function usePrekladChannel(sessionId: Ref<string | null>, accessToken?: Ref<string | null>): PrekladChannel {
    const connectionState = ref<ConnectionState>('idle')
    const listenerCount = ref(0)
    const captionHandlers: Array<(payload: CaptionEvent) => void> = []

    let channel: RealtimeChannel | null = null

    function ensureChannel(): RealtimeChannel | null {
        const supabase = getSupabase()

        if (!supabase || !sessionId.value) {
            return null
        }

        if (channel) {
            return channel
        }

        connectionState.value = 'connecting'
        supabase.realtime.setAuth(accessToken?.value ?? undefined)

        channel = supabase.channel(`sermon:${sessionId.value}`, {
            config: { broadcast: { self: false }, private: true },
        })

        channel.on('broadcast', { event: CAPTION_EVENT }, ({ payload }) => {
            for (const handler of captionHandlers) {
                handler(payload as CaptionEvent)
            }
        })

        channel.on('presence', { event: 'sync' }, () => {
            const state = channel?.presenceState() ?? {}
            listenerCount.value = Object.keys(state).length
        })

        channel.subscribe((status) => {
            if (status === 'SUBSCRIBED') {
                connectionState.value = 'open'
            } else if (status === 'CHANNEL_ERROR' || status === 'TIMED_OUT') {
                connectionState.value = 'reconnecting'
            } else if (status === 'CLOSED') {
                connectionState.value = 'closed'
            }
        })

        return channel
    }

    function publish(payload: CaptionEvent): void {
        const ch = ensureChannel()
        void ch?.send({ type: 'broadcast', event: CAPTION_EVENT, payload })
    }

    function onCaption(handler: (payload: CaptionEvent) => void): void {
        captionHandlers.push(handler)
        ensureChannel()
    }

    function trackPresence(): void {
        const ch = ensureChannel()
        void ch?.track({ at: Date.now() })
    }

    function leave(): void {
        if (channel) {
            void getSupabase()?.removeChannel(channel)
            channel = null
        }

        connectionState.value = 'closed'
    }

    onUnmounted(leave)

    return { connectionState, listenerCount, publish, onCaption, trackPresence, leave }
}
