# Gestión de Personal y Seguridad de Sesiones

El módulo de Gestión de Personal permite la administración de los usuarios del sistema (profesores y equipo directivo), aplicando un estricto control de acceso basado en roles (RBAC) y asegurando la integridad de las sesiones mediante Laravel Sanctum.

## Control de Acceso Basado en Roles (RBAC)

Se ha implementado un sistema de roles para diferenciar entre `profesor` y `admin` (Director).

1. **Protección en el Frontend (Vue 3 + Pinia):**
   La navegación se renderiza de forma condicional. Las opciones sensibles, como el acceso a `/gestion-personal`, están ocultas en `App.vue` mediante directivas de renderizado (`v-if="auth.rolUsuario === 'admin'"`), garantizando una interfaz limpia y adaptada a los privilegios del usuario activo.

2. **Protección en el Backend (Laravel):**
   No basta con ocultar la interfaz. Las rutas de la API (`/api/users`) han sido encapsuladas dentro del middleware `auth:sanctum`. Además, en el controlador, se verifica explícitamente el rol del usuario que realiza la petición (`$request->user()->role === 'admin'`). Si un usuario no autorizado intenta forzar la petición, la API responde con un código HTTP 403 (Forbidden).

## Resolución de Problemas: Bloqueo de Sesiones (Error 419/500)

Durante la fase de pruebas, se detectó una vulnerabilidad de desincronización entre el estado del Frontend y el estado del Backend que provocaba bloqueos en el inicio de sesión.

**El Problema:**
La función de cierre de sesión original en Pinia únicamente eliminaba los datos del `localStorage`. Esto destruía la sesión visual en Vue, pero la cookie de autenticación de Laravel Sanctum permanecía activa en el navegador. Al intentar realizar un nuevo inicio de sesión, Laravel detectaba una colisión entre la cookie viva y la nueva petición, bloqueando el acceso por seguridad (Error de expiración de token o Error 500 al no reconocer el estado del usuario).

**La Solución:**
Se reescribió la lógica de autenticación en el almacén de Pinia (`auth.ts`) para establecer una comunicación bidireccional en el cierre de sesión:

1. **Petición de destrucción:** Vue ejecuta `api.post('/logout')` antes de hacer nada, obligando a Laravel a destruir el token y la cookie de Sanctum en el servidor.
2. **Limpieza local:** Una vez el servidor confirma el cierre, se limpian las variables reactivas y el `localStorage`.
3. **Reinicio de contexto:** Se fuerza una recarga de la ventana (`window.location.href = '/'`) para asegurar que la memoria del navegador queda completamente purgada de datos residuales.

Esta solución garantiza un ciclo de vida de la sesión limpio, permitiendo el intercambio de cuentas (Director/Profesor) en el mismo dispositivo sin falsos positivos de seguridad.