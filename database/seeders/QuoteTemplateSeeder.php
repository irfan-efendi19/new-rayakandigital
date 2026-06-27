<?php

namespace Database\Seeders;

use App\Models\QuoteTemplate;
use Illuminate\Database\Seeder;

class QuoteTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'label' => 'Ar-Rum 21',
                'content' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan-pasangan dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang. Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berpikir.',
                'source' => 'QS. Ar-Rum: 21',
                'sort_order' => 1,
            ],
            [
                'label' => 'Doa Pernikahan',
                'content' => 'Semoga Allah memberkahimu pada waktu bahagia dan memberkahimu pada waktu susah, serta semoga Allah mempersatukan kamu berdua dalam kebaikan.',
                'source' => 'Doa Pernikahan Islam',
                'sort_order' => 2,
            ],
            [
                'label' => 'Barakallah',
                'content' => "Barakallahu laka wa baraka 'alaika wa jama'a bainakuma fi khair.",
                'source' => 'Doa Pernikahan',
                'sort_order' => 3,
            ],
            [
                'label' => 'HR. Abu Daud',
                'content' => 'Sebaik-baik pernikahan adalah yang paling mudah.',
                'source' => 'HR. Abu Daud',
                'sort_order' => 4,
            ],
            [
                'label' => 'An-Nur 32',
                'content' => 'Dan kawinkanlah orang-orang yang sendirian di antara kamu, dan orang-orang yang layak (menikah) dari hamba-hamba sahayamu yang lelaki dan hamba-hamba sahayamu yang perempuan. Jika mereka miskin, Allah akan memberi kemampuan kepada mereka dengan karunia-Nya. Dan Allah Maha Luas (pemberian-Nya) lagi Maha Mengetahui.',
                'source' => 'QS. An-Nur: 32',
                'sort_order' => 5,
            ],
            [
                'label' => 'Al-Mumtahanah 10',
                'content' => "Sesungguhnya aku menikahi engkau dengan mas kawin yang telah aku berikan.",
                'source' => 'QS. Al-Mumtahanah: 10',
                'sort_order' => 6,
            ],
            [
                'label' => 'Kutipan Romantis',
                'content' => 'Cinta adalah ketika kamu bertemu seseorang yang mengubah hidupmu, tanpa sadar dan tanpa diminta.',
                'source' => 'Kutipan Romantis',
                'sort_order' => 7,
            ],
        ];

        foreach ($templates as $template) {
            QuoteTemplate::create($template);
        }
    }
}
