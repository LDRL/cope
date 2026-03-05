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
        Schema::create('servicio_financiero', function (Blueprint $table) {
            $table->id();
            $table->string('no_beneficiario', 50)->nullable();
            $table->string('no_servicio', 50)->nullable();
            $table->date('fecha_solicitud')->nullable();

            $table->unsignedBigInteger('oficina_id'); // foreign key a catalogo oficinas
            $table->decimal('monto', 15, 2)->default(0);
            $table->integer('plazo')->default(0);
            $table->integer('tasa')->default(0);

            $table->unsignedBigInteger('destino_id');
            $table->string('periodo_gracia', 3)->nullable();

            $table->unsignedBigInteger('tipo_servicio_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('estado',30);
            //$table->unsignedBigInteger('persona_id')->nullable();

            // Foreign key (si tienes tabla oficinas)
            $table->foreign('oficina_id')->references('id')->on('oficinas')->onDelete('cascade');
            $table->foreign('destino_id')->references('id')->on('destinos')->onDelete('cascade');
            $table->foreign('tipo_servicio_id')->references('id')->on('tipo_servicios')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            //$table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_financiero');
    }
};
