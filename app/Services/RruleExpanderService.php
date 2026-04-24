<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RruleExpanderService
{
    /**
     * Expand an event with RRULE into virtual occurrences within a date range.
     * Returns a collection of Carbon dates for event starts within the range.
     *
     * @return Collection<int, Carbon>
     */
    public function expand(Event $event, Carbon $from, Carbon $to): Collection
    {
        if (! $event->rrule) {
            return collect();
        }

        $occurrences = collect();
        $rules = $this->parseRrule($event->rrule);
        $freq = strtoupper($rules['FREQ'] ?? '');
        $byDay = isset($rules['BYDAY']) ? explode(',', $rules['BYDAY']) : [];
        $count = isset($rules['COUNT']) ? (int) $rules['COUNT'] : null;
        $until = isset($rules['UNTIL']) ? Carbon::parse($rules['UNTIL']) : null;
        $interval = (int) ($rules['INTERVAL'] ?? 1);

        $start = Carbon::instance($event->starts_at);
        $cursor = $start->copy();

        $generated = 0;
        $limit = $count ?? 500;

        while ($cursor->lte($to) && $generated < $limit) {
            if ($until && $cursor->gt($until)) {
                break;
            }

            $candidates = match ($freq) {
                'DAILY' => [$cursor->copy()],
                'WEEKLY' => $this->expandWeekly($cursor, $byDay),
                'MONTHLY' => [$cursor->copy()],
                default => [],
            };

            foreach ($candidates as $candidate) {
                if ($candidate->gte($from) && $candidate->lte($to)) {
                    $occurrences->push($candidate);
                    $generated++;
                }
            }

            $cursor = match ($freq) {
                'DAILY' => $cursor->addDays($interval),
                'WEEKLY' => $cursor->addWeeks($interval),
                'MONTHLY' => $cursor->addMonths($interval),
                default => $to->copy()->addDay(),
            };
        }

        return $occurrences->sortBy(fn (Carbon $d) => $d->timestamp)->values();
    }

    /**
     * Expand recurring events from the database for a given date range.
     * Returns a flat collection of synthetic event data arrays.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function expandAll(Carbon $from, Carbon $to): Collection
    {
        $events = Event::query()
            ->where('is_published', true)
            ->whereNotNull('rrule')
            ->get();

        return $events->flatMap(function (Event $event) use ($from, $to): Collection {
            return $this->expand($event, $from, $to)->map(function (Carbon $date) use ($event): array {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'category' => $event->category,
                    'location' => $event->location,
                    'starts_at' => $date->toIso8601String(),
                    'ends_at' => $event->ends_at
                        ? $date->copy()->addSeconds($event->starts_at->diffInSeconds($event->ends_at))->toIso8601String()
                        : null,
                    'has_registration' => $event->has_registration,
                    'is_recurring' => true,
                ];
            });
        });
    }

    /** @return array<string, string> */
    private function parseRrule(string $rrule): array
    {
        $parts = explode(';', $rrule);
        $rules = [];
        foreach ($parts as $part) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
            $rules[trim($key)] = trim($value);
        }

        return $rules;
    }

    /** @return Collection<int, Carbon> */
    private function expandWeekly(Carbon $weekStart, array $byDay): Collection
    {
        if (empty($byDay)) {
            return collect([$weekStart->copy()]);
        }

        $dayMap = ['MO' => 1, 'TU' => 2, 'WE' => 3, 'TH' => 4, 'FR' => 5, 'SA' => 6, 'SU' => 0];
        $monday = $weekStart->copy()->startOfWeek(Carbon::MONDAY);

        return collect($byDay)->map(function (string $day) use ($monday, $dayMap): ?Carbon {
            $day = strtoupper(trim($day));
            if (! isset($dayMap[$day])) {
                return null;
            }
            $offset = ($dayMap[$day] - 1 + 7) % 7;

            return $monday->copy()->addDays($offset);
        })->filter()->values();
    }
}
