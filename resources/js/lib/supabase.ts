import { createClient  } from '@supabase/supabase-js'
import type {SupabaseClient} from '@supabase/supabase-js';

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL as string | undefined
const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY as string | undefined

let client: SupabaseClient | null = null

/**
 * Lazily-created Supabase client for the sermon-translation module. Backed by the
 * church's existing "jako-doma" project, which provides Auth + Realtime Broadcast.
 * Returns null when env vars are missing so pages can render a config warning
 * instead of crashing.
 */
export function getSupabase(): SupabaseClient | null {
    if (!supabaseUrl || !supabaseAnonKey) {
        return null
    }

    if (!client) {
        client = createClient(supabaseUrl, supabaseAnonKey, {
            realtime: { params: { eventsPerSecond: 10 } },
        })
    }

    return client
}

export const isSupabaseConfigured = Boolean(supabaseUrl && supabaseAnonKey)
