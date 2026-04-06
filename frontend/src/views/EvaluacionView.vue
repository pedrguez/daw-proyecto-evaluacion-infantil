<script setup lang="ts">
import { ref, computed } from 'vue'

// 1. ESCALA DE EVALUACIÓN
const escala = [
  { valor: 1, titulo: 'Poco Adecuado', color: '#fee2e2', borde: '#ef4444', textoColor: '#b91c1c' },
  { valor: 2, titulo: 'Adecuado', color: '#fef3c7', borde: '#f59e0b', textoColor: '#b45309' },
  { valor: 3, titulo: 'Muy Adecuado', color: '#d1fae5', borde: '#10b981', textoColor: '#047857' },
  { valor: 4, titulo: 'Excelente', color: '#e0e7ff', borde: '#6366f1', textoColor: '#4338ca' }
]

// 2. BASE DE DATOS LOCAL CON PESTAÑAS
const areas = ref([
  {
    id: 1,
    nombre: 'Área 1. Crecimiento en Armonía',
    competencias: [
      {
        id: 1,
        texto: '1. Progresar en el conocimiento y control de su cuerpo y en la adquisición de distintas estrategias...',
        criterios: [
          {
            id: '1.1',
            texto: '1.1. (Criterios de ejemplo para el Área 1...)',
            nota: null as number | null,
            rubrica: { 1: 'Texto poco adecuado', 2: 'Texto adecuado', 3: 'Texto muy adecuado', 4: 'Texto excelente' }
          }
        ]
      }
    ]
  },
  {
    id: 2,
    nombre: 'Área 2. Descubrimiento y Exploración del Entorno',
    competencias: [
      {
        id: 2,
        texto: '1. Identificar las características de materiales, objetos y colecciones y establecer relaciones entre ellos, mediante la exploración, la manipulación sensorial, el manejo de herramientas sencillas y el desarrollo de destrezas lógico-matemáticas para descubrir y crear una idea cada vez más compleja del mundo.',
        criterios: [
          {
            id: '1.1',
            texto: '1.1. Identificar y describir las cualidades o los atributos de los materiales, los objetos y las colecciones, reconociendo sus semejanzas y diferencias, en situaciones cotidianas del aula y contextos lúdicos...',
            nota: null as number | null,
            rubrica: {
              1: 'Identifica y describe sin incorrecciones importantes las cualidades... reconoce habitualmente y con claridad sus semejanzas y diferencias... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos sin dificultades destacables. A menudo demuestra curiosidad e interés.',
              2: 'Identifica y describe con bastante corrección las cualidades... reconoce con bastante claridad sus semejanzas y diferencias... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con bastante facilidad. Muchas veces demuestra curiosidad e interés.',
              3: 'Identifica y describe casi siempre con corrección las cualidades... reconoce con mucha claridad sus semejanzas y diferencias... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con mucha facilidad. Casi siempre demuestra curiosidad e interés.',
              4: 'Identifica y describe con total corrección las cualidades... reconoce con total claridad sus semejanzas y diferencias... establece relaciones de orden, correspondencia, clasificación y comparación entre ellos con total facilidad y precisión. Siempre demuestra curiosidad e interés.'
            }
          },
          {
            id: '1.2',
            texto: '1.2. Emplear los cuantificadores básicos más significativos y construir el concepto de número y de cantidad, identificando el número cardinal que representa la cantidad y viceversa, y desarrollando la técnica de contar.',
            nota: null as number | null,
            rubrica: {
              1: 'Emplea los cuantificadores básicos más significativos sin incorrecciones importantes, construye el concepto de número y de cantidad sin dificultades destacables, identificando en ocasiones y con ayuda el número cardinal... y desarrollando sin incorrecciones importantes la técnica de contar.',
              2: 'Emplea los cuantificadores básicos más significativos con cierta corrección, construye el concepto de número y de cantidad con bastante facilidad, identificando en muchas ocasiones y sin ayuda el número cardinal... y desarrollando con cierta corrección la técnica de contar.',
              3: 'Emplea los cuantificadores básicos más significativos con mucha corrección, construye el concepto de número y de cantidad con mucha facilidad, identificando casi siempre el número cardinal... y desarrollando con mucha corrección la técnica de contar.',
              4: 'Emplea los cuantificadores básicos más significativos con total corrección, construye el concepto de número y de cantidad con total facilidad, identificando correctamente y de forma autónoma el número cardinal... y desarrollando con total corrección la técnica de contar.'
            }
          },
          {
            id: '1.3',
            texto: '1.3. Identificar las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas para realizar estimaciones de medida...',
            nota: null as number | null,
            rubrica: {
              1: 'Identifica frecuentemente las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas sin dificultades destacables... Manipula y experimenta con cierta confianza y algo de seguridad.',
              2: 'Identifica muchas veces las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con facilidad... Manipula y experimenta generalmente con confianza y seguridad.',
              3: 'Identifica casi siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con bastante facilidad... Manipula y experimenta con bastante confianza y seguridad.',
              4: 'Identifica siempre las situaciones cotidianas en las que es preciso medir, utilizando el cuerpo u otros materiales y herramientas con total facilidad... Manipula y experimenta con mucha confianza y seguridad.'
            }
          },
          {
            id: '1.4',
            texto: '1.4. Aplicar sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos, con el fin de ubicarse y orientarse adecuadamente en distintos espacios.',
            nota: null as number | null,
            rubrica: {
              1: 'Aplica a menudo sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta en ocasiones en distintos espacios.',
              2: 'Aplica muchas veces sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta frecuentemente en distintos espacios.',
              3: 'Aplica casi siempre sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta muchas veces en distintos espacios.',
              4: 'Aplica siempre sus conocimientos acerca de las nociones espaciales básicas, jugando con el propio cuerpo y con los objetos. Se ubica y orienta siempre en distintos espacios.'
            }
          },
          {
            id: '1.5',
            texto: '1.5. Organizar su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas, tanto en las rutinas como en relación con sus juegos y experiencias cotidianas...',
            nota: null as number | null,
            rubrica: {
              1: 'Organiza sin incorrecciones importantes su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas en relación con sus juegos en experiencias cotidianas...',
              2: 'Organiza con cierta corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas en relación con sus juegos en experiencias cotidianas...',
              3: 'Organiza con mucha corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas en relación con sus juegos en experiencias cotidianas...',
              4: 'Organiza con total corrección su actividad, ordenando y anticipando las secuencias, y utilizando las nociones temporales básicas en relación con sus juegos en experiencias cotidianas...'
            }
          }
        ]
      }
    ]
  },
  {
    id: 3,
    nombre: 'Área 3. Comunicación y Representación',
    competencias: [
      {
        id: 3,
        texto: '1. Manifestar interés por interactuar en situaciones cotidianas a través de la exploración...',
        criterios: [
          {
            id: '3.1',
            texto: '3.1. (Criterios de ejemplo para el Área 3...)',
            nota: null as number | null,
            rubrica: { 1: 'Texto', 2: 'Texto', 3: 'Texto', 4: 'Texto' }
          }
        ]
      }
    ]
  }
])

