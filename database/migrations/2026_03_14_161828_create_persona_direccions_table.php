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
        Schema::create('persona_direccion', function (Blueprint $table) {
            $table->id();
            
            $table->string('direccion',255);
            $table->string('referencia', 255)->nullable();
            $table->unsignedBigInteger('id_persona'); // foreign key a catalogo
            $table->unsignedBigInteger('id_tipo_direccion'); // foreign key a catalogo
            // Foreign key
            $table->foreign('id_persona')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('id_tipo_direccion')->references('id')->on('tipo_direccion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_direccion');
    }
};
