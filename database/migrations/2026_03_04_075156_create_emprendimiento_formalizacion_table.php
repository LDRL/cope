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
        Schema::create('emprendimiento_formalizacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_emprendimiento'); // foreign key a catalogo
            $table->unsignedBigInteger('id_aspecto_formalizacion'); 

            // Foreign key
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimiento')->onDelete('cascade');
            $table->foreign('id_aspecto_formalizacion')->references('id')->on('aspecto_formalizacion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento_formalizacion');
    }
};
