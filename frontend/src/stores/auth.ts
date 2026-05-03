
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // Estado: ¿Está el usuario autenticado? (Leemos del localStorage al arrancar)
  const estaAutenticado = ref(localStorage.getItem('auth') === 'true')

  // Acción: Iniciar Sesión
  function login() {
    estaAutenticado.value = true
    localStorage.setItem('auth', 'true')
  }

  // Acción: Cerrar Sesión
  function logout() {
    estaAutenticado.value = false
    localStorage.removeItem('auth')
  }

  return { estaAutenticado, login, logout }
})