// 3. CONTROL DE PESTAÑAS (Empezamos en el Área 2 para que veas los datos completos)
const tabActiva = ref(2)

const areaActual = computed(() => {
  return areas.value.find(a => a.id === tabActiva.value)
})

// 4. MOTOR DE CÁLCULO (DEL ÁREA ACTIVA)
const mediaAreaActiva = computed(() => {
  let totalNotas = 0
  let cantidadEvaluados = 0

  areaActual.value?.competencias.forEach(comp => {
    comp.criterios.forEach(crit => {
      if (crit.nota !== null) {
        totalNotas += crit.nota
        cantidadEvaluados++
      }
    })
  })

  if (cantidadEvaluados === 0) return 0
  return (totalNotas / cantidadEvaluados)
})

// TRADUCTOR DE NOTA
const infoMediaArea = computed(() => {
  const media = mediaAreaActiva.value
  if (media === 0) return { titulo: 'Sin evaluar', color: '#f3f4f6', borde: '#d1d5db', textoColor: '#6b7280' }
  if (media < 1.5) return escala[0]
  if (media < 2.5) return escala[1]
  if (media < 3.5) return escala[2]
  return escala[3]
})

// 5. CÁLCULO GLOBAL (SUMA DE TODAS LAS ÁREAS)
const mediaGlobal = computed(() => {
  let totalNotasGlobal = 0
  let cantidadEvaluadosGlobal = 0

  areas.value.forEach(area => {
    area.competencias.forEach(comp => {
      comp.criterios.forEach(crit => {
        if (crit.nota !== null) {
          totalNotasGlobal += crit.nota
          cantidadEvaluadosGlobal++
        }
      })
    })
  })

  if (cantidadEvaluadosGlobal === 0) return '0.00'
  return (totalNotasGlobal / cantidadEvaluadosGlobal).toFixed(2)
})

