<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'


const route = useRoute()
const alumnoId = route.params.id

// --- DEFINICIÓN DE TIPOS ---
interface Criterio {
  id: number;
  identificador: string;
  texto: string;
  rubrica_1: string | null;
  rubrica_2: string | null;
  rubrica_3: string | null;
  rubrica_4: string | null;
  nota: number | null;
  [key: string]: string | number | null; // <-- Adiós al error del "any"
}

interface Competencia {
  id: number;
  texto: string;
  criterios: Criterio[];
}

interface Area {
  id: number;
  nombre: string;
  competencias: Competencia[];
}
// -------------------------------------------------------------------

// 1. ESCALA DE EVALUACIÓN
const escala = [
  { valor: 1, titulo: 'Poco Adecuado', color: '#fee2e2', borde: '#ef4444', textoColor: '#b91c1c' },
  { valor: 2, titulo: 'Adecuado', color: '#fef3c7', borde: '#f59e0b', textoColor: '#b45309' },
  { valor: 3, titulo: 'Muy Adecuado', color: '#d1fae5', borde: '#10b981', textoColor: '#047857' },
  { valor: 4, titulo: 'Excelente', color: '#e0e7ff', borde: '#6366f1', textoColor: '#4338ca' }
]

// 2. VARIABLES REACTIVAS
const areas = ref<Area[]>([])
const tabActiva = ref<number | null>(null)
const trimestreActivo = ref(1)

// 3. DESCARGAR LA RÚBRICA REAL DESDE LARAVEL
const cargarRubrica = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/rubricas')
    const data: Area[] = await res.json()

    data.forEach((area: Area) => {
      area.competencias.forEach((comp: Competencia) => {
        comp.criterios.forEach((crit: Criterio) => {
          crit.nota = null
        })
      })
    })

    areas.value = data
    if (areas.value.length > 0 && areas.value[0]) {
      tabActiva.value = areas.value[0].id
    }
  } catch (error) {
    console.error("Error al cargar las rúbricas:", error)
  }
}
// 3.5 DESCARGAR LAS NOTAS GUARDADAS
const cargarNotas = async () => {
  try {
    const res = await fetch(`http://localhost:8000/api/evaluacion/${alumnoId}/${trimestreActivo.value}`)
    const notasGuardadas = await res.json()

    // 1. Primero, borramos (ponemos a null) todas las notas por si venimos de otro trimestre
    areas.value.forEach((area: Area) => {
      area.competencias.forEach((comp: Competencia) => {
        comp.criterios.forEach((crit: Criterio) => {
          crit.nota = null
        })
      })
    })

    // 2. Pintamos las notas que vienen de la base de datos
    notasGuardadas.forEach((notaGuardada: any) => {
      areas.value.forEach((area: Area) => {
        area.competencias.forEach((comp: Competencia) => {
          const criterioEncontrado = comp.criterios.find(c => c.id === notaGuardada.criterio_id)
          if (criterioEncontrado) {
            criterioEncontrado.nota = notaGuardada.valor // ¡Aquí se marca el botón automáticamente!
          }
        })
      })
    })
  } catch (error) {
    console.error("Error al cargar las notas guardadas:", error)
  }
}

// Si el profesor cambia el Trimestre en el desplegable recargamos las notas
watch(trimestreActivo, () => {
  cargarNotas()
})

// 4. GUARDAR NOTAS EN LARAVEL
const guardarEvaluacionFinal = async () => {
  const notasParaGuardar: { criterio_id: number, valor: number }[] = []

  areas.value.forEach((area: Area) => {
    area.competencias.forEach((comp: Competencia) => {
      comp.criterios.forEach((crit: Criterio) => {
        if (crit.nota !== null) {
          notasParaGuardar.push({
            criterio_id: crit.id,
            valor: crit.nota
          })
        }
      })
    })
  })

  if (notasParaGuardar.length === 0) {
    alert('⚠️ No has evaluado ningún criterio aún.')
    return
  }

  try {
    const res = await fetch('http://localhost:8000/api/evaluacion', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        alumno_id: alumnoId,
        trimestre: trimestreActivo.value,
        notas: notasParaGuardar
      })
    })

    const respuestaServidor = await res.json()
    alert('✅ ' + respuestaServidor.mensaje)
  } catch (error) {
    console.error("Error al guardar:", error)
    alert('❌ Hubo un error al guardar las notas en la base de datos.')
  }
}

// Control de pestaña activa
const areaActual = computed(() => {
  return areas.value.find(a => a.id === tabActiva.value)
})

// Cálculos de medias
const mediaAreaActiva = computed(() => {
  let total = 0, cantidad = 0
  if (!areaActual.value) return 0

  areaActual.value.competencias.forEach((comp: Competencia) => {
    comp.criterios.forEach((crit: Criterio) => {
      if (crit.nota !== null) { total += crit.nota; cantidad++ }
    })
  })
  return cantidad === 0 ? 0 : (total / cantidad)
})

const infoMediaArea = computed(() => {
  const media = mediaAreaActiva.value
  if (media === 0) return { titulo: 'Sin evaluar', color: '#f3f4f6', borde: '#d1d5db', textoColor: '#6b7280' }

  // <-- Adiós al error "posiblemente undefined" añadiendo la exclamación !
  if (media < 1.5) return escala[0]!
  if (media < 2.5) return escala[1]!
  if (media < 3.5) return escala[2]!
  return escala[3]!
})

