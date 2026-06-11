<?php

namespace App\Http\Controllers;

use App\Services\YoutubeSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Endpoint pro Vercel Cron — serverless prostředí nemá Laravel scheduler,
 * takže denní synchronizaci YouTube streamů spouští HTTP požadavek
 * definovaný v `crons` ve vercel.json.
 */
class YoutubeSyncCronController extends Controller
{
    public function __invoke(Request $request, YoutubeSyncService $sync): JsonResponse
    {
        $secret = config('services.cron.secret');

        abort_if(empty($secret), 503, 'CRON_SECRET není nastaven.');

        $token = $request->bearerToken() ?? $request->query('token');

        abort_unless(is_string($token) && hash_equals($secret, $token), 403);

        return response()->json($sync->sync());
    }
}
