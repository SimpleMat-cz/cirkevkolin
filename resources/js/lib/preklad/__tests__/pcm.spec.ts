import { describe, expect, it } from 'vitest';
import { downsampleBuffer, encodePcmChunk, floatTo16BitPCM, rms } from '../pcm';

describe('downsampleBuffer', () => {
    it('returns the same buffer when rates match', () => {
        const input = new Float32Array([0.1, 0.2, 0.3]);
        expect(downsampleBuffer(input, 16000, 16000)).toBe(input);
    });

    it('halves the length when downsampling 32k → 16k', () => {
        const input = new Float32Array(32);
        const out = downsampleBuffer(input, 32000, 16000);
        expect(out.length).toBe(16);
    });

    it('averages input windows', () => {
        const input = new Float32Array([1, 1, -1, -1]);
        const out = downsampleBuffer(input, 32000, 16000);
        expect(out.length).toBe(2);
        expect(out[0]).toBeCloseTo(1);
        expect(out[1]).toBeCloseTo(-1);
    });

    it('rejects upsampling', () => {
        expect(() =>
            downsampleBuffer(new Float32Array(4), 16000, 48000),
        ).toThrow();
    });
});

describe('floatTo16BitPCM', () => {
    it('clamps and scales to the int16 range', () => {
        const out = floatTo16BitPCM(new Float32Array([0, 1, -1, 2, -2]));
        expect(out[0]).toBe(0);
        expect(out[1]).toBe(32767);
        expect(out[2]).toBe(-32768);
        expect(out[3]).toBe(32767);
        expect(out[4]).toBe(-32768);
    });
});

describe('encodePcmChunk', () => {
    it('produces 2 bytes per output sample', () => {
        const buffer = encodePcmChunk(new Float32Array(32), 32000, 16000);
        expect(buffer.byteLength).toBe(16 * 2);
    });
});

describe('rms', () => {
    it('is zero for an empty or silent buffer', () => {
        expect(rms(new Float32Array(0))).toBe(0);
        expect(rms(new Float32Array([0, 0, 0]))).toBe(0);
    });

    it('equals the amplitude for a constant signal', () => {
        expect(rms(new Float32Array([0.5, -0.5, 0.5, -0.5]))).toBeCloseTo(0.5);
    });
});
