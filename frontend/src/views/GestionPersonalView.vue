<template>
  <div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Gestión de Personal</h2>
      <button v-if="!mostrarFormulario" @click="mostrarFormulario = true" class="btn btn-success">
        + Añadir Nuevo Profesor
      </button>
    </div>

    <div v-if="mostrarFormulario" class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Registro de Nuevo Profesor</h5>
        <form @submit.prevent="agregarProfesor">
          <div class="row g-2 mb-3">
            <div class="col-md-3">
              <input v-model="nuevoProfesor.name" class="form-control" placeholder="Nombre completo" required />
            </div>
            <div class="col-md-3">
              <input v-model="nuevoProfesor.email" type="email" class="form-control" placeholder="Correo electrónico" required />
            </div>
            <div class="col-md-3">
              <input v-model="nuevoProfesor.password" type="password" class="form-control" placeholder="Contraseña" required />
            </div>
            <div class="col-md-3">
              <select v-model="nuevoProfesor.rol" class="form-select" required>
                <option value="" disabled>Selecciona un rol</option>
                <option value="profesor">Profesor</option>
                <option value="admin">Director (Admin)</option>
              </select>
            </div>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" @click="mostrarFormulario = false" class="btn btn-secondary">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Profesor</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nombre Completo</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="profesor in profesores" :key="profesor.id">
              <td>{{ profesor.id }}</td>
              <td>{{ profesor.name }}</td>
              <td>{{ profesor.email }}</td>
              <td>
                <span class="badge" :class="obtenerRolProfesor(profesor) === 'admin' ? 'bg-danger' : 'bg-info text-dark'">
                  {{ obtenerRolProfesor(profesor) === 'admin' ? 'Director' : 'Profesor' }}
                </span>
              </td>
              <td>
                <button class="btn btn-outline-primary btn-sm">Editar Datos</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../axios'

interface Profesor {
  id: number;
  name: string;
  email: string;
  role?: string;
  rol?: string;
}

const mostrarFormulario = ref(false)
const profesores = ref<Profesor[]>([])
const nuevoProfesor = ref({
  name: '',
  email: '',
  password: '',
  rol: ''
})

const obtenerRolProfesor = (profesor: Profesor) => profesor.role ?? profesor.rol ?? 'profesor'

const obtenerProfesores = async () => {
  try {
    // Apunta a la tabla de usuarios de Laravel
    const res = await api.get('/api/users')
    profesores.value = res.data
  } catch (error) {
    console.error("Error al cargar el personal:", error)
  }
}

const agregarProfesor = async () => {
  try {
    await api.post('/api/users', nuevoProfesor.value)
    // Limpiamos y recargamos
    nuevoProfesor.value = { name: '', email: '', password: '', rol: '' }
    obtenerProfesores()
    mostrarFormulario.value = false
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

onMounted(obtenerProfesores)
</script>
