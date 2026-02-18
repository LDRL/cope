<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            'Nuevo',
            'Subsiguiente',
            'Ampliación',
            'Novación',
            'Reubicación'
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate([
                'nombre' => $producto
            ]);
        }
    }
}
