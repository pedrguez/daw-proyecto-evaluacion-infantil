<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter() // Para poder hacer redirecciones
const alumno = ref<any>(null)
const idAlumno = route.params.id

// Variable para controlar si estamos leyendo o editando
const modoEdicion = ref(false)

// 1. OBTENER DATOS
const obtenerDetalles = async () => {
  const res = await fetch(`http://localhost:8000/api/alumnos/${idAlumno}`)
  alumno.value = await res.json()
}

// 2. GUARDAR CAMBIOS
const guardarCambios = async () => {
  try {
    await fetch(`http://localhost:8000/api/alumnos/${idAlumno}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(alumno.value)
    })
    modoEdicion.value = false // Apagamos el modo edición al terminar
  } catch (error) {
    console.error("Error al actualizar", error)
  }
}

// 3. ELIMINAR ALUMNO
const eliminarAlumno = async () => {
  // Confirmación de seguridad nativa del navegador
  const seguro = window.confirm('⚠️ ¿Estás seguro de que deseas dar de baja a este alumno? Toda su información y notas se perderán.')

  if (seguro) {
    try {
      await fetch(`http://localhost:8000/api/alumnos/${idAlumno}`, {
        method: 'DELETE'
      })
      // Si se borra con éxito, volvemos a la lista de alumnos
      router.push('/alumnos')
    } catch (error) {
      console.error("Error al eliminar", error)
    }
  }
}

onMounted(obtenerDetalles)
</script>

<template>
  <div v-if="alumno" class="ficha-alumno">

    <header class="cabecera-ficha">
      <div class="navegacion">
        <router-link to="/alumnos" class="btn-volver">← Volver a la Lista</router-link>
        <div class="acciones-peligrosas">
          <button @click="eliminarAlumno" class="btn-borrar">Dar de baja (Borrar)</button>
        </div>
      </div>

      <div class="titulo-perfil">
        <h1 v-if="!modoEdicion">Ficha de {{ alumno.nombre }} {{ alumno.apellidos }}</h1>
        <div v-else class="edicion-nombre">
          <input v-model="alumno.nombre" placeholder="Nombre" class="input-edit" />
          <input v-model="alumno.apellidos" placeholder="Apellidos" class="input-edit" />
        </div>

        <button v-if="!modoEdicion" @click="modoEdicion = true" class="btn-editar">✏️ Editar Datos</button>
        <button v-else @click="guardarCambios" class="btn-guardar">💾 Guardar Cambios</button>
      </div>
    </header>

    <div class="datos-personales">
      <h3>Datos de Matriculación</h3>
      <div class="grid-datos">
        <div class="dato-item">
          <strong>Curso:</strong>
          <span v-if="!modoEdicion">{{ alumno.curso }}</span>
          <select v-else v-model="alumno.curso" class="input-edit">
            <option value="1º Infantil">1º Infantil</option>
            <option value="2º Infantil">2º Infantil</option>
            <option value="3º Infantil">3º Infantil</option>
          </select>
        </div>

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
  </div>
</template>

<style scoped>
.ficha-alumno { padding: 30px; max-width: 900px; margin: 0 auto; font-family: sans-serif; color: #374151; }

.cabecera-ficha { margin-bottom: 30px; }
.navegacion { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-volver { color: #6366f1; text-decoration: none; font-weight: bold; font-size: 1.1em; }
.btn-volver:hover { text-decoration: underline; }

.btn-borrar { background-color: #fee2e2; color: #dc2626; border: 1px solid #f87171; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.2s; }
.btn-borrar:hover { background-color: #fef2f2; color: #b91c1c; border-color: #ef4444; }

.titulo-perfil { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 8px 8px 0 0; border-bottom: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.titulo-perfil h1 { margin: 0; color: #111827; }

.edicion-nombre { display: flex; gap: 10px; flex: 1; margin-right: 20px; }
.btn-editar { background: #f3f4f6; border: 1px solid #d1d5db; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }
.btn-guardar { background: #10b981; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3); }

.datos-personales { background: white; padding: 30px; border-radius: 0 0 8px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 30px; }
.datos-personales h3 { margin-top: 0; color: #4b5563; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; }

.grid-datos { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.dato-item { display: flex; flex-direction: column; gap: 5px; }
.dato-item strong { color: #6b7280; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; }

.texto-observaciones { background: #f9fafb; padding: 15px; border-radius: 6px; border-left: 4px solid #3b82f6; font-style: italic; margin: 0; }

.input-edit { padding: 10px; border: 1px solid #6366f1; border-radius: 4px; font-size: 1em; width: 100%; box-sizing: border-box; background: #eef2ff; }
.input-edit:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2); }
.textarea-edit { min-height: 100px; resize: vertical; }

.seccion-evaluar { background: white; border: 2px dashed #d1d5db; padding: 30px; border-radius: 8px; text-align: center; }
.seccion-evaluar h2 { margin-top: 0; color: #1f2937; }
.seccion-evaluar p { color: #6b7280; margin-bottom: 20px; }
.btn-evaluar { display: inline-block; background: #6366f1; color: white; text-decoration: none; padding: 15px 30px; border-radius: 8px; font-size: 1.1em; font-weight: bold; transition: background 0.2s; }
.btn-evaluar:hover { background: #4f46e5; }
</style>
