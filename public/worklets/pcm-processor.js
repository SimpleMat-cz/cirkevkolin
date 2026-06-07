// AudioWorklet that batches mono Float32 frames from the capture graph and posts
// them to the main thread, which downsamples to 16 kHz and encodes to s16le PCM
// before fanning out to the Soniox WebSockets. We use AudioWorklet (not
// MediaRecorder) because Soniox needs raw PCM, not a compressed container.
class PCMProcessor extends AudioWorkletProcessor {
    constructor() {
        super()
        // ~100 ms of audio per posted chunk at the context sample rate.
        this._target = Math.round(sampleRate * 0.1)
        this._buffer = new Float32Array(this._target)
        this._offset = 0
    }

    process(inputs) {
        const input = inputs[0]
        if (!input || !input[0]) {
            return true
        }
        const channel = input[0]
        for (let i = 0; i < channel.length; i++) {
            this._buffer[this._offset++] = channel[i]
            if (this._offset >= this._target) {
                const chunk = this._buffer.slice(0, this._offset)
                this.port.postMessage(chunk, [chunk.buffer])
                this._offset = 0
            }
        }
        return true
    }
}

registerProcessor('pcm-processor', PCMProcessor)
