<script setup lang="ts">
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from './stores/auth'

const auth = useAuthStore()
const router = useRouter()

const cerrarSesion = async () => {
  await auth.logout() // Llamamos a la acción de Pinia (que ahora se comunica con Laravel)
  router.push('/')
}
</script>

<template>
  <header v-if="auth.estaAutenticado">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
      <div class="container">

        <span class="navbar-brand fw-bold text-primary">
          Evaluación Infantil
        </span>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Desplegar menú">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNavegacion">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <RouterLink to="/panel-de-control" class="nav-link" active-class="active fw-bold text-primary">Panel de Control</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/alumnos" class="nav-link" active-class="active fw-bold text-primary">Alumnos</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/gestion-familiar" class="nav-link" active-class="active fw-bold text-primary">Gestión Familiar</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/diario-aula" class="nav-link" active-class="active fw-bold text-primary">Diario de Aula</RouterLink>
            </li>
            <li class="nav-item" v-if="auth.rolUsuario === 'admin'">
              <RouterLink to="/gestion-personal" class="nav-link" active-class="active fw-bold text-primary">Gestión Personal</RouterLink>
            </li>
          </ul>

          <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
            <span class="text-muted small">
              Hola, <span class="fw-bold text-dark">{{ auth.nombreUsuario }}</span>
              ({{ auth.rolUsuario === 'admin' ? 'Director' : 'Profesor' }})
            </span>
            <button @click="cerrarSesion" class="btn btn-outline-danger btn-sm">
              Cerrar Sesión
            </button>
          </div>
        </div>

      </div>
    </nav>
  </header>

  <main class="container">
    <RouterView />
  </main>
</template>

<style scoped>

.nav-link {
  transition: color 0.2s ease-in-out;
}
.nav-link:hover {
  color: #4f46e5 !important;
}
</style>
