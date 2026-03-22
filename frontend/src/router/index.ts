
import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import AlumnosView from '../views/AlumnosView.vue'
import EvaluacionView from '../views/EvaluacionView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView },
    { path: '/dashboard', name: 'dashboard', component: DashboardView },
    { path: '/alumnos', name: 'alumnos', component: AlumnosView },
    { path: '/evaluacion', name: 'evaluacion', component: EvaluacionView }
  ]
})

export default router
