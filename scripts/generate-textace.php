<?php

/**
 * Generátor podkladu pro copywritera: kompletní inventura textů webu → XLSX.
 * Spuštění: php scripts/generate-textace.php
 */
require __DIR__.'/../vendor/autoload.php';

use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Entity\SheetView;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Writer\XLSX\Writer;

$pdo = new PDO('sqlite:'.__DIR__.'/../database/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$P = [];
foreach ($pdo->query('SELECT * FROM pages') as $r) {
    $P[$r['slug']] = $r;
}
$h = static fn (string $slug, string $field): string => (string) ($P[$slug][$field] ?? '');
$faqs = $pdo->query('SELECT * FROM faqs ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);

// Zdroje (kde se text edituje)
$ST = 'Vue (v kódu) — mění vývojář';
$DBP = 'DB → admin: Stránky';
$DBF = 'DB → admin: FAQ';
$DBS = 'DB → admin: Nastavení';
$DYN = 'Dynamický obsah (DB)';

/** @var array<int,array{0:string,1:string,2:string,3:string,4:string,5:string,6:string}> $D */
$D = [];
$add = static function (string $page, string $url, string $section, string $element, string $text, string $source, string $note = '') use (&$D): void {
    $D[] = [$page, $url, $section, $element, $text, $source, $note];
};

// ───────────────────────── SDÍLENÉ: Hlavní menu ─────────────────────────
$pg = 'SDÍLENÉ — Menu';
$u = '(všechny stránky)';
$add($pg, $u, 'Horní lišta', 'aria-label loga', 'Domů — církev kolín', $ST);
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Neděle', $ST, '→ /nedele');
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Jsem tu poprvé', $ST, '→ /jsem-tu-poprve');
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Co děláme', $ST, '→ /co-delame');
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Kázání', $ST, '→ /kazani');
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Akce', $ST, '→ /akce');
$add($pg, $u, 'Hlavní navigace', 'Odkaz menu', 'Kontakt', $ST, '→ /kontakt');
$add($pg, $u, 'Horní lišta', 'CTA tlačítko', 'Přispět', $ST, '→ /prispet');
$add($pg, $u, 'Mobilní menu', 'aria-label', 'Otevřít menu / Zavřít menu', $ST, 'mění se dle stavu');

// ───────────────────────── SDÍLENÉ: Patička ─────────────────────────
$pg = 'SDÍLENÉ — Patička';
$add($pg, $u, 'Brand', 'Odstavec', 'Apoštolská církev Kolín. Místo, kde se cítíte jako doma — bez ohledu na to, kdo jste nebo odkud přicházíte.', $ST);
$add($pg, $u, 'Brand', 'Sociální odkaz', 'Facebook', $ST, 'URL z Nastavení');
$add($pg, $u, 'Brand', 'Sociální odkaz', 'Instagram', $ST, 'URL z Nastavení');
$add($pg, $u, 'Brand', 'Sociální odkaz', 'YouTube', $ST, 'URL z Nastavení');
$add($pg, $u, 'Sloupec Kontakt', 'H3 nadpis', 'Kontakt', $ST);
$add($pg, $u, 'Sloupec Kontakt', 'Adresa', 'V Zídkách 402, Kolín 2 / (vchod z Benešovy ulice) / PSČ 280 02', $DBS, 'skládá se z Nastavení → Kontakt');
$add($pg, $u, 'Sloupec Kontakt', 'E-mail', 'kolin@apostolskacirkev.cz', $DBS);
$add($pg, $u, 'Sloupec Kontakt', 'Bankovní účet', 'č.ú. 435669379 / 0800', $DBS);
$add($pg, $u, 'Sloupec Stránky', 'H3 nadpis', 'Stránky', $ST);
$add($pg, $u, 'Sloupec Stránky', 'Odkazy', 'Neděle · Jsem tu poprvé · Kázání · Akce · Kdo jsme · Přispět', $ST);
$add($pg, $u, 'Spodní lišta', 'Copyright', '© [rok] Apoštolská církev Kolín — součást Apoštolské církve v ČR.', $ST, 'rok se generuje automaticky');
$add($pg, $u, 'Spodní lišta', 'Právní odkazy', 'Cookies · GDPR · Přístupnost', $ST, '→ /cookies, /gdpr, /pristupnost (stránky možná zatím chybí)');
$add($pg, $u, 'Přístupnost', 'Skip-link', 'Přejít na hlavní obsah', $ST, 'skrytý, jen pro klávesnici');

// ───────────────────────── / (Domů) ─────────────────────────
$pg = 'Domů';
$u = '/';
$add($pg, $u, 'SEO / <head>', 'meta_title', $h('home', 'meta_title'), $DBP);
$add($pg, $u, 'SEO / <head>', 'meta_description', $h('home', 'meta_description'), $DBP);
$add($pg, $u, 'Hero', 'Eyebrow (nadočko)', $h('home', 'hero_eyebrow'), $DBP);
$add($pg, $u, 'Hero', 'H1 (1. řádek)', $h('home', 'hero_title'), $DBP);
$add($pg, $u, 'Hero', 'H1 (2. řádek, barevný)', $h('home', 'hero_title_accent'), $DBP);
$add($pg, $u, 'Hero', 'Odstavec', $h('home', 'hero_description'), $DBP);
$add($pg, $u, 'Hero', 'CTA tlačítko 1', 'Chci přijít poprvé', $ST, '→ /jsem-tu-poprve');
$add($pg, $u, 'Hero', 'CTA tlačítko 2', 'Poslední kázání', $ST, '→ /kazani');
$add($pg, $u, 'Hero — rychlá fakta', 'Dlaždice', 'Začátek: 10:00', $ST, 'čas z Nastavení');
$add($pg, $u, 'Hero — rychlá fakta', 'Dlaždice', 'Dress code: Libovolný', $ST);
$add($pg, $u, 'Hero — rychlá fakta', 'Dlaždice', 'Děti: Postaráme se 👶', $ST);
$add($pg, $u, 'Hero — rychlá fakta', 'Dlaždice', 'Káva: Vždy ☕', $ST);
$add($pg, $u, 'Poslední kázání', 'Badge', 'Poslední záznam', $ST);
$add($pg, $u, 'Poslední kázání', 'Eyebrow', 'Pustit hned', $ST);
$add($pg, $u, 'Poslední kázání', 'H2 (fallback)', 'Podívej se na poslední kázání', $ST, 'jinak název kázání z DB');
$add($pg, $u, 'Poslední kázání', 'Odstavec (fallback)', 'Prohlédni si archiv nedělních kázání.', $ST);
$add($pg, $u, 'Poslední kázání', 'Odkaz', 'Všechna kázání', $ST);
$add($pg, $u, 'Běžící pás', 'Marquee', 'JAKO DOMA · POJĎ DÁL · BUĎ TU · TVŮJ ČAS · KAŽDÝ JE VÍTÁN', $ST);
$add($pg, $u, 'Co tě čeká', 'Eyebrow', 'Co tě čeká', $ST);
$add($pg, $u, 'Co tě čeká', 'H2', 'První neděle u nás', $ST);
$add($pg, $u, 'Co tě čeká', 'Odstavec', 'Víme, že přijít poprvé do kostela může být trochu nervy. Řekneme ti všechno, ať víš, do čeho jdeš.', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 1 — H3', 'Začínáme v 10:00', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 1 — popis', 'Každou neděli. Chvály, krátké kázání, modlitby — trvá to kolem 90 minut.', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 2 — H3', 'Program pro děti', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 2 — popis', 'Kidztown pro nejmenší, WyldLife pro starší. Rodiče si sednou a poslouchají.', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 3 — H3', 'Káva a pohoda po', $ST);
$add($pg, $u, 'Co tě čeká', 'Karta 3 — popis', 'Po každé neděli zůstáváme, povídáme a sdílíme. Tohle je ta nejlepší část.', $ST);
$add($pg, $u, 'Co tě čeká', 'Odkaz', 'Celý průvodce pro první návštěvu', $ST, '→ /jsem-tu-poprve');
$add($pg, $u, 'Pro koho', 'Eyebrow', 'Pro koho to děláme', $ST);
$add($pg, $u, 'Pro koho', 'H2', 'Každý je tu vítaný.', $ST);
$add($pg, $u, 'Pro koho', 'Odstavec', 'Přijdou sem lidé z celého spektra — studenti, rodiny s dětmi, podnikatelé i pensisti. Nikdo není vylučován.', $ST, 'PŘEKLEP: „pensisti" → „penzisti"');
$add($pg, $u, 'Pro koho', 'Karta 1', 'Rodiny — Prostor pro každého — od nejmenšího po nejstaršího.', $ST);
$add($pg, $u, 'Pro koho', 'Karta 2', 'Děti • Kidztown — Batolata mají svůj program každý čtvrtek i v neděli.', $ST);
$add($pg, $u, 'Pro koho', 'Karta 3', 'Mládež • WyldLife — Klub pro 10–13 leté, středa 16:30–18:00.', $ST, 'POZOR: jinde uvádíte WyldLife 9–13 let');
$add($pg, $u, 'Pro koho', 'Karta 4', 'Dospělí — Lidé hledající komunitu, smysl nebo prostě dobrou kávu.', $ST);
$add($pg, $u, 'Pro koho', 'Přepínač', 'A co ještě během roku? / Schovat další akce', $ST);
$add($pg, $u, 'Pro koho — rozbalené', 'Karta', 'Limity — Mužská skupina, která jde k jádru věci. Vede Martin Fridrich.', $ST);
$add($pg, $u, 'Pro koho — rozbalené', 'Karta', 'Business chill — Setkání podnikatelů a manažerů. Sdílíme výzvy, modlíme se za byznys.', $ST);
$add($pg, $u, 'Pro koho — rozbalené', 'Karta', 'Filmové večery — Sborový film, popcorn a pak rozhovor o tom, co z toho plyne.', $ST);
$add($pg, $u, 'Pro koho — rozbalené', 'Karta', 'Sborové dovolené — Jedeme spolu na pár dní — hory, jídlo, hry, modlitby. Ročně.', $ST);
$add($pg, $u, 'Pro koho — rozbalené', 'Karta', 'CityCamp — Příměstský tábor pro děti — léto v Kolíně plné dobrodružství.', $ST);
$add($pg, $u, 'Nejnovější kázání', 'Eyebrow', 'Poslouchej', $ST);
$add($pg, $u, 'Nejnovější kázání', 'H2', 'Nejnovější kázání', $ST);
$add($pg, $u, 'Nejnovější kázání', 'Odstavec', 'Každou neděli tu máme nové slovo. Můžeš si ho pustit i zpětně — kdykoliv.', $ST);
$add($pg, $u, 'Nejnovější kázání', 'Odkaz', 'Všechna kázání', $ST);
$add($pg, $u, 'Nejnovější kázání', 'Prázdný stav', 'Kázání brzy přibydou / Mezitím se koukni na náš YouTube kanál.', $ST);
$add($pg, $u, 'Hodnoty', 'Eyebrow', 'Tři věci, které nás drží', $ST);
$add($pg, $u, 'Hodnoty', 'H2 (3 řádky)', 'Učíme o Ježíši. / Milujeme lidi. / Žijeme jako rodina.', $ST);
$add($pg, $u, 'Hodnoty', 'Karta 01', 'Učíme se o Ježíši — Bible, která mluví do dnešního života. Srozumitelně a bez předstírání.', $ST);
$add($pg, $u, 'Hodnoty', 'Karta 02', 'Milujeme lidi — Každý je vítaný — ať už jsi teprve hledá nebo věříš celý život.', $ST, 'GRAMATIKA: „jsi teprve hledá"');
$add($pg, $u, 'Hodnoty', 'Karta 03', 'Žijeme jako rodina — Nejsme jen program v neděli. Scházíme se během týdne, pomáháme si.', $ST);
$add($pg, $u, 'Hodnoty', 'Odkaz', 'Přečti si, kdo jsme a čemu věříme', $ST, '→ /kdo-jsme');
$add($pg, $u, 'Nejbližší akce', 'Eyebrow', 'Plán týdne', $ST);
$add($pg, $u, 'Nejbližší akce', 'H2', 'Nejbližší akce', $ST);
$add($pg, $u, 'Nejbližší akce', 'Odstavec', 'Neděle je jen začátek. Přes týden jsou skupinky, mládež a dětský klub.', $ST);
$add($pg, $u, 'Nejbližší akce', 'Odkaz', 'Celý kalendář', $ST, '→ /akce');
$add($pg, $u, 'Nejbližší akce', 'Prázdný stav', 'Žádné plánované akce. Zkontroluj to příští týden!', $ST);
$add($pg, $u, 'Závěrečné CTA', 'H2', 'Vidíme se v neděli?', $ST);
$add($pg, $u, 'Závěrečné CTA', 'Odstavec', 'V 10:00 ve V Zídkách 402, Kolín. Přijď, jak jsi — kavárna je otevřená od 9:30.', $ST, 'čísla z Nastavení');
$add($pg, $u, 'Závěrečné CTA', 'CTA tlačítko 1', 'Přijdu poprvé', $ST, '→ /jsem-tu-poprve');
$add($pg, $u, 'Závěrečné CTA', 'CTA tlačítko 2', 'Jak se k nám dostanete', $ST, '→ mapy');
$add($pg, $u, 'Součást rodiny', 'Eyebrow', 'Součást rodiny', $ST);
$add($pg, $u, 'Součást rodiny', 'Odstavec', 'Náš sbor je součástí Apoštolské církve v ČR — společenství víc než 100 sborů po celé zemi, které sdílí stejné hodnoty, víru a vizi.', $ST, 'odkaz na apostolskacirkev.cz');

// ───────────────────────── /nedele ─────────────────────────
$pg = 'Neděle';
$u = '/nedele';
$add($pg, $u, 'SEO / <head>', 'title', 'Neděle v 10:00 — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Každou neděli v 10:00 V Zídkách 402, Kolín. Chvály, kázání, káva — cca 90 minut. Program pro děti i mládež.', $ST);
$add($pg, $u, 'Hero', 'Eyebrow', 'Každou neděli', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Neděle v 10:00.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'V Zídkách 402, Kolín — vchod z Benešovy ulice. Průměrná délka 90 minut. Program pro děti i mládež běží paralelně.', $ST);
$add($pg, $u, 'Program', 'Eyebrow', 'Jak to vypadá', $ST);
$add($pg, $u, 'Program', 'H2', 'Program neděle, minuta po minutě.', $ST);
$add($pg, $u, 'Program', 'Položka 10:00', 'Chvály — Pár písní, volné zapojení. Nikdo nemusí zpívat, kdo nechce.', $ST);
$add($pg, $u, 'Program', 'Položka 10:30', 'Kázání — ~40 min, srozumitelně, bez religiózního slangu.', $ST);
$add($pg, $u, 'Program', 'Položka 11:10', 'Modlitba & oznámení — Krátce. Kdo chce, může přijít na modlitbu dopředu.', $ST);
$add($pg, $u, 'Program', 'Položka 11:30', 'Káva a pohoda — Tohle je ta nejlepší část. Zůstaň, povídáme si.', $ST);
$add($pg, $u, 'Program pro rodiny', 'Eyebrow', 'Program pro rodiny', $ST);
$add($pg, $u, 'Program pro rodiny', 'H2', 'Dětem dáme jejich prostor, rodičům klid.', $ST);
$add($pg, $u, 'Program pro rodiny', 'Odstavec', 'Během nedělního setkání probíhá besídka — program pro děti od batolat až po školáky. Rodiče si mohou sednout a v klidu poslouchat. WyldLife (9–13 let) probíhá ve středu odpoledne.', $ST);
$add($pg, $u, 'Program pro rodiny', 'Odkaz', 'Všechno, co děláme během týdne', $ST, '→ /co-delame');
$add($pg, $u, 'Program pro rodiny', 'Karta', 'Besídka — Každou neděli 🧒', $ST);
$add($pg, $u, 'Závěrečné CTA', 'H2', 'Vidíme se v neděli?', $ST);
$add($pg, $u, 'Závěrečné CTA', 'Odstavec', 'Stačí přijít. Ale pokud chceš, napiš nám předem.', $ST);
$add($pg, $u, 'Závěrečné CTA', 'CTA tlačítko 1', 'Přijdu poprvé', $ST, '→ /jsem-tu-poprve');
$add($pg, $u, 'Závěrečné CTA', 'CTA tlačítko 2', 'Co ještě děláme', $ST, '→ /co-delame');

// ───────────────────────── /jsem-tu-poprve ─────────────────────────
$pg = 'Jsem tu poprvé';
$u = '/jsem-tu-poprve';
$add($pg, $u, 'SEO / <head>', 'meta_title', $h('jsem-tu-poprve', 'meta_title'), $DBP);
$add($pg, $u, 'SEO / <head>', 'meta_description', $h('jsem-tu-poprve', 'meta_description'), $DBP);
$add($pg, $u, 'Hero', 'Eyebrow', $h('jsem-tu-poprve', 'hero_eyebrow'), $DBP);
$add($pg, $u, 'Hero', 'H1 + akcent', $h('jsem-tu-poprve', 'hero_title').' '.$h('jsem-tu-poprve', 'hero_title_accent'), $DBP);
$add($pg, $u, 'Hero', 'Odstavec', $h('jsem-tu-poprve', 'hero_description'), $DBP);
$add($pg, $u, 'Časté otázky', 'Eyebrow', 'Časté otázky', $ST);
$add($pg, $u, 'Časté otázky', 'H2', 'Co nejspíš řešíš', $ST);
foreach ($faqs as $i => $faq) {
    $add($pg, $u, 'Časté otázky', 'Otázka '.($i + 1), $faq['question'], $DBF);
    $add($pg, $u, 'Časté otázky', 'Odpověď '.($i + 1), $faq['answer'], $DBF);
}
$add($pg, $u, 'Mapa / místo', 'Eyebrow', 'Místo', $ST);
$add($pg, $u, 'Mapa / místo', 'H2', 'Kde nás najdeš', $ST);
$add($pg, $u, 'Mapa / místo', 'Odstavec', 'V Zídkách 402, Kolín 2 — vchod z Benešovy ulice. Modrá zóna v neděli zdarma.', $ST);
$add($pg, $u, 'Mapa / místo', 'Popisek foto 1', 'Tak vypadá budova zvenčí.', $ST);
$add($pg, $u, 'Mapa / místo', 'Popisek foto 2', 'U vchodu tě čeká tahle tabule.', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Eyebrow', 'Napiš nám', $ST);
$add($pg, $u, 'Formulář návštěvy', 'H2', 'Plánuji návštěvu', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Odstavec', 'Není povinné, ale rádi budeme vědět, že přijdeš. Přivítáme tě osobně.', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Hláška o úspěchu', 'Díky! Ozveme se ti brzy. Těšíme se na setkání.', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Labely polí', 'Jméno * · E-mail * · Telefon · Počet lidí * · Plánované datum · Poznámka', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Placeholdery', 'Vaše jméno · vas@email.cz · +420 123 456 789 · Cokoliv, co chcete, abychom věděli...', $ST);
$add($pg, $u, 'Formulář návštěvy', 'Tlačítko submit', 'Odeslat přihlášení / Odesílám…', $ST);

// ───────────────────────── /kdo-jsme ─────────────────────────
$pg = 'Kdo jsme';
$u = '/kdo-jsme';
$add($pg, $u, 'SEO / <head>', 'meta_title', $h('kdo-jsme', 'meta_title'), $DBP);
$add($pg, $u, 'SEO / <head>', 'meta_description', $h('kdo-jsme', 'meta_description'), $DBP);
$add($pg, $u, 'Hero', 'Eyebrow', $h('kdo-jsme', 'hero_eyebrow'), $DBP);
$add($pg, $u, 'Hero', 'H1 + akcent', $h('kdo-jsme', 'hero_title').' '.$h('kdo-jsme', 'hero_title_accent'), $DBP);
$add($pg, $u, 'Hero', 'Odstavec', $h('kdo-jsme', 'hero_description'), $DBP);
$add($pg, $u, 'Vize', 'Eyebrow', 'Kdo jsme', $ST);
$add($pg, $u, 'Vize', 'H2', 'Místní komunita, co má rada lidi.', $ST);
$add($pg, $u, 'Vize', 'Odstavec 1', 'Jsme místní komunita lidí, kterou spojuje víra v Boha a touha být užiteční lidem kolem nás. Věříme, že Bůh je Stvořitel všeho a Ježíš Kristus je naším osobním zachráncem i přítelem.', $ST);
$add($pg, $u, 'Vize', 'Odstavec 2', 'To, co nás učí o životě, naději a smyslu, nacházíme v Bibli. Věříme, že Bůh dává lidem dary i schopnosti, které používáme k vzájemné pomoci a službě druhým.', $ST);
$add($pg, $u, 'Vize', 'Odstavec 3', 'S radostí vítáme každého, kdo by se k nám chtěl připojit — nebo se chtěl jen přijít podívat.', $ST);
$add($pg, $u, 'Čemu věříme', 'Eyebrow', 'Čemu věříme', $ST);
$add($pg, $u, 'Čemu věříme', 'H2', 'Tři věci, na kterých stavíme', $ST);
$add($pg, $u, 'Čemu věříme', 'Bod 1', 'Bůh je Stvořitel — Věříme, že všechno, co je kolem nás — a my sami — máme od Boha. A že o nás stojí.', $ST);
$add($pg, $u, 'Čemu věříme', 'Bod 2', 'Ježíš je přítel i zachránce — Věříme, že Ježíš Kristus není jen postava z dějin, ale osobní zachránce a přítel pro každého, kdo ho pustí dál.', $ST);
$add($pg, $u, 'Čemu věříme', 'Bod 3', 'Bible nás vede — Učíme se z Bible o životě, naději a smyslu. Je pro nás mapou i kompasem.', $ST);
$add($pg, $u, 'Vedení sboru', 'Eyebrow', 'Vedení sboru', $ST);
$add($pg, $u, 'Vedení sboru', 'H2', 'Martin & Slávka Fridrichovi', $ST);
$add($pg, $u, 'Vedení sboru', 'Odstavec', 'Martin vede sbor společně se svou manželkou Slávkou. Věří, že víra se žije v každodennosti — v práci, v rodině i ve vztazích. Jsou rodiče, manželé a lidé, kteří mají rádi lidi.', $ST);
$add($pg, $u, 'Vedení sboru', 'Placeholder', '(Delší představení Martina a Slávky — doplníme.)', $ST, 'K DOPLNĚNÍ');
$add($pg, $u, 'Součást rodiny', 'Eyebrow', 'Součást rodiny', $ST);
$add($pg, $u, 'Součást rodiny', 'H2', 'Jsme součástí Apoštolské církve v ČR.', $ST);
$add($pg, $u, 'Součást rodiny', 'Odstavec', 'Společenství víc než 100 sborů po celé zemi. Sdílíme stejné hodnoty, víru a touhu žít autenticky.', $ST);
$add($pg, $u, 'Součást rodiny', 'Odkaz', 'apostolskacirkev.cz', $ST, 'externí');

// ───────────────────────── /kontakt ─────────────────────────
$pg = 'Kontakt';
$u = '/kontakt';
$add($pg, $u, 'SEO / <head>', 'meta_title', $h('kontakt', 'meta_title'), $DBP);
$add($pg, $u, 'SEO / <head>', 'meta_description', $h('kontakt', 'meta_description'), $DBP);
$add($pg, $u, 'Hero', 'Eyebrow', $h('kontakt', 'hero_eyebrow'), $DBP);
$add($pg, $u, 'Hero', 'H1 + akcent', $h('kontakt', 'hero_title').' '.$h('kontakt', 'hero_title_accent'), $DBP);
$add($pg, $u, 'Hero', 'Odstavec', $h('kontakt', 'hero_description'), $DBP);
$add($pg, $u, 'Kontaktní karty', 'Karta Adresa', 'V Zídkách 402, Kolín 2, PSČ 280 02', $DBS);
$add($pg, $u, 'Kontaktní karty', 'Karta E-mail', 'kolin@apostolskacirkev.cz', $DBS);
$add($pg, $u, 'Kontaktní karty', 'Karta Bohoslužba', '10:00 — cca 11:30 / Kavárna od 9:30 / Neděle', $DBS);
$add($pg, $u, 'Kontaktní karty', 'Karta Účet', '435669379 / 0800 (ČS)', $DBS);
$add($pg, $u, 'Orientační body', 'Eyebrow', 'Orientační body', $ST);
$add($pg, $u, 'Orientační body', 'H2', 'Takhle to u nás vypadá.', $ST);
$add($pg, $u, 'Orientační body', 'Odstavec', 'Abys nás poznal(a), když přijdeš poprvé. Hledej prosklený vstup a černou tabuli „Vítejte CÍRKEV KOLÍN".', $ST);
$add($pg, $u, 'Orientační body', 'Popisek foto 1', 'Budova z ulice. Najdi prosklený vchod — přijdeš přes kovovou branku.', $ST);
$add($pg, $u, 'Orientační body', 'Popisek foto 2', '„Vítejte" u vstupu. Když vidíš tuhle tabuli, jsi na správným místě.', $ST);

// ───────────────────────── /prispet ─────────────────────────
$pg = 'Přispět';
$u = '/prispet';
$add($pg, $u, 'SEO / <head>', 'title', 'Přispět — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Podpořte finančně církev kolín. Číslo účtu 435669379/0800, IBAN CZ6508000000004356693790.', $ST);
$add($pg, $u, 'Hero', 'Eyebrow', 'Přispět', $ST, 'POZOR: v DB je hero „Přispěj na to, co děláme" — na stránce se ale zobrazuje tento statický text');
$add($pg, $u, 'Hero', 'H1 + akcent', 'Děkujeme. Vážně.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Váš dar pomáhá pokrývat provoz sboru, programy pro děti a mládež, a také podporu lidí v tíživé životní situaci. Každá koruna počítá.', $ST);
$add($pg, $u, 'Platba', 'Eyebrow', 'Bankovním převodem', $ST);
$add($pg, $u, 'Platba', 'H2', 'Kam poslat dar', $ST);
$add($pg, $u, 'Platba', 'Popisky polí', 'Číslo účtu · IBAN (pro zahraniční platby)', $ST);
$add($pg, $u, 'Platba', 'Tlačítka', 'Kopírovat / Zkopírováno / OK', $ST);
$add($pg, $u, 'Na co dary jdou', 'Eyebrow', 'Na co dary jdou', $ST);
$add($pg, $u, 'Na co dary jdou', 'H2', 'Každá koruna má adresu', $ST);
$add($pg, $u, 'Na co dary jdou', 'Bod 1', 'Sborová budova — Provoz, nájem, energie — abys mohl přijít do teplé místnosti.', $ST);
$add($pg, $u, 'Na co dary jdou', 'Bod 2', 'Program pro děti — Kidztown, WyldLife — materiály, vybavení, akce.', $ST);
$add($pg, $u, 'Na co dary jdou', 'Bod 3', 'Hudba a technika — Nástroje, mixpult, mikrofony — aby zvuk seděl.', $ST);
$add($pg, $u, 'Na co dary jdou', 'Bod 4', 'Sociální pomoc — Akutní pomoc lidem v nouzi z našeho okolí.', $ST);
$add($pg, $u, 'Na co dary jdou', 'Poznámka', 'Dary fyzických osob nejsou daňově uznatelné. Právnické osoby mohou kontaktovat sbor pro vystavení potvrzení.', $ST);

// ───────────────────────── /co-delame ─────────────────────────
$pg = 'Co děláme';
$u = '/co-delame';
$add($pg, $u, 'SEO / <head>', 'title', 'Co děláme — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Neděle, skupinky, WyldLife, Kidztown — co všechno děláme v církev kolín. Komunita, která žije celý týden.', $ST);
$add($pg, $u, 'Hero', 'Eyebrow', 'Co děláme', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Nejsme jen neděle.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Kromě nedělního dopoledne se scházíme celý týden — děti, mládež, rodiče, podnikatelé. Přijď tam, kde to sedne tobě.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 1', '🙌 Nedělní dopoledne — Každou neděli v 10:00 se scházíme úplně všichni. Chvály, kázání, káva — a nikdo nikam nepospíchá.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 2', '🧸 Kidztown — Mateřské centrum pro batolata a jejich rodiče. Středy, čtvrtky a neděle — hraní, vyrábění, podpora.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 3', '🏄 WyldLife — Klub pro děti 9–13 let. Každou středu 16:30–18:00. Hry, smích, nové zážitky.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 4', '🔥 Young Life — Pro teenagery 14–19 let. Pátky 17:30–19:30. Hry, rozhovory o životě i víře, přátelství.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 5', '☕ Kavárna — Výběrová káva Fathers. V neděli, u Kidztownu i na Blešáku — nejlepší kafe v Kolíně.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 6', '💼 Business setkání — Středy ráno — pro podnikatele a manažery. Inspirace, sdílení výzev, modlitby za byznys.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'Karta 7', '🤝 Menší skupiny — Kromě velké neděle jsou tu menší skupinky — Limity pro muže a další. Tam se dá jít opravdu do hloubky.', $ST);
$add($pg, $u, 'Mřížka aktivit', 'CTA (na každé kartě)', 'Zjistit víc', $ST);

// ───────────────────────── /co-delame/nedelni-setkani ─────────────────────────
$pg = 'CoDěláme: Nedělní dopoledne';
$u = '/co-delame/nedelni-setkani';
$add($pg, $u, 'SEO / <head>', 'title', 'Nedělní dopoledne — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Každou neděli v 10:00 v Kolíně. Chvály, slovo od pastora, program pro děti a nejlepší káva v Kolíně po skončení.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět', '← Co děláme', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Srdce naší komunity', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Nedělní dopoledne.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Každou neděli v 10:00 se scházíme všichni společně — a rádi mezi sebou přivítáme každého, i neohlášené hosty. U nás nedělíme lidi na věřící a nevěřící. Každý, kdo přijde, je vítán.', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Neděle 10:00 · V Zídkách 402, Kolín', $ST);
$add($pg, $u, 'Jak to vypadá', 'Eyebrow', 'Jak to u nás vypadá', $ST);
$add($pg, $u, 'Jak to vypadá', 'H2', 'Zamyšlení, chvály, a nikdo nikam nepospíchá.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Odstavec 1', 'Během „oficiálního" programu si od našeho pastora poslechneme zamyšlení o tom, jak víra souvisí s našimi každodenními životy. Je to srozumitelně, prakticky a beze zbytečných frází.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Odstavec 2', 'Součástí programu je také hudba — této části říkáme chvály. Na pódiu hraje kapela moderní písně vytvářející prostor pro rozjímání, vnitřní ztišení a napojení na Boha. Kdo chce, může se přidat zpěvem — nebo jen tiše poslouchat.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Odstavec 3', 'Ve stejné budově v prostorech mateřského centra KidzTown zároveň probíhá samostatný program pro děti, aby rodiče mohli být v klidu na setkání.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Odstavec 4', 'Po skončení bohoslužby to většinou nekončí — zůstáváme u „nejlepší kávy v Kolíně" a domácího zákusku. Povídáme si, seznamujeme se a sdílíme život.', $ST);
$add($pg, $u, 'Program', 'Eyebrow', 'Program', $ST);
$add($pg, $u, 'Program', 'H2', 'Rámcově to vypadá takhle', $ST);
$add($pg, $u, 'Program', 'Odstavec', 'Trvá to kolem hodiny a půl. Čas je přibližný — nespěcháme na nikoho.', $ST);
$add($pg, $u, 'Program', 'Položka 10:00', 'Chvály — Pár písniček pro naladění srdce. Kapela hraje moderní chválové písně, text se promítá — ať jsi zpěvák, nebo ne.', $ST);
$add($pg, $u, 'Program', 'Položka 10:20', 'Zamyšlení — Pastor Martin (nebo host) otevře Bibli a hledá, co dnes říká nám. Lidsky, prakticky, upřímně.', $ST);
$add($pg, $u, 'Program', 'Položka 11:10', 'Modlitba a oznámení — Modlíme se za sebe navzájem a říkáme si, co se v komunitě děje během týdne.', $ST);
$add($pg, $u, 'Program', 'Položka 11:30', 'Káva a pokec — Nejlepší část. Kafe, čaj, domácí zákusek a čas na rozhovor. Nikdo tě nevyhání.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow', 'Kdo to vede', $ST);
$add($pg, $u, 'Vedoucí', 'H2', 'Kdo tě v neděli přivítá', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 1', 'Martin Fridrich — Pastor sboru — káže a vede setkání', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 2', 'Slávka Fridrichová — Manželka pastora — srdce rodiny a vítání', $ST);
$add($pg, $u, 'CTA', 'Levá karta', 'Přijdeš poprvé? — Přijít poprvé je úplně normální věc. U vchodu tě přivítáme, ukážeme ti, kde co je, a pokud chceš, posadíme tě k někomu, kdo tě provede. [Jsem tu poprvé]', $ST);
$add($pg, $u, 'CTA', 'Pravá karta', 'Kde nás najdeš — V Zídkách 402, Kolín 2 (vchod z Benešovy ulice). Hledej tabuli „Vítejte" — a jsi na místě. [Otevřít v mapách]', $ST);

// ───────────────────────── /co-delame/kidztown ─────────────────────────
$pg = 'CoDěláme: Kidztown';
$u = '/co-delame/kidztown';
$add($pg, $u, 'SEO / <head>', 'title', 'Kidztown — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Kidztown — mateřské centrum pro batolata a jejich rodiče. Středy a čtvrtky dopoledne, navíc program pro děti v neděli při bohoslužbě.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Pro děti 0–3 + rodiče', $ST);
$add($pg, $u, 'Hero', 'H1', 'Kidztown.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Mateřské centrum, kde se děti radují z objevování světa a rodiče najdou podporu, společnost a novou kávu.', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Středa a čtvrtek 10:30–12:30 · V Zídkách 402, Kolín', $ST);
$add($pg, $u, 'Co se děje', 'Eyebrow', 'Co se v Kidztownu děje', $ST);
$add($pg, $u, 'Co se děje', 'H2', 'Hraní, vyrábění, káva pro rodiče.', $ST);
$add($pg, $u, 'Co se děje', 'Odstavec 1', 'Scházíme se ve středu a čtvrtek dopoledne ke společnému hraní, vyrábění a sdílení času s dětmi. Zároveň dáváme prostor maminkám (i tatínkům), aby si mohli v klidu vypít skvělou kávu.', $ST);
$add($pg, $u, 'Co se děje', 'Odstavec 2', 'Kidztown je bezpečné a přátelské místo, kde se děti můžou radovat z objevování světa a rodiče najdou podporu, společnost a nové přátele.', $ST);
$add($pg, $u, 'Co se děje', 'Karta 1', 'Bezpečnost na prvním místě — Vedoucí mají platný výpis z rejstříku trestů a prošli školením ochrany dětí. V neděli pracujeme ve dvojicích, dítě předáváme vždy zpátky rodiči.', $ST);
$add($pg, $u, 'Co se děje', 'Karta 2', 'I v neděli — V neděli paralelně s kázáním probíhá samostatný program pro děti. Rodiče mají klid na setkání, děti mají svoje.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Kdo vede Kidztown', $ST);
$add($pg, $u, 'Vedoucí', 'Karty', 'Jméno vedoucí — Vedoucí Kidztown — doplníme (2×)', $ST, 'K DOPLNĚNÍ — placeholder jména');
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Víc na vlastních stránkách — Kidztown má vlastní web a Facebook — tam najdeš aktuální program, fotky i praktické info.', $ST);
$add($pg, $u, 'CTA', 'Tlačítka', 'kidztown.cz · Facebook', $ST);

// ───────────────────────── /co-delame/wyldlife ─────────────────────────
$pg = 'CoDěláme: WyldLife';
$u = '/co-delame/wyldlife';
$add($pg, $u, 'SEO / <head>', 'title', 'WyldLife — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'WyldLife je klub pro děti 9–13 let. Každou středu 16:30–18:00 v Kolíně. Hry, zážitky, kamarádství, občas i vážnější rozhovor.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Pro 9–13 let', $ST);
$add($pg, $u, 'Hero', 'H1', 'WyldLife', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Klub pro děti mezi dětstvím a dospíváním. Bezpečné, přátelské místo, kde mohou trávit čas s kamarády, zažívat nové věci a rozvíjet vztahy.', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Středa 16:30–18:00 · V Zídkách 402, Kolín · 9–13 let', $ST);
$add($pg, $u, 'Obsah', 'H2 (levý)', 'Co se na WyldLife děje?', $ST);
$add($pg, $u, 'Obsah', 'Odstavec', 'Každé setkání má jiný program — hry, vyrábění i speciální akce. Aktuální plán na měsíc dáváme vždycky na Facebook, ať víš, na co se těšit.', $ST);
$add($pg, $u, 'Obsah', 'Výčet (levý)', 'Hry, soutěže a občas trochu šílenosti · Témata, která dávají smysl v reálném životě · Čas na pokec, když se chce · Výpravy a speciální akce během roku · Bezpečný prostor pro otázky i pochybnosti', $ST);
$add($pg, $u, 'Obsah', 'H2 (pravý)', 'Přijít můžeš kdykoliv', $ST);
$add($pg, $u, 'Obsah', 'Odstavec 1', 'WyldLife je pro všechny děti ve věku 9–13 let — nezáleží na tom, jestli do církve chodíš, nebo ne. Vítáme každého, i v průběhu roku.', $ST);
$add($pg, $u, 'Obsah', 'Odstavec 2', 'Vedoucí jsou dobrovolníci, kteří to dělají, protože jim na dětech záleží. Jsou proškolení, prověření a hlavně — mají rádi legraci.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Kdo má WyldLife na starosti', $ST);
$add($pg, $u, 'Vedoucí', 'Karty', 'Jméno vedoucího — Vedoucí WyldLife — doplníme (2×)', $ST, 'K DOPLNĚNÍ — placeholder jména');
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Chceš vědět víc? — Aktuální program a novinky najdeš na Facebooku. Můžeš se ale taky jen tak stavit — první návštěva je bez závazků.', $ST);
$add($pg, $u, 'CTA', 'Tlačítka', 'WYLD LIFE Kolín na FB · Napsat nám', $ST);

// ───────────────────────── /co-delame/skupinky ─────────────────────────
$pg = 'CoDěláme: Menší skupiny';
$u = '/co-delame/skupinky';
$add($pg, $u, 'SEO / <head>', 'title', 'Menší skupiny — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Kromě velké neděle se v týdnu scházíme v menších skupinách. Tam je prostor jít do hloubky — Limity pro muže a další.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Komunita v týdnu', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Menší skupiny.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Neděle je úžasná, ale skutečný život — a skutečné přátelství — se často odehrává v menších skupinkách. Tady víme jeden o druhém, modlíme se spolu a neseme se navzájem.', $ST);
$add($pg, $u, 'Skupiny', 'Eyebrow', 'Co se scházíme', $ST, 'GRAMATIKA: zní nedokončeně');
$add($pg, $u, 'Skupiny', 'H2', 'Skupiny, které právě běží', $ST);
$add($pg, $u, 'Skupiny', 'Karta 1', 'Limity — pro muže — Mužská skupina, která se baví o tom, co se v hluku všedního dne těžko říká. Vede ji Martin Fridrich. (Termín a místo — napiš si o něj.)', $ST);
$add($pg, $u, 'Skupiny', 'Karta 2', 'Business setkání — Středy ráno pro podnikatele a manažery. Sdílení, inspirace, modlitby za byznys. [Víc info]', $ST);
$add($pg, $u, 'Jak to vypadá', 'H3', 'Jak skupinka vypadá?', $ST);
$add($pg, $u, 'Jak to vypadá', 'Bod 1', 'Menší počet lidí. Dost malá, aby každý mohl mluvit. Dost velká, aby bylo pestro.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Bod 2', 'Příběhy a Bible. Mluvíme o tom, co prožíváme — a o tom, co k tomu říká Bible.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Bod 3', 'Opravdu spolu. Radosti i trápení si neseme — modlíme se za sebe a pomáháme si.', $ST);
$add($pg, $u, 'Jak to vypadá', 'Bod 4', 'Každý týden nebo čtrnáct dní. Obvykle večer. Přesný čas záleží na skupině.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Vedoucí skupin — ozvi se jim', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 1', 'Martin Fridrich — Vede skupinu Limity pro muže', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 2', 'Martin Penc — Vede Business setkání', $ST);
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Chci do skupiny — Napiš nebo se zeptej v neděli. Doladíme spolu, co by ti nejvíc sedlo — ať už to je Limity, Business, nebo něco nového. [Napsat nám]', $ST);

// ───────────────────────── /co-delame/young-life ─────────────────────────
$pg = 'CoDěláme: Young Life';
$u = '/co-delame/young-life';
$add($pg, $u, 'SEO / <head>', 'title', 'Young Life — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Young Life pro teenagery 14–19 let. Pátky 17:30–19:30 v Kolíně. Hry, rozhovory o životě i víře, přátelství.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Pro 14–19 let', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Young Life.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Pro teenagery, kteří hledají, kam patří. Prostor pro zábavu i vážnější rozhovory o životě a víře. Tady můžeš být takový, jaký doopravdy jsi.', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Pátek 17:30–19:30 · V Zídkách 402, Kolín · 14–19 let', $ST);
$add($pg, $u, 'O čem to je', 'Eyebrow', 'O čem to je', $ST);
$add($pg, $u, 'O čem to je', 'H2', 'Najdi si svý lidi.', $ST);
$add($pg, $u, 'O čem to je', 'Odstavec 1', 'Young Life je místo pro teenagery od 14 do 19 let. Trávíme spolu čas, hrajeme hry, povídáme si a podnikáme společně věci, které nás baví a spojují.', $ST);
$add($pg, $u, 'O čem to je', 'Odstavec 2', 'Přejeme si, aby u nás mohl každý zažít pocit, že někam patří. Že je přijatý takový, jaký je. A že nemusí na nic hrát.', $ST);
$add($pg, $u, 'O čem to je', 'Odstavec 3', 'Neváhej dorazit — první návštěva je bez závazků.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Koho tady potkáš', $ST);
$add($pg, $u, 'Vedoucí', 'Karty', 'Jméno vedoucího — Vedoucí Young Life — doplníme (2×)', $ST, 'K DOPLNĚNÍ — placeholder jména');
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Chceš vědět, co se chystá? — Ozvi se a pošleme ti aktuální plán akcí. Nebo jen v pátek přijď — stačí otevřít dveře. [Napsat nám]', $ST);

// ───────────────────────── /co-delame/kavarna ─────────────────────────
$pg = 'CoDěláme: Kavárna';
$u = '/co-delame/kavarna';
$add($pg, $u, 'SEO / <head>', 'title', 'Kavárna — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Výběrová káva Fathers, připravovaná s péčí našimi baristy. V neděli, při Kidztownu, na Blešáku a dalších akcích v Kolíně.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Nejlepší kafe v Kolíně', $ST);
$add($pg, $u, 'Hero', 'H1', 'Kavárna.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Výběrová káva Fathers, připravovaná s péčí a vášní. Káva, ke které se budeš rád vracet.', $ST);
$add($pg, $u, 'O kavárně', 'Eyebrow', 'O kavárně', $ST);
$add($pg, $u, 'O kavárně', 'H2', 'Káva s příběhem. A s Pájou.', $ST);
$add($pg, $u, 'O kavárně', 'Odstavec 1', 'Naše kavárna nabízí výběrovou kávu Fathers, připravovanou s péčí a vášní našimi skvělými baristy v čele s Pájou. Je to káva, ke které se budete rádi vracet znovu a znovu.', $ST);
$add($pg, $u, 'O kavárně', 'Odstavec 2', 'Finanční příspěvky z provozu kavárny směřují na podporu… (doplníme).', $ST, 'K DOPLNĚNÍ');
$add($pg, $u, 'Kdy nás najít', 'Karta 1', 'Každá neděle — Od 9:30 před bohoslužbou i po ní — připrav si ji na rozhovor s přáteli.', $ST);
$add($pg, $u, 'Kdy nás najít', 'Karta 2', 'U Kidztownu — Středa a čtvrtek dopoledne — káva pro rodiče, zatímco si děti hrají.', $ST);
$add($pg, $u, 'Kdy nás najít', 'Karta 3', 'Na akcích — Najdeš nás na Blešáku a dalších městských akcích — hledej žlutou dodávku.', $ST);
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Kdo ti tu kávu udělá', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 1', 'Pája — Hlavní barista — stojí za nejlepší kávou v Kolíně', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 2', 'Jméno kolegy — Barista — doplníme', $ST, 'K DOPLNĚNÍ — placeholder jména');
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Přijď na kafe — Nemusíš jít na bohoslužbu. Stačí otevřít dveře a říct, jaký máš rád espresso. [Jak to v neděli chodí]', $ST);

// ───────────────────────── /co-delame/business ─────────────────────────
$pg = 'CoDěláme: Business setkání';
$u = '/co-delame/business';
$add($pg, $u, 'SEO / <head>', 'title', 'Business setkání — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Středeční setkání podnikatelů a manažerů. Inspirace, sdílení výzev, modlitby za byznys. Hodinu ráno, pak zpět do práce.', $ST);
$add($pg, $u, 'Hero', 'Odkaz zpět + badge', '← Co děláme · Pro podnikatele a manažery', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Business setkání.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Chceš se potkat s lidmi ve vedoucích pozicích, nechat se inspirovat a zároveň inspirovat ostatní, sdílet své výzvy a modlit se za své podnikání? Právě k tomu tyhle středy jsou.', $ST);
$add($pg, $u, 'Hero', 'Badge', 'Středa ráno · ~60 min · Malá skupina', $ST);
$add($pg, $u, 'Jak to probíhá', 'Eyebrow', 'Jak to probíhá', $ST);
$add($pg, $u, 'Jak to probíhá', 'H2', 'Neformálně, organicky, podle zájmu.', $ST);
$add($pg, $u, 'Jak to probíhá', 'Odstavec 1', 'Setkání probíhají ve středu ráno — neformálně a organicky, podle toho, co aktuálně řešíme. Obvykle trvají přibližně hodinu, pak každý zpátky do práce.', $ST);
$add($pg, $u, 'Jak to probíhá', 'Odstavec 2', 'Bavíme se o věcech, které v běžném pracovním hovoru nemají místo: dilema, které tě tíží, rozhodnutí, co tě čeká, vděčnost za průlom, prosba o modlitbu za lidi v týmu.', $ST);
$add($pg, $u, 'Jak to probíhá', 'Odstavec 3', 'Pokud se chceš přidat, ozvi se Martinovi Pencovi nebo Michalu Koudelkovi.', $ST);
$add($pg, $u, 'Jak to probíhá', 'Kontakt 1', 'Martin Penc — Kontakt (doplníme)', $ST, 'K DOPLNĚNÍ');
$add($pg, $u, 'Jak to probíhá', 'Kontakt 2', 'Michal Koudelka — Kontakt (doplníme)', $ST, 'K DOPLNĚNÍ');
$add($pg, $u, 'Vedoucí', 'Eyebrow + H2', 'Kdo to vede / Koho se můžeš zeptat', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 1', 'Martin Penc — Vede Business setkání — ozvi se mu přímo', $ST);
$add($pg, $u, 'Vedoucí', 'Karta 2', 'Michal Koudelka — Druhý pilíř setkání — taky se ho můžeš zeptat', $ST);
$add($pg, $u, 'CTA', 'H2 + odstavec', 'Přijít se jen mrknout? — Jasně. Ozvi se předem, ať víme, že dorazíš — a připravíme dvě kávy. [Napsat nám]', $ST);

// ───────────────────────── /kazani ─────────────────────────
$pg = 'Kázání (výpis)';
$u = '/kazani';
$add($pg, $u, 'SEO / <head>', 'title', 'Kázání — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Poslechněte si kázání z Apoštolské církve Kolín. Filtrujte podle řečníka, série nebo tématu.', $ST);
$add($pg, $u, 'Hero', 'Eyebrow', 'Kázání', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Poslechni si, co se u nás děje.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Záznamy nedělních setkání a dalších přednášek. Filtruj podle řečníka, série nebo tématu — najdi, co tě chytne.', $ST);
$add($pg, $u, 'Filtry', 'Placeholder', 'Hledat kázání…', $ST);
$add($pg, $u, 'Filtry', 'Výchozí volby', 'Všichni řečníci · Všechny série · Všechna témata', $ST);
$add($pg, $u, 'Filtry', 'Tlačítko', 'Zrušit filtry', $ST);
$add($pg, $u, 'Výpis', 'Karty kázání', '[seznam kázání]', $DYN, 'obsah z DB → admin: Kázání');
$add($pg, $u, 'Výpis', 'Prázdný stav', 'Žádná kázání nenalezena. / Zkuste uvolnit filtry.', $ST);
$add($pg, $u, 'Stránkování', 'Odkazy', '← Předchozí · Další →', $ST);

// ───────────────────────── /kazani/{slug} ─────────────────────────
$pg = 'Kázání (detail)';
$u = '/kazani/{slug}';
$add($pg, $u, 'SEO / <head>', 'title', '[název kázání] — církev kolín', $DYN);
$add($pg, $u, 'Video', 'Souhlas cookies', 'Video je uloženo na YouTube. Přehráním souhlasíte s tím, že YouTube může ukládat cookies.', $ST);
$add($pg, $u, 'Video', 'Tlačítko / prázdný stav', 'Přehrát video / Video není dostupné', $ST);
$add($pg, $u, 'Hlavička', 'H1 + meta', '[název, řečník, datum]', $DYN, 'z admin: Kázání');
$add($pg, $u, 'Záložky', 'Taby', 'Shrnutí · Bible verše · Pro skupinku', $ST);
$add($pg, $u, 'Záložky', 'Prázdné stavy', 'Popis není k dispozici. / Bible verše nejsou zadány. / Otázky pro skupinku nejsou zadány.', $ST);
$add($pg, $u, 'Související', 'H2', 'Další kázání', $ST);

// ───────────────────────── /akce ─────────────────────────
$pg = 'Akce (výpis)';
$u = '/akce';
$add($pg, $u, 'SEO / <head>', 'title', 'Akce — církev kolín', $ST);
$add($pg, $u, 'SEO / <head>', 'meta_description', 'Přehled akcí Apoštolské církve Kolín — neděle, WyldLife, Kidztown, skupinky a další.', $ST);
$add($pg, $u, 'Hero', 'Eyebrow', 'Kalendář', $ST);
$add($pg, $u, 'Hero', 'H1 + akcent', 'Co se u nás chystá.', $ST);
$add($pg, $u, 'Hero', 'Odstavec', 'Nedělní setkání, WyldLife, Kidztown a další. Přijď, kam ti to sedí — každá akce je otevřená.', $ST);
$add($pg, $u, 'Filtr', 'Tlačítka kategorií', 'Vše · Neděle · Wyldlife · Kidztown · Skupinky · Akce', $ST);
$add($pg, $u, 'Výpis', 'Karty akcí', '[seznam akcí]', $DYN, 'obsah z DB → admin: Akce');
$add($pg, $u, 'Výpis', 'Prázdný stav', 'Žádné akce nenalezeny.', $ST);
$add($pg, $u, 'Stránkování', 'Odkazy', '← Předchozí · Další →', $ST);

// ───────────────────────── /akce/{slug} ─────────────────────────
$pg = 'Akce (detail)';
$u = '/akce/{slug}';
$add($pg, $u, 'SEO / <head>', 'title', '[název akce] — církev kolín', $DYN);
$add($pg, $u, 'Hlavička', 'Odkaz zpět', '← Všechny akce', $ST);
$add($pg, $u, 'Hlavička', 'H1 + meta', '[název, datum/čas, místo]', $DYN, 'z admin: Akce');
$add($pg, $u, 'Popis', 'Text / prázdný stav', '[popis akce] / Popis není k dispozici.', $ST);

// ───────────────────────── Generování XLSX ─────────────────────────
$headers = ['Stránka', 'URL', 'Sekce', 'Prvek / typ', 'Současný text', 'Zdroj / kde upravit', 'NÁVRH ÚPRAVY (sem piš)', 'Poznámka'];

$border = new Border(new BorderPart(Border::BOTTOM, 'D0D0D0', Border::WIDTH_THIN, Border::STYLE_SOLID));

$headerStyle = (new Style)
    ->setFontBold()->setFontSize(11)->setFontColor('FFFFFF')
    ->setBackgroundColor('1F3A5F')
    ->setShouldWrapText()
    ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);

$pageStyle = (new Style)
    ->setFontBold()->setFontSize(11)->setFontColor('1F3A5F')
    ->setBackgroundColor('DCE6F1')
    ->setCellVerticalAlignment(CellVerticalAlignment::TOP)
    ->setShouldWrapText()->setBorder($border);

$cellStyle = (new Style)
    ->setFontSize(10)->setShouldWrapText()
    ->setCellVerticalAlignment(CellVerticalAlignment::TOP)->setBorder($border);

$editStyle = (new Style)
    ->setFontSize(10)->setShouldWrapText()
    ->setBackgroundColor('FFF7DC')
    ->setCellVerticalAlignment(CellVerticalAlignment::TOP)->setBorder($border);

$noteStyle = (new Style)
    ->setFontSize(9)->setFontItalic()->setFontColor('A0522D')->setShouldWrapText()
    ->setCellVerticalAlignment(CellVerticalAlignment::TOP)->setBorder($border);

$options = new Options;
$options->setColumnWidth(20, 1);
$options->setColumnWidth(20, 2);
$options->setColumnWidth(22, 3);
$options->setColumnWidth(20, 4);
$options->setColumnWidth(70, 5);
$options->setColumnWidth(22, 6);
$options->setColumnWidth(45, 7);
$options->setColumnWidth(34, 8);

$out = __DIR__.'/../storage/app/textace-webu-cirkevkolin.xlsx';
$writer = new Writer($options);
$writer->openToFile($out);
$writer->getCurrentSheet()->setName('Textace webu');
$sheetView = (new SheetView)->setFreezeRow(2)->setFreezeColumn('C');
$writer->getCurrentSheet()->setSheetView($sheetView);

$writer->addRow(Row::fromValues($headers, $headerStyle));

$lastPage = null;
foreach ($D as $row) {
    [$page, $url, $section, $element, $text, $source, $note] = $row;
    $isNewPage = ($page !== $lastPage);
    $lastPage = $page;

    $rowStyle = $isNewPage ? $pageStyle : $cellStyle;
    $cells = [
        Cell::fromValue($page, $isNewPage ? $pageStyle : $cellStyle),
        Cell::fromValue($url, $isNewPage ? $pageStyle : $cellStyle),
        Cell::fromValue($section, $cellStyle),
        Cell::fromValue($element, $cellStyle),
        Cell::fromValue($text, $cellStyle),
        Cell::fromValue($source, $cellStyle),
        Cell::fromValue('', $editStyle),
        Cell::fromValue($note, $noteStyle),
    ];
    $writer->addRow(new Row($cells));
}

$writer->close();

echo 'OK: '.$out.' ('.count($D)." řádků textů)\n";
