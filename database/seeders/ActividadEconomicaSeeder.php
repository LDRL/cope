<?php

namespace Database\Seeders;

use App\Models\ActividadEconomica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActividadEconomicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Comercial',
            'Servicios',
            'Industria',
            'Agricultura',
            'Artesania'
        ];

        foreach ($tipos as $tipo) {
            ActividadEconomica::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
