<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

type Alumno = {
  id: number
  nombre: string
  apellidos: string
  fecha_nacimiento: string
  curso: string
  observaciones: string
}

const route = useRoute()
const router = useRouter()
const alumno = ref<Alumno | null>(null)
const idAlumno = String(route.params.id)

const obtenerDetalles = async () => {
  const res = await fetch(`http://localhost:8000/api/alumnos/${idAlumno}`)
  alumno.value = await res.json() as Alumno
}

onMounted(obtenerDetalles)

const iniciarEvaluacion = () => {
  router.push(`/evaluacion/${idAlumno}`)
}
</script>

<template>
  <div v-if="alumno" class="ficha-alumno">
    <header>
      <router-link to="/alumnos" class="btn-volver">← Volver</router-link>
      <h1>Ficha de {{ alumno.nombre }}</h1>
    </header>

    <div class="datos-personales">
      <p><strong>Apellidos:</strong> {{ alumno.apellidos }}</p>
      <p><strong>Curso:</strong> {{ alumno.curso }}</p>
      <p><strong>Observaciones:</strong> {{ alumno.observaciones || 'Sin observaciones' }}</p>
    </div>

    <div class="seccion-evaluar">
      <h2>Panel de Evaluación</h2>
      <p>Selecciona los ítems alcanzados por el alumno:</p>

      <div class="zona-check">
         <button class="btn-evaluar" @click="iniciarEvaluacion">Iniciar Evaluación Trimestral</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.ficha-alumno { padding: 30px; max-width: 800px; margin: 0 auto; }
.btn-volver { color: #6366f1; text-decoration: none; font-weight: bold; }
.datos-personales { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0; }
.seccion-evaluar { border-top: 2px solid #eee; padding-top: 20px; }
.btn-evaluar { background: #10b981; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 1.1em; cursor: pointer; }
</style>
