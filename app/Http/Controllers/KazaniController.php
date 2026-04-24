<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Sermon;
use App\Models\Speaker;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KazaniController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Sermon::query()
            ->where('is_published', true)
            ->with(['speaker', 'series', 'topics'])
            ->orderByDesc('published_at');

        if ($request->filled('speaker')) {
            $query->where('speaker_id', $request->input('speaker'));
        }
        if ($request->filled('series')) {
            $query->where('series_id', $request->input('series'));
        }
        if ($request->filled('topic')) {
            $query->whereHas('topics', fn ($q) => $q->where('topics.id', $request->input('topic')));
        }
        if ($request->filled('year')) {
            $query->whereYear('published_at', $request->input('year'));
        }
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"));
        }

        return Inertia::render('Kazani/Index', [
            'sermons' => $query->paginate(12)->withQueryString(),
            'speakers' => Speaker::orderBy('name')->get(['id', 'name']),
            'series' => Series::where('is_published', true)->orderBy('title')->get(['id', 'title']),
            'topics' => Topic::orderBy('name')->get(['id', 'name']),
            'filters' => $request->only(['q', 'speaker', 'series', 'topic', 'year']),
        ]);
    }

    public function show(string $slug): Response
    {
        $sermon = Sermon::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with(['speaker', 'series', 'topics'])
            ->firstOrFail();

        $related = Sermon::query()
            ->where('is_published', true)
            ->where('id', '!=', $sermon->id)
            ->where(fn ($q) => $q->where('speaker_id', $sermon->speaker_id)->orWhere('series_id', $sermon->series_id))
            ->with(['speaker', 'series'])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return Inertia::render('Kazani/Show', [
            'sermon' => $sermon,
            'related' => $related,
        ]);
    }
}
