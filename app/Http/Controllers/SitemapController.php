<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sermon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $sermons = Sermon::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at']);

        $events = Event::query()
            ->where('is_published', true)
            ->where('starts_at', '>=', now()->subMonth())
            ->orderByDesc('starts_at')
            ->get(['slug', 'updated_at']);

        $content = view('sitemap', compact('sermons', 'events'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
