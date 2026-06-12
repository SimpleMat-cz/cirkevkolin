<?php

namespace Tests\Unit;

use App\Services\RruleBuilder;
use Tests\TestCase;

class RruleBuilderTest extends TestCase
{
    public function test_composes_weekly_with_days(): void
    {
        $rrule = RruleBuilder::compose([
            ['freq' => 'WEEKLY', 'days' => ['TU', 'TH']],
        ]);

        $this->assertSame('FREQ=WEEKLY;BYDAY=TU,TH', $rrule);
    }

    public function test_composes_biweekly_as_weekly_interval_2(): void
    {
        $rrule = RruleBuilder::compose([
            ['freq' => 'BIWEEKLY', 'days' => ['WE']],
        ]);

        $this->assertSame('FREQ=WEEKLY;INTERVAL=2;BYDAY=WE', $rrule);
    }

    public function test_composes_multiple_schedules_on_separate_lines(): void
    {
        $rrule = RruleBuilder::compose([
            ['freq' => 'WEEKLY', 'days' => ['TU', 'TH']],
            ['freq' => 'BIWEEKLY', 'days' => ['WE']],
        ]);

        $this->assertSame(
            "FREQ=WEEKLY;BYDAY=TU,TH\nFREQ=WEEKLY;INTERVAL=2;BYDAY=WE",
            $rrule,
        );
    }

    public function test_compose_returns_null_for_empty_or_invalid(): void
    {
        $this->assertNull(RruleBuilder::compose([]));
        $this->assertNull(RruleBuilder::compose([['freq' => 'NESMYSL']]));
    }

    public function test_days_keep_calendar_order_regardless_of_input(): void
    {
        $rrule = RruleBuilder::compose([
            ['freq' => 'WEEKLY', 'days' => ['SU', 'MO']],
        ]);

        $this->assertSame('FREQ=WEEKLY;BYDAY=MO,SU', $rrule);
    }

    public function test_parses_existing_production_rules(): void
    {
        $this->assertSame(
            [['freq' => 'WEEKLY', 'days' => ['SU']]],
            RruleBuilder::parse('FREQ=WEEKLY;BYDAY=SU'),
        );
    }

    public function test_parses_biweekly(): void
    {
        $this->assertSame(
            [['freq' => 'BIWEEKLY', 'days' => ['WE']]],
            RruleBuilder::parse('FREQ=WEEKLY;INTERVAL=2;BYDAY=WE'),
        );
    }

    public function test_parse_compose_roundtrip(): void
    {
        $original = "FREQ=WEEKLY;BYDAY=TU,TH\nFREQ=WEEKLY;INTERVAL=2;BYDAY=WE\nFREQ=YEARLY";

        $this->assertSame($original, RruleBuilder::compose(RruleBuilder::parse($original)));
    }

    public function test_parse_handles_null_and_blank(): void
    {
        $this->assertSame([], RruleBuilder::parse(null));
        $this->assertSame([], RruleBuilder::parse('  '));
    }
}
