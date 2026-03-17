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
            $table->foreignId('id_nacionalidad')->nullable()->constrained('nacionalidades');
            $table->foreignId('id_etnia')->nullable()->constrained('etnias');
            $table->foreignId('id_estado_civil')->nullable()->constrained('estado_civil');
            

            // Información adicional
            $table->string('numero_dpi', 13)->unique();
            $table->string('profesion_oficio', 100)->nullable();
            $table->string('ocupacion_actual', 100)->nullable();
            $table->integer('no_dependientes')->default(0);
            $table->decimal('porcentaje_de_aporte_familiar', 5, 2)->nullable();

            $table->string('lugar_trabajo', 100)->nullable();
            $table->string('nombre_cargo', 100)->nullable();
            $table->integer('ingreso_neto')->default(0);       
            $table->integer('tiempo_residencia')->nullable();

            //Casa donde vive
            $table->foreignId('id_casa_tipo')->constrained('casa_tipo');
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
