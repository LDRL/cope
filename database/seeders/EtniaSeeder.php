<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etnia;

class EtniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etnias = [
            'Maya',
            'Xinca',
            'Garífuna',
            'Ladino',
            'Otros'
        ];

        foreach ($etnias as $etnia) {
            Etnia::firstOrCreate([
                'nombre' => $etnia
            ]);
        }
    }
}
