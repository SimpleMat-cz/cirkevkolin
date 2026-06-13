import type { RealtimeChannel, SupabaseClient } from '@supabase/supabase-js';
import type { Ref } from 'vue';
import { onUnmounted, ref } from 'vue';
import type {
    CaptionEvent,
    CaptionLang,
    ConnectionState,
} from '@/lib/preklad/types';
import { getBroadcasterClient, getSupabase } from '@/lib/supabase';

const CAPTION_EVENT = 'caption';

interface PresenceMeta {
    at: number;
    lang?: CaptionLang | null;
}

export interface PrekladChannel {
    connectionState: Ref<ConnectionState>;
    listenerCount: Ref<number>;
    /** Broadcaster: distinct languages currently requested by at least one guest. */
    requestedLangs: Ref<CaptionLang[]>;
    /** Broadcaster: ensure the channel is subscribed (to start receiving presence). */
    connect: () => void;
    /** Broadcaster: publish a caption segment. */
    publish: (payload: CaptionEvent) => void;
    /** Viewer: register a handler for incoming caption segments. */
    onCaption: (handler: (payload: CaptionEvent) => void) => void;
    /** Viewer: announce presence (and which language the guest is reading). */
    trackPresence: (lang?: CaptionLang | null) => void;
    leave: () => void;
}

/**
 * Subscribe to the private Realtime Broadcast channel `sermon:{id}`. Supabase's
 * client handles its own reconnect, so we only surface a connection indicator.
 * Viewers use the anon client (read-only) and announce — via presence — which
 * language they're reading; the broadcaster reads that to spin translation
 * sessions up and down on demand. The broadcaster passes a Laravel-minted token
 * and gets an authorized client (write).
 */
export function usePrekladChannel(
    sessionId: Ref<string | null>,
    accessToken?: Ref<string | null>,
): PrekladChannel {
    const connectionState = ref<ConnectionState>('idle');
    const listenerCount = ref(0);
    const requestedLangs = ref<CaptionLang[]>([]);
    const captionHandlers: Array<(payload: CaptionEvent) => void> = [];

    let channel: RealtimeChannel | null = null;
    let presenceLang: CaptionLang | null = null;
    let tracking = false;

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
            const state = (channel?.presenceState() ?? {}) as Record<
                string,
                PresenceMeta[]
            >;
            const keys = Object.keys(state);
            listenerCount.value = keys.length;

            const langs = new Set<CaptionLang>();

            for (const key of keys) {
                for (const meta of state[key]) {
                    if (meta.lang) {
                        langs.add(meta.lang);
                    }
                }
            }

            requestedLangs.value = [...langs];
        });

        channel.subscribe((status) => {
            if (status === 'SUBSCRIBED') {
                connectionState.value = 'open';

                if (tracking) {
                    void channel?.track({ at: Date.now(), lang: presenceLang });
                }
            } else if (status === 'CHANNEL_ERROR' || status === 'TIMED_OUT') {
                connectionState.value = 'reconnecting';
            } else if (status === 'CLOSED') {
                connectionState.value = 'closed';
            }
        });

        return channel;
    }

    function connect(): void {
        ensureChannel();
    }

    function publish(payload: CaptionEvent): void {
        const ch = ensureChannel();
        void ch?.send({ type: 'broadcast', event: CAPTION_EVENT, payload });
    }

    function onCaption(handler: (payload: CaptionEvent) => void): void {
        captionHandlers.push(handler);
        ensureChannel();
    }

    function trackPresence(lang?: CaptionLang | null): void {
        presenceLang = lang ?? null;
        tracking = true;
        const ch = ensureChannel();
        void ch?.track({ at: Date.now(), lang: presenceLang });
    }

    function leave(): void {
        if (channel) {
            void resolveClient()?.removeChannel(channel);
            channel = null;
        }

        tracking = false;
        connectionState.value = 'closed';
    }

    onUnmounted(leave);

    return {
        connectionState,
        listenerCount,
        requestedLangs,
        connect,
        publish,
        onCaption,
        trackPresence,
        leave,
    };
}
