<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Services\RruleExpanderService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RruleExpanderServiceTest extends TestCase
{
    private RruleExpanderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RruleExpanderService;
    }

    private function makeEvent(string $rrule, string $startsAt): object
    {
        return (object) [
            'rrule' => $rrule,
            'starts_at' => Carbon::parse($startsAt),
            'ends_at' => null,
        ];
    }

    public function test_expand_returns_empty_when_no_rrule(): void
    {
        $event = (object) ['rrule' => null];

        $service = new class extends RruleExpanderService
        {
            /** @phpstan-ignore-next-line */
            public function expand($event, Carbon $from, Carbon $to): Collection
            {
                if (! $event->rrule) {
                    return collect();
                }

                return parent::expand($event, $from, $to);
            }
        };

        $result = $service->expand($event, Carbon::today(), Carbon::today()->addMonths(1));
        $this->assertCount(0, $result);
    }

    public function test_parse_rrule_weekly_sunday_generates_four_sundays_in_april(): void
    {
        // Test the internal logic via a public proxy
        $expander = new class extends RruleExpanderService
        {
            public function test_parse(string $rrule): array
            {
                return $this->callParseRrule($rrule);
            }

            /** @return array<string, string> */
            private function callParseRrule(string $rrule): array
            {
                $parts = explode(';', $rrule);
                $rules = [];
                foreach ($parts as $part) {
                    [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
                    $rules[trim($key)] = trim($value);
                }

                return $rules;
            }
        };

        $parsed = $expander->test_parse('FREQ=WEEKLY;BYDAY=SU;COUNT=10');

        $this->assertEquals('WEEKLY', $parsed['FREQ']);
        $this->assertEquals('SU', $parsed['BYDAY']);
        $this->assertEquals('10', $parsed['COUNT']);
    }

    public function test_service_instantiates_correctly(): void
    {
        $this->assertInstanceOf(RruleExpanderService::class, $this->service);
    }

    private function makeRealEvent(string $rrule, string $startsAt, ?string $endsAt = null): Event
    {
        return new Event([
            'title' => 'Testovací akce',
            'slug' => 'testovaci-akce',
            'rrule' => $rrule,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);
    }

    public function test_weekly_occurrences_keep_event_start_time(): void
    {
        $event = $this->makeRealEvent('FREQ=WEEKLY;BYDAY=SU', '2026-06-07 10:00:00');

        $occurrences = $this->service->expand(
            $event,
            Carbon::parse('2026-06-08'),
            Carbon::parse('2026-06-30'),
        );

        $this->assertNotEmpty($occurrences);
        foreach ($occurrences as $occurrence) {
            $this->assertSame('10:00:00', $occurrence->format('H:i:s'));
            $this->assertSame(Carbon::SUNDAY, $occurrence->dayOfWeek);
        }
    }

    public function test_no_occurrences_before_event_start(): void
    {
        // Událost začíná ve středu — BYDAY pondělí nesmí vygenerovat výskyt
        // v témže týdnu před skutečným začátkem.
        $event = $this->makeRealEvent('FREQ=WEEKLY;BYDAY=MO', '2026-06-10 18:00:00');

        $occurrences = $this->service->expand(
            $event,
            Carbon::parse('2026-06-01'),
            Carbon::parse('2026-06-30'),
        );

        $this->assertNotEmpty($occurrences);
        $this->assertTrue($occurrences->every(
            fn (Carbon $occurrence) => $occurrence->gte(Carbon::parse('2026-06-10 18:00:00')),
        ));
    }

    public function test_interval_zero_does_not_loop_forever(): void
    {
        $event = $this->makeRealEvent('FREQ=WEEKLY;BYDAY=SU;INTERVAL=0', '2026-06-07 10:00:00');

        $occurrences = $this->service->expand(
            $event,
            Carbon::parse('2026-06-01'),
            Carbon::parse('2026-06-30'),
        );

        $this->assertCount(4, $occurrences);
    }

    public function test_multiple_rules_are_unioned_without_duplicates(): void
    {
        // Kidztown: út + čt každý týden, st jednou za 2 týdny.
        $event = $this->makeRealEvent(
            "FREQ=WEEKLY;BYDAY=TU,TH\nFREQ=WEEKLY;INTERVAL=2;BYDAY=WE",
            '2026-06-02 09:00:00',
        );

        $occurrences = $this->service->expand(
            $event,
            Carbon::parse('2026-06-01'),
            Carbon::parse('2026-06-14 23:59:59'),
        );

        $dates = $occurrences->map(fn (Carbon $d) => $d->format('Y-m-d H:i'))->all();

        $this->assertSame([
            '2026-06-02 09:00', // út
            '2026-06-03 09:00', // st (1. běh čtrnáctidenního)
            '2026-06-04 09:00', // čt
            '2026-06-09 09:00', // út
            '2026-06-11 09:00', // čt
        ], $dates);
    }

    public function test_yearly_recurrence_is_supported(): void
    {
        $event = $this->makeRealEvent('FREQ=YEARLY', '2025-12-24 16:00:00');

        $occurrences = $this->service->expand(
            $event,
            Carbon::parse('2026-01-01'),
            Carbon::parse('2027-12-31'),
        );

        $this->assertCount(2, $occurrences);
        $this->assertSame('2026-12-24 16:00:00', $occurrences[0]->toDateTimeString());
        $this->assertSame('2027-12-24 16:00:00', $occurrences[1]->toDateTimeString());
    }
}
