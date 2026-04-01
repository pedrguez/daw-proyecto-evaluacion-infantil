<script setup lang="ts">
import { ref } from 'vue'
import { criteriosEvaluacion } from '../data/criterios'

// 1. Usamos TODOS los criterios, no solo el primero
const criterios = criteriosEvaluacion

// 2. Variable reactiva para guardar las notas.
// Será un objeto donde la clave es el ID del criterio y el valor es la nota (1, 2, 3 o 4)
// Ejemplo: { "1.1": 4, "1.2": 2, "3.3": 3 }
const notasSeleccionadas = ref<Record<string, number>>({})

// 3. Función para guardar la nota de un criterio específico
const seleccionarNota = (criterioId: string, valor: number) => {
  notasSeleccionadas.value[criterioId] = valor
}
</script>

<template>
  <div class="pantalla">
    <h1>Evaluar Alumno: (Nombre del Alumno irá aquí)</h1>

    <div v-for="criterio in criterios" :key="criterio.id" class="tarjeta-criterio">

      <div class="cabecera">
        <h2>{{ criterio.titulo }}</h2>
      </div>
      <p class="descripcion">{{ criterio.descripcion }}</p>

      <div class="niveles-grid">
        <div
          v-for="nivel in criterio.niveles"
          :key="nivel.valor"
          class="caja-nivel"
          :class="{ 'activa': notasSeleccionadas[criterio.id] === nivel.valor }"
          @click="seleccionarNota(criterio.id, nivel.valor)"
        >
          <h3>{{ nivel.etiqueta }}</h3>
          <p>{{ nivel.texto }}</p>
        </div>
      </div>

    </div>

    <button class="btn-guardar" @click="console.log('Notas a guardar:', notasSeleccionadas)">
      Guardar Evaluación
    </button>
  </div>
</template>

<style scoped>
/* Los estilos siguen siendo los mismos */
.pantalla {
  padding: 10px;
  font-family: sans-serif;
  max-width: 1200px;
  margin: 0 auto;
}

.tarjeta-criterio {
  background-color: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 24px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
  margin-top: 20px;
  margin-bottom: 30px; /* Separación entre tarjetas */
}

.cabecera h2 {
  color: #1f2937;
  margin-top: 0;
  border-bottom: 2px solid #e5e7eb;
  padding-bottom: 10px;
}

.descripcion {
  color: #4b5563;
  margin-bottom: 24px;
  line-height: 1.5;
  font-size: 1.1em;
}

.niveles-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

.caja-nivel {
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  padding: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
}

.caja-nivel:hover {
  border-color: #9ca3af;
  background-color: #f9fafb;
}

.caja-nivel.activa {
  border-color: #10b981;
  background-color: #ecfdf5;
}

.caja-nivel h3 {
  margin-top: 0;
  margin-bottom: 8px;
  color: #111827;
}

.caja-nivel p {
  margin: 0;
  font-size: 0.9em;
  color: #6b7280;
}

.btn-guardar {
  margin-top: 20px;
  padding: 15px 30px;
  background-color: #10b981;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1.2em;
  font-weight: bold;
  cursor: pointer;
  width: 100%;
}
.btn-guardar:hover {
  background-color: #059669;
}

@media (max-width: 1024px) {
  .niveles-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
  .niveles-grid { grid-template-columns: 1fr; }
}
</style>
