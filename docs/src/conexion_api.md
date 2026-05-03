# Comunicación API y Tipado TypeScript

Para asegurar la robustez del sistema, se ha implementado un tipado estricto en el Frontend que refleja la estructura del Backend.

## Interfaces de TypeScript (Contratos de Datos)
Se han definido interfaces para evitar errores de "undefined" durante la carga:
- **Area:** Define el nombre y el array de competencias.
- **Competencia:** Define el texto descriptivo y sus criterios asociados.
- **Criterio:** Incluye los textos de la rúbrica (1-4) y el estado de la `nota` actual.

## Endpoints de la API
| Método | Ruta | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/rubricas` | Obtiene el árbol completo de áreas, competencias y criterios. |
| `GET` | `/api/evaluacion/{id}/{tri}` | Recupera las notas guardadas de un alumno específico. |
| `POST` | `/api/evaluacion` | Envía el paquete de calificaciones para su persistencia. |

## Solución de Problemas de Navegación
Se ha corregido el enrutamiento dinámico en `PerfilAlumnoView.vue` utilizando *Template Literals* para inyectar correctamente el ID del alumno en la URL:
```typescript
router.push(`/evaluacion/${alumno.id}`)

## Cliente HTTP (Axios) e Integración con Sanctum
Para la gestión de la autenticación se ha sustituido la API nativa `fetch` por **Axios**. Se ha creado una instancia global (`axios.ts`) configurada con la propiedad `withCredentials: true`. Esto es un requisito indispensable para la arquitectura SPA (Single Page Application), ya que permite a Vue recibir y enviar automáticamente las cookies de seguridad (CSRF tokens) generadas por Laravel Sanctum en cada petición.

## Tipado Estricto (TypeScript)
Para asegurar la robustez del Frontend y eliminar la vulnerabilidad a errores en tiempo de ejecución, se han eliminado los tipos genéricos (`any`) implementando **Interfaces** exactas que mapean la estructura de la base de datos (Modelos: `Alumno`, `Area`, `Competencia`, `Criterio`, `NotaGuardada`). Asimismo, el `ControladorPrueba` del Backend ha sido tipado fuertemente.

## Resolución de Problemas Frecuentes (Troubleshooting)

Durante el desarrollo y acoplamiento del Frontend (Vue) y el Backend (Laravel), se resolvieron los siguientes retos arquitectónicos, los cuales es importante tener en cuenta para futuros despliegues o mantenimientos:

### 1. Bloqueo por CORS y Dominios de Sanctum
* **El Problema:** Al realizar peticiones desde Vue (puerto `5173`) hacia Laravel (puerto `8000`), el navegador bloqueaba la conexión por políticas de seguridad CORS, mostrando un error de conexión en el Dashboard.
* **La Solución:** Se configuraron las variables de entorno en el archivo `.env` de Laravel para autorizar explícitamente al Frontend. Se ajustaron `FRONTEND_URL=http://localhost:5173` y `SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173`. Esto permite que el middleware de Sanctum acepte las peticiones (y las cookies) provenientes del entorno cliente.

### 2. Error 404 en el Login (Ubicación de Rutas Auth)
* **El Problema:** Al instalar Laravel Breeze (API), las rutas de autenticación se inyectaron temporalmente en `api.php`. Esto provocaba que Laravel esperara el inicio de sesión en `/api/login` en lugar de `/login`, y además impedía la correcta generación de las cookies de sesión requeridas por Sanctum.
* **La Solución:** Se migró la línea `require __DIR__.'/auth.php';` al archivo de rutas principal `web.php`. La API quedó reservada exclusivamente para los datos de la aplicación (alumnos, notas), mientras que la web gestiona las rutas de autenticación con el soporte completo de sesiones HTTP.

### 3. Creación de Usuarios (Ausencia de Registro Público)
* **Decisión de Diseño:** Por razones estrictas de seguridad (al tratarse de datos de menores), la aplicación no dispone de una vista pública de "Registro" para profesores. 
* **Procedimiento:** La creación de credenciales de acceso se realiza directamente desde el lado del servidor utilizando la consola interactiva `php artisan tinker`.