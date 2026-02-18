<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();

            // Datos personales
            $table->string('nombre', 40);
            $table->string('apellido', 40);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('lugar_nacimiento');

            // Catálogos (relaciones)
            $table->foreignId('nacionalidad_id')->constrained('nacionalidades');
            $table->foreignId('etnia_id')->constrained('etnias');
            $table->foreignId('estado_civil_id')->constrained('estado_civil');
            

            // Información adicional
            $table->string('numero_dpi', 13)->unique();
            $table->string('profesion_oficio', 100)->nullable();
            $table->string('ocupacion_actual', 100)->nullable();
            $table->integer('no_dependientes')->default(0);
            $table->decimal('porcentaje_de_aporte_familiar', 5, 2)->nullable();

            // Contacto
            $table->string('celular', 20)->nullable();
            $table->string('numero_telefonico_casa', 20)->nullable();
            $table->string('numero_telefonico_otro', 20)->nullable();

            // Dirección
            $table->text('direccion_domiciliar',254);
            $table->text('referencia_de_direccion', 254)->nullable();
            $table->integer('tiempo_residencia')->nullable();

            //Casa donde vive
            $table->foreignId('casa_tipo_id')->constrained('casa_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