// Función para guardar nota
const puntuar = (criterio: any, valor: number) => {
  criterio.nota = valor
}
</script>

<template>
  <div class="contenedor-evaluacion">

    <header class="cabecera">
      <div class="titulos">
        <h2>Evaluación Trimestral</h2>
        <span class="info-alumno">Alumno ID: {{ $route.params.id }}</span>
      </div>

      <div class="caja-media">
        <div class="media-numerica">
          Media del Área: <strong>{{ mediaAreaActiva > 0 ? mediaAreaActiva.toFixed(2) : '0.00' }}</strong> / 4.00
        </div>

        <div
          class="etiqueta-resultado"
          :style="{ backgroundColor: infoMediaArea.color, borderColor: infoMediaArea.borde, color: infoMediaArea.textoColor }"
        >
          {{ infoMediaArea.titulo }}
        </div>
      </div>
    </header>

    <div class="navegacion-tabs">
      <button
        v-for="area in areas"
        :key="area.id"
        class="tab-btn"
        :class="{ 'activo': tabActiva === area.id }"
        @click="tabActiva = area.id"
      >
        {{ area.nombre }}
      </button>
    </div>

    <div v-if="areaActual" class="bloque-area">
      <h2 class="titulo-area">{{ areaActual.nombre }}</h2>

      <div v-for="competencia in areaActual.competencias" :key="competencia.id" class="bloque-competencia">
        <div class="texto-competencia">
          <strong>Competencia específica:</strong> {{ competencia.texto }}
        </div>

        <div v-for="criterio in competencia.criterios" :key="criterio.id" class="bloque-criterio">
          <div class="texto-criterio">
            <strong>Criterio de evaluación:</strong> {{ criterio.texto }}
          </div>

          <div class="grid-rubrica">
            <div
              v-for="nivel in escala"
              :key="nivel.valor"
              class="tarjeta-rubrica"
              :class="{ 'seleccionada': criterio.nota === nivel.valor }"
              :style="{ borderColor: criterio.nota === nivel.valor ? nivel.borde : 'transparent', backgroundColor: criterio.nota === nivel.valor ? nivel.color : '#f9fafb' }"
              @click="puntuar(criterio, nivel.valor)"
            >
              <div class="cabecera-tarjeta" :style="{ color: nivel.textoColor }">
                {{ nivel.titulo }}
                <div class="radio-custom" :class="{ 'activo': criterio.nota === nivel.valor }">
                  <div class="punto-interior" :style="{ backgroundColor: nivel.borde }"></div>
                </div>
              </div>
              <div class="texto-rubrica">
                {{ criterio.rubrica[nivel.valor as keyof typeof criterio.rubrica] }}
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="panel-guardar">
      <div class="info-guardar">
        <div v-if="mediaGlobal !== '0.00'" class="media-global-texto">
          Nota Trimestral Global (Todas las áreas): <strong>{{ mediaGlobal }}</strong> / 4.00
        </div>
        <button class="btn-guardar-final">💾 Guardar Evaluación Completa</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* ESTILOS ORIGINALES RECUPERADOS AL 100% */
