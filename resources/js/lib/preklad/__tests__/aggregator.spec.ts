import { describe, expect, it } from 'vitest';
import { LanguageAggregator, splitTokens } from '../aggregator';

describe('splitTokens', () => {
    it('separates original and translation tokens', () => {
        const { original, translation } = splitTokens([
            { text: 'Ahoj', translation_status: 'original' },
            { text: 'Hello', translation_status: 'translation' },
            { text: ' lidi', translation_status: 'original' },
        ]);
        expect(original.map((t) => t.text)).toEqual(['Ahoj', ' lidi']);
        expect(translation.map((t) => t.text)).toEqual(['Hello']);
    });
});

describe('LanguageAggregator', () => {
    it('keeps final and partial separate, replacing partial wholesale', () => {
        const agg = new LanguageAggregator('en');
        let event = agg.push([{ text: 'Hello', is_final: true }]);
        expect(event).toMatchObject({
            lang: 'en',
            seq: 0,
            final: 'Hello',
            partial: '',
        });

        event = agg.push([{ text: ' there' }]);
        expect(event).toMatchObject({ final: 'Hello', partial: 'there' });

        // Partial is replaced, never appended.
        event = agg.push([{ text: ' world' }]);
        expect(event).toMatchObject({ final: 'Hello', partial: 'world' });
    });

    it('starts a new segment after a finalized sentence', () => {
        const agg = new LanguageAggregator('en');
        agg.push([{ text: 'First sentence.', is_final: true }]);
        const event = agg.push([{ text: 'Second', is_final: true }]);
        expect(event.seq).toBe(1);
        expect(event.final).toBe('Second');
    });

    it('does not split while a partial is still pending', () => {
        const agg = new LanguageAggregator('en');
        const event = agg.push([
            { text: 'Done.', is_final: true },
            { text: ' more', is_final: false },
        ]);
        expect(event.seq).toBe(0);
        expect(event.partial).toBe('more');
    });

    it('flush emits the buffered segment and advances seq', () => {
        const agg = new LanguageAggregator('cs');
        agg.push([{ text: 'Nedokončená věta', is_final: true }]);
        const flushed = agg.flush();
        expect(flushed).toMatchObject({ seq: 0, final: 'Nedokončená věta' });
        expect(agg.flush()).toBeNull();
    });
});
