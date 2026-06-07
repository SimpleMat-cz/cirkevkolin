export type CaptionLang = 'cs' | 'en' | 'uk' | 'pl' | 'sr';

/** A single token as returned by the Soniox real-time WebSocket API. */
export interface SonioxToken {
    text: string;
    is_final?: boolean;
    translation_status?: 'original' | 'translation';
    language?: string;
}

/** Payload broadcast over the Supabase Realtime channel `sermon:{id}`. */
export interface CaptionEvent {
    lang: CaptionLang;
    final: string;
    partial: string;
    seq: number;
}

export type ConnectionState =
    | 'idle'
    | 'connecting'
    | 'open'
    | 'reconnecting'
    | 'closed'
    | 'error';

export interface SessionInfo {
    id: string;
    title: string;
    status: 'idle' | 'live' | 'ended';
}
