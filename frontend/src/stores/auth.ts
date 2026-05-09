import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../axios' // Añadimos la conexión al backend

export const useAuthStore = defineStore('auth', () => {
  // Estado
  const estaAutenticado = ref(localStorage.getItem('auth') === 'true')
  const nombreUsuario = ref(localStorage.getItem('nombre_usuario') || '')
  const rolUsuario = ref(localStorage.getItem('rol_usuario') || 'profesor')

  // Función de login
  function login(nombre: string, rol: string) {
    estaAutenticado.value = true
    nombreUsuario.value = nombre
    rolUsuario.value = rol

    localStorage.setItem('auth', 'true')
    localStorage.setItem('nombre_usuario', nombre)
    localStorage.setItem('rol_usuario', rol)
  }

  // NUEVA Función para cerrar sesión de verdad (Backend + Frontend)
  async function logout() {
    try {
      // 1. Le decimos a Laravel que destruya la sesión real de Sanctum
      await api.post('/logout')
    } catch (error) {
      console.error("Error desconectando del backend", error)
    } finally {
      // 2. Limpiamos el navegador (Lo que ya tenías)
      estaAutenticado.value = false
      nombreUsuario.value = ''
      rolUsuario.value = ''

      localStorage.removeItem('auth')
      localStorage.removeItem('nombre_usuario')
      localStorage.removeItem('rol_usuario')

      // 3. Forzamos una recarga completa para volver al Login limpio
      window.location.href = '/'
    }
  }

  return { estaAutenticado, nombreUsuario, rolUsuario, login, logout }
})
