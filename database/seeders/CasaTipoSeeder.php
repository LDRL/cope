<?php

namespace Database\Seeders;

use App\Models\CasaTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CasaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Propia',
            'Alquilada',
            'Familiar'
        ];

        foreach ($tipos as $tipo) {
            CasaTipo::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
