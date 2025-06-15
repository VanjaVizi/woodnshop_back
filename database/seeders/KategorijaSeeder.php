<?php

namespace Database\Seeders;

use App\Models\Kategorija;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategorijaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $kategorije = [
        [
            'slug' => 'daske-tacne',
            'naziv' => 'Daske i tacne',
            'opis' => 'Izrađujemo daske i tacne od punog drveta i epoxy smole, idealne za posluženje.'
        ],
        [
            'slug' => 'klub-stolovi',
            'naziv' => 'Klub stolovi',
            'opis' => 'Unikatni klub stolovi sa prirodnim godovima i epoxy završnicom.'
        ],
        [
            'slug' => 'ikone',
            'naziv' => 'Ikone',
            'opis' => 'CNC gravirane ikone po porudžbini – ručni završni detalji po vašim željama.'
        ],
        [
            'slug' => 'satovi',
            'naziv' => 'Satovi',
            'opis' => 'Zidni i stoni satovi od prirodnog drveta u kombinaciji sa smolom.'
        ],
        [
            'slug' => 'ukrasi',
            'naziv' => 'Ukrasi',
            'opis' => 'Ručno rađeni drveni ukrasi za dom, praznike i poklone.'
        ],
        [
            'slug' => 'ostalo',
            'naziv' => 'Ostalo',
            'opis' => 'Ostali proizvodi iz naše radionice koji ne spadaju u glavne kategorije.'
        ]
    ];

    foreach ($kategorije as $kategorija) {
        Kategorija::create($kategorija);
    }
    }
}
