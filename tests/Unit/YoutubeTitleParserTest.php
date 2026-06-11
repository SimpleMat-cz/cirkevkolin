<?php

namespace Tests\Unit;

use App\Services\YoutubeTitleParser;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class YoutubeTitleParserTest extends TestCase
{
    private function makeParser(): YoutubeTitleParser
    {
        return new YoutubeTitleParser(
            knownSeries: ['Cenzurováno', 'Pro každého'],
            knownSpeakers: ['Martin Fridrich', 'Martin Moldan'],
        );
    }

    /**
     * @return array<string, array{string, ?string, ?string, ?string, ?string}>
     */
    public static function realTitleProvider(): array
    {
        // Skutečné názvy streamů z kanálu Církev Kolín: [titulek, datum, série, název, řečník]
        return [
            'plný formát se sérií' => [
                '26.4.2026 - Cenzurováno - ZNOVUZROZENÍ - Radek Smetana',
                '2026-04-26', 'Cenzurováno', 'Znovuzrození', 'Radek Smetana',
            ],
            'řečník s dovětkem' => [
                '7.6.2026 - Hostina s Bohem - Martin Fridrich + dětské chvály',
                '2026-06-07', null, 'Hostina s Bohem', 'Martin Fridrich',
            ],
            'datum bez roku a dlouhé pomlčky' => [
                '31. 5. PRO KAŽDÉHO – i pro mladé – Marek Osoha',
                null, 'Pro každého', 'I pro mladé', 'Marek Osoha',
            ],
            'série oddělená dvojtečkou bez řečníka' => [
                '17. 5. 2026 – PRO KAŽDÉHO: i pro ostřílené (talkshow)',
                '2026-05-17', 'Pro každého', 'I pro ostřílené (talkshow)', null,
            ],
            'krátké téma s tečkou' => [
                '3.5.2026 - PRO KAŽDÉHO - tečka. - Martin Fridrich',
                '2026-05-03', 'Pro každého', 'Tečka.', 'Martin Fridrich',
            ],
            'bez řečníka, dovětek o hostech' => [
                '3.4.2026 - Velkopáteční - společně s CB Kolín',
                '2026-04-03', null, 'Velkopáteční – společně s CB Kolín', null,
            ],
            'jen datum a známý řečník' => [
                '8.3.2026 - Martin Moldan',
                '2026-03-08', null, null, 'Martin Moldan',
            ],
            'dvouslovný název není řečník' => [
                '25.1.2026 - Mission Impossible',
                '2026-01-25', null, 'Mission Impossible', null,
            ],
            'prefix kanálu' => [
                'Církev Kolín – 11. 1. 2026  – Neděle chval a uctívání',
                '2026-01-11', null, 'Neděle chval a uctívání', null,
            ],
            'prefix kanálu, datum bez pomlčky před názvem' => [
                'Církev Kolín – 4. 1. 2026 Zabalte tábor a vyražte – Steve Hertzog',
                '2026-01-04', null, 'Zabalte tábor a vyražte', 'Steve Hertzog',
            ],
            'bez data' => [
                'Vyprávět příběhy a radost',
                null, null, 'Vyprávět příběhy a radost', null,
            ],
            'titulek s čárkami' => [
                '15.2.2026 - Zrada, láska, odpuštění - Martin Fridrich',
                '2026-02-15', null, 'Zrada, láska, odpuštění', 'Martin Fridrich',
            ],
            'otazník v názvu' => [
                'Církev Kolín – 14. 12. 2025 Můžeme být dokonalí? - Ivana Clement',
                '2025-12-14', null, 'Můžeme být dokonalí?', 'Ivana Clement',
            ],
        ];
    }

    #[DataProvider('realTitleProvider')]
    public function test_parses_real_channel_titles(
        string $rawTitle,
        ?string $expectedDate,
        ?string $expectedSeries,
        ?string $expectedTitle,
        ?string $expectedSpeaker,
    ): void {
        $result = $this->makeParser()->parse($rawTitle);

        $this->assertSame($expectedDate, $result['date']?->toDateString());
        $this->assertSame($expectedSeries, $result['series']);
        $this->assertSame($expectedTitle, $result['title']);
        $this->assertSame($expectedSpeaker, $result['speaker']);
    }

    public function test_year_is_taken_from_broadcast_date_when_missing_in_title(): void
    {
        $result = $this->makeParser()->parse(
            '24. 5. – PRO KAŽDÉHO – I pro nedokonalé – Martin Fridrich',
            Carbon::parse('2026-05-24 08:01:22'),
        );

        $this->assertSame('2026-05-24', $result['date']?->toDateString());
        $this->assertSame('Pro každého', $result['series']);
        $this->assertSame('I pro nedokonalé', $result['title']);
        $this->assertSame('Martin Fridrich', $result['speaker']);
    }

    public function test_date_without_year_and_broadcast_date_is_ignored(): void
    {
        $result = $this->makeParser()->parse('24. 5. – Téma');

        $this->assertNull($result['date']);
        $this->assertSame('Téma', $result['title']);
    }

    public function test_invalid_date_is_ignored_but_stripped(): void
    {
        $result = $this->makeParser()->parse('99.99.2026 - Téma - Martin Fridrich');

        $this->assertNull($result['date']);
        $this->assertSame('Téma', $result['title']);
        $this->assertSame('Martin Fridrich', $result['speaker']);
    }

    public function test_unknown_single_name_stays_as_title(): void
    {
        $result = $this->makeParser()->parse('8.3.2026 - Pepa Neznámý');

        $this->assertNull($result['speaker']);
        $this->assertSame('Pepa Neznámý', $result['title']);
    }

    public function test_series_matching_is_diacritics_and_case_insensitive(): void
    {
        $result = $this->makeParser()->parse('1.1.2026 - CENZUROVÁNO - Téma - Martin Fridrich');

        $this->assertSame('Cenzurováno', $result['series']);
    }
}
