<?php

namespace Database\Seeders;

use App\Models\TipoDireccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDireccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Domiciliar',
            'Laboral',
            'Empresarial'
        ];

        foreach ($tipos as $tipo) {
            TipoDireccion::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
