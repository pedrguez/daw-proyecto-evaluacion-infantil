<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Competencia;
use App\Models\Criterio;

class RubricasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREAMOS EL ÁREA
        $area2 = Area::create([
            'nombre' => 'Área 2. Descubrimiento y Exploración del Entorno'
        ]);

        // 2. CREAMOS LA COMPETENCIA (y la atamos al Área 2)
        $competencia1 = Competencia::create([
            'area_id' => $area2->id,
            'texto' => '1. Identificar las características de materiales, objetos y colecciones y establecer relaciones entre ellos, mediante la exploración, la manipulación sensorial, el manejo de herramientas sencillas y el desarrollo de destrezas lógico-matemáticas para descubrir y crear una idea cada vez más compleja del mundo.'
        ]);

        // 3. CREAMOS LOS CRITERIOS (y los atamos a la Competencia 1)

        // Criterio 1.1
        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.1',
            'texto' => '1.1. Identificar y describir las cualidades o los atributos de los materiales, los objetos y las colecciones, reconociendo sus semejanzas y diferencias...',
            'rubrica_1' => 'Identifica y describe sin incorrecciones importantes las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos sin dificultades destacables.',
            'rubrica_2' => 'Identifica y describe con bastante corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con bastante facilidad.',
            'rubrica_3' => 'Identifica y describe casi siempre con corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con mucha facilidad.',
            'rubrica_4' => 'Identifica y describe con total corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con total facilidad y precisión.'
        ]);

        // Criterio 1.2
        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.2',
            'texto' => '1.2. Emplear los cuantificadores básicos más significativos y construir el concepto de número y de cantidad, identificando el número cardinal que representa la cantidad y viceversa, y desarrollando la técnica de contar.',
            'rubrica_1' => 'Emplea los cuantificadores básicos más significativos sin incorrecciones importantes, construye el concepto de número y de cantidad sin dificultades destacables...',
            'rubrica_2' => 'Emplea los cuantificadores básicos más significativos con cierta corrección, construye el concepto de número y de cantidad con bastante facilidad...',
            'rubrica_3' => 'Emplea los cuantificadores básicos más significativos con mucha corrección, construye el concepto de número y de cantidad con mucha facilidad...',
            'rubrica_4' => 'Emplea los cuantificadores básicos más significativos con total corrección, construye el concepto de número y de cantidad con total facilidad...'
        ]);

        // Aquí es donde en el futuro copiaremos y pegaremos el resto de criterios (1.3, 1.4, etc.)
    }
}
