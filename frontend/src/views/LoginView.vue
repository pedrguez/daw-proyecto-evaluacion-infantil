<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()
const email = ref('')
const password = ref('')
const mensajeError = ref('')
// Función para iniciar sesión
const iniciarSesion = async () => {
  mensajeError.value = ''
  try {
      // Pedimos la "cookie de seguridad" a Laravel Sanctum
      await api.get('/sanctum/csrf-cookie')

      // Enviamos el email y contraseña
      await api.post('/login', {
        email: email.value,
        password: password.value
      })

      // Pedimos los datos de nuestro usuario
      const respuestaUser = await api.get('/api/user')

      // Extraemos el nombre y el rol con cuidado
      const nombreLogueado = respuestaUser.data.name || respuestaUser.data.usuario?.name || 'Profesor'
      const rolLogueado = respuestaUser.data.rol || respuestaUser.data.role || respuestaUser.data.usuario?.rol || respuestaUser.data.usuario?.role || 'profesor'

      // Guardamos ambos en Pinia
      auth.login(nombreLogueado, rolLogueado)

      // Redirige al Panel de Control
      router.push('/panel-de-control')
  } catch (error) {
    mensajeError.value = 'Credenciales incorrectas o error en el servidor.'
    console.error("Error en el login:", error)
  }
}
</script>

<template>
  <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f3f4f6;">

    <div class="card shadow border-0 p-4 w-100" style="max-width: 400px; border-radius: 8px;">

      <div class="text-center mb-4">
        <h2 class="text-dark mb-1">Acceso Profesores</h2>
        <p class="text-muted small">Sistema de Evaluación Infantil</p>
      </div>

      <form @submit.prevent="iniciarSesion">

        <div class="mb-3 text-start">
          <label for="email" class="form-label fw-bold text-secondary mb-1" style="font-size: 0.9em;">Correo Electrónico</label>
          <input type="email" id="email" v-model="email" class="form-control" required placeholder="profesor@colegio.com" />
        </div>

        <div class="mb-4 text-start"> 
          <label for="password" class="form-label fw-bold text-secondary mb-1" style="font-size: 0.9em;">Contraseña</label>
          <input type="password" id="password" v-model="password" class="form-control" required placeholder="********" />
        </div>

        <div v-if="mensajeError" class="alert alert-danger py-2 text-center" style="font-size: 0.9em;" role="alert">
          {{ mensajeError }}
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold login-btn">
          Iniciar Sesión
        </button>
      </form>
    </div>
  </div>
</template>
// Estilos específicos para el LoginView
<style scoped>

.login-btn {
  background-color: #4f46e5;
  border-color: #4f46e5;
  transition: background 0.2s;
}
.login-btn:hover {
  background-color: #4338ca;
  border-color: #4338ca;
}
</style>
