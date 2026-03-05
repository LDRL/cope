<?php

namespace Database\Seeders;

use App\Models\AspectoFormalizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspectoFormalizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Plan De Mercadeo',
            'CV Empresarial',
            'Patente De Comercio',
            'Estados Financieros',
            'Nit'
        ];

        foreach ($tipos as $tipo) {
            AspectoFormalizacion::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
