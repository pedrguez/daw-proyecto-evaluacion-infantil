
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import AlumnosView from '../views/AlumnosView.vue'
import EvaluacionView from '../views/EvaluacionView.vue'
import PerfilAlumnoView from '../views/PerfilAlumnoView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView },
    { path: '/dashboard', name: 'dashboard', component: DashboardView },
    { path: '/alumnos', name: 'alumnos', component: AlumnosView },
    { path: '/evaluacion/:id?', name: 'evaluacion', component: EvaluacionView },
    { path: '/alumno/:id', name: 'perfil-alumno', component: PerfilAlumnoView }
  ]
})

export default router
