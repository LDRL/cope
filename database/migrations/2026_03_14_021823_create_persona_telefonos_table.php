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
        Schema::create('persona_telefono', function (Blueprint $table) {
            $table->id();
            $table->string('numero',8);
            $table->unsignedBigInteger('id_persona'); // foreign key a catalogo
            $table->unsignedBigInteger('id_tipo_telefono'); 

            // Foreign key
            $table->foreign('id_persona')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('id_tipo_telefono')->references('id')->on('tipo_telefono')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_telefono');
    }
};
