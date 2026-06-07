import { createClient } from '@supabase/supabase-js';
import type { SupabaseClient } from '@supabase/supabase-js';

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL as string | undefined;
const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY as
    | string
    | undefined;

let client: SupabaseClient | null = null;

/**
 * Lazily-created Supabase client for the sermon-translation module. Backed by the
 * church's existing "jako-doma" project, which provides Auth + Realtime Broadcast.
 * Returns null when env vars are missing so pages can render a config warning
 * instead of crashing.
 */
export function getSupabase(): SupabaseClient | null {
    if (!supabaseUrl || !supabaseAnonKey) {
        return null;
    }

    if (!client) {
        client = createClient(supabaseUrl, supabaseAnonKey, {
            realtime: { params: { eventsPerSecond: 10 } },
        });
    }

    return client;
}

let broadcasterClient: { token: string; client: SupabaseClient } | null = null;

/**
 * Client authorized as a broadcaster via a Laravel-minted Supabase JWT. The
 * token is sent as the Authorization header (so PostgREST writes pass RLS) and
 * via realtime.setAuth (so private-channel broadcasts pass RLS). Memoized per
 * token to avoid recreating channels.
 */
export function getBroadcasterClient(token: string): SupabaseClient | null {
    if (!supabaseUrl || !supabaseAnonKey) {
        return null;
    }

    if (!broadcasterClient || broadcasterClient.token !== token) {
        const client = createClient(supabaseUrl, supabaseAnonKey, {
            global: { headers: { Authorization: `Bearer ${token}` } },
            realtime: { params: { eventsPerSecond: 10 } },
        });
        client.realtime.setAuth(token);
        broadcasterClient = { token, client };
    }

    return broadcasterClient.client;
}

export const isSupabaseConfigured = Boolean(supabaseUrl && supabaseAnonKey);
