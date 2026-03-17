<?php

namespace Database\Seeders;

use App\Models\TipoReferencia;
use Illuminate\Database\Seeder;

class TipoReferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'personal',
            'comercial'
        ];

        foreach ($tipos as $tipo) {
            TipoReferencia::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
