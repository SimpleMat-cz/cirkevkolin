<?php

namespace App\Http\Controllers;

use App\Services\SupabaseTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class PrekladController extends Controller
{
    private const SONIOX_TEMP_KEY_URL = 'https://api.soniox.com/v1/auth/temporary-api-key';

    private const BROADCASTER_ROLES = ['admin', 'broadcaster'];

    public function viewer(): Response
    {
        return Inertia::render('Preklad/Viewer');
    }

    public function admin(Request $request): Response
    {
        $this->authorizeBroadcaster($request);

        return Inertia::render('Preklad/Admin');
    }

    /**
     * Stav serverové konfigurace pro vysílací konzoli — jen booleany, žádné
     * hodnoty. Technik tak hned vidí, který klíč na serveru chybí.
     */
    public function health(Request $request): JsonResponse
    {
        $this->authorizeBroadcaster($request);

        return response()->json([
            'soniox_key_configured' => (bool) config('services.soniox.api_key'),
            'supabase_jwt_configured' => (bool) config('services.supabase.jwt_secret'),
        ]);
    }

    /**
     * Mint a short-lived Soniox temporary API key. The main key never reaches
     * the browser; only an authorized broadcaster can request one.
     */
    public function sonioxKey(Request $request): JsonResponse
    {
        $this->authorizeBroadcaster($request);

        $apiKey = config('services.soniox.api_key');
        if (! $apiKey) {
            return response()->json(['error' => 'server_misconfigured'], 500);
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->post(self::SONIOX_TEMP_KEY_URL, [
                'usage_type' => 'transcribe_websocket',
                'expires_in_seconds' => 300,
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'soniox_error', 'status' => $response->status()], 502);
        }

        return response()->json([
            'api_key' => $response->json('api_key'),
            'expires_at' => $response->json('expires_at'),
        ]);
    }

    /**
     * Mint a Supabase JWT that authorizes the broadcaster to write captions to
     * the Realtime channel and the archive tables.
     */
    public function realtimeToken(Request $request): JsonResponse
    {
        $this->authorizeBroadcaster($request);

        $secret = config('services.supabase.jwt_secret');
        if (! $secret) {
            return response()->json(['error' => 'server_misconfigured'], 500);
        }

        return response()->json(
            (new SupabaseTokenService($secret))->broadcasterToken('broadcaster:'.$request->user()->id)
        );
    }

    private function authorizeBroadcaster(Request $request): void
    {
        $user = $request->user();
        abort_unless($user && $user->hasAnyRole(self::BROADCASTER_ROLES), 403);
    }
}
