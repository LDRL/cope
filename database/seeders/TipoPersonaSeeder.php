<?php

namespace Database\Seeders;

use App\Models\TipoPersona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Cliente',
            'Conyugue',
            'Fiador'
        ];

        foreach ($tipos as $tipo) {
            TipoPersona::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