const mediaGlobal = computed(() => {
  let total = 0, cantidad = 0
  areas.value.forEach((area: Area) => {
    area.competencias.forEach((comp: Competencia) => {
      comp.criterios.forEach((crit: Criterio) => {
        if (crit.nota !== null) { total += crit.nota; cantidad++ }
      })
    })
  })
  return cantidad === 0 ? '0.00' : (total / cantidad).toFixed(2)
})

const puntuar = (criterio: Criterio, valor: number) => { criterio.nota = valor }

onMounted(async () => {
  await cargarRubrica()
  await cargarNotas() // Cargamos las notas después de tener la estructura
})

</script>
<template>
  <div class="contenedor-evaluacion">

    <header class="cabecera">
      <div class="titulos">
        <h2>Evaluación Trimestral</h2>
        <span class="info-alumno">Alumno ID: {{ alumnoId }}</span>
      </div>

      <div class="caja-media">
        <div class="media-numerica">Media del Área: <strong>{{ mediaAreaActiva > 0 ? mediaAreaActiva.toFixed(2) : '0.00' }}</strong> / 4.00</div>
        <div class="etiqueta-resultado" :style="{ backgroundColor: infoMediaArea.color, borderColor: infoMediaArea.borde, color: infoMediaArea.textoColor }">
          {{ infoMediaArea.titulo }}
        </div>
      </div>
    </header>

    <div v-if="areas.length === 0" class="mensaje-carga">
      ⏳ Descargando rúbrica oficial desde la base de datos...
    </div>

    <div v-else class="navegacion-tabs">
      <button v-for="area in areas" :key="area.id" class="tab-btn" :class="{ 'activo': tabActiva === area.id }" @click="tabActiva = area.id">
        {{ area.nombre }}
      </button>
    </div>

    <div v-if="areaActual" class="bloque-area">
      <h2 class="titulo-area">{{ areaActual.nombre }}</h2>

      <div v-for="competencia in areaActual.competencias" :key="competencia.id" class="bloque-competencia">
        <div class="texto-competencia"><strong>Competencia específica:</strong> {{ competencia.texto }}</div>

        <div v-for="criterio in competencia.criterios" :key="criterio.id" class="bloque-criterio">
          <div class="texto-criterio"><strong>Criterio {{ criterio.identificador }}:</strong> {{ criterio.texto }}</div>

          <div class="grid-rubrica">
            <div v-for="nivel in escala" :key="nivel.valor" class="tarjeta-rubrica" :class="{ 'seleccionada': criterio.nota === nivel.valor }" :style="{ borderColor: criterio.nota === nivel.valor ? nivel.borde : 'transparent', backgroundColor: criterio.nota === nivel.valor ? nivel.color : '#f9fafb' }" @click="puntuar(criterio, nivel.valor)">
              <div class="cabecera-tarjeta" :style="{ color: nivel.textoColor }">
                {{ nivel.titulo }}
                <div class="radio-custom" :class="{ 'activo': criterio.nota === nivel.valor }"><div class="punto-interior" :style="{ backgroundColor: nivel.borde }"></div></div>
              </div>
              <div class="texto-rubrica">
                {{ criterio['rubrica_' + nivel.valor] }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="panel-guardar">
      <div v-if="mediaGlobal !== '0.00'" class="media-global-texto">
        Nota Trimestral Global: <strong>{{ mediaGlobal }}</strong> / 4.00
      </div>

      <div class="controles-guardado">
        <div class="selector-trimestre">
          <label>Evaluando:</label>
          <select v-model="trimestreActivo" class="select-trim">
            <option :value="1">1º Trimestre</option>
            <option :value="2">2º Trimestre</option>
            <option :value="3">3º Trimestre</option>
          </select>
        </div>
        <button @click="guardarEvaluacionFinal" class="btn-guardar-final">💾 Guardar Evaluación Completa</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.contenedor-evaluacion { padding: 20px; max-width: 1400px; margin: 0 auto; font-family: sans-serif; color: #374151; }
.mensaje-carga { text-align: center; font-size: 1.2em; color: #6b7280; padding: 40px; background: #f3f4f6; border-radius: 8px; margin-top: 20px;}
.cabecera { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e5e7eb; padding-bottom: 15px; }
.titulos h2 { margin: 0 0 10px 0; color: #111827; }
.info-alumno { background: #e0e7ff; color: #4338ca; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9em; }
.caja-media { display: flex; align-items: center; gap: 20px; background: #f3f4f6; padding: 15px 25px; border-radius: 8px; border: 1px solid #d1d5db; }
.media-numerica { font-size: 1.2em; }
.media-numerica strong { color: #2563eb; font-size: 1.4em; }
.etiqueta-resultado { padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 1.1em; border: 2px solid; letter-spacing: 0.5px; transition: all 0.3s ease; }
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
.panel-guardar { margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; display: flex; flex-direction: column; align-items: flex-end; gap: 15px; }
.media-global-texto { background: #111827; color: white; padding: 10px 20px; border-radius: 6px; font-size: 1.1em; }
.media-global-texto strong { color: #10b981; font-size: 1.3em; }
.controles-guardado { display: flex; gap: 15px; align-items: center; }
.selector-trimestre { display: flex; align-items: center; gap: 10px; font-weight: bold; color: #4b5563; background: #f3f4f6; padding: 10px 15px; border-radius: 8px; border: 1px solid #d1d5db; }
.select-trim { font-size: 1em; padding: 5px; border-radius: 4px; border: 1px solid #9ca3af; cursor: pointer;}
.btn-guardar-final { background: #4f46e5; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: background 0.2s; }
.btn-guardar-final:hover { background: #4338ca; }
</style>
