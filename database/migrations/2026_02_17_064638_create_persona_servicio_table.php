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

            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('servicio_financiero_id')->constrained('servicio_financiero')->onDelete('cascade');
            $table->timestamps(); // opcional, para created_at y updated_at
            $table->unique(['persona_id', 'servicio_financiero_id']);
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
