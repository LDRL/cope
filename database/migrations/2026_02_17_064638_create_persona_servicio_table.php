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
        Schema::create('persona_servicio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_persona')->constrained('personas')->onDelete('cascade');
            $table->foreignId('id_servicio_financiero')->constrained('servicio_financiero')->onDelete('cascade');
            $table->foreignId('id_tipo_persona')->constrained('tipo_persona')->onDelete('cascade');
            $table->timestamps(); // opcional, para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_servicio');
    }
};
