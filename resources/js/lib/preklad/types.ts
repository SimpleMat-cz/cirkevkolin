/**
 * Kód jazyka (ISO 639-1). Otevřená množina — Soniox umí 60 jazyků, takže
 * místo úzkého unionu používáme string a katalog řešíme v languages.ts.
 */
export type CaptionLang = string;

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
    /** Nabízené jazyky; starší sessions sloupec nemají. */
    languages?: CaptionLang[] | null;
    /** Heartbeat — divácká stránka podle něj pozná, že vysílání opravdu běží. */
    last_seen_at?: string | null;
}
