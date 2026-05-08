

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue' // Importamos el componente raíz
import router from './router' // Importamos el router para manejar las rutas de la aplicación
// Importamos Bootstrap CSS y JS para estilos y funcionalidades de Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
