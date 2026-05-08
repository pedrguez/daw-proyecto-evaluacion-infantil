import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // Estado
  const estaAutenticado = ref(localStorage.getItem('auth') === 'true')
  const nombreUsuario = ref(localStorage.getItem('nombre_usuario') || '')

  // Añadimos la variable para el rol (por defecto 'profesor')
  const rolUsuario = ref(localStorage.getItem('rol_usuario') || 'profesor')

  // Modificamos el login para que reciba también el rol
  function login(nombre: string, rol: string) {
    estaAutenticado.value = true
    nombreUsuario.value = nombre
    rolUsuario.value = rol

    // Guardamos en el navegador para que no se borre al recargar (F5)
    localStorage.setItem('auth', 'true')
    localStorage.setItem('nombre_usuario', nombre)
    localStorage.setItem('rol_usuario', rol)
  }
  // Función para cerrar sesión
  function logout() {
    estaAutenticado.value = false
    nombreUsuario.value = ''
    rolUsuario.value = ''

    // Limpiamos el navegador
    localStorage.removeItem('auth')
    localStorage.removeItem('nombre_usuario')
    localStorage.removeItem('rol_usuario')
  }

  return { estaAutenticado, nombreUsuario, rolUsuario, login, logout }
})
