
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import AlumnosView from '../views/AlumnosView.vue'
import EvaluacionView from '../views/EvaluacionView.vue'
import PerfilAlumnoView from '../views/PerfilAlumnoView.vue'
import GestionFamiliarView from '../views/GestionFamiliarView.vue'
import DiarioAulaView from '../views/DiarioAulaView.vue'
import GestionPersonalView from '../views/GestionPersonalView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView }, // El login es la única sin proteger
    { path: '/dashboard', name: 'dashboard', component: DashboardView, meta: { requiresAuth: true } },
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

  // Si la ruta requiere autenticación y el usuario no está validado -> Redirigir al Login (raíz)
  if (to.meta.requiresAuth && !estaAutenticado) {
    next('/')
  }
  // Si el usuario ya está autenticado e intenta acceder de nuevo al Login -> Redirigir a Alumnos
  else if (to.path === '/' && estaAutenticado) {
    next('/alumnos')
  }
  // En cualquier otro caso, permitir la navegación
  else {
    next()
  }
})

export default router
