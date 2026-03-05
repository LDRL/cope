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
        Schema::create('emprendimiento', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 50)->nullable();
            $table->string('giro_negocio')->nullable();

            $table->unsignedBigInteger('id_actividad_economica'); // foreign key a catalogo
            $table->date('fecha');
            $table->string('constituida_legalmente',3);
            $table->integer('empleado_masculino')->default(0);
            $table->integer('empleado_femenino')->default(0);
            $table->string('tiene_sucursales',3);
            $table->string('establecida_casa',3); // Establecida en su casa
            $table->string('negocio_por_internet',3); // Ha realizado negocios por internet
            $table->string('plataformas',100);
            $table->string('programa_rngg',100);
            $table->unsignedBigInteger('id_persona'); // foreign key a catalogo
            $table->unsignedBigInteger('id_servicio_financiero'); // foreign key a catalogo

            // Foreign key
            $table->foreign('id_actividad_economica')->references('id')->on('actividad_economica')->onDelete('cascade');
            $table->foreign('id_persona')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('id_servicio_financiero')->references('id')->on('servicio_financiero')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento');
    }
};
