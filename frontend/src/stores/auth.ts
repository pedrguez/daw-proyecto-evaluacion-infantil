
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // Estado: ¿Está el usuario autenticado? (Leemos del localStorage al arrancar)
  const estaAutenticado = ref(localStorage.getItem('auth') === 'true')
  const nombreUsuario = ref(localStorage.getItem('nombre_usuario') || '')

  // Ahora el login recibe el nombre del profesor
  function login(nombre: string) {
    estaAutenticado.value = true
    nombreUsuario.value = nombre
    localStorage.setItem('auth', 'true')
    localStorage.setItem('nombre_usuario', nombre)
  }

  function logout() {
    estaAutenticado.value = false
    nombreUsuario.value = ''
    localStorage.removeItem('auth')
    localStorage.removeItem('nombre_usuario')
  }

  return { estaAutenticado, nombreUsuario, login, logout }
})
