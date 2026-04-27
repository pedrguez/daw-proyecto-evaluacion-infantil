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

        // 2. CREAMOS LA COMPETENCIA 1
        $competencia1 = Competencia::create([
            'area_id' => $area2->id,
            'texto' => '1. Identificar las características de materiales, objetos y colecciones y establecer relaciones entre ellos, mediante la exploración, la manipulación sensorial, el manejo de herramientas sencillas y el desarrollo de destrezas lógico-matemáticas para descubrir y crear una idea cada vez más compleja del mundo.'
        ]);

        // 3. CRITERIOS DE LA COMPETENCIA 1

        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.1',
            'texto' => '1.1. Identificar y describir las cualidades o los atributos de los materiales, los objetos y las colecciones, reconociendo sus semejanzas y diferencias...',
            'rubrica_1' => 'Identifica y describe sin incorrecciones importantes las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos sin dificultades destacables.',
            'rubrica_2' => 'Identifica y describe con bastante corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con bastante facilidad.',
            'rubrica_3' => 'Identifica y describe casi siempre con corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con mucha facilidad.',
            'rubrica_4' => 'Identifica y describe con total corrección las cualidades... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con total facilidad y precisión.'
        ]);

        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.2',
            'texto' => '1.2. Emplear los cuantificadores básicos más significativos y construir el concepto de número y de cantidad, identificando el número cardinal que representa la cantidad y viceversa, y desarrollando la técnica de contar.',
            'rubrica_1' => 'Emplea los cuantificadores básicos más significativos sin incorrecciones importantes, construye el concepto de número y de cantidad sin dificultades destacables...',
            'rubrica_2' => 'Emplea los cuantificadores básicos más significativos con cierta corrección, construye el concepto de número y de cantidad con bastante facilidad...',
            'rubrica_3' => 'Emplea los cuantificadores básicos más significativos con mucha corrección, construye el concepto de número y de cantidad con mucha facilidad...',
            'rubrica_4' => 'Emplea los cuantificadores básicos más significativos con total corrección, construye el concepto de número y de cantidad con total facilidad...'
        ]);

        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.3',
            'texto' => '1.3. Identificar las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas para realizar estimaciones de medida, a través de la manipulación y experimentación con distintos materiales e instrumentos cotidianos, con la finalidad de desarrollar sus habilidades lógico-matemáticas.',
            'rubrica_1' => 'Identifica frecuentemente las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas sin dificultades destacables para realizar estimaciones de medida. Manipula y experimenta con cierta confianza y algo de seguridad, con distintos materiales e instrumentos cotidianos...',
            'rubrica_2' => 'Identifica muchas veces las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con facilidad para realizar estimaciones de medida. Manipula y experimenta generalmente con confianza y seguridad...',
            'rubrica_3' => 'Identifica casi siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con bastante facilidad para realizar estimaciones de medida. Manipula y experimenta con bastante confianza y seguridad...',
            'rubrica_4' => 'Identifica siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con total facilidad para realizar estimaciones de medida. Manipula y experimenta con mucha confianza y seguridad...'
        ]);

        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.4',
            'texto' => '1.4. Aplicar sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos, con el fin de ubicarse y orientarse adecuadamente en distintos espacios.',
            'rubrica_1' => 'Aplica a menudo sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta en ocasiones en distintos espacios.',
            'rubrica_2' => 'Aplica muchas veces sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta frecuentemente en distintos espacios.',
            'rubrica_3' => 'Aplica casi siempre sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta muchas veces en distintos espacios.',
            'rubrica_4' => 'Aplica siempre sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta siempre en distintos espacios.'
        ]);

        Criterio::create([
            'competencia_id' => $competencia1->id,
            'identificador' => '1.5',
            'texto' => '1.5. Organizar su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, tanto en las rutinas como en relación con sus juegos y experiencias cotidianas, con el fin de avanzar en la comprensión de la organización y sucesión del tiempo.',
            'rubrica_1' => 'Organiza sin incorrecciones importantes su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, en experiencias cotidianas con el fin de avanzar en la comprensión de la organización y sucesión del tiempo.',
            'rubrica_2' => 'Organiza con cierta corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, en experiencias cotidianas con el fin de avanzar en la comprensión de la organización y sucesión del tiempo.',
            'rubrica_3' => 'Organiza con mucha corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, en experiencias cotidianas con el fin de avanzar en la comprensión de la organización y sucesión del tiempo.',
            'rubrica_4' => 'Organiza con total corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, en experiencias cotidianas con el fin de avanzar en la comprensión de la organización y sucesión del tiempo.'
        ]);
    }
}
