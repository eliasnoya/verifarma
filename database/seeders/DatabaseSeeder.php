<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Context\Pharmacy\Application\CreatePharmacyService;
use Src\Context\Pharmacy\Infrastructure\Repositories\DbPharmacyRespository;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Parque Patricios Pharmacies examples elias nearby
        // Farmaplus || Av. Caseros 2827 || -34.6378606,-58.4020155
        // La Santé || Av. Caseros 2657 || -34.6362615,-58.4093998

        // Belgrano Pharmacies examples elias faraway
        // Farmaplus || Echeverría 3187 || -34.5672378,-58.4658993
        // La Santé || Av. Elcano 3380 || -34.5675846,-58.4792472

        $creator = new CreatePharmacyService(new DbPharmacyRespository());

        $creator->execute("Farmaplus", [
            [
                'address' => 'Av. Caseros 2827',
                'latitude' => -34.6378606,
                'longitude' => -58.4020155,
            ],
            [
                'address' => 'Echeverría 3187',
                'latitude' => -34.5672378,
                'longitude' => -58.4658993,
            ]
        ]);

        $creator->execute("La Santé", [
            [
                'address' => 'Av. Caseros 2657',
                'latitude' => -34.6362615,
                'longitude' => -58.4093998,
            ],
            [
                'address' => 'Av. Elcano 3380',
                'latitude' => -34.5675846,
                'longitude' => -58.4792472,
            ]
        ]);
    }
}
