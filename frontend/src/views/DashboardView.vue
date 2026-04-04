<script setup lang="ts">
import { ref, onMounted } from 'vue'

// Variable para guardar el mensaje de Laravel
const mensajeBackend = ref<string>('Esperando respuesta de Laravel...')

// Cuando la pantalla carga, pedimos los datos a nuestra nueva API
onMounted(async () => {
  try {
    const respuesta = await fetch('http://localhost:8000/api/prueba')
    const datos = await respuesta.json()

    mensajeBackend.value = datos.mensaje
  } catch (error) {
    mensajeBackend.value = 'Error: No se pudo conectar con el Backend.'
  }
})
</script>

<template>
  <div class="pantalla">
    <h1>Panel de Control (Dashboard)</h1>

    <div class="caja-mensaje">
      <h2>Mensaje de la API:</h2>
      <p>{{ mensajeBackend }}</p>
    </div>
  </div>
</template>

<style scoped>
.pantalla { padding: 20px; }
.caja-mensaje {
  margin-top: 20px; padding: 20px;
  background-color: #f0fdf4; border: 2px dashed #16a34a;
  border-radius: 8px; color: #166534; font-size: 1.2em;
}
</style>