.contenedor-evaluacion { padding: 20px; max-width: 1400px; margin: 0 auto; font-family: sans-serif; color: #374151; }

.cabecera { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e5e7eb; padding-bottom: 15px; }
.titulos h2 { margin: 0 0 10px 0; color: #111827; }
.info-alumno { background: #e0e7ff; color: #4338ca; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9em; }

.caja-media { display: flex; align-items: center; gap: 20px; background: #f3f4f6; padding: 15px 25px; border-radius: 8px; border: 1px solid #d1d5db; }
.media-numerica { font-size: 1.2em; }
.media-numerica strong { color: #2563eb; font-size: 1.4em; }
.etiqueta-resultado { padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 1.1em; border: 2px solid; letter-spacing: 0.5px; transition: all 0.3s ease; }

/* ESTILOS NUEVOS DE PESTAÑAS (Sin romper lo demás) */
.navegacion-tabs { display: flex; gap: 10px; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 0px; }
.tab-btn { background: #f9fafb; color: #6b7280; border: 1px solid transparent; border-bottom: none; padding: 12px 24px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: bold; font-size: 1.05em; transition: all 0.2s; margin-bottom: -2px; }
.tab-btn:hover { background: #f3f4f6; color: #374151; }
.tab-btn.activo { background: white; color: #2563eb; border-color: #e5e7eb; border-top: 3px solid #3b82f6; }

.bloque-area { margin-bottom: 40px; }
.titulo-area { color: #1f2937; font-size: 1.5em; border-bottom: 3px solid #3b82f6; padding-bottom: 10px; display: inline-block; margin-bottom: 25px; }

.bloque-competencia { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.texto-competencia { font-size: 1.05em; line-height: 1.5; color: #1f2937; margin-bottom: 25px; padding: 15px; background: #f9fafb; border-left: 4px solid #6366f1; border-radius: 4px; }

.bloque-criterio { margin-left: 15px; border-top: 1px dashed #d1d5db; padding-top: 20px; }
.texto-criterio { font-size: 1em; line-height: 1.5; margin-bottom: 20px; color: #4b5563; }

.grid-rubrica { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; }

.tarjeta-rubrica { border: 2px solid transparent; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.2s ease; position: relative; }
.tarjeta-rubrica:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-color: #d1d5db !important; }
.tarjeta-rubrica.seleccionada { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }

.cabecera-tarjeta { display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 1.1em; margin-bottom: 15px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 10px; }
.texto-rubrica { font-size: 0.9em; line-height: 1.5; color: #4b5563; }

.radio-custom { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #9ca3af; display: flex; align-items: center; justify-content: center; background: white; transition: all 0.2s; }
.tarjeta-rubrica.seleccionada .radio-custom { border-color: inherit; }
.punto-interior { width: 12px; height: 12px; border-radius: 50%; opacity: 0; transform: scale(0); transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
.radio-custom.activo .punto-interior { opacity: 1; transform: scale(1); }

.panel-guardar { margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; display: flex; justify-content: flex-end; }
.info-guardar { display: flex; flex-direction: column; align-items: flex-end; gap: 15px; }
.media-global-texto { background: #111827; color: white; padding: 10px 20px; border-radius: 6px; font-size: 1.1em; }
.media-global-texto strong { color: #10b981; font-size: 1.3em; }

.btn-guardar-final { background: #4f46e5; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: background 0.2s; }
.btn-guardar-final:hover { background: #4338ca; }
</style>
