<script setup lang="ts">
import { ref } from 'vue'
import { criteriosEvaluacion } from '../data/criterios'

// 1. Cargamos el primer criterio de nuestro archivo de datos
const criterio = criteriosEvaluacion[0]

// 2. Variable reactiva para guardar la nota que elige el profesor
// Empieza en null (ninguna seleccionada)
const notaSeleccionada = ref<number | null>(null)

// 3. Función que se ejecuta al hacer clic en una cajita
const seleccionarNota = (valor: number) => {
  notaSeleccionada.value = valor
}
</script>

<template>
  <div class="pantalla">
    <h1>Evaluar Alumno</h1>

    <div class="tarjeta-criterio">

      <div class="cabecera">
        <h2>{{ criterio.titulo }}</h2>
      </div>
      <p class="descripcion">{{ criterio.descripcion }}</p>

      <div class="niveles-grid">
        <div
          v-for="nivel in criterio.niveles"
          :key="nivel.valor"
          class="caja-nivel"
          :class="{ 'activa': notaSeleccionada === nivel.valor }"
          @click="seleccionarNota(nivel.valor)"
        >
          <h3>{{ nivel.etiqueta }}</h3>
          <p>{{ nivel.texto }}</p>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>
/* Estilos para que se parezca a tu idea original */
.pantalla {
  padding: 10px;
  font-family: sans-serif;
}

.tarjeta-criterio {
  background-color: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 24px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
  margin-top: 20px;
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

/* La cuadrícula de 4 columnas */
.niveles-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

/* El diseño de cada botón/cajita */
.caja-nivel {
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  padding: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
}

/* Efecto al pasar el ratón */
.caja-nivel:hover {
  border-color: #9ca3af;
  background-color: #f9fafb;
}

/* Efecto cuando el profesor hace clic (Seleccionado) */
.caja-nivel.activa {
  border-color: #10b981; /* Verde */
  background-color: #ecfdf5; /* Fondo verde muy clarito */
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

/* Diseño responsive: Si la pantalla es pequeña (móvil/tablet), poner uno debajo del otro */
@media (max-width: 1024px) {
  .niveles-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .niveles-grid {
    grid-template-columns: 1fr;
  }
}
</style>
