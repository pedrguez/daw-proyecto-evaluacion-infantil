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
        Schema::table('alumnos', function (Blueprint $table) {
            // Añadimos los campos. Le ponemos nullable() por si algún alumno aún no tiene estos datos.
            $table->string('correo_familiar')->nullable()->after('curso');
            $table->text('notas_tutoria')->nullable()->after('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn(['correo_familiar', 'notas_tutoria']);
        });
    }
};
