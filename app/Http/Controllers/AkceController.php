<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\RruleExpanderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AkceController extends Controller
{
    public function __construct(private readonly RruleExpanderService $rrule) {}

    public function index(Request $request): Response
    {
        $from = Carbon::today();
        $to = Carbon::today()->addMonths(3);
        $category = $request->input('category');

        // Non-recurring events
        $query = Event::query()
            ->where('is_published', true)
            ->whereNull('rrule')
            ->where('starts_at', '>=', $from)
            ->orderBy('starts_at');

        if ($category) {
            $query->where('category', $category);
        }

        $oneTime = $query->paginate(20)->withQueryString();

        // Recurring events expanded for the next 3 months
        $recurring = $this->rrule->expandAll($from, $to);
        if ($category) {
            $recurring = $recurring->filter(fn ($e) => $e['category'] === $category);
        }

        return Inertia::render('Akce/Index', [
            'events' => $oneTime,
            'recurring' => $recurring->values(),
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
