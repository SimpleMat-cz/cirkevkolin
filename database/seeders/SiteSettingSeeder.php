<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Kontakt
            ['key' => 'contact.address_street', 'group' => 'contact', 'label' => 'Adresa — ulice a č.p.', 'value' => 'V Zídkách 402', 'type' => 'text', 'sort' => 1],
            ['key' => 'contact.address_city', 'group' => 'contact', 'label' => 'Adresa — město', 'value' => 'Kolín 2', 'type' => 'text', 'sort' => 2],
            ['key' => 'contact.address_zip', 'group' => 'contact', 'label' => 'Adresa — PSČ', 'value' => '280 02', 'type' => 'text', 'sort' => 3],
            ['key' => 'contact.address_note', 'group' => 'contact', 'label' => 'Adresa — poznámka', 'value' => 'Vchod z Benešovy ulice', 'type' => 'text', 'help' => 'Krátký dovětek k adrese (např. „vchod z…")', 'sort' => 4],
            ['key' => 'contact.email', 'group' => 'contact', 'label' => 'Hlavní e-mail', 'value' => 'kolin@apostolskacirkev.cz', 'type' => 'email', 'sort' => 5],
            ['key' => 'contact.bank_account', 'group' => 'contact', 'label' => 'Bankovní účet', 'value' => '435669379 / 0800 (ČS)', 'type' => 'text', 'help' => 'Pro dary a sbírku', 'sort' => 6],

            // Bohoslužby
            ['key' => 'service.weekday', 'group' => 'service', 'label' => 'Den bohoslužby', 'value' => 'Neděle', 'type' => 'text', 'sort' => 1],
            ['key' => 'service.time_start', 'group' => 'service', 'label' => 'Začátek bohoslužby', 'value' => '10:00', 'type' => 'text', 'sort' => 2],
            ['key' => 'service.time_end', 'group' => 'service', 'label' => 'Konec bohoslužby (přibližný)', 'value' => '11:30', 'type' => 'text', 'sort' => 3],
            ['key' => 'service.coffee_from', 'group' => 'service', 'label' => 'Kavárna otevřena od', 'value' => '9:30', 'type' => 'text', 'sort' => 4],

            // Sociální sítě
            ['key' => 'social.facebook', 'group' => 'social', 'label' => 'Facebook URL', 'value' => 'https://www.facebook.com/cirkevkolin', 'type' => 'url', 'sort' => 1],
            ['key' => 'social.instagram', 'group' => 'social', 'label' => 'Instagram URL', 'value' => 'https://www.instagram.com/cirkevkolin', 'type' => 'url', 'sort' => 2],
            ['key' => 'social.youtube', 'group' => 'social', 'label' => 'YouTube URL', 'value' => 'https://www.youtube.com/channel/UCnsKOpdlWx4wS0mos_PXfDg', 'type' => 'url', 'sort' => 3],

            // Meta / obecné
            ['key' => 'meta.site_tagline', 'group' => 'meta', 'label' => 'Tagline (slogan webu)', 'value' => 'jako doma', 'type' => 'text', 'help' => 'Krátká věta v meta titulku', 'sort' => 1],
            ['key' => 'meta.default_description', 'group' => 'meta', 'label' => 'Výchozí meta popis', 'value' => 'Apoštolská církev Kolín. Neděle v 10:00, V Zídkách 402. Otevřená komunita, kde se cítíš jako doma — ať jsi tu poprvé nebo odjakživa.', 'type' => 'textarea', 'sort' => 2],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
