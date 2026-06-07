import type { RealtimeChannel, SupabaseClient } from '@supabase/supabase-js';
import type { Ref } from 'vue';
import { onUnmounted, ref } from 'vue';
import type { CaptionEvent, ConnectionState } from '@/lib/preklad/types';
import { getBroadcasterClient, getSupabase } from '@/lib/supabase';

const CAPTION_EVENT = 'caption';

export interface PrekladChannel {
    connectionState: Ref<ConnectionState>;
    listenerCount: Ref<number>;
    /** Broadcaster: publish a caption segment. */
    publish: (payload: CaptionEvent) => void;
    /** Viewer: register a handler for incoming caption segments. */
    onCaption: (handler: (payload: CaptionEvent) => void) => void;
    /** Viewer: announce presence so the broadcaster can count listeners. */
    trackPresence: () => void;
    leave: () => void;
}

/**
 * Subscribe to the private Realtime Broadcast channel `sermon:{id}`. Supabase's
 * client handles its own reconnect, so we only surface a connection indicator
 * (spec §9.8). Viewers use the anon client (read-only); the broadcaster passes a
 * Laravel-minted token and gets an authorized client (write).
 */
export function usePrekladChannel(
    sessionId: Ref<string | null>,
    accessToken?: Ref<string | null>,
): PrekladChannel {
    const connectionState = ref<ConnectionState>('idle');
    const listenerCount = ref(0);
    const captionHandlers: Array<(payload: CaptionEvent) => void> = [];

    let channel: RealtimeChannel | null = null;

    function resolveClient(): SupabaseClient | null {
        if (accessToken?.value) {
            return getBroadcasterClient(accessToken.value);
        }

        return getSupabase();
    }

    function ensureChannel(): RealtimeChannel | null {
        const supabase = resolveClient();

        if (!supabase || !sessionId.value) {
            return null;
        }

        if (channel) {
            return channel;
        }

        connectionState.value = 'connecting';

        if (accessToken?.value) {
            supabase.realtime.setAuth(accessToken.value);
        }

        channel = supabase.channel(`sermon:${sessionId.value}`, {
            config: { broadcast: { self: false }, private: true },
        });

        channel.on('broadcast', { event: CAPTION_EVENT }, ({ payload }) => {
            for (const handler of captionHandlers) {
                handler(payload as CaptionEvent);
            }
        });

        channel.on('presence', { event: 'sync' }, () => {
            const state = channel?.presenceState() ?? {};
            listenerCount.value = Object.keys(state).length;
        });

        channel.subscribe((status) => {
            if (status === 'SUBSCRIBED') {
                connectionState.value = 'open';
            } else if (status === 'CHANNEL_ERROR' || status === 'TIMED_OUT') {
                connectionState.value = 'reconnecting';
            } else if (status === 'CLOSED') {
                connectionState.value = 'closed';
            }
        });

        return channel;
    }

    function publish(payload: CaptionEvent): void {
        const ch = ensureChannel();
        void ch?.send({ type: 'broadcast', event: CAPTION_EVENT, payload });
    }

    function onCaption(handler: (payload: CaptionEvent) => void): void {
        captionHandlers.push(handler);
        ensureChannel();
    }

    function trackPresence(): void {
        const ch = ensureChannel();
        void ch?.track({ at: Date.now() });
    }

    function leave(): void {
        if (channel) {
            void resolveClient()?.removeChannel(channel);
            channel = null;
        }

        connectionState.value = 'closed';
    }

    onUnmounted(leave);

    return {
        connectionState,
        listenerCount,
        publish,
        onCaption,
        trackPresence,
        leave,
    };
}
