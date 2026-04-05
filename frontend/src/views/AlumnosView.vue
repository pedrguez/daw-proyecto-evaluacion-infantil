<script setup lang="ts">
import { ref, onMounted } from 'vue'

type Alumno = {
  id: number
  nombre: string
  apellidos: string
  fecha_nacimiento: string
  curso: string
  observaciones: string
}

// 1. NUEVA VARIABLE PARA CONTROLAR LA UX (Oculto por defecto)
const mostrarFormulario = ref(false)

const alumnos = ref<Alumno[]>([])
const nuevoAlumno = ref({
  nombre: '',
  apellidos: '',
  fecha_nacimiento: '',
  curso: '',
  observaciones: ''
})

const obtenerAlumnos = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/alumnos')
    alumnos.value = await res.json()
  } catch (error) {
    console.error("Error al cargar los alumnos", error)
  }
}

const agregarAlumno = async () => {
  try {
    await fetch('http://localhost:8000/api/alumnos', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(nuevoAlumno.value)
    })

    // Limpiar formulario y refrescar tabla
    nuevoAlumno.value = { nombre: '', apellidos: '', fecha_nacimiento: '', curso: '', observaciones: '' }
    obtenerAlumnos()

    // 2. OCULTAR EL FORMULARIO AUTOMÁTICAMENTE AL GUARDAR CON ÉXITO
    mostrarFormulario.value = false

  } catch (error) {
    console.error("Error al guardar el alumno", error)
  }
}

onMounted(obtenerAlumnos)
</script>

<template>
  <div class="contenedor">

    <div class="cabecera-pagina">
      <h2>Lista de Alumnos</h2>

      <button
        v-if="!mostrarFormulario"
        @click="mostrarFormulario = true"
        class="btn-nuevo"
      >
        + Añadir Nuevo Alumno
      </button>
    </div>

    <div v-if="mostrarFormulario" class="caja-formulario">
      <h3>Registro de Nuevo Alumno</h3>
      <form @submit.prevent="agregarAlumno" class="formulario">
        <div class="fila-inputs">
          <input v-model="nuevoAlumno.nombre" placeholder="Nombre" required />
          <input v-model="nuevoAlumno.apellidos" placeholder="Apellidos" required />
          <input v-model="nuevoAlumno.fecha_nacimiento" type="date" required />
          <select v-model="nuevoAlumno.curso" required>
            <option value="" disabled>Selecciona curso</option>
            <option value="1º Infantil">1º Infantil</option>
            <option value="2º Infantil">2º Infantil</option>
            <option value="3º Infantil">3º Infantil</option>
          </select>
        </div>
        <textarea v-model="nuevoAlumno.observaciones" placeholder="Observaciones iniciales (opcional)..."></textarea>

        <div class="botones-formulario">
          <button type="button" @click="mostrarFormulario = false" class="btn-cancelar">Cancelar</button>
          <button type="submit" class="btn-guardar">Guardar Alumno</button>
        </div>
      </form>
    </div>

    <table class="tabla-alumnos">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre Completo</th>
          <th>Curso</th>
          <th>Observaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="alumno in alumnos" :key="alumno.id">
          <td>{{ alumno.id }}</td>
          <td>{{ alumno.nombre }} {{ alumno.apellidos }}</td>
          <td>{{ alumno.curso }}</td>
          <td class="truncar-texto">{{ alumno.observaciones || '---' }}</td>
          <td>
            <router-link :to="'/alumno/' + alumno.id" class="btn-ficha">
              Ver Ficha
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.contenedor { padding: 20px; font-family: sans-serif; }

/* Nuevos estilos para la cabecera */
.cabecera-pagina { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-nuevo { background-color: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 1em; }
.btn-nuevo:hover { background-color: #059669; }

/* Estilos de la caja del formulario */
.caja-formulario { background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
.caja-formulario h3 { margin-top: 0; margin-bottom: 15px; color: #374151; }

.formulario { display: flex; flex-direction: column; gap: 15px; }
.fila-inputs { display: flex; gap: 10px; flex-wrap: wrap; }
.fila-inputs input, .fila-inputs select { padding: 10px; border: 1px solid #ccc; border-radius: 4px; flex: 1; min-width: 150px; }
textarea { padding: 10px; border: 1px solid #ccc; border-radius: 4px; resize: vertical; min-height: 80px; }

/* Botones del formulario alineados a la derecha */
.botones-formulario { display: flex; justify-content: flex-end; gap: 10px; }
.btn-cancelar { background-color: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; }
.btn-cancelar:hover { background-color: #e5e7eb; }
.btn-guardar { background-color: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; }
.btn-guardar:hover { background-color: #2563eb; }

.tabla-alumnos { width: 100%; border-collapse: collapse; margin-top: 10px; }
.tabla-alumnos th, .tabla-alumnos td { border: 1px solid #e5e7eb; padding: 14px 12px; text-align: left; }
.tabla-alumnos th { background-color: #f3f4f6; color: #374151; }
.truncar-texto { max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #6b7280; font-style: italic; }

.btn-ficha { display: inline-block; background-color: #6366f1; color: white; text-decoration: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-size: 0.9em; transition: background 0.2s; }
.btn-ficha:hover { background-color: #4f46e5; }
</style>
