<template>
  <div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4"> // Encabezado y botón para añadir nuevo profesor
      <h2>Gestión de Personal</h2>
      <button v-if="!mostrarFormulario" @click="mostrarFormulario = true" class="btn btn-success">
        + Añadir Nuevo Profesor
      </button>
    </div>

    <div v-if="mostrarFormulario" class="card shadow-sm mb-4"> // Formulario para añadir nuevo profesor
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
              <select v-model="nuevoProfesor.role" class="form-select" required>
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

    <div class="card shadow-sm border-0"> // Tabla de profesores
      <div class="card-body p-0">
        <div class="table-responsive">
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
                  <div class="d-flex gap-2">
                    <button @click="abrirModal(profesor)" class="btn btn-outline-primary btn-sm">Editar</button>
                    <button @click="eliminarProfesor(profesor)" class="btn btn-outline-danger btn-sm">Eliminar</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="mostrarModal" class="modal d-block" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(2px);"> // Modal para editar profesor
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-light">
            <h5 class="modal-title fw-bold text-primary">Editar Profesor</h5>
            <button type="button" class="btn-close" @click="cerrarModal"></button>
          </div>
          <div class="modal-body p-4">
            <form @submit.prevent="guardarEdicion">
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Nombre Completo</label>
                <input v-model="formEdit.name" type="text" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
                <input v-model="formEdit.email" type="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Rol</label>
                <select v-model="formEdit.role" class="form-select" required>
                  <option value="profesor">Profesor</option>
                  <option value="admin">Director (Admin)</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Nueva Contraseña <span class="text-muted fw-normal">(Dejar en blanco para mantener)</span></label>
                <input v-model="formEdit.password" type="password" class="form-control" placeholder="********">
              </div>
              <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-secondary" @click="cerrarModal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
              </div>
            </form>
          </div>
        </div>
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
// Variables para gestión de profesores
const mostrarFormulario = ref(false)
const profesores = ref<Profesor[]>([])
const nuevoProfesor = ref({ name: '', email: '', password: '', role: '' })

// Variables Modal
const mostrarModal = ref(false)
const profesorEditando = ref<Profesor | null>(null)
const formEdit = ref({ name: '', email: '', role: '', password: '' })

const obtenerRolProfesor = (profesor: Profesor) => profesor.role ?? profesor.rol ?? 'profesor'

const obtenerProfesores = async () => {
  try {
    const res = await api.get('/api/users')
    profesores.value = res.data
  } catch (error) {
    console.error("Error al cargar el personal:", error)
  }
}

const agregarProfesor = async () => {
  try {
    await api.post('/api/users', nuevoProfesor.value)
    nuevoProfesor.value = { name: '', email: '', password: '', role: '' }
    obtenerProfesores()
    mostrarFormulario.value = false
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

const abrirModal = (profesor: Profesor) => {
  profesorEditando.value = profesor
  formEdit.value.name = profesor.name
  formEdit.value.email = profesor.email
  formEdit.value.role = obtenerRolProfesor(profesor)
  formEdit.value.password = ''
  mostrarModal.value = true
}

const cerrarModal = () => {
  mostrarModal.value = false
  profesorEditando.value = null
}

const guardarEdicion = async () => {
  if (!profesorEditando.value) return
  const datosAEnviar: { name: string; email: string; role: string; password?: string } = {
    name: formEdit.value.name,
    email: formEdit.value.email,
    role: formEdit.value.role
  }
  if (formEdit.value.password.trim() !== '') datosAEnviar.password = formEdit.value.password

  try {
    await api.put(`/api/users/${profesorEditando.value.id}`, datosAEnviar)
    await obtenerProfesores()
    cerrarModal()
  } catch (error) {
    console.error("Error al actualizar:", error)
  }
}

// Función para eliminar profesor con confirmación
const eliminarProfesor = async (profesor: Profesor) => {
  if (confirm(`¿Estás seguro de que deseas eliminar a ${profesor.name}? Esta acción no se puede deshacer.`)) {
    try {
      await api.delete(`/api/users/${profesor.id}`)
      await obtenerProfesores()
    } catch (error) {
      console.error("Error al eliminar el profesor:", error)
      alert("No se ha podido eliminar el registro. Comprueba los permisos en el backend.")
    }
  }
}

onMounted(obtenerProfesores)
</script>
