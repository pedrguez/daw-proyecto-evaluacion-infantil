<template>
  <div class="container mt-4">
    <h2 class="fw-bold mb-1">Panel de Control</h2>
    <p class="text-muted mb-4">Resumen general del sistema de evaluación.</p>

    <div class="row g-3">
      <div class="col-md-6">
        <div class="card h-100 shadow-sm border rounded-3 p-4">
          <h6 class="text-secondary fw-bold small text-uppercase">📊 ALUMNOS REGISTRADOS</h6>
          <h1 class="display-4 fw-bold mt-2 mb-0">{{ totalAlumnos }}</h1>
        </div>
      </div>

      <div class="col-md-6">
        <RouterLink to="/alumnos" class="card h-100 shadow-sm border rounded-3 p-4 text-decoration-none text-dark bg-white">
          <h6 class="text-secondary fw-bold small text-uppercase">👦👧 GESTIONAR ALUMNOS</h6>
          <p class="mt-2 mb-0">Acceder a la lista y evaluaciones &rarr;</p>
        </RouterLink>
      </div>

      <div class="col-md-6">
        <RouterLink to="/gestion-familiar" class="card h-100 shadow-sm border rounded-3 p-4 text-decoration-none text-dark bg-white">
          <h6 class="text-secondary fw-bold small text-uppercase">👪 GESTIÓN FAMILIAR</h6>
          <p class="mt-2 mb-0">Contactos para tutorías y correos &rarr;</p>
        </RouterLink>
      </div>

      <div class="col-md-6">
        <RouterLink to="/diario-aula" class="card h-100 shadow-sm border rounded-3 p-4 text-decoration-none text-dark bg-white">
          <h6 class="text-secondary fw-bold small text-uppercase">📅 DIARIO DE AULA</h6>
          <p class="mt-2 mb-0">Anotaciones y seguimiento grupal &rarr;</p>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../axios'

const totalAlumnos = ref(0) // Variable reactiva para almacenar el número total de alumnos registrados

const cargarEstadisticas = async () => { // Función para cargar el número total de alumnos registrados
  try {
    const respuesta = await api.get('/api/alumnos')
    totalAlumnos.value = respuesta.data.length
  } catch (error) {
    console.error("Error al cargar el contador:", error)
  }
}

onMounted(cargarEstadisticas)
</script>

<style scoped>
.card {
  min-height: 160px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
</style>
