<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Domů',
                'hero_eyebrow' => 'Neděle 10:00 · živě i online',
                'hero_title' => 'Pojď dál',
                'hero_title_accent' => 'a buď tu jako doma.',
                'hero_accent_color' => 'coral',
                'hero_description' => 'Otevřená komunita Apoštolské církve v Kolíně. Scházíme se každou neděli v 10:00 V Zídkách 402. Chvály, slovo, káva, lidi.',
                'meta_title' => 'církev kolín — jako doma',
                'meta_description' => 'Apoštolská církev Kolín. Neděle v 10:00, V Zídkách 402. Otevřená komunita, kde se cítíš jako doma — ať jsi tu poprvé nebo odjakživa.',
                'is_published' => true,
            ],
            [
                'slug' => 'jsem-tu-poprve',
                'title' => 'Jsem tu poprvé',
                'hero_eyebrow' => 'Vítejte',
                'hero_title' => 'Jsem tu',
                'hero_title_accent' => 'poprvé.',
                'hero_accent_color' => 'coral',
                'hero_description' => 'Rozumíme — přijít někam poprvé může být trochu divné. Proto jsme připravili odpovědi na otázky, které tě asi napadají. A pokud něco chybí, napiš nám.',
                'meta_title' => 'Jsem tu poprvé — církev kolín',
                'meta_description' => 'Plánujete první návštěvu? Zjistěte, co vás čeká, kde zaparkovat, co s dětmi a jak to u nás chodí.',
                'is_published' => true,
            ],
            [
                'slug' => 'kdo-jsme',
                'title' => 'Kdo jsme',
                'hero_eyebrow' => 'O nás',
                'hero_title' => 'Kdo jsme',
                'hero_title_accent' => 'a čemu věříme.',
                'hero_accent_color' => 'teal',
                'hero_description' => 'Jsme místní komunita lidí, kterou spojuje víra v Boha a touha být užiteční lidem kolem nás. S radostí vítáme každého, kdo se chce přidat — nebo se jen přijít podívat.',
                'meta_title' => 'Kdo jsme — církev kolín',
                'meta_description' => 'Jsme otevřená komunita v Kolíně, která podporuje život v celé jeho šíři. Apoštolská církev Kolín, pastor Martin Fridrich.',
                'is_published' => true,
            ],
            [
                'slug' => 'kontakt',
                'title' => 'Kontakt',
                'hero_eyebrow' => 'Kontakt',
                'hero_title' => 'Napiš.',
                'hero_title_accent' => 'Přijď. Ozvi se.',
                'hero_accent_color' => 'teal',
                'hero_description' => 'Jsme dostupní — napiš, zavolej nebo prostě přijď. Nejlíp v neděli v 10:00.',
                'meta_title' => 'Kontakt — církev kolín',
                'meta_description' => 'V Zídkách 402, Kolín. E-mail kolin@apostolskacirkev.cz. Neděle 10:00.',
                'is_published' => true,
            ],
            [
                'slug' => 'prispet',
                'title' => 'Přispět',
                'hero_eyebrow' => 'Dary',
                'hero_title' => 'Přispěj',
                'hero_title_accent' => 'na to, co děláme.',
                'hero_accent_color' => 'sunny',
                'hero_description' => 'Sbor i veškeré naše aktivity jsou financovány z darů. Děkujeme za každou podporu — od pravidelných desátků po jednorázové příspěvky.',
                'meta_title' => 'Přispět — církev kolín',
                'meta_description' => 'Podpora sboru a aktivit. Bankovní spojení a možnosti darů.',
                'is_published' => true,
            ],
            [
                'slug' => 'co-delame',
                'title' => 'Co děláme',
                'hero_eyebrow' => 'Co děláme',
                'hero_title' => 'Náš týden',
                'hero_title_accent' => 'je plný setkání.',
                'hero_accent_color' => 'primary',
                'hero_description' => 'Neděle je jen začátek. Přes týden se scházíme ve skupinkách, máme programy pro děti i mládež, kávu i podnikatele.',
                'meta_title' => 'Co děláme — církev kolín',
                'meta_description' => 'Nedělní setkání, Kidztown, WyldLife, skupinky, Young Life, kavárna, business chill. Plánuj si týden s námi.',
                'is_published' => true,
            ],
            [
                'slug' => 'nedele',
                'title' => 'Neděle',
                'hero_eyebrow' => 'Neděle',
                'hero_title' => 'Nedělní',
                'hero_title_accent' => 'setkání.',
                'hero_accent_color' => 'coral',
                'hero_description' => 'Každou neděli v 10:00. Chvály, slovo, modlitby a káva.',
                'is_published' => true,
            ],
            [
                'slug' => 'akce',
                'title' => 'Akce',
                'hero_eyebrow' => 'Plán',
                'hero_title' => 'Co se',
                'hero_title_accent' => 'děje.',
                'hero_accent_color' => 'primary',
                'hero_description' => 'Nedělní setkání, dětský klub, mládež, skupinky, sborové akce. Všechno na jednom místě.',
                'meta_title' => 'Akce — církev kolín',
                'meta_description' => 'Kalendář akcí Apoštolské církve v Kolíně.',
                'is_published' => true,
            ],
            [
                'slug' => 'kazani',
                'title' => 'Kázání',
                'hero_eyebrow' => 'Poslouchej',
                'hero_title' => 'Archiv',
                'hero_title_accent' => 'kázání.',
                'hero_accent_color' => 'primary',
                'hero_description' => 'Každou neděli máme nové slovo. Můžeš si ho pustit i zpětně — kdykoliv.',
                'meta_title' => 'Kázání — církev kolín',
                'meta_description' => 'Archiv nedělních kázání. Pusť si je kdykoliv.',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
