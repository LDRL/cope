<?php

namespace Database\Seeders;

use App\Models\Destino;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinos = [
            'Capital de trabajo',
            'Activo fijo',
            'Desarollo del emprendimiento'
        ];

        foreach ($destinos as $destino) {
            Destino::firstOrCreate([
                'nombre' => $destino
            ]);
        }
    }
}
