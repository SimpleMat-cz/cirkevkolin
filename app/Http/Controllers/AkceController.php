<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AkceController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Event::query()
            ->where('is_published', true)
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        return Inertia::render('Akce/Index', [
            'events' => $query->paginate(20)->withQueryString(),
            'filters' => $request->only(['category']),
        ]);
    }

    public function show(string $slug): Response
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return Inertia::render('Akce/Show', [
            'event' => $event,
        ]);
    }
}
