<?php

namespace Database\Seeders;

use App\Models\TipoServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Emprendimiento',
            'MYPE'
        ];

        foreach ($tipos as $tipo) {
            TipoServicio::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
