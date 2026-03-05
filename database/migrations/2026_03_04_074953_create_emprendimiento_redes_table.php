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
        Schema::create('emprendimiento_redes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_emprendimiento'); // foreign key a catalogo
            $table->unsignedBigInteger('id_redes_sociales');

            // Foreign key
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimiento')->onDelete('cascade');
            $table->foreign('id_redes_sociales')->references('id')->on('redes_sociales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento_redes');
    }
};
