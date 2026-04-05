// Este es el componente raíz de la aplicación. Aquí se define la estructura básica y se incluyen las rutas principales.
<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <nav class="menu">
      <RouterLink to="/">Login</RouterLink>
      <RouterLink to="/dashboard">Dashboard</RouterLink>
      <RouterLink to="/alumnos">Lista de Alumnos</RouterLink>
      <RouterLink to="/evaluacion">Evaluar</RouterLink>
    </nav>
  </header>

  <main class="contenedor">
    <RouterView />
  </main>
</template>

<style scoped>
/* Estilos básicos */
.menu {
  background-color: #f3f4f6;
  padding: 15px;
  display: flex;
  gap: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.menu a {
  text-decoration: none;
  color: #374151;
  font-weight: bold;
}

.menu a.router-link-exact-active {
  color: #10b981; /* Verde cuando estás en esa página */
}

.contenedor {
  padding: 20px;
  border: 1px dashed #ccc;
  border-radius: 8px;
}
</style>
