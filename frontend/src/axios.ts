import axios from 'axios'
// Configuramos una instancia de Axios con la URL base de nuestro backend y las opciones necesarias para manejar cookies y tokens CSRF
const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: true, // Esto es importante para enviar cookies (como la de sesión) en cada solicitud
  withXSRFToken: true, // Esto es importante para enviar el token CSRF en cada solicitud
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})

export default axiosInstance
