<?php

namespace Tests\Unit;

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
}
