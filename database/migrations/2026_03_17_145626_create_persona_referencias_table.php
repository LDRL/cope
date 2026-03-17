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
        Schema::create('persona_referencia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('numero_telefono', 8);
            $table->string('tipo_relacion', 50);

            $table->foreignId('id_persona')->constrained('personas')->onDelete('cascade');
            $table->foreignId('id_tipo_referencia')->constrained('tipo_referencia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_referencia');
    }
};
