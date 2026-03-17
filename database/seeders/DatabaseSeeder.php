<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            DestinoSeeder::class,    
            EstadoCivilSeeder::class,
            EtniaSeeder::class,
            NacionalidadSeeder::class,
            OficinaSeeder::class,
            ProductoSeeder::class,
            TipoServicioSeeder::class,
            UserSeeder::class,
            CasaTipoSeeder::class,
            ActividadEconomicaSeeder::class,
            AspectoFormalizacionSeeder::class,
            RedesSocialesSeeder::class,
            TipoPersonaSeeder::class,
            TipoTelefonoSeeder::class,
            TipoDireccionSeeder::class
        ]);
    }
}
