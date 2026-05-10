<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../axios' // CAMBIO VITAL: Importamos Axios para pasar la seguridad de Sanctum

// Definimos los moldes de nuestros datos
interface Alumno {
  id: number;
  nombre: string;
  apellidos: string;
  fecha_nacimiento: string;
  observaciones: string;
}

interface NotaGuardada {
  id: number;
  alumno_id: number;
  criterio_id: number;
  trimestre: number;
  valor: number;
}

interface Criterio {
  id: number;
  identificador: string;
  texto: string;
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
// Variables para el perfil del alumno
const route = useRoute()
const alumnoId = route.params.id
const alumno = ref<Alumno | null>(null)
const modoEdicion = ref(false)

// Variables para el boletín de notas
const rubricaCompleta = ref<Area[]>([])
const notasAlumno = ref<NotaGuardada[]>([])

// Cargar datos básicos del alumno
const cargarAlumno = async () => {
  try {
    const res = await api.get(`/api/alumnos/${alumnoId}`)
    alumno.value = res.data
  } catch (error) {
    console.error("Error al cargar el alumno:", error)
  }
}

// Cargar datos para el Boletín (Rúbricas + Notas)
const cargarBoletin = async () => {
  try {
    const resRubrica = await api.get('/api/rubricas')
    rubricaCompleta.value = resRubrica.data

    const resNotas = await api.get(`/api/alumnos/${alumnoId}/notas`)
    notasAlumno.value = resNotas.data
  } catch (error) {
    console.error("Error al cargar el boletín:", error)
  }
}

// Busca qué nota sacó en un criterio y trimestre exacto
const obtenerNota = (criterioId: number, trimestre: number) => {
  const nota = notasAlumno.value.find(n => n.criterio_id === criterioId && n.trimestre === trimestre)
  return nota ? nota.valor : '-'
}

// Convierte el número de la base de datos en texto para las familias
const obtenerTextoNota = (valor: number | string) => {
  if (valor === 1) return 'Poco Adecuado'
  if (valor === 2) return 'Adecuado'
  if (valor === 3) return 'Muy Adecuado'
  if (valor === 4) return 'Excelente'
  return '-'
}

// Guardar cambios del perfil
const guardarCambios = async () => {
  try {
    await api.put(`/api/alumnos/${alumnoId}`, alumno.value)
    modoEdicion.value = false
    alert('✅ Datos actualizados')
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

onMounted(async () => {
  await cargarAlumno()
  await cargarBoletin()
})
</script>

<template>
  <div v-if="alumno" class="container mt-4 mb-5"> // Contenedor principal con márgenes verticales

    <header class="mb-4">
      <button @click="$router.push('/alumnos')" class="btn btn-outline-secondary btn-sm mb-3 fw-bold">
        &larr; Volver a la lista
      </button>

      <div class="d-flex flex-wrap justify-content-between align-items-center bg-white p-4 border rounded-top gap-3">
        <div class="d-flex gap-2 flex-grow-1">
          <h1 v-if="!modoEdicion" class="m-0 fw-bolder text-dark display-6">{{ alumno.nombre }} {{ alumno.apellidos }}</h1>
          <template v-else>
            <input v-model="alumno.nombre" class="form-control form-control-lg" placeholder="Nombre">
            <input v-model="alumno.apellidos" class="form-control form-control-lg" placeholder="Apellidos">
          </template>
        </div>
        <button v-if="!modoEdicion" @click="modoEdicion = true" class="btn btn-light border fw-bold text-nowrap">✏️ Editar Perfil</button>
        <button v-else @click="guardarCambios" class="btn btn-success fw-bold text-nowrap">💾 Guardar Cambios</button>
      </div>
    </header>

    <div class="bg-white p-4 border border-top-0 rounded-bottom mb-5">
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="fw-bold text-secondary text-uppercase small d-block mb-1">Fecha Nacimiento:</label>
          <span v-if="!modoEdicion" class="fs-5">{{ alumno.fecha_nacimiento }}</span>
          <input v-else type="date" v-model="alumno.fecha_nacimiento" class="form-control" />
        </div>
      </div>
      <div class="col-12">
        <label class="fw-bold text-secondary text-uppercase small d-block mb-1">Observaciones iniciales:</label>
        <div v-if="!modoEdicion" class="bg-light p-3 rounded border fst-italic text-secondary">
          {{ alumno.observaciones || 'No hay observaciones registradas.' }}
        </div>
        <textarea v-else v-model="alumno.observaciones" class="form-control" rows="3"></textarea>
      </div>
    </div>

    <div class="alert alert-primary text-center p-5 mb-5 border-primary border-opacity-25 rounded-3">
      <h2 class="text-primary fw-bolder mb-3">Panel de Evaluación</h2>
      <p class="text-dark fs-5 mb-4">Accede a la rúbrica interactiva para calificar el progreso de este alumno.</p>
      <router-link :to="`/evaluacion/${alumno.id}`" class="btn btn-primary btn-lg fw-bold px-5">
        Ir a la Rúbrica de Evaluación &rarr;
      </router-link>
    </div>

    <div v-if="rubricaCompleta.length > 0" class="mt-5 pt-4 border-top">
      <div class="mb-4">
        <h2 class="fw-bolder text-dark">Boletín de Calificaciones</h2>
        <p class="text-secondary">Historial de notas separadas por áreas, competencias y trimestres.</p>
      </div>

      <div v-for="area in rubricaCompleta" :key="area.id" class="mb-5 bg-white p-4 rounded-3 border">
        <h3 class="fw-bold text-dark border-bottom border-primary pb-2 mb-4 d-inline-block">
          {{ area.nombre }}
        </h3>

        <div v-for="comp in area.competencias" :key="comp.id" class="mb-5">

          <div class="mb-3">
            <h6 class="text-dark fw-bold mb-1">
              <span class="text-primary me-2">●</span> Competencia:
            </h6>
            <p class="text-secondary ms-4 mb-3 small">{{ comp.texto }}</p>
          </div>

          <div class="table-responsive ms-0 ms-md-4 border-start border-2 border-light ps-3">
            <table class="table table-bordered table-sm align-middle mb-0">
              <thead class="table-light text-secondary">
                <tr>
                  <th class="py-2 px-3">Criterio de Evaluación</th>
                  <th class="text-center" style="width: 100px;">T1</th>
                  <th class="text-center" style="width: 100px;">T2</th>
                  <th class="text-center" style="width: 100px;">T3</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="crit in comp.criterios" :key="crit.id">
                  <td class="text-secondary small px-3 py-2">{{ crit.texto }}</td>
                  <td class="text-center fw-bold p-0" :class="'nota-' + obtenerNota(crit.id, 1)">
                    <div class="d-flex align-items-center justify-content-center h-100 p-2" style="min-height: 40px;">
                      {{ obtenerTextoNota(obtenerNota(crit.id, 1)) }}
                    </div>
                  </td>
                  <td class="text-center fw-bold p-0" :class="'nota-' + obtenerNota(crit.id, 2)">
                    <div class="d-flex align-items-center justify-content-center h-100 p-2" style="min-height: 40px;">
                      {{ obtenerTextoNota(obtenerNota(crit.id, 2)) }}
                    </div>
                  </td>
                  <td class="text-center fw-bold p-0" :class="'nota-' + obtenerNota(crit.id, 3)">
                    <div class="d-flex align-items-center justify-content-center h-100 p-2" style="min-height: 40px;">
                      {{ obtenerTextoNota(obtenerNota(crit.id, 3)) }}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

.nota-1 { background-color: #fee2e2 !important; color: #b91c1c !important; }
.nota-2 { background-color: #fef3c7 !important; color: #b45309 !important; }
.nota-3 { background-color: #d1fae5 !important; color: #047857 !important; }
.nota-4 { background-color: #e0e7ff !important; color: #4338ca !important; }
.nota-- { background-color: #f9fafb !important; color: #9ca3af !important; }
</style>
