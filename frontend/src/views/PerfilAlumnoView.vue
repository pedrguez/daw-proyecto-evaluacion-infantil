<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute} from 'vue-router'

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

const route = useRoute()
const alumnoId = route.params.id
const alumno = ref<Alumno | null>(null)
const modoEdicion = ref(false)

// NUEVAS VARIABLES PARA EL BOLETÍN
const rubricaCompleta = ref<Area[]>([])
const notasAlumno = ref<NotaGuardada[]>([])

// 1. Cargar datos básicos del alumno
const cargarAlumno = async () => {
  try {
    const res = await fetch(`http://localhost:8000/api/alumnos/${alumnoId}`)
    alumno.value = await res.json()
  } catch (error) {
    console.error("Error al cargar el alumno:", error)
  }
}

// 2. Cargar datos para el Boletín (Rúbricas + Notas)
const cargarBoletin = async () => {
  try {
    const resRubrica = await fetch('http://localhost:8000/api/rubricas')
    rubricaCompleta.value = await resRubrica.json()

    const resNotas = await fetch(`http://localhost:8000/api/alumnos/${alumnoId}/notas`)
    notasAlumno.value = await resNotas.json()
  } catch (error) {
    console.error("Error al cargar el boletín:", error)
  }
}

// 3. Función mágica: Busca qué nota sacó en un criterio y trimestre exacto
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

