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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();

            // 1. ¿De quién es la nota? (Relación con alumno)
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');

            // 2. ¿Qué criterio estamos evaluando? (Relación con criterio)
            $table->foreignId('criterio_id')->constrained('criterios')->onDelete('cascade');

            // 3. ¿En qué trimestre estamos? (1, 2 o 3)
            $table->integer('trimestre');

            // 4. La nota numérica real (1, 2, 3 o 4)
            $table->integer('valor');

            $table->timestamps();

            // REGLA DE ORO: Un alumno no puede tener dos notas distintas para el mismo criterio en el mismo trimestre.
            $table->unique(['alumno_id', 'criterio_id', 'trimestre']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
