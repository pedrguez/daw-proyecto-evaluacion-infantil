<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const totalAlumnos = ref(0)
const cargando = ref(true)

onMounted(async () => {
  try {
    // Corregida la ruta añadiendo /api/
    const respuesta = await api.get('/api/alumnos')
    totalAlumnos.value = respuesta.data.length
  } catch (error) {
    console.error("Error cargando estadísticas", error)
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="dashboard-container">
    <div class="cabecera-dashboard">
      <h1>Panel de Control</h1>
      <p>Resumen general del sistema de evaluación.</p>
    </div>

    <div v-if="cargando" class="cargando">
      <p>Cargando datos...</p>
    </div>

    <div v-else class="grid-tarjetas">
      <div class="tarjeta stat-card">
        <div class="info">
          <h3>Alumnos Registrados</h3>
          <p class="numero">{{ totalAlumnos }}</p>
        </div>
      </div>

      <div class="tarjeta action-card" @click="router.push('/alumnos')">
        <div class="info">
          <h3>Gestionar Alumnos</h3>
          <p class="subtexto">Acceder a la lista y evaluaciones →</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard-container { max-width: 900px; margin: 0 auto; padding: 20px; }
.cabecera-dashboard { margin-bottom: 40px; }
.cabecera-dashboard h1 { color: #0f172a; margin-bottom: 5px; font-size: 2.2rem; }
.cabecera-dashboard p { color: #475569; font-size: 1.1em; }

.grid-tarjetas { display: flex; gap: 30px; flex-wrap: wrap; }

.tarjeta {
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 30px;
  flex: 1;
  min-width: 250px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  transition: all 0.2s ease;
}

.tarjeta:hover { border-color: #94a3b8; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }

.info h3 { margin: 0; font-size: 1.1em; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
.info .numero { margin: 10px 0 0 0; font-size: 2.5em; font-weight: bold; color: #0f172a; }
.info .subtexto { margin: 10px 0 0 0; font-size: 1em; color: #0f172a; font-weight: 500;}

/* Hacemos que la segunda tarjeta parezca información, no un botón gigante */
.action-card { cursor: default; }
</style>
