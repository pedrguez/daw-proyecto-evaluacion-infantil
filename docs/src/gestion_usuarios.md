# Gestión de Usuarios y Autenticación (Simulación ERP)

Para dar cumplimiento a los requisitos del módulo de **Sistemas de Gestión Empresarial**, se ha implementado un panel de gestión (Backoffice) que simula la arquitectura de un ERP, permitiendo la futura gestión de clientes (profesores/centros) y roles.


## Gestión de Usuarios y Autenticación (Sanctum)

El sistema utiliza Laravel Sanctum para la autenticación SPA (Single Page Application) basada en cookies.

## Sistema de Roles y Jerarquía (RBAC)

Para cumplir con los requisitos de seguridad y acceso a datos del centro educativo, se ha implementado un sistema de control de acceso basado en roles (Role-Based Access Control). 

Se ha modificado el modelo `User` de Laravel (versión 13, mediante atributos PHP 8) y su correspondiente migración para incluir la columna `rol`.

Existen dos perfiles definidos:
1. **Profesor (rol por defecto):** Acceso restringido a sus tutorías y diarios de aula.
2. **Superadministrador (Director):** Acceso global a todos los alumnos, capacidad de crear nuevos profesores y visión completa del estado del centro.

La creación de la cuenta de dirección se realiza exclusivamente por consola de servidor para evitar brechas de seguridad públicas:

```bash
# Acceder a la consola interactiva dentro del contenedor Docker
sudo docker exec -it laravel_api php artisan tinker

# Creación del Superadministrador (Director)
App\Models\User::create([
    'name' => 'Director', 
    'email' => 'director@colegio.com', 
    'password' => bcrypt('12345678'), 
    'rol' => 'admin'
]);
```

## Creación de Usuarios (Profesores)
Al no existir un formulario de registro público por motivos de seguridad del centro educativo, los usuarios con rol docente se crean internamente mediante la consola de Laravel:

```bash
# Acceder a la consola interactiva dentro del contenedor Docker
sudo docker exec -it laravel_api php artisan tinker

# Comando para instanciar un nuevo profesor
App\Models\User::create([
    'name' => 'Nombre del Profesor', 
    'email' => 'correo@colegio.com', 
    'password' => bcrypt('contraseña_segura')
]);
 ```

## Arquitectura de Seguridad
Dado que el proyecto utiliza una arquitectura desacoplada (Frontend en Vue 3 y Backend en Laravel), se ha descartado el uso de sistemas de plantillas monolíticos (Blade). En su lugar, se ha implementado la capa de seguridad utilizando:

1. **Laravel Breeze (Modo API):** Se encarga de proveer todo el *scaffolding* (rutas y controladores) para el registro, inicio de sesión y cierre de sesión.
2. **Laravel Sanctum:** Actúa como el sistema de protección mediante tokens de la API, garantizando que el Frontend (Vue) se comunique de forma segura y autenticada con el Backend mediante peticiones SPA (Single Page Application).

## Configuración del Modelo de Usuario
Se ha modificado el modelo principal de la base de datos (`User.php`) añadiendo el trait `HasApiTokens` para permitir la emisión y validación de credenciales en la API.

```bash
composer require laravel/breeze --dev
php artisan breeze:install api
```

## Protección de Rutas en el Frontend (Navigation Guards)

Para garantizar la integridad del panel de gestión (SSG) y evitar el acceso no autorizado a los datos de los alumnos, se ha implementado un sistema de protección de rutas en el Frontend utilizando las capacidades avanzadas de **Vue Router**.

1. **Gestión de Estado de Sesión:** Tras una autenticación exitosa mediante la API de Laravel, el Frontend almacena un indicador de sesión en el `localStorage` del navegador.
2. **Navigation Guards:** Se ha configurado un interceptor global (`router.beforeEach`) en `index.ts`. Este guardia verifica de forma reactiva la propiedad `meta: { requiresAuth: true }` de cada ruta. 
3. **Redirección Segura:** Si un usuario sin credenciales válidas intenta forzar la navegación hacia una ruta protegida (ej. `/alumnos`), el guardia aborta la navegación y lo redirige automáticamente a la vista raíz de Login (`/`).
4. **Renderizado Condicional:** El menú de navegación principal (`App.vue`) utiliza directivas `v-if` vinculadas al estado de autenticación para mostrar u ocultar los enlaces de acceso dinámicamente, mejorando la usabilidad y la seguridad visual de la interfaz.

## Refactorización de Accesibilidad y Coherencia (UI/UX)
Para cumplir con los estándares de usabilidad web y accesibilidad, se han realizado los siguientes ajustes en el diseño del Frontend:
1. **Coherencia Visual:** Se han unificado los componentes de navegación ("Botones de Volver") y las tarjetas del Dashboard, eliminando fondos de alto impacto (negros/colores saturados) para evitar problemas de contraste y facilitar la lectura a usuarios con daltonismo.
2. **Jerarquía Tipográfica:** Se ha aumentado el peso y tamaño de los encabezados (`h1`, `h2`) en las vistas de evaluación para guiar correctamente el flujo visual del usuario frente a los datos numéricos.
3. **Limpieza de Navegación:** Se ha eliminado la ruta genérica de "Evaluación" del menú principal superior, ya que arquitectónicamente la evaluación depende estrictamente del contexto de un alumno seleccionado (navegación jerárquica).

## Troubleshooting: Error 401 (Unauthorized) en Login
Durante el despliegue con Docker, si el frontend (Vue) y el backend (Laravel) operan en puertos distintos, puede producirse un rechazo de cookies por políticas de CORS y dominios stateful.

Solución aplicada:
Se deben configurar estrictamente las variables de entorno en el archivo `.env` del backend para declarar al frontend como una aplicación de confianza:

```env
SESSION_DOMAIN=
SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
FRONTEND_URL=http://localhost:5173
```

`SESSION_DOMAIN` debe dejarse vacío para evitar conflictos de resolución en localhost.

Tras cualquier cambio en estas variables, es obligatorio purgar la caché de configuración:

```bash
sudo docker exec -it laravel_api php artisan optimize:clear
```