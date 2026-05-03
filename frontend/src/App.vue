<script setup lang="ts">
import { ref, watch } from 'vue'
import { RouterLink, RouterView, useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

// Variable reactiva que controla si el menú se ve o no
const estaAutenticado = ref(localStorage.getItem('auth') === 'true')

// Vigilamos cada vez que el usuario cambia de página para actualizar el menú
watch(() => route.path, () => {
  estaAutenticado.value = localStorage.getItem('auth') === 'true'
})

// Función para Cerrar Sesión
const cerrarSesion = () => {
  localStorage.removeItem('auth') // Le quitamos la "cookie de seguridad"
  estaAutenticado.value = false   // Ocultamos el menú
  router.push('/')                // Lo echamos al Login
}
</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <template v-if="!estaAutenticado">
          <RouterLink to="/">Login</RouterLink>
        </template>

        <template v-if="estaAutenticado">
          <RouterLink to="/dashboard">Dashboard</RouterLink>
          <RouterLink to="/alumnos">Lista de Alumnos</RouterLink>
          <RouterLink to="/evaluacion">Evaluar</RouterLink>
          <a href="#" @click.prevent="cerrarSesion" class="btn-logout">Cerrar Sesión</a>
        </template>
      </nav>
    </div>
  </header>

  <RouterView />
</template>

<style scoped>
/* Estilos básicos */
nav {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 25px; /* Espacio entre los botones */
  padding: 20px;
  background-color: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  margin-bottom: 30px;
}

nav a {
  text-decoration: none;
  color: #475569;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
}

nav a:hover, nav a.router-link-active {
  color: #4f46e5; /* Color morado cuando pasas el ratón o estás en esa página */
}

nav .btn-logout {
  color: #94a3b8; /* Gris apagado para que no destaque más que el resto */
  margin-left: 20px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  padding: 5px 10px;
  background: transparent;
  border: none;
  cursor: pointer;
}

nav .btn-logout:hover {
  color: #dc2626; /* Solo se pone rojo (peligro) cuando pasas el ratón por encima */
}

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
