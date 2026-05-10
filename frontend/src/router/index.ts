import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import AlumnosView from '../views/AlumnosView.vue'
import EvaluacionView from '../views/EvaluacionView.vue'
import PerfilAlumnoView from '../views/PerfilAlumnoView.vue'
import GestionFamiliarView from '../views/GestionFamiliarView.vue'
import DiarioAulaView from '../views/DiarioAulaView.vue'
import GestionPersonalView from '../views/GestionPersonalView.vue'

const router = createRouter({ // Configuración del router usando el historial de navegación basado en la API History de HTML5
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView },
    // Usamos /panel-de-control como ruta oficial
    { path: '/dashboard', redirect: '/panel-de-control' },
    { path: '/panel-de-control', name: 'panel-de-control', component: DashboardView, meta: { requiresAuth: true } },
    { path: '/alumnos', name: 'alumnos', component: AlumnosView, meta: { requiresAuth: true } },
    { path: '/evaluacion/:id?', name: 'evaluacion', component: EvaluacionView, meta: { requiresAuth: true } },
    { path: '/alumno/:id', name: 'perfil-alumno', component: PerfilAlumnoView, meta: { requiresAuth: true } },
    { path: '/gestion-familiar', name: 'gestion-familiar', component: GestionFamiliarView, meta: { requiresAuth: true } },
    { path: '/diario-aula', name: 'diario-aula', component: DiarioAulaView, meta: { requiresAuth: true } },
    { path: '/gestion-personal', name: 'gestion-personal', component: GestionPersonalView, meta: { requiresAuth: true } },
  ]
})

// GUARDIA DE NAVEGACIÓN (Protección de Rutas)
router.beforeEach((to, from, next) => {
  // Verificamos si existe el token de sesión en el almacenamiento local
  const estaAutenticado = localStorage.getItem('auth') === 'true'

  // Si la ruta requiere autenticación y el usuario no está validado -> Redirigir al Login
  if (to.meta.requiresAuth && !estaAutenticado) {
    next('/')
  }
  // Si el usuario ya está autenticado e intenta acceder de nuevo al Login -> Redirigir al Panel de Control
  else if (to.path === '/' && estaAutenticado) {
    next('/panel-de-control') // Redirigir al Panel de Control si el usuario ya está autenticado
  }
  // En cualquier otro caso, permitir la navegación
  else {
    next()
  }
})

export default router
