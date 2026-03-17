<?php

namespace Database\Seeders;

use App\Models\TipoTelefono;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoTelefonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Movil',
            'Residencial'
        ];

        foreach ($tipos as $tipo) {
            TipoTelefono::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
