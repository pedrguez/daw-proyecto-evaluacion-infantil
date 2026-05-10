<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../axios'

type Alumno = {
  id: number
  nombre: string
  apellidos: string
  fecha_nacimiento: string
  curso: string
  observaciones: string
}

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
    const res = await api.get('/api/alumnos')
    alumnos.value = res.data // Axios ya te da el JSON procesado aquí
  } catch (error) {
    console.error("Error al cargar los alumnos", error)
  }
}

const agregarAlumno = async () => {
  try {
    // Axios usa api.post, le pasas la ruta y directamente tu variable.
    // Él hace el JSON.stringify y pone los headers por ti.
    await api.post('/api/alumnos', nuevoAlumno.value)

    nuevoAlumno.value = { nombre: '', apellidos: '', fecha_nacimiento: '', curso: '', observaciones: '' }
    obtenerAlumnos()
    mostrarFormulario.value = false
  } catch (error) {
    console.error("Error al guardar el alumno", error)
  }
}

onMounted(obtenerAlumnos)
</script>

<template>
  <div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Lista de Alumnos</h2>
      <button v-if="!mostrarFormulario" @click="mostrarFormulario = true" class="btn btn-success">
        + Añadir Nuevo Alumno
      </button>
    </div>

    <div v-if="mostrarFormulario" class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Registro de Nuevo Alumno</h5>
        <form @submit.prevent="agregarAlumno">
          <div class="row g-2 mb-3">
            <div class="col-md-3">
              <input v-model="nuevoAlumno.nombre" class="form-control" placeholder="Nombre" required />
            </div>
            <div class="col-md-3">
              <input v-model="nuevoAlumno.apellidos" class="form-control" placeholder="Apellidos" required />
            </div>
            <div class="col-md-3">
              <input v-model="nuevoAlumno.fecha_nacimiento" type="date" class="form-control" required />
            </div>
            <div class="col-md-3">
              <select v-model="nuevoAlumno.curso" class="form-select" required>
                <option value="" disabled>Selecciona curso</option>
                <option value="1º Infantil">1º Infantil</option>
                <option value="2º Infantil">2º Infantil</option>
                <option value="3º Infantil">3º Infantil</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <textarea v-model="nuevoAlumno.observaciones" class="form-control" placeholder="Observaciones iniciales (opcional)..." rows="2"></textarea>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" @click="mostrarFormulario = false" class="btn btn-secondary">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Alumno</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
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
                <td class="text-truncate" style="max-width: 250px;">
                  <span class="text-muted fst-italic">{{ alumno.observaciones || '---' }}</span>
                </td>
                <td>
                  <router-link :to="'/alumno/' + alumno.id" class="btn btn-primary btn-sm">
                    Ver Ficha
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
/* Sin CSS manual, todo limpio con Bootstrap */
</style>
