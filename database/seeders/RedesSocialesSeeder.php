<?php

namespace Database\Seeders;

use App\Models\RedesSociales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RedesSocialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Facebook',
            'Instagram',
            'Twitter',
            'TitkTok',
            'WhatsApp'
        ];

        foreach ($tipos as $tipo) {
            RedesSociales::firstOrCreate([
                'nombre' => $tipo
            ]);
        }
    }
}
