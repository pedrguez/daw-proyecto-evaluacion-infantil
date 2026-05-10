<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Gestión Familiar</h2>
    </div>

    <div class="card shadow-sm border-0"> // Tabla de alumnos y datos familiares
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Nombre Completo</th>
                <th>Curso</th>
                <th>Correo Electrónico</th>
                <th>Tutoría / Notas</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="alumno in alumnos" :key="alumno.id">
                <td>{{ alumno.nombre }} {{ alumno.apellidos }}</td>
                <td>{{ alumno.curso }}</td>
                <td>
                  <a v-if="alumno.correo_familiar" :href="'mailto:' + alumno.correo_familiar" class="text-decoration-none fw-bold">
                    {{ alumno.correo_familiar }}
                  </a>
                  <span v-else class="text-muted fst-italic">Sin correo</span>
                </td>
                <td class="text-truncate" style="max-width: 200px;">
                  <span class="text-muted small">{{ alumno.notas_tutoria || '---' }}</span>
                </td>
                <td>
                  <button @click="abrirModal(alumno)" class="btn btn-outline-primary btn-sm">Editar Datos</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="mostrarModal" class="modal d-block" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(2px);"> // Modal para editar datos familiares
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-light">
            <h5 class="modal-title fw-bold text-primary">Editar Familia: {{ alumnoEditando?.nombre }}</h5>
            <button type="button" class="btn-close" @click="cerrarModal"></button>
          </div>
          <div class="modal-body p-4">
            <div class="mb-3">
              <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
              <input v-model="formCorreo" type="email" class="form-control" placeholder="correo@ejemplo.com">
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold text-secondary small">Notas de Tutoría</label>
              <textarea v-model="formNotas" class="form-control" rows="4" placeholder="Escribe aquí las observaciones..."></textarea>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" @click="cerrarModal">Cancelar</button>
            <button type="button" class="btn btn-primary" @click="guardarDatos">Guardar Cambios</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../axios'

interface Alumno {
  id: number;
  nombre: string;
  apellidos: string;
  curso: string;
  correo_familiar: string | null;
  notas_tutoria: string | null;
}

const alumnos = ref<Alumno[]>([])
const mostrarModal = ref(false)
const alumnoEditando = ref<Alumno | null>(null)
const formCorreo = ref('')
const formNotas = ref('')

const cargarAlumnos = async () => { // Carga la lista de alumnos desde la API
  try {
    const respuesta = await api.get('/api/alumnos')
    alumnos.value = respuesta.data
  } catch (error) {
    console.error("Error al cargar datos familiares:", error)
  }
}

const abrirModal = (alumno: Alumno) => { // Abre el modal y carga los datos del alumno seleccionado
  alumnoEditando.value = alumno
  formCorreo.value = alumno.correo_familiar || ''
  formNotas.value = alumno.notas_tutoria || ''
  mostrarModal.value = true
}

const cerrarModal = () => { // Cierra el modal y limpia los datos del alumno editando
  mostrarModal.value = false
  alumnoEditando.value = null
}

const guardarDatos = async () => { // Guarda los datos editados del alumno
  if (!alumnoEditando.value) return;
  try {
    await api.put(`/api/alumnos/${alumnoEditando.value.id}`, {
      correo_familiar: formCorreo.value,
      notas_tutoria: formNotas.value
    })
    await cargarAlumnos()
    cerrarModal()
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

onMounted(cargarAlumnos)
</script>
