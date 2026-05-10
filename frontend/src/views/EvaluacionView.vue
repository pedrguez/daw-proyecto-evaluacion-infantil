<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../axios'

const route = useRoute()
const router = useRouter()
const alumnoId = route.params.id

// Moldes de datos
interface Criterio {
  id: number;
  identificador: string;
  texto: string;
  rubrica_1: string | null;
  rubrica_2: string | null;
  rubrica_3: string | null;
  rubrica_4: string | null;
  nota: number | null;
  [key: string]: string | number | null;
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

interface NotaGuardada {
  id: number;
  alumno_id: number;
  criterio_id: number;
  trimestre: number;
  valor: number;
}

// Escala de colores y títulos para las medias
const escala = [
  { valor: 1, titulo: 'Poco Adecuado', color: '#fee2e2', borde: '#ef4444', textoColor: '#b91c1c' },
  { valor: 2, titulo: 'Adecuado', color: '#fef3c7', borde: '#f59e0b', textoColor: '#b45309' },
  { valor: 3, titulo: 'Muy Adecuado', color: '#d1fae5', borde: '#10b981', textoColor: '#047857' },
  { valor: 4, titulo: 'Excelente', color: '#e0e7ff', borde: '#6366f1', textoColor: '#4338ca' }
]

// Variables reactivas
const areas = ref<Area[]>([])
const tabActiva = ref<number | null>(null)
const trimestreActivo = ref(1)

// Cargar rúbrica oficial desde la base de datos
const cargarRubrica = async () => {
  try {
    const res = await api.get('/api/rubricas')
    const data: Area[] = res.data

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

// Cargar notas guardadas para el alumno y trimestre activo
const cargarNotas = async () => {
  try {
    const res = await api.get(`/api/evaluacion/${alumnoId}/${trimestreActivo.value}`)
    const notasGuardadas = res.data

    areas.value.forEach((area: Area) => {
      area.competencias.forEach((comp: Competencia) => {
        comp.criterios.forEach((crit: Criterio) => {
          crit.nota = null
        })
      })
    })

    notasGuardadas.forEach((notaGuardada: NotaGuardada) => {
      areas.value.forEach((area: Area) => {
        area.competencias.forEach((comp: Competencia) => {
          const criterioEncontrado = comp.criterios.find(c => c.id === notaGuardada.criterio_id)
          if (criterioEncontrado) {
            criterioEncontrado.nota = notaGuardada.valor
          }
        })
      })
    })
  } catch (error) {
    console.error("Error al cargar las notas guardadas:", error)
  }
}

watch(trimestreActivo, () => {
  cargarNotas()
})

// Guardar evaluación final
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
    const res = await api.post('/api/evaluacion', {
      alumno_id: alumnoId,
      trimestre: trimestreActivo.value,
      notas: notasParaGuardar
    })

    alert('✅ ' + res.data.mensaje)
  } catch (error) {
    console.error("Error al guardar:", error)
    alert('❌ Hubo un error al guardar las notas.')
  }
}
// Cálculos computados
const areaActual = computed(() => {
  return areas.value.find(a => a.id === tabActiva.value)
})
// Media del área activa
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
// Información para mostrar según la media del área activa
const infoMediaArea = computed(() => {
  const media = mediaAreaActiva.value
  if (media === 0) return { titulo: 'Sin evaluar', color: '#f3f4f6', borde: '#d1d5db', textoColor: '#6b7280' }

  if (media < 1.5) return escala[0]!
  if (media < 2.5) return escala[1]!
  if (media < 3.5) return escala[2]!
  return escala[3]!
})
// Media global de todos los criterios evaluados
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
// Función para puntuar un criterio
const puntuar = (criterio: Criterio, valor: number) => { criterio.nota = valor }

onMounted(async () => {
  await cargarRubrica()
  await cargarNotas()
})
</script>

<template>
  <div class="container mt-4 mb-5"> // Encabezado con título, media del área activa y selector de trimestre

    <div class="mb-4">// Botón para volver al perfil del alumno
      <button @click="router.push(`/alumno/${alumnoId}`)" class="btn btn-outline-secondary btn-sm mb-3 fw-bold">
        &larr; Volver al Perfil del Alumno
      </button>

      <div class="d-flex flex-wrap justify-content-between align-items-end border-bottom pb-3 mb-4 gap-3"> // Título y media del área activa
        <div>
          <h2 class="fw-bolder mb-2 display-6 text-dark">Evaluación Trimestral</h2>
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2 fs-6">
            Alumno ID: {{ alumnoId }}
          </span>
        </div>

        <div class="d-flex align-items-center gap-3 bg-light p-3 border rounded-3 shadow-sm"> // Media del área activa
          <div class="fs-5 text-secondary">
            Media del Área: <strong class="text-primary fs-4">{{ mediaAreaActiva > 0 ? mediaAreaActiva.toFixed(2) : '0.00' }}</strong> / 4.00
          </div>
          <div class="badge rounded-pill border border-2 px-3 py-2 fs-6"
               :style="{ backgroundColor: infoMediaArea.color, borderColor: infoMediaArea.borde, color: infoMediaArea.textoColor }">
            {{ infoMediaArea.titulo }}
          </div>
        </div>
      </div>
    </div>

