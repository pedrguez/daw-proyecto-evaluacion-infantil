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

        // ÁREA 1: CRECIMIENTO EN ARMONÍA

        $area1 = Area::updateOrCreate(['nombre' => 'Área 1. Crecimiento en Armonía']);

        // COMPETENCIA 1
        $comp1_A1 = Competencia::updateOrCreate([
            'area_id' => $area1->id,
            'texto' => '1. Progresar en el conocimiento y control de su cuerpo y en la adquisición de distintas estrategias, adecuando sus acciones a la realidad del entorno de una manera segura.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A1->id, 'identificador' => '1.1'], [
            'texto' => '1.1. Reconocer las características y partes de su cuerpo, de manera global y segmentada, percibiendo sus cambios, así como sus posibilidades de acción...',
            'rubrica_1' => 'Reconoce con dudas importantes las características y partes de su cuerpo... Avanza con cierta confianza y seguridad en el control dinámico.',
            'rubrica_2' => 'Reconoce con claridad las características y partes de su cuerpo... Avanza generalmente con confianza y seguridad en el control dinámico.',
            'rubrica_3' => 'Reconoce con bastante claridad las características y partes de su cuerpo... Avanza con bastante confianza y seguridad en el control dinámico.',
            'rubrica_4' => 'Reconoce con total claridad las características y partes de su cuerpo... Avanza con mucha confianza y seguridad en el control dinámico.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A1->id, 'identificador' => '1.2'], [
            'texto' => '1.2. Progresar en la integración sensorial del mundo a través de la aplicación de distintas estrategias que le permitan reconocer los sentidos y sus funciones...',
            'rubrica_1' => 'Progresa sin dificultades destacables en la integración sensorial del mundo... Actúa con cierta confianza y seguridad.',
            'rubrica_2' => 'Progresa con cierta facilidad en la integración sensorial del mundo... Actúa generalmente con confianza y seguridad.',
            'rubrica_3' => 'Progresa con bastante facilidad en la integración sensorial del mundo... Actúa con bastante confianza y seguridad.',
            'rubrica_4' => 'Progresa con mucha facilidad en la integración sensorial del mundo... Actúa con mucha confianza y seguridad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A1->id, 'identificador' => '1.3'], [
            'texto' => '1.3. Participar en contextos de juego dirigido y espontáneo, ajustándose a sus posibilidades personales, demostrando control de su cuerpo...',
            'rubrica_1' => 'Participa de manera casi autónoma en contextos de juego dirigido y espontáneo... Demuestra sin dificultades destacables control de su cuerpo.',
            'rubrica_2' => 'Participa con bastante autonomía en contextos de juego dirigido... Demuestra con cierta facilidad control de su cuerpo.',
            'rubrica_3' => 'Participa con mucha autonomía en contextos de juego dirigido... Demuestra con bastante facilidad control de su cuerpo.',
            'rubrica_4' => 'Participa de manera totalmente autónoma en contextos de juego dirigido... Demuestra con mucha facilidad control de su cuerpo.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A1->id, 'identificador' => '1.4'], [
            'texto' => '1.4. Manejar diferentes objetos, útiles y herramientas, en situaciones de juego y en la realización de tareas cotidianas...',
            'rubrica_1' => 'Maneja sin dificultades destacables diferentes objetos, útiles y herramientas... Muestra frecuentemente control y coordinación.',
            'rubrica_2' => 'Maneja con facilidad diferentes objetos, útiles y herramientas... Muestra muchas veces control y coordinación.',
            'rubrica_3' => 'Maneja con bastante facilidad diferentes objetos, útiles y herramientas... Muestra casi siempre control y coordinación.',
            'rubrica_4' => 'Maneja con mucha facilidad diferentes objetos, útiles y herramientas... Muestra siempre control y coordinación.'
        ]);

        // COMPETENCIA 2
        $comp2_A1 = Competencia::updateOrCreate([
            'area_id' => $area1->id,
            'texto' => '2. Reconocer, manifestar y regular progresivamente sus emociones, expresando necesidades y sentimientos para lograr bienestar emocional y seguridad en sí mismo.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A1->id, 'identificador' => '2.1'], [
            'texto' => '2.1. Identificar y expresar sus necesidades, sentimientos, vivencias, preferencias e intereses, en distintos momentos...',
            'rubrica_1' => 'Identifica y expresa sin gran dificultad sus necesidades, vivencias, preferencias e intereses.',
            'rubrica_2' => 'Identifica y expresa generalmente con facilidad sus necesidades, vivencias, preferencias e intereses.',
            'rubrica_3' => 'Identifica y expresa con bastante facilidad sus necesidades, vivencias, preferencias e intereses.',
            'rubrica_4' => 'Identifica y expresa con mucha facilidad sus necesidades, vivencias, preferencias e intereses.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A1->id, 'identificador' => '2.2'], [
            'texto' => '2.2. Ofrecer y pedir ayuda, en situaciones de juego, tareas y actividades, reconociendo sus propias posibilidades...',
            'rubrica_1' => 'A menudo ofrece y pide ayuda. Reconoce de manera casi autónoma sus propias posibilidades.',
            'rubrica_2' => 'Muchas veces ofrece y pide ayuda. Reconoce con bastante autonomía sus propias posibilidades.',
            'rubrica_3' => 'Casi siempre ofrece y pide ayuda. Reconoce con mucha autonomía sus propias posibilidades.',
            'rubrica_4' => 'Siempre ofrece y pide ayuda. Reconoce de manera totalmente autónoma sus propias posibilidades.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A1->id, 'identificador' => '2.3'], [
            'texto' => '2.3. Identificar sus posibilidades de acción para la ejecución de tareas propuestas, aceptando con actitud positiva las críticas...',
            'rubrica_1' => 'Identifica sin dificultades destacables sus posibilidades... A menudo acepta con actitud positiva las críticas.',
            'rubrica_2' => 'Identifica con facilidad sus posibilidades... Muchas veces acepta con actitud positiva las críticas.',
            'rubrica_3' => 'Identifica con bastante facilidad sus posibilidades... Casi siempre acepta con actitud positiva las críticas.',
            'rubrica_4' => 'Identifica con mucha facilidad sus posibilidades... Siempre acepta con actitud positiva las críticas.'
        ]);

        // COMPETENCIA 3
        $comp3_A1 = Competencia::updateOrCreate([
            'area_id' => $area1->id,
            'texto' => '3. Adoptar modelos, normas y hábitos, desarrollando la confianza en sus posibilidades y sentimientos de logro, para promover un estilo de vida saludable y ecosocialmente responsable.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A1->id, 'identificador' => '3.1'], [
            'texto' => '3.1. Participar, con interés y disfrute, en actividades relacionadas con el autocuidado y el cuidado del entorno...',
            'rubrica_1' => 'Participa, generalmente con interés y disfrute, en actividades relacionadas con el autocuidado... Desarrolla sin gran dificultad una actitud respetuosa.',
            'rubrica_2' => 'Participa, mostrando bastante interés y disfrute... Desarrolla generalmente con facilidad una actitud respetuosa.',
            'rubrica_3' => 'Participa, con mucho interés y disfrute... Desarrolla con bastante facilidad una actitud respetuosa.',
            'rubrica_4' => 'Participa, con total interés, motivación y disfrute... Desarrolla con mucha facilidad una actitud respetuosa.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A1->id, 'identificador' => '3.2'], [
            'texto' => '3.2. Respetar la secuencia temporal -mostrando capacidad de anticipación a los acontecimientos y de adaptación a las rutinas...',
            'rubrica_1' => 'Respeta de manera casi autónoma la secuencia temporal... Frecuentemente desarrolla comportamientos respetuosos.',
            'rubrica_2' => 'Respeta con bastante autonomía la secuencia temporal... Muchas veces desarrolla comportamientos respetuosos.',
            'rubrica_3' => 'Respeta con mucha autonomía la secuencia temporal... Casi siempre desarrolla comportamientos respetuosos.',
            'rubrica_4' => 'Respeta de forma totalmente autónoma la secuencia temporal... Siempre desarrolla comportamientos respetuosos.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A1->id, 'identificador' => '3.3'], [
            'texto' => '3.3. Mostrar autonomía en las actividades de cuidado e higiene personal, manifestando interés en su presentación personal...',
            'rubrica_1' => 'Muestra frecuentemente autonomía en las actividades de cuidado e higiene personal... Manifiesta algo de interés.',
            'rubrica_2' => 'Muestra muchas veces autonomía en las actividades de cuidado e higiene personal... Manifiesta bastante interés.',
            'rubrica_3' => 'Muestra casi siempre autonomía en las actividades de cuidado e higiene personal... Manifiesta mucho interés.',
            'rubrica_4' => 'Muestra siempre autonomía en las actividades de cuidado e higiene personal... Manifiesta mucho interés y dedicación.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A1->id, 'identificador' => '3.4'], [
            'texto' => '3.4. Participar en el desarrollo de actividades físicas estructuradas, con diferentes grados de intensidad...',
            'rubrica_1' => 'Participa de manera casi autónoma en el desarrollo de actividades físicas... Manifiesta algo de interés y disfrute.',
            'rubrica_2' => 'Participa con bastante autonomía en el desarrollo de actividades físicas... Manifiesta generalmente interés y disfrute.',
            'rubrica_3' => 'Participa con mucha autonomía en el desarrollo de actividades físicas... Manifiesta bastante interés y disfrute.',
            'rubrica_4' => 'Participa de manera totalmente autónoma en el desarrollo de actividades físicas... Manifiesta total interés y disfrute.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A1->id, 'identificador' => '3.5'], [
            'texto' => '3.5. Implementar iniciativas de prevención de riesgos, en situaciones cotidianas, a través de la identificación de situaciones de peligro...',
            'rubrica_1' => 'Implementa sin gran dificultad iniciativas de prevención de riesgos, en situaciones cotidianas.',
            'rubrica_2' => 'Implementa generalmente con facilidad iniciativas de prevención de riesgos, en situaciones cotidianas.',
            'rubrica_3' => 'Implementa con bastante facilidad iniciativas de prevención de riesgos, en situaciones cotidianas.',
            'rubrica_4' => 'Implementa con mucha facilidad iniciativas de prevención de riesgos, en situaciones cotidianas.'
        ]);

        // COMPETENCIA 4 (Área 1)
        $comp4_A1 = Competencia::updateOrCreate([
            'area_id' => $area1->id,
            'texto' => '4. Establecer interacciones sociales en condiciones de igualdad, valorando la importancia de la amistad, el respeto y la empatía, para construir su propia identidad basada en valores democráticos y de respeto a los derechos humanos.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.1'], [
            'texto' => '4.1. Establecer relaciones armoniosas con las demás personas y con el mundo, creando lazos de amistad, como instrumento de prevención de la violencia y de desarrollo de la cultura de paz...',
            'rubrica_1' => 'Establece frecuentemente relaciones armoniosas con las demás personas... Crea sin dificultades destacables lazos de amistad.',
            'rubrica_2' => 'Establece muchas veces relaciones armoniosas con las demás personas... Crea con facilidad lazos de amistad.',
            'rubrica_3' => 'Establece casi siempre relaciones armoniosas con las demás personas... Crea con bastante facilidad lazos de amistad.',
            'rubrica_4' => 'Establece siempre relaciones armoniosas con las demás personas... Crea con mucha facilidad lazos de amistad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.2'], [
            'texto' => '4.2. Demostrar actitudes de afecto y de empatía, en situaciones de relación con otras personas, juegos y actividades colectivas, con la finalidad de avanzar en el desarrollo de actitudes de respeto...',
            'rubrica_1' => 'A menudo demuestra actitudes de afecto y de empatía... Desarrolla de manera casi autónoma actitudes de respeto hacia los ritmos individuales.',
            'rubrica_2' => 'Muchas veces demuestra actitudes de afecto y de empatía... Desarrolla con bastante autonomía actitudes de respeto hacia los ritmos individuales.',
            'rubrica_3' => 'Casi siempre demuestra actitudes de afecto y de empatía... Desarrolla con mucha autonomía actitudes de respeto hacia los ritmos individuales.',
            'rubrica_4' => 'Siempre demuestra actitudes de afecto y de empatía... Desarrolla de manera totalmente autónoma actitudes de respeto hacia los ritmos individuales.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.3'], [
            'texto' => '4.3. Identificar pautas básicas de convivencia e interiorizar, de manera natural y progresiva, modelos adecuados de relación social, participando activamente en propuestas...',
            'rubrica_1' => 'Identifica sin imprecisiones importantes pautas básicas de convivencia. Interioriza sin dificultades destacables modelos adecuados de relación.',
            'rubrica_2' => 'Identifica con bastante precisión pautas básicas de convivencia. Interioriza con cierta facilidad modelos adecuados de relación.',
            'rubrica_3' => 'Identifica generalmente con precisión pautas básicas de convivencia. Interioriza con bastante facilidad modelos adecuados de relación.',
            'rubrica_4' => 'Identifica con total precisión pautas básicas de convivencia. Interioriza con mucha facilidad modelos adecuados de relación.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.4'], [
            'texto' => '4.4. Reproducir conductas, acciones o situaciones a través del juego simbólico en interacción con sus iguales, identificando y rechazando todo tipo de estereotipos.',
            'rubrica_1' => 'Reproduce con algo de fluidez conductas, acciones o situaciones a través del juego simbólico... identificando y rechazando todo tipo de estereotipos.',
            'rubrica_2' => 'Reproduce generalmente con fluidez conductas, acciones o situaciones a través del juego simbólico... identificando y rechazando estereotipos.',
            'rubrica_3' => 'Reproduce con bastante fluidez conductas, acciones o situaciones a través del juego simbólico... identificando y rechazando estereotipos.',
            'rubrica_4' => 'Reproduce con mucha fluidez conductas, acciones o situaciones a través del juego simbólico... identificando y rechazando estereotipos.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.5'], [
            'texto' => '4.5. Participar, de manera activa, en actividades relacionadas con costumbres y tradiciones de la propia cultura así como de otras presentes en su entorno...',
            'rubrica_1' => 'Participa frecuentemente, de manera activa, en actividades relacionadas con costumbres... Demuestra algo de respeto e interés por el conocimiento del patrimonio.',
            'rubrica_2' => 'Participa muchas veces, de manera activa, en actividades relacionadas con costumbres... Demuestra bastante respeto e interés por el conocimiento del patrimonio.',
            'rubrica_3' => 'Participa casi siempre, de manera activa, en actividades relacionadas con costumbres... Demuestra mucho respeto e interés por el conocimiento del patrimonio.',
            'rubrica_4' => 'Participa siempre, de manera activa, en actividades relacionadas con costumbres... Demuestra mucho respeto, interés y dedicación por el conocimiento del patrimonio.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A1->id, 'identificador' => '4.6'], [
            'texto' => '4.6. Progresar en la construcción de una autoimagen positiva y ajustada, a partir del reconocimiento de las cualidades personales y la identificación de las diferencias...',
            'rubrica_1' => 'Progresa de manera casi autónoma en la construcción de una autoimagen positiva y ajustada. Reconoce sin dudas importantes las cualidades personales.',
            'rubrica_2' => 'Progresa con bastante autonomía en la construcción de una autoimagen positiva y ajustada. Reconoce con cierta claridad las cualidades personales.',
            'rubrica_3' => 'Progresa con mucha autonomía en la construcción de una autoimagen positiva y ajustada. Reconoce con bastante claridad las cualidades personales.',
            'rubrica_4' => 'Progresa de manera totalmente autónoma en la construcción de una autoimagen positiva y ajustada. Reconoce con total claridad las cualidades personales.'
        ]);


        // ÁREA 2: DESCUBRIMIENTO DEL ENTORNO

        $area2 = Area::updateOrCreate(['nombre' => 'Área 2. Descubrimiento y Exploración del Entorno']);

        // COMPETENCIA 1 (Área 2)
        $comp1_A2 = Competencia::updateOrCreate([
            'area_id' => $area2->id,
            'texto' => '1. Identificar las características de materiales, objetos y colecciones y establecer relaciones entre ellos, mediante la exploración, la manipulación sensorial y el manejo de herramientas sencillas para descubrir y crear una idea cada vez más compleja del mundo.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A2->id, 'identificador' => '1.1'], [
            'texto' => '1.1. Identificar y describir las cualidades o los atributos de los materiales, los objetos y las colecciones, reconociendo sus semejanzas y diferencias...',
            'rubrica_1' => 'Identifica y describe sin incorrecciones importantes las cualidades... reconoce habitualmente y con claridad sus semejanzas y diferencias.',
            'rubrica_2' => 'Identifica y describe con bastante corrección las cualidades... reconoce con bastante claridad sus semejanzas y diferencias.',
            'rubrica_3' => 'Identifica y describe casi siempre con corrección las cualidades... reconoce con mucha claridad sus semejanzas y diferencias.',
            'rubrica_4' => 'Identifica y describe con total corrección las cualidades... reconoce con total claridad sus semejanzas y diferencias.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A2->id, 'identificador' => '1.2'], [
            'texto' => '1.2. Emplear los cuantificadores básicos más significativos y construir el concepto de número y de cantidad, identificando el número cardinal que representa...',
            'rubrica_1' => 'Emplea los cuantificadores básicos más significativos sin incorrecciones importantes, construye el concepto de número y de cantidad sin dificultades destacables.',
            'rubrica_2' => 'Emplea los cuantificadores básicos más significativos con cierta corrección, construye el concepto de número y de cantidad con bastante facilidad.',
            'rubrica_3' => 'Emplea los cuantificadores básicos más significativos con mucha corrección, construye el concepto de número y de cantidad con mucha facilidad.',
            'rubrica_4' => 'Emplea los cuantificadores básicos más significativos con total corrección, construye el concepto de número y de cantidad con total facilidad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A2->id, 'identificador' => '1.3'], [
            'texto' => '1.3. Identificar las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas para realizar estimaciones de medida...',
            'rubrica_1' => 'Identifica frecuentemente las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas sin dificultades destacables.',
            'rubrica_2' => 'Identifica muchas veces las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con facilidad.',
            'rubrica_3' => 'Identifica casi siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con bastante facilidad.',
            'rubrica_4' => 'Identifica siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con total facilidad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A2->id, 'identificador' => '1.4'], [
            'texto' => '1.4. Aplicar sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos, con el fin de ubicarse y orientarse...',
            'rubrica_1' => 'Aplica a menudo sus conocimientos acerca de las nociones espaciales básicas... Se ubica y orienta en ocasiones en distintos espacios.',
            'rubrica_2' => 'Aplica muchas veces sus conocimientos acerca de las nociones espaciales básicas... Se ubica y orienta frecuentemente en distintos espacios.',
            'rubrica_3' => 'Aplica casi siempre sus conocimientos acerca de las nociones espaciales básicas... Se ubica y orienta muchas veces en distintos espacios.',
            'rubrica_4' => 'Aplica siempre sus conocimientos acerca de las nociones espaciales básicas... Se ubica y orienta siempre en distintos espacios.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A2->id, 'identificador' => '1.5'], [
            'texto' => '1.5. Organizar su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, tanto en las rutinas como en relación con sus juegos...',
            'rubrica_1' => 'Organiza sin incorrecciones importantes su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas.',
            'rubrica_2' => 'Organiza con cierta corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas.',
            'rubrica_3' => 'Organiza con mucha corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas.',
            'rubrica_4' => 'Organiza con total corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas.'
        ]);

        // COMPETENCIA 2 (Área 2)
        $comp2_A2 = Competencia::updateOrCreate([
            'area_id' => $area2->id,
            'texto' => '2. Desarrollar, de manera progresiva, los procedimientos del método científico y las destrezas del pensamiento computacional, a través de procesos de observación y manipulación de objetos, para iniciarse en la interpretación del entorno y responder de forma creativa a las situaciones y retos cotidianos.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A2->id, 'identificador' => '2.1'], [
            'texto' => '2.1. Gestionar situaciones, retos o problemas, y proponer soluciones y alternativas a los mismos, mediante la planificación guiada de secuencias de actividades...',
            'rubrica_1' => 'Gestiona en ocasiones y con ayuda situaciones, retos o problemas, y propone soluciones y alternativas a los mismos sin dificultades destacables.',
            'rubrica_2' => 'Gestiona con razonamientos sencillos situaciones, retos o problemas, y propone soluciones y alternativas a los mismos con bastante facilidad.',
            'rubrica_3' => 'Gestiona con un razonamiento de cierta complejidad situaciones, retos o problemas, y propone soluciones y alternativas a los mismos con mucha facilidad.',
            'rubrica_4' => 'Gestiona con conciencia plena situaciones, retos o problemas, y propone soluciones y alternativas a los mismos con total facilidad y precisión.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A2->id, 'identificador' => '2.2'], [
            'texto' => '2.2. Utilizar diferentes estrategias y técnicas básicas de investigación, experimentar, observar, hacer preguntas, comprobar y plantear hipótesis acerca de posibles resultados...',
            'rubrica_1' => 'Utiliza con algún razonamiento diferentes estrategias y técnicas básicas de investigación, experimentar, observar, hacer preguntas... a través de la manipulación.',
            'rubrica_2' => 'Utiliza con razonamientos sencillos diferentes estrategias y técnicas básicas de investigación, experimentar, observar, hacer preguntas... a través de la manipulación.',
            'rubrica_3' => 'Utiliza con un razonamiento de cierta complejidad diferentes estrategias y técnicas básicas de investigación, experimentar, observar... a través de la manipulación.',
            'rubrica_4' => 'Utiliza con conciencia plena diferentes estrategias y técnicas básicas de investigación, experimentar, observar... a través de la manipulación con total facilidad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A2->id, 'identificador' => '2.3'], [
            'texto' => '2.3. Participar en diversos proyectos de investigación que se plantean en el contexto de aula, a través de estrategias y dinámicas cooperativas, con la finalidad de compartir y valorar las opiniones...',
            'rubrica_1' => 'Participa frecuentemente en diversos proyectos de investigación... compartiendo y valorando con algo de interés las opiniones propias y ajenas.',
            'rubrica_2' => 'Participa muchas veces en diversos proyectos de investigación... compartiendo y valorando con bastante interés las opiniones propias y ajenas.',
            'rubrica_3' => 'Participa casi siempre en diversos proyectos de investigación... compartiendo y valorando con mucho interés las opiniones propias y ajenas.',
            'rubrica_4' => 'Participa siempre en diversos proyectos de investigación... compartiendo y valorando con mucho interés y dedicación las opiniones propias y ajenas.'
        ]);

        // COMPETENCIA 3 (Área 2)
        $comp3_A2 = Competencia::updateOrCreate([
            'area_id' => $area2->id,
            'texto' => '3. Reconocer elementos y fenómenos de la naturaleza, mostrando interés por los hábitos que inciden sobre ella, para apreciar la importancia del uso sostenible, el cuidado y la conservación del entorno en la vida de las personas.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A2->id, 'identificador' => '3.1'], [
            'texto' => '3.1. Demostrar una actitud de curiosidad, respeto, cuidado y protección hacia el medio natural y hacia los seres vivos que habitan en él...',
            'rubrica_1' => 'Demuestra en algunas ocasiones una actitud de curiosidad, respeto, cuidado y protección hacia el medio natural... Se inicia sin dificultades destacables en el reconocimiento de los recursos.',
            'rubrica_2' => 'Demuestra muchas veces una actitud de curiosidad, respeto, cuidado y protección hacia el medio natural... Se inicia con bastante facilidad en el reconocimiento de los recursos.',
            'rubrica_3' => 'Demuestra casi siempre una actitud de curiosidad, respeto, cuidado y protección hacia el medio natural... Se inicia con mucha facilidad en el reconocimiento de los recursos.',
            'rubrica_4' => 'Demuestra siempre una actitud de curiosidad, respeto, cuidado y protección hacia el medio natural... Se inicia con total facilidad en el reconocimiento de los recursos.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A2->id, 'identificador' => '3.2'], [
            'texto' => '3.2. Observar, manipular y explorar los elementos naturales y experimentar con ellos, con la finalidad de comprobar sus características y comportamiento...',
            'rubrica_1' => 'Observa, manipula y explora sin necesidad de pautas los elementos naturales... Comprueba con algún razonamiento sus características y comportamiento.',
            'rubrica_2' => 'Observa, manipula y explora con cierta originalidad los elementos naturales... Comprueba con razonamientos sencillos sus características y comportamiento.',
            'rubrica_3' => 'Observa, manipula y explora con originalidad los elementos naturales... Comprueba con un razonamiento de cierta complejidad sus características y comportamiento.',
            'rubrica_4' => 'Observa, manipula y explora con originalidad y aportaciones personales los elementos naturales... Comprueba con conciencia plena sus características y comportamiento.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A2->id, 'identificador' => '3.3'], [
            'texto' => '3.3. Identificar rasgos comunes y diferentes entre los seres vivos e inertes, en actividades de exploración en la naturaleza, reconociendo, entre ellos, las especies más representativas de Canarias...',
            'rubrica_1' => 'Identifica sin incorrecciones importantes rasgos comunes y diferentes entre los seres vivos e inertes... reconociendo habitualmente con claridad las especies representativas.',
            'rubrica_2' => 'Identifica con bastante corrección rasgos comunes y diferentes entre los seres vivos e inertes... reconociendo con bastante claridad las especies representativas.',
            'rubrica_3' => 'Identifica con mucha corrección rasgos comunes y diferentes entre los seres vivos e inertes... reconociendo con mucha claridad las especies representativas.',
            'rubrica_4' => 'Identifica con total corrección rasgos comunes y diferentes entre los seres vivos e inertes... reconociendo con total claridad las especies representativas.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A2->id, 'identificador' => '3.4'], [
            'texto' => '3.4. Observar, reconocer y nombrar algunos fenómenos naturales, acercándose, a través de la experimentación y el juego, a las repercusiones que tienen en la vida cotidiana...',
            'rubrica_1' => 'Observa, reconoce y nombra sin dificultades destacables algunos fenómenos naturales. Se acerca... con una reflexión sencilla.',
            'rubrica_2' => 'Observa, reconoce y nombra con bastante facilidad algunos fenómenos naturales. Se acerca... con razonamientos algo complejos.',
            'rubrica_3' => 'Observa, reconoce y nombra con mucha facilidad algunos fenómenos naturales. Se acerca... con razonamientos bastante complejos.',
            'rubrica_4' => 'Observa, reconoce y nombra con total facilidad algunos fenómenos naturales. Se acerca... con conciencia plena.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A2->id, 'identificador' => '3.5'], [
            'texto' => '3.5. Establecer relaciones e identificar elementos del medio natural y social, a partir de la observación y la participación en actividades de acercamiento...',
            'rubrica_1' => 'Establece relaciones sin dificultades destacables e identifica elementos del medio natural y social... Valora con algún razonamiento y respeta los rasgos característicos de Canarias.',
            'rubrica_2' => 'Establece relaciones e identifica con bastante facilidad elementos del medio natural y social... Valora con razonamientos sencillos y respeta los rasgos característicos.',
            'rubrica_3' => 'Establece relaciones e identifica con mucha facilidad elementos del medio natural y social... Valora con razonamientos de cierta complejidad y respeta los rasgos característicos.',
            'rubrica_4' => 'Establece relaciones e identifica con total facilidad elementos del medio natural y social... Valora con conciencia plena y respeta los rasgos característicos.'
        ]);

        
        // ÁREA 3: COMUNICACIÓN Y REPRESENTACIÓN

        $area3 = Area::updateOrCreate(['nombre' => 'Área 3. Comunicación y Representación de la Realidad']);

        // COMPETENCIA 1 (Área 3)
        $comp1_A3 = Competencia::updateOrCreate([
            'area_id' => $area3->id,
            'texto' => '1. Manifestar interés por interactuar en situaciones cotidianas a través de la exploración y el uso de su repertorio comunicativo, para expresar sus necesidades e intenciones y para responder a las exigencias del entorno.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A3->id, 'identificador' => '1.1'], [
            'texto' => '1.1. Participar en situaciones comunicativas espontáneas y planificadas, de manera activa y respetuosa con las diferencias individuales...',
            'rubrica_1' => 'Participa con alguna dificultad en situaciones comunicativas... Indaga con interés poco constante en las posibilidades expresivas.',
            'rubrica_2' => 'Participa sin dificultades destacables en situaciones comunicativas... Indaga con algo de interés en las posibilidades expresivas.',
            'rubrica_3' => 'Participa con facilidad en situaciones comunicativas... Indaga generalmente con interés en las posibilidades expresivas.',
            'rubrica_4' => 'Participa con bastante facilidad en situaciones comunicativas... Indaga con bastante interés en las posibilidades expresivas.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A3->id, 'identificador' => '1.2'], [
            'texto' => '1.2. Participar en situaciones de uso y en interacciones sencillas en una primera lengua extranjera a través de la participación en actividades lúdicas...',
            'rubrica_1' => 'Participa en pocas ocasiones en situaciones de uso... Responde con alguna incorrección. Esporádicamente manifiesta interés.',
            'rubrica_2' => 'Participa a menudo en situaciones de uso... Responde sin incorrecciones importantes. Frecuentemente manifiesta interés.',
            'rubrica_3' => 'Participa muchas veces en situaciones de uso... Responde con bastante corrección. Muchas veces manifiesta interés.',
            'rubrica_4' => 'Participa casi siempre en situaciones de uso... Responde generalmente con corrección. Casi siempre manifiesta interés.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A3->id, 'identificador' => '1.3'], [
            'texto' => '1.3. Comunicar necesidades, sentimientos y vivencias, con empatía y asertividad, utilizando diferentes lenguajes y estrategias comunicativas...',
            'rubrica_1' => 'Comunica con alguna dificultad necesidades, sentimientos y vivencias... Adecúa la expresión facial generalmente sin ayuda.',
            'rubrica_2' => 'Comunica sin gran dificultad necesidades, sentimientos y vivencias... Adecúa la expresión facial con algo de autonomía.',
            'rubrica_3' => 'Comunica generalmente con facilidad necesidades, sentimientos y vivencias... Adecúa la expresión facial con bastante autonomía.',
            'rubrica_4' => 'Comunica con bastante facilidad necesidades, sentimientos y vivencias... Adecúa la expresión facial con mucha autonomía.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp1_A3->id, 'identificador' => '1.4'], [
            'texto' => '1.4. Experimentar con diferentes recursos tecnológicos, con el fin de familiarizarse, de manera progresiva, con los diferentes medios...',
            'rubrica_1' => 'Experimenta con diferentes recursos tecnológicos mostrando interés poco constante.',
            'rubrica_2' => 'Experimenta con diferentes recursos tecnológicos mostrando algo de interés.',
            'rubrica_3' => 'Experimenta con diferentes recursos tecnológicos mostrando generalmente interés.',
            'rubrica_4' => 'Experimenta con diferentes recursos tecnológicos mostrando bastante interés.'
        ]);

        // COMPETENCIA 2 (Área 3)
        $comp2_A3 = Competencia::updateOrCreate([
            'area_id' => $area3->id,
            'texto' => '2. Interpretar y comprender mensajes y representaciones apoyándose en conocimientos y recursos de su propia experiencia para responder a las demandas del entorno y construir nuevos aprendizajes.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A3->id, 'identificador' => '2.1'], [
            'texto' => '2.1. Interpretar los mensajes y la información proveniente de su entorno, así como las intenciones comunicativas de las demás personas...',
            'rubrica_1' => 'Interpreta con alguna incorrección los mensajes... En pocas ocasiones demuestra interés y curiosidad.',
            'rubrica_2' => 'Interpreta sin incorrecciones importantes los mensajes... A menudo demuestra interés y curiosidad.',
            'rubrica_3' => 'Interpreta con bastante corrección los mensajes... Muchas veces demuestra interés y curiosidad.',
            'rubrica_4' => 'Interpreta generalmente con corrección los mensajes... Casi siempre demuestra interés y curiosidad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A3->id, 'identificador' => '2.2'], [
            'texto' => '2.2. Interpretar los mensajes transmitidos mediante representaciones o manifestaciones sociales, culturales y artísticas de su entorno...',
            'rubrica_1' => 'Interpreta con alguna dificultad los mensajes... Reconoce con alguna dificultad la intencionalidad del emisor.',
            'rubrica_2' => 'Interpreta sin dificultades destacables los mensajes... Reconoce sin dificultades destacables la intencionalidad.',
            'rubrica_3' => 'Interpreta con bastante claridad los mensajes... Reconoce con cierta facilidad la intencionalidad.',
            'rubrica_4' => 'Interpreta con mucha claridad los mensajes... Reconoce con bastante facilidad la intencionalidad.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp2_A3->id, 'identificador' => '2.3'], [
            'texto' => '2.3. Comprender palabras y mensajes sencillos relacionados a las rutinas diarias y al contexto más próximo, en una primera lengua extranjera...',
            'rubrica_1' => 'Comprende con poca fluidez palabras y mensajes sencillos... Participa en pocas ocasiones en actividades relacionadas.',
            'rubrica_2' => 'Comprende habitualmente con claridad palabras y mensajes... Participa frecuentemente en actividades relacionadas.',
            'rubrica_3' => 'Comprende con bastante claridad y fluidez palabras y mensajes... Participa muchas veces en actividades relacionadas.',
            'rubrica_4' => 'Comprende con mucha claridad y fluidez palabras y mensajes... Participa casi siempre en actividades relacionadas.'
        ]);

        // COMPETENCIA 3 (Área 3)
        $comp3_A3 = Competencia::updateOrCreate([
            'area_id' => $area3->id,
            'texto' => '3. Producir mensajes de manera eficaz, personal y creativa, utilizando diferentes lenguajes, descubriendo los códigos de cada uno de ellos y explorando sus posibilidades expresivas.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A3->id, 'identificador' => '3.1'], [
            'texto' => '3.1. Hacer un uso funcional del lenguaje oral, en contextos formales e informales, como medio de aprendizaje, de regulación de la conducta...',
            'rubrica_1' => 'Hace un uso funcional del lenguaje oral con escasa fluidez en contextos formales e informales.',
            'rubrica_2' => 'Hace un uso funcional del lenguaje oral con algo de fluidez en contextos formales e informales.',
            'rubrica_3' => 'Hace un uso funcional del lenguaje oral generalmente con fluidez en contextos formales e informales.',
            'rubrica_4' => 'Hace un uso funcional del lenguaje oral con bastante fluidez en contextos formales e informales.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A3->id, 'identificador' => '3.5'], [
            'texto' => '3.5. Elaborar creaciones plásticas, explorando y utilizando diferentes materiales y técnicas, y participando activamente en el trabajo en grupo...',
            'rubrica_1' => 'Elabora creaciones plásticas siguiendo alguna pauta. En pocas ocasiones participa de forma activa en el trabajo en grupo.',
            'rubrica_2' => 'Elabora creaciones plásticas con algo de originalidad. Frecuentemente participa de forma activa en el trabajo en grupo.',
            'rubrica_3' => 'Elabora creaciones plásticas con bastante originalidad. Muchas veces participa activamente en el trabajo en grupo.',
            'rubrica_4' => 'Elabora creaciones plásticas con mucha originalidad. Casi siempre participa de forma activa en el trabajo en grupo.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp3_A3->id, 'identificador' => '3.8'], [
            'texto' => '3.8. Expresarse de manera creativa a través de herramientas o aplicaciones digitales, intuitivas y visuales...',
            'rubrica_1' => 'En pocas ocasiones se expresa de manera creativa a través de herramientas o aplicaciones digitales.',
            'rubrica_2' => 'A menudo se expresa de manera creativa a través de herramientas o aplicaciones digitales.',
            'rubrica_3' => 'Muchas veces se expresa de manera creativa a través de herramientas o aplicaciones digitales.',
            'rubrica_4' => 'Casi siempre se expresa de manera creativa a través de herramientas o aplicaciones digitales.'
        ]);

        // COMPETENCIA 4 (Área 3)
        $comp4_A3 = Competencia::updateOrCreate([
            'area_id' => $area3->id,
            'texto' => '4. Participar por iniciativa propia en actividades de aproximación a la lectura y escritura valorando ambas como medio de comunicación, información y disfrute.'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp4_A3->id, 'identificador' => '4.1'], [
            'texto' => '4.1. Participar, con interés y curiosidad, en actividades de aproximación al lenguaje escrito y mostrar interés por producir mensajes...',
            'rubrica_1' => 'Participa, en pocas ocasiones, con interés y curiosidad... Muestra interés poco constante por producir mensajes.',
            'rubrica_2' => 'Participa, frecuentemente con interés y curiosidad... Muestra interés creciente por producir mensajes.',
            'rubrica_3' => 'Participa, muchas veces con interés y curiosidad... Muestra bastante interés por producir mensajes.',
            'rubrica_4' => 'Participa, casi siempre con interés y curiosidad... Muestra mucho interés por producir mensajes.'
        ]);

        // COMPETENCIA 5 (Área 3)
        $comp5_A3 = Competencia::updateOrCreate([
            'area_id' => $area3->id,
            'texto' => '5. Valorar la diversidad lingüística presente en su entorno, así como otras manifestaciones culturales...'
        ]);

        Criterio::updateOrCreate(['competencia_id' => $comp5_A3->id, 'identificador' => '5.1'], [
            'texto' => '5.1. Demostrar curiosidad, interés y respeto por la pluralidad lingüística y cultural de su contexto...',
            'rubrica_1' => 'Demuestra curiosidad, interés y respeto poco constantes por la pluralidad lingüística y cultural...',
            'rubrica_2' => 'Demuestra algo de curiosidad, interés y respeto por la pluralidad lingüística y cultural...',
            'rubrica_3' => 'Demuestra cierta curiosidad, interés y respeto por la pluralidad lingüística y cultural...',
            'rubrica_4' => 'Demuestra bastante curiosidad, interés y respeto por la pluralidad lingüística y cultural...'
        ]);


    }
}
