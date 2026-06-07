/**
 * PCM helpers for the broadcaster audio pipeline.
 *
 * Soniox expects raw PCM s16le, 16 kHz, mono. The browser's AudioContext
 * typically runs at 44.1/48 kHz, so we downsample then convert Float32 → Int16.
 * These functions are pure and unit-tested.
 */

/**
 * Downsample a mono Float32 buffer to `targetRate` by averaging each output
 * sample over its corresponding input window (cheap anti-aliasing).
 */
export function downsampleBuffer(input: Float32Array, inputRate: number, targetRate = 16000): Float32Array {
    if (targetRate === inputRate) {
        return input
    }

    if (targetRate > inputRate) {
        throw new Error('targetRate must be <= inputRate')
    }

    const ratio = inputRate / targetRate
    const newLength = Math.round(input.length / ratio)
    const result = new Float32Array(newLength)

    let offsetResult = 0
    let offsetInput = 0

    while (offsetResult < newLength) {
        const nextOffsetInput = Math.round((offsetResult + 1) * ratio)
        let accum = 0
        let count = 0

        for (let i = offsetInput; i < nextOffsetInput && i < input.length; i++) {
            accum += input[i]
            count++
        }

        result[offsetResult] = count > 0 ? accum / count : 0
        offsetResult++
        offsetInput = nextOffsetInput
    }

    return result
}

/** Convert Float32 samples in [-1, 1] to signed 16-bit little-endian PCM. */
export function floatTo16BitPCM(input: Float32Array): Int16Array {
    const output = new Int16Array(input.length)

    for (let i = 0; i < input.length; i++) {
        const s = Math.max(-1, Math.min(1, input[i]))
        output[i] = s < 0 ? s * 0x8000 : s * 0x7fff
    }

    return output
}

/** Downsample to 16 kHz and encode to an s16le ArrayBuffer ready for the WebSocket. */
export function encodePcmChunk(input: Float32Array, inputRate: number, targetRate = 16000): ArrayBuffer {
    return floatTo16BitPCM(downsampleBuffer(input, inputRate, targetRate)).buffer as ArrayBuffer
}

/** Root-mean-square level (0–1) of a buffer, for the VU meter. */
export function rms(input: Float32Array): number {
    if (input.length === 0) {
        return 0
    }

    let sum = 0

    for (let i = 0; i < input.length; i++) {
        sum += input[i] * input[i]
    }

    return Math.sqrt(sum / input.length)
}
