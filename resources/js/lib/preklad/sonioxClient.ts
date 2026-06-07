import type { ConnectionState, SonioxToken } from './types';

const SONIOX_WS_URL = 'wss://stt-rt.soniox.com/transcribe-websocket';
const SONIOX_MODEL = 'stt-rt-v4';
const MAX_BACKOFF_MS = 16000;

export interface SonioxSessionOptions {
    /** Soniox translation target, e.g. "en". */
    targetLanguage: string;
    /** Mints a fresh temporary API key (called on connect and before each reconnect). */
    getTempKey: () => Promise<string>;
    context?: string;
    languageHints?: string[];
    onTokens: (tokens: SonioxToken[]) => void;
    onStateChange?: (state: ConnectionState) => void;
    onError?: (message: string) => void;
}

/**
 * One Soniox real-time translation session over a raw WebSocket. The broadcaster
 * runs several of these in parallel, fanning the same PCM chunks into each.
 *
 * Includes auto-reconnect with exponential backoff (church Wi-Fi may drop) and
 * keepalive while audio is paused. Raw WS (not the Soniox SDK) so a single audio
 * capture can drive multiple sessions — see spec §4.
 */
export class SonioxSession {
    private ws: WebSocket | null = null;
    private state: ConnectionState = 'idle';
    private backoff = 1000;
    private closedByUser = false;
    private keepaliveTimer: ReturnType<typeof setInterval> | null = null;

    constructor(private readonly options: SonioxSessionOptions) {}

    get connectionState(): ConnectionState {
        return this.state;
    }

    async connect(): Promise<void> {
        this.closedByUser = false;
        this.setState('connecting');

        let apiKey: string;

        try {
            apiKey = await this.options.getTempKey();
        } catch (error) {
            this.setState('error');
            this.options.onError?.(`temp-key: ${(error as Error).message}`);
            this.scheduleReconnect();

            return;
        }

        const ws = new WebSocket(SONIOX_WS_URL);
        ws.binaryType = 'arraybuffer';
        this.ws = ws;

        ws.onopen = () => {
            ws.send(
                JSON.stringify({
                    api_key: apiKey,
                    model: SONIOX_MODEL,
                    audio_format: 'pcm_s16le',
                    sample_rate: 16000,
                    num_channels: 1,
                    language_hints: this.options.languageHints ?? ['cs'],
                    enable_language_identification: true,
                    context: this.options.context,
                    translation: {
                        type: 'one_way',
                        target_language: this.options.targetLanguage,
                    },
                }),
            );
            this.backoff = 1000;
            this.setState('open');
            this.startKeepalive();
        };

        ws.onmessage = (event) => {
            if (typeof event.data !== 'string') {
                return;
            }

            try {
                const message = JSON.parse(event.data);

                if (message.error_code || message.error_message) {
                    this.options.onError?.(
                        message.error_message ?? `code ${message.error_code}`,
                    );

                    return;
                }

                if (
                    Array.isArray(message.tokens) &&
                    message.tokens.length > 0
                ) {
                    this.options.onTokens(message.tokens as SonioxToken[]);
                }
            } catch {
                // Ignore non-JSON frames.
            }
        };

        ws.onerror = () => {
            this.options.onError?.('websocket error');
        };

        ws.onclose = () => {
            this.stopKeepalive();
            this.ws = null;

            if (!this.closedByUser) {
                this.scheduleReconnect();
            } else {
                this.setState('closed');
            }
        };
    }

    /** Send one binary PCM chunk (s16le, 16 kHz, mono). */
    sendAudio(chunk: ArrayBuffer): void {
        if (this.ws?.readyState === WebSocket.OPEN) {
            this.ws.send(chunk);
        }
    }

    /** Ask Soniox to finalize pending tokens (call before closing at sermon end). */
    finalize(): void {
        if (this.ws?.readyState === WebSocket.OPEN) {
            this.ws.send(JSON.stringify({ type: 'finalize' }));
        }
    }

    close(): void {
        this.closedByUser = true;
        this.stopKeepalive();
        this.finalize();
        this.ws?.close();
        this.ws = null;
        this.setState('closed');
    }

    private startKeepalive(): void {
        this.stopKeepalive();
        this.keepaliveTimer = setInterval(() => {
            if (this.ws?.readyState === WebSocket.OPEN) {
                this.ws.send(JSON.stringify({ type: 'keepalive' }));
            }
        }, 10000);
    }

    private stopKeepalive(): void {
        if (this.keepaliveTimer) {
            clearInterval(this.keepaliveTimer);
            this.keepaliveTimer = null;
        }
    }

    private scheduleReconnect(): void {
        if (this.closedByUser) {
            return;
        }

        this.setState('reconnecting');
        const delay = Math.min(this.backoff, MAX_BACKOFF_MS);
        this.backoff = Math.min(this.backoff * 2, MAX_BACKOFF_MS);
        setTimeout(() => {
            if (!this.closedByUser) {
                void this.connect();
            }
        }, delay);
    }

    private setState(state: ConnectionState): void {
        this.state = state;
        this.options.onStateChange?.(state);
    }
}
