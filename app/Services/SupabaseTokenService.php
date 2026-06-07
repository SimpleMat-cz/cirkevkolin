<?php

namespace App\Services;

class SupabaseTokenService
{
    public function __construct(private readonly string $jwtSecret) {}

    /**
     * Mint a short-lived Supabase-compatible JWT (HS256, signed with the project
     * JWT secret) that authorizes the holder to broadcast captions. The
     * `broadcaster` claim is checked by the `sermon:*` Realtime and table RLS
     * policies; `role: authenticated` makes PostgREST/Realtime treat the request
     * as a signed-in user. This lets the church's Laravel login double as the
     * broadcaster identity without a separate Supabase account.
     *
     * @return array{token: string, expires_at: int}
     */
    public function broadcasterToken(string $subject, int $ttlSeconds = 21600): array
    {
        $issuedAt = time();
        $expiresAt = $issuedAt + $ttlSeconds;

        $token = $this->encode([
            'role' => 'authenticated',
            'aud' => 'authenticated',
            'sub' => $subject,
            'broadcaster' => true,
            'iat' => $issuedAt,
            'exp' => $expiresAt,
        ]);

        return ['token' => $token, 'expires_at' => $expiresAt];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function encode(array $payload): string
    {
        $segments = [
            $this->base64UrlEncode((string) json_encode(['alg' => 'HS256', 'typ' => 'JWT'])),
            $this->base64UrlEncode((string) json_encode($payload)),
        ];

        $signingInput = implode('.', $segments);
        $signature = hash_hmac('sha256', $signingInput, $this->jwtSecret, true);
        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
