<?php

namespace App\Services;

/**
 * Převádí mezi strukturovanými řádky z formuláře („každý týden v út a čt",
 * „jednou za 2 týdny ve st") a RRULE řetězci uloženými v events.rrule.
 * Více rozvrhů jedné akce se ukládá jako RRULE oddělené novým řádkem.
 */
class RruleBuilder
{
    public const FREQUENCIES = [
        'WEEKLY' => 'Každý týden',
        'BIWEEKLY' => 'Jednou za 2 týdny',
        'MONTHLY' => 'Každý měsíc',
        'YEARLY' => 'Každý rok',
        'DAILY' => 'Každý den',
    ];

    public const DAYS = [
        'MO' => 'Pondělí',
        'TU' => 'Úterý',
        'WE' => 'Středa',
        'TH' => 'Čtvrtek',
        'FR' => 'Pátek',
        'SA' => 'Sobota',
        'SU' => 'Neděle',
    ];

    /**
     * @param  list<array{freq?: ?string, days?: ?array<int, string>}>  $schedules
     */
    public static function compose(array $schedules): ?string
    {
        $rules = [];

        foreach ($schedules as $schedule) {
            $freq = strtoupper($schedule['freq'] ?? '');

            if (! array_key_exists($freq, self::FREQUENCIES)) {
                continue;
            }

            $parts = $freq === 'BIWEEKLY'
                ? ['FREQ=WEEKLY', 'INTERVAL=2']
                : ['FREQ='.$freq];

            $days = array_values(array_intersect(
                array_keys(self::DAYS),
                array_map('strtoupper', $schedule['days'] ?? []),
            ));

            if (in_array($freq, ['WEEKLY', 'BIWEEKLY'], true) && $days !== []) {
                $parts[] = 'BYDAY='.implode(',', $days);
            }

            $rules[] = implode(';', $parts);
        }

        return $rules === [] ? null : implode("\n", array_unique($rules));
    }

    /**
     * @return list<array{freq: string, days: array<int, string>}>
     */
    public static function parse(?string $rrule): array
    {
        if ($rrule === null || trim($rrule) === '') {
            return [];
        }

        $schedules = [];

        foreach (preg_split('/\R+/', trim($rrule)) ?: [] as $line) {
            $rules = [];

            foreach (explode(';', $line) as $part) {
                [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
                $rules[strtoupper(trim($key))] = strtoupper(trim($value));
            }

            $freq = $rules['FREQ'] ?? '';
            $interval = (int) ($rules['INTERVAL'] ?? 1);

            if ($freq === 'WEEKLY' && $interval === 2) {
                $freq = 'BIWEEKLY';
            }

            if (! array_key_exists($freq, self::FREQUENCIES)) {
                continue;
            }

            $days = array_values(array_intersect(
                array_keys(self::DAYS),
                array_filter(array_map('trim', explode(',', $rules['BYDAY'] ?? ''))),
            ));

            $schedules[] = ['freq' => $freq, 'days' => $days];
        }

        return $schedules;
    }
}
