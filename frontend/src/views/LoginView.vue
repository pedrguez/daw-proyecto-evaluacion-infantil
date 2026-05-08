<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios' // Importamos el axios que acabamos de configurar
import { useAuthStore } from '../stores/auth'
const auth = useAuthStore()
const router = useRouter()
const email = ref('')
const password = ref('')
const mensajeError = ref('')

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

      // Ya estamos dentro. Ahora pedimos los datos de nuestro usuario
      const respuestaUser = await api.get('/api/user')

      // Extraemos el nombre y el rol con cuidado
      const nombreLogueado = respuestaUser.data.name || respuestaUser.data.usuario?.name || 'Profesor'
      const rolLogueado = respuestaUser.data.rol || respuestaUser.data.usuario?.rol || 'profesor'

      // Guardamos ambos en Pinia
      auth.login(nombreLogueado, rolLogueado)

      // Redirigimos a la lista
      router.push('/alumnos')
  } catch (error) {
    mensajeError.value = 'Credenciales incorrectas o error en el servidor.'
    console.error("Error en el login:", error)
  }
}
</script>

<template>
  <div class="login-container">
    <div class="login-box">
      <h2>Acceso Profesores</h2>
      <p>Sistema de Evaluación Infantil</p>

      <form @submit.prevent="iniciarSesion" class="login-form">
        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <input type="email" id="email" v-model="email" required placeholder="profesor@colegio.com" />
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" id="password" v-model="password" required placeholder="********" />
        </div>

        <p v-if="mensajeError" class="error">{{ mensajeError }}</p>

        <button type="submit" class="btn-login">Iniciar Sesión</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-container { display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f3f4f6; }
.login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
.login-box h2 { color: #1f2937; margin-bottom: 5px; }
.login-box p { color: #6b7280; margin-bottom: 30px; font-size: 0.9em; }
.form-group { text-align: left; margin-bottom: 20px; }
.form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #374151; font-size: 0.9em; }
.form-group input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1em; box-sizing: border-box; }
.btn-login { width: 100%; padding: 12px; background-color: #4f46e5; color: white; border: none; border-radius: 6px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: background 0.2s; }
.btn-login:hover { background-color: #4338ca; }
.error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; font-size: 0.9em; margin-bottom: 20px; }
</style>
