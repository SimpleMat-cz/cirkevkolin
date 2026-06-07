import type { CaptionEvent, CaptionLang, SonioxToken } from './types';

/** Matches text whose tail closes a sentence (optionally with a closing quote/bracket). */
const SENTENCE_END = /[.!?…]['")\]]?\s*$/;

/**
 * Split a Soniox token batch into the original (source language) tokens and the
 * translated tokens. A one-way translation session returns both: the Czech
 * original carries `translation_status: "original"`, the translation carries
 * `"translation"`.
 */
export function splitTokens(tokens: SonioxToken[]): {
    original: SonioxToken[];
    translation: SonioxToken[];
} {
    const original: SonioxToken[] = [];
    const translation: SonioxToken[] = [];

    for (const token of tokens) {
        if (token.translation_status === 'translation') {
            translation.push(token);
        } else {
            original.push(token);
        }
    }

    return { original, translation };
}

/**
 * Aggregates the token stream for a single output language into broadcastable
 * {@link CaptionEvent}s.
 *
 * Rules (spec §9.2, §9.3):
 *  - `final` and `partial` are kept strictly separate; partial tokens are never
 *    appended to the final buffer and are replaced wholesale on every batch.
 *  - A new segment (incremented `seq`) starts once the finalized text closes a
 *    sentence (".", "!", "?", "…") and no partial is pending — otherwise the
 *    transcript would grow into one endless paragraph.
 */
export class LanguageAggregator {
    private seq = 0;
    private final = '';
    private partial = '';

    constructor(public readonly lang: CaptionLang) {}

    /** Feed a batch of (already language-filtered) tokens; returns the current segment. */
    push(tokens: SonioxToken[]): CaptionEvent {
        let partialBuf = '';

        for (const token of tokens) {
            const text = token.text ?? '';

            if (token.is_final) {
                this.final += text;
            } else {
                partialBuf += text;
            }
        }

        this.partial = partialBuf;

        const event = this.snapshot();

        if (
            this.final.trim() !== '' &&
            this.partial === '' &&
            SENTENCE_END.test(this.final)
        ) {
            this.seq++;
            this.final = '';
        }

        return event;
    }

    /** Emit any buffered text and close the current segment (used on finalize). */
    flush(): CaptionEvent | null {
        if (this.final.trim() === '' && this.partial.trim() === '') {
            return null;
        }

        const event = this.snapshot();
        this.seq++;
        this.final = '';
        this.partial = '';

        return event;
    }

    private snapshot(): CaptionEvent {
        return {
            lang: this.lang,
            seq: this.seq,
            final: this.final.trim(),
            partial: this.partial.trim(),
        };
    }
}
