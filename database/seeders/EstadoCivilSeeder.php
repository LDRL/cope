<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoCivil;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Casado(A)',
            'Soltero(A)',
            'Unido(A)',
            'Separado(A)',
            'Divorciado(A)',
        ];

        foreach ($estados as $estado) {
            EstadoCivil::firstOrCreate([
                'nombre' => $estado
            ]);
        }
    }
}
