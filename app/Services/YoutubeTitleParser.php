<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Rozparsuje název YouTube streamu na strukturované části.
 *
 * Kanál používá názvy ve tvaru "DD.MM.YYYY - Série - TÉMA - Jméno Řečníka",
 * ale s mnoha variacemi: pomlčky vs. dlouhé pomlčky, série oddělená dvojtečkou,
 * chybějící rok, prefix "Církev Kolín –", chybějící řečník nebo téma.
 */
class YoutubeTitleParser
{
    /**
     * @param  list<string>  $knownSeries  Názvy existujících sérií — jen ty se přiřazují.
     * @param  list<string>  $knownSpeakers  Jména existujících řečníků (pro titulky tvaru "datum - jméno").
     */
    public function __construct(
        private array $knownSeries = [],
        private array $knownSpeakers = [],
    ) {}

    /**
     * @return array{date: ?Carbon, series: ?string, title: ?string, speaker: ?string}
     */
    public function parse(string $rawTitle, ?Carbon $broadcastDate = null): array
    {
        $working = trim(preg_replace('/^Církev\s+Kolín\s*[-–—:]?\s*/iu', '', trim($rawTitle)) ?? '');

        [$date, $working] = $this->extractLeadingDate($working, $broadcastDate);

        $segments = $this->splitSegments($working);
        $speaker = $this->extractSpeaker($segments);
        $series = $this->extractSeries($segments);
        $title = $this->buildTitle($segments);

        return [
            'date' => $date,
            'series' => $series,
            'title' => $title,
            'speaker' => $speaker,
        ];
    }

    /**
     * @return array{0: ?Carbon, 1: string}
     */
    private function extractLeadingDate(string $title, ?Carbon $broadcastDate): array
    {
        if (! preg_match('/^\s*(\d{1,2})\s*\.\s*(\d{1,2})\s*\.?\s*(\d{4})?\s*[-–—:]?\s*/u', $title, $m)) {
            return [null, $title];
        }

        $day = (int) $m[1];
        $month = (int) $m[2];
        $year = ($m[3] ?? '') !== '' ? (int) $m[3] : $broadcastDate?->year;

        $date = null;
        if ($year !== null && checkdate($month, $day, $year)) {
            $date = Carbon::create($year, $month, $day)->startOfDay();
        }

        return [$date, mb_substr($title, mb_strlen($m[0]))];
    }

    /**
     * @return list<string>
     */
    private function splitSegments(string $title): array
    {
        $segments = preg_split('/\s+[-–—]\s+|\s*:\s+/u', $title) ?: [];

        return array_values(array_filter(array_map('trim', $segments), fn (string $s): bool => $s !== ''));
    }

    /**
     * Řečník bývá poslední segment ("Jméno Příjmení", případně s dovětkem "+ dětské chvály").
     * Jediný zbylý segment považujeme za řečníka jen u již známých jmen, aby se názvy
     * jako "Mission Impossible" nepletly se jmény.
     *
     * @param  list<string>  $segments
     */
    private function extractSpeaker(array &$segments): ?string
    {
        if ($segments === []) {
            return null;
        }

        $last = $segments[count($segments) - 1];
        $candidate = trim(preg_split('/\s*[+,\/]\s*/u', $last)[0] ?? '');

        if (! $this->looksLikePersonName($candidate)) {
            return null;
        }

        if (count($segments) === 1 && ! $this->isKnown($candidate, $this->knownSpeakers)) {
            return null;
        }

        array_pop($segments);

        return $candidate;
    }

    /**
     * @param  list<string>  $segments
     */
    private function extractSeries(array &$segments): ?string
    {
        if ($segments === []) {
            return null;
        }

        foreach ($this->knownSeries as $series) {
            if (Str::slug($segments[0]) === Str::slug($series)) {
                array_shift($segments);

                return $series;
            }
        }

        return null;
    }

    /**
     * @param  list<string>  $segments
     */
    private function buildTitle(array $segments): ?string
    {
        if ($segments === []) {
            return null;
        }

        $parts = array_map(
            fn (string $s): string => mb_strtoupper($s, 'UTF-8') === $s && preg_match('/\p{Lu}/u', $s)
                ? Str::ucfirst(mb_strtolower($s, 'UTF-8'))
                : $s,
            $segments,
        );

        return Str::ucfirst(implode(' – ', $parts));
    }

    private function looksLikePersonName(string $candidate): bool
    {
        return (bool) preg_match('/^\p{Lu}[\p{L}\'’.]+(?:\s+\p{Lu}[\p{L}\'’.]+){1,2}$/u', $candidate);
    }

    /**
     * @param  list<string>  $known
     */
    private function isKnown(string $candidate, array $known): bool
    {
        $slug = Str::slug($candidate);

        return collect($known)->contains(fn (string $name): bool => Str::slug($name) === $slug);
    }
}
