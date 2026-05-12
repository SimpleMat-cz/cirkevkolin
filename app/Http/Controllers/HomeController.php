<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\Sermon;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $latestSermons = Sermon::query()
            ->where('is_published', true)
            ->with(['speaker', 'series'])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $upcomingEvents = Event::query()
            ->where('is_published', true)
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(3)
            ->get();

        return Inertia::render('Home', [
            'page' => Page::findBySlug('home'),
            'latestSermons' => $latestSermons,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
