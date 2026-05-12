<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Co mě čeká, když přijdu?',
                'answer' => 'Chvíle uctívání hudbou (~30 min), kázání (~40 min) a neformální čas po s kávou. Žádné divné rituály, žádný nátlak. Lidé jsou oblečeni běžně — džíny jsou OK.',
                'sort' => 1,
            ],
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Co si mám vzít s sebou?',
                'answer' => 'Nic zvláštního. Sami sebe. Pokud máte Bibli a chcete ji přinést, super — ale není to nutné. Bible jsou k dispozici i u nás.',
                'sort' => 2,
            ],
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Co bude s mými dětmi?',
                'answer' => 'V neděli během setkání mají děti vlastní program (Kidztown). Malé batolata mohou být s vámi nebo v dětském koutku. Předem nemusíte nic registrovat.',
                'sort' => 3,
            ],
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Budu muset něco dělat nebo říkat?',
                'answer' => 'Vůbec ne. Přijďte, posaďte se, poslouchejte. Nikdo vás nebude nutit vstávat, zpívat, mluvit ani nic podepisovat. Jste hosté.',
                'sort' => 4,
            ],
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Co jste za lidi?',
                'answer' => 'Jsme parta různých lidí — mladí, starší, rodiny, singles, lidé hledající, lidé věřící. Nedělíme lidi na věřící a nevěřící. Přijde každý, kdo chce.',
                'sort' => 5,
            ],
            [
                'page_slug' => 'jsem-tu-poprve',
                'question' => 'Kde zaparkuji?',
                'answer' => 'Parking je dostupný na ulici Benešova (modrá zóna — neděle je zdarma). Vstup do budovy je z Benešovy ulice, ne ze Z Zídkách.',
                'sort' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['page_slug' => $faq['page_slug'], 'question' => $faq['question']],
                $faq,
            );
        }
    }
}
