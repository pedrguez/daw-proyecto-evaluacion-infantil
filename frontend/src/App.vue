<script setup lang="ts">
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from './stores/auth' // Importamos el almacén

const auth = useAuthStore() // Usamos el almacén
const router = useRouter()

const cerrarSesion = () => {
  auth.logout() // Llamamos a la acción de Pinia
  router.push('/')
}
</script>

<template>
  <header>
    <nav>
      <template v-if="auth.estaAutenticado">
          <RouterLink to="/dashboard">Dashboard</RouterLink>
          <RouterLink to="/alumnos">Lista de Alumnos</RouterLink>
          <RouterLink to="/gestion-familiar" class="nav-link">Gestión Familiar</RouterLink>
          <a v-if="auth.rolUsuario === 'admin'" href="#" class="admin-link">⭐ Gestión Personal</a>

          <span class="bienvenida">Hola, {{ auth.nombreUsuario }} ({{ auth.rolUsuario }})</span>
          <button @click="cerrarSesion" class="btn-logout">Cerrar Sesión</button>
        </template>
    </nav>
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
