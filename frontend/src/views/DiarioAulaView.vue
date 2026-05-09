<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Diario de Aula</h2>
    </div>

    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title text-muted small fw-bold">📅 NUEVA ENTRADA</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <input v-model="nuevaNota.fecha" type="date" class="form-control" />
          </div>
          <div class="col-md-12">
            <textarea v-model="nuevaNota.contenido" class="form-control" placeholder="¿Qué se ha hecho hoy?..." rows="3"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
          <button @click="guardarNota" class="btn btn-primary px-4">Guardar en Diario</button>
        </div>
      </div>
    </div>

    <div class="card shadow-sm mb-4 border-info">
      <div class="card-body d-flex align-items-center gap-3">
        <span class="fw-bold">🔍 Buscar:</span>
        <input v-model="filtroFecha" type="date" class="form-control w-auto" />
        <button v-if="filtroFecha" @click="filtroFecha = ''" class="btn btn-outline-secondary btn-sm">Limpiar Filtro</button>
      </div>
    </div>

    <div class="row flex-column align-items-center g-4">
      <div v-if="notasAMostrar.length === 0" class="text-center text-muted my-5">
        No hay registros para este día o el diario está vacío.
      </div>

      <div v-for="nota in notasAMostrar" :key="nota.id" class="col-md-10">
        <div class="card border-start border-4 border-primary shadow-sm">
          <div class="card-body">
            <div class="mb-2">
              <span class="badge bg-light text-primary fs-6">{{ formatearFecha(nota.fecha) }}</span>
            </div>
            <p class="card-text text-dark" style="white-space: pre-wrap;">{{ nota.contenido }}</p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!filtroFecha && notas.length > itemsPorPagina" class="d-flex justify-content-center mt-5 mb-5">
      <nav>
        <ul class="pagination shadow-sm">
          <li class="page-item" :class="{ disabled: paginaActual === 1 }">
            <button class="page-link" @click="paginaActual--">Anterior</button>
          </li>
          <li class="page-item disabled">
            <span class="page-link text-dark">Página {{ paginaActual }} de {{ totalPaginas }}</span>
          </li>
          <li class="page-item" :class="{ disabled: paginaActual >= totalPaginas }">
            <button class="page-link" @click="paginaActual++">Siguiente</button>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api from '../axios'

// 1. Le decimos a TypeScript qué forma tiene la nota
interface NotaDiario {
  id: number;
  fecha: string;
  contenido: string;
}

// 2. Se lo aplicamos a la variable
const notas = ref<NotaDiario[]>([])
const filtroFecha = ref('')
const paginaActual = ref(1)
const itemsPorPagina = 5

const nuevaNota = ref({
  fecha: new Date().toISOString().split('T')[0],
  contenido: ''
})

const notasAMostrar = computed(() => {
  if (filtroFecha.value) {
    return notas.value.filter(n => n.fecha === filtroFecha.value)
  }
  const inicio = (paginaActual.value - 1) * itemsPorPagina
  return notas.value.slice(inicio, inicio + itemsPorPagina)
})

const totalPaginas = computed(() => Math.ceil(notas.value.length / itemsPorPagina))

const cargarDiario = async () => {
  try {
    const res = await api.get('/api/diario')
    notas.value = res.data
  } catch (error) {
    console.error("Error al cargar el diario", error)
  }
}

const guardarNota = async () => {
  if (!nuevaNota.value.contenido) return
  try {
    await api.post('/api/diario', nuevaNota.value)
    nuevaNota.value.contenido = ''
    filtroFecha.value = ''
    paginaActual.value = 1
    cargarDiario()
  } catch (error) {
    console.error("Error al guardar", error)
  }
}

const formatearFecha = (fechaStr: string) => {
  // 3. Tipamos estrictamente las opciones de la fecha
  const opciones: Intl.DateTimeFormatOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(fechaStr).toLocaleDateString('es-ES', opciones);
}

onMounted(cargarDiario)
</script>

<style scoped>
.page-link { cursor: pointer; }
.card { transition: transform 0.2s; }
.card:hover { transform: scale(1.01); }
</style>
