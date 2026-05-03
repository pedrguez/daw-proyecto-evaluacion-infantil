# Gestión de Usuarios y Autenticación (Simulación ERP)

Para dar cumplimiento a los requisitos del módulo de **Sistemas de Gestión Empresarial**, se ha implementado un panel de gestión (Backoffice) que simula la arquitectura de un ERP, permitiendo la futura gestión de clientes (profesores/centros) y roles.

## Arquitectura de Seguridad
Dado que el proyecto utiliza una arquitectura desacoplada (Frontend en Vue 3 y Backend en Laravel), se ha descartado el uso de sistemas de plantillas monolíticos (Blade). En su lugar, se ha implementado la capa de seguridad utilizando:

1. **Laravel Breeze (Modo API):** Se encarga de proveer todo el *scaffolding* (rutas y controladores) para el registro, inicio de sesión y cierre de sesión.
2. **Laravel Sanctum:** Actúa como el sistema de protección mediante tokens de la API, garantizando que el Frontend (Vue) se comunique de forma segura y autenticada con el Backend mediante peticiones SPA (Single Page Application).

## Configuración del Modelo de Usuario
Se ha modificado el modelo principal de la base de datos (`User.php`) añadiendo el trait `HasApiTokens` para permitir la emisión y validación de credenciales en la API.

`composer require laravel/breeze --dev`
`php artisan breeze:install api`

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