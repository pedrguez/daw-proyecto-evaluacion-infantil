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
        Schema::create('criterios', function (Blueprint $table) {
            $table->id();
            // Relación con la competencia
            $table->foreignId('competencia_id')->constrained()->onDelete('cascade');

            $table->string('identificador'); // Identificador del criterio (1.1, 1.2...)
            // el texto del criterio
            $table->text('texto');

            // los textos de la rúbrica
            $table->text('rubrica_1')->nullable(); // Poco Adecuado
            $table->text('rubrica_2')->nullable(); // Adecuado
            $table->text('rubrica_3')->nullable(); // Muy Adecuado
            $table->text('rubrica_4')->nullable(); // Excelente

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterios');
    }
};