    <div v-if="areas.length === 0" class="alert alert-info text-center py-5 shadow-sm fw-bold"> // Cargando rúbrica oficial...
      ⏳ Descargando rúbrica oficial desde la base de datos...
    </div>

    <div v-else>
      <ul class="nav nav-tabs mb-4"> // Pestañas para cada área
        <li class="nav-item" v-for="area in areas" :key="area.id">
          <button class="nav-link fw-bold text-secondary"
                  :class="{ 'active text-primary bg-light border-bottom-0': tabActiva === area.id }"
                  @click="tabActiva = area.id">
            {{ area.nombre }}
          </button>
        </li>
      </ul>

      <div v-if="areaActual" class="mb-5 bg-white p-4 rounded-3 border shadow-sm"> // Contenido del área activa
        <h3 class="fw-bold text-dark border-bottom border-primary pb-2 mb-4 d-inline-block">
          {{ areaActual.nombre }}
        </h3>

        <div v-for="competencia in areaActual.competencias" :key="competencia.id" class="mb-5">

          <div class="mb-4 pb-3 border-bottom">
            <h5 class="text-dark fw-bold mb-2">
              <span class="text-primary fs-4 me-2">●</span> Competencia específica:
            </h5>
            <p class="text-secondary fs-6 ms-4 mb-0">{{ competencia.texto }}</p>
          </div>

          <div class="ps-0 ps-md-4"> // Criterios de evaluación de la competencia
            <div v-for="criterio in competencia.criterios" :key="criterio.id" class="border pt-4 pb-4 px-4 mt-4 rounded-3 bg-light">
              <p class="mb-3 text-secondary fs-6">
                <strong class="text-dark">Criterio {{ criterio.identificador }}:</strong> {{ criterio.texto.replace(/^[0-9.]+\s*/, '') }}
              </p>

              <div class="row g-3">
                <div v-for="nivel in escala" :key="nivel.valor" class="col-12 col-md-6 col-xl-3">
                  <div class="card h-100 cursor-pointer tarjeta-hover"
                       :class="{ 'shadow': criterio.nota === nivel.valor }"
                       :style="{ borderColor: criterio.nota === nivel.valor ? nivel.borde : 'rgba(0,0,0,0.1)', backgroundColor: criterio.nota === nivel.valor ? nivel.color : '#fff', borderWidth: '2px' }"
                       @click="puntuar(criterio, nivel.valor)">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center fw-bold border-bottom-0 pb-0"
                         :style="{ color: nivel.textoColor }">
                      {{ nivel.titulo }}
                      <div class="radio-custom" :class="{ 'activo': criterio.nota === nivel.valor }">
                        <div class="punto-interior" :style="{ backgroundColor: nivel.borde }"></div>
                      </div>
                    </div>
                    <div class="card-body text-secondary small pt-2">
                      {{ criterio['rubrica_' + nivel.valor] }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 pt-4 border-top d-flex flex-column align-items-end gap-3"> // Sección de nota global y selector de trimestre
      <div v-if="mediaGlobal !== '0.00'" class="bg-dark text-white px-4 py-2 rounded-3 fs-5 shadow-sm">
        Nota Trimestral Global: <strong class="text-success fs-4">{{ mediaGlobal }}</strong> / 4.00
      </div>

      <div class="d-flex flex-wrap gap-3 align-items-center"> // Selector de trimestre y botón para guardar evaluación
        <div class="d-flex align-items-center gap-2 bg-light p-2 px-3 rounded border shadow-sm">
          <label class="fw-bold text-secondary mb-0">Evaluando:</label>
          <select v-model="trimestreActivo" class="form-select form-select-sm w-auto fw-bold cursor-pointer">
            <option :value="1">1º Trimestre</option>
            <option :value="2">2º Trimestre</option>
            <option :value="3">3º Trimestre</option>
          </select>
        </div>
        <button @click="guardarEvaluacionFinal" class="btn btn-primary btn-lg fw-bold px-4 shadow">
          💾 Guardar Evaluación Completa
        </button>
      </div>
    </div>

  </div>
</template>

<style scoped>
.cursor-pointer { cursor: pointer; }
.tarjeta-hover { transition: all 0.2s ease; }
.tarjeta-hover:hover { transform: translateY(-3px); border-color: #adb5bd !important; }

.radio-custom { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #9ca3af; display: flex; align-items: center; justify-content: center; background: white; transition: all 0.2s; }
.card.shadow .radio-custom { border-color: inherit; }
.punto-interior { width: 12px; height: 12px; border-radius: 50%; opacity: 0; transform: scale(0); transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
.radio-custom.activo .punto-interior { opacity: 1; transform: scale(1); }
</style>
