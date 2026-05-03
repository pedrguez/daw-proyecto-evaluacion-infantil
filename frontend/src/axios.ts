import axios from 'axios'

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