// 4. Guardar cambios del perfil (tu código anterior)
const guardarCambios = async () => {
  try {
    await fetch(`http://localhost:8000/api/alumnos/${alumnoId}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(alumno.value)
    })
    modoEdicion.value = false
    alert('✅ Datos actualizados')
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

// Al entrar a la pantalla, cargar todo
onMounted(async () => {
  await cargarAlumno()
  await cargarBoletin()
})
</script>

<template>
  <div v-if="alumno" class="ficha-alumno">
    <header class="cabecera-ficha">
      <div class="navegacion">
        <router-link to="/alumnos" class="btn-volver">← Volver a la lista</router-link>
      </div>
      <div class="titulo-perfil">
        <div class="edicion-nombre">
          <h1 v-if="!modoEdicion">{{ alumno.nombre }} {{ alumno.apellidos }}</h1>
          <template v-else>
            <input v-model="alumno.nombre" class="input-edit" placeholder="Nombre">
            <input v-model="alumno.apellidos" class="input-edit" placeholder="Apellidos">
          </template>
        </div>
        <button v-if="!modoEdicion" @click="modoEdicion = true" class="btn-editar">✏️ Editar Perfil</button>
        <button v-else @click="guardarCambios" class="btn-guardar">💾 Guardar Cambios</button>
      </div>
    </header>

    <div class="datos-personales">
      <div class="grid-datos">
        <div class="dato-item">
          <strong>Fecha Nacimiento:</strong>
          <span v-if="!modoEdicion">{{ alumno.fecha_nacimiento }}</span>
          <input v-else type="date" v-model="alumno.fecha_nacimiento" class="input-edit" />
        </div>
      </div>
      <div class="dato-item observaciones">
        <strong>Observaciones iniciales:</strong>
        <p v-if="!modoEdicion" class="texto-observaciones">{{ alumno.observaciones || 'No hay observaciones registradas.' }}</p>
        <textarea v-else v-model="alumno.observaciones" class="input-edit textarea-edit"></textarea>
      </div>
    </div>

    <div class="seccion-evaluar">
      <h2>Panel de Evaluación</h2>
      <p>Accede a la rúbrica interactiva para calificar el progreso de este alumno.</p>
      <router-link :to="`/evaluacion/${alumno.id}`" class="btn-evaluar">Ir a la Rúbrica de Evaluación</router-link>
    </div>

    <div class="seccion-boletin" v-if="rubricaCompleta.length > 0">
      <h2>Boletín de Calificaciones</h2>
      <p class="subtitulo-boletin">Historial de notas separadas por áreas, competencias y trimestres.</p>

      <div v-for="area in rubricaCompleta" :key="area.id" class="boletin-area">
        <h3>{{ area.nombre }}</h3>

        <div v-for="comp in area.competencias" :key="comp.id" class="boletin-comp">
          <p class="texto-comp"><strong>Competencia:</strong> {{ comp.texto }}</p>

          <table class="tabla-notas">
            <thead>
              <tr>
                <th>Criterio de Evaluación</th>
                <th class="col-trimestre">T1</th>
                <th class="col-trimestre">T2</th>
                <th class="col-trimestre">T3</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="crit in comp.criterios" :key="crit.id">
                <td class="celda-criterio">{{ crit.texto }}</td>
                <td class="nota-celda" :class="'nota-' + obtenerNota(crit.id, 1)">
                  {{ obtenerTextoNota(obtenerNota(crit.id, 1)) }}</td>
                <td class="nota-celda" :class="'nota-' + obtenerNota(crit.id, 2)">
                  {{ obtenerTextoNota(obtenerNota(crit.id, 2)) }}</td>
                <td class="nota-celda" :class="'nota-' + obtenerNota(crit.id, 3)">
                  {{ obtenerTextoNota(obtenerNota(crit.id, 3)) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
/* ESTILOS ANTERIORES BÁSICOS */
.ficha-alumno { padding: 30px; max-width: 1000px; margin: 0 auto; font-family: sans-serif; color: #374151; }
.cabecera-ficha { margin-bottom: 30px; }
.navegacion { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-volver { color: #6366f1; text-decoration: none; font-weight: bold; font-size: 1.1em; }
.btn-volver:hover { text-decoration: underline; }
.titulo-perfil { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 8px 8px 0 0; border-bottom: 2px solid #e5e7eb; }
.titulo-perfil h1 { margin: 0; color: #111827; }
.edicion-nombre { display: flex; gap: 10px; flex: 1; margin-right: 20px; }
.input-edit { padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 1em; width: 100%; }
.textarea-edit { min-height: 80px; resize: vertical; }
.btn-editar { background: #f3f4f6; border: 1px solid #d1d5db; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }
.btn-guardar { background: #10b981; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }
.datos-personales { background: white; padding: 30px; border-radius: 0 0 8px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 30px; }
.grid-datos { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
.dato-item strong { display: block; color: #6b7280; font-size: 0.9em; text-transform: uppercase; margin-bottom: 5px; }
.texto-observaciones { background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px dashed #d1d5db; font-style: italic; }
.seccion-evaluar { background: #e0e7ff; padding: 25px; border-radius: 8px; text-align: center; border: 1px solid #c7d2fe; margin-bottom: 40px; }
.seccion-evaluar h2 { margin-top: 0; color: #4338ca; }
.btn-evaluar { display: inline-block; background: #4f46e5; color: white; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; margin-top: 10px; transition: background 0.2s; }
.btn-evaluar:hover { background: #4338ca; }

/* NUEVOS ESTILOS DEL BOLETÍN */
.seccion-boletin { padding-top: 20px; border-top: 2px solid #e5e7eb; }
.subtitulo-boletin { color: #6b7280; margin-bottom: 25px; }
.boletin-area { background: white; padding: 25px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
.boletin-area h3 { color: #2563eb; border-bottom: 2px solid #bfdbfe; padding-bottom: 10px; margin-top: 0; }
.boletin-comp { margin-top: 20px; }
.texto-comp { font-size: 0.95em; color: #1f2937; margin-bottom: 15px; background: #f3f4f6; padding: 10px; border-left: 4px solid #9ca3af; border-radius: 4px; }
.tabla-notas { width: 100%; border-collapse: collapse; font-size: 0.9em; margin-bottom: 20px; }
.tabla-notas th, .tabla-notas td { border: 1px solid #d1d5db; padding: 10px; }
.tabla-notas th { background-color: #f9fafb; color: #374151; }
.col-trimestre { text-align: center; width: 60px; font-weight: bold; color: #4b5563; }
.celda-criterio { color: #4b5563; line-height: 1.4; }
.nota-celda { text-align: center; font-weight: bold; font-size: 1.1em; background: #f9fafb; color: #9ca3af; }

/* Colores dinámicos para las notas en la tabla */
.nota-1 { background-color: #fee2e2; color: #b91c1c; }
.nota-2 { background-color: #fef3c7; color: #b45309; }
.nota-3 { background-color: #d1fae5; color: #047857; }
.nota-4 { background-color: #e0e7ff; color: #4338ca; }
</style>
