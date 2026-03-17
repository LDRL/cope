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

            $table->unsignedBigInteger('id_oficina'); // foreign key a catalogo oficinas
            $table->decimal('monto', 15, 2)->default(0);
            $table->integer('plazo')->default(0);
            $table->integer('tasa')->default(0);

            $table->unsignedBigInteger('id_destino');
            $table->string('periodo_gracia', 3)->nullable();

            $table->unsignedBigInteger('id_tipo_servicio');
            $table->unsignedBigInteger('id_producto');
            $table->string('estado',30);

            // Foreign key (si tienes tabla oficinas)
            $table->foreign('id_oficina')->references('id')->on('oficinas')->onDelete('cascade');
            $table->foreign('id_destino')->references('id')->on('destinos')->onDelete('cascade');
            $table->foreign('id_tipo_servicio')->references('id')->on('tipo_servicios')->onDelete('cascade');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
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
