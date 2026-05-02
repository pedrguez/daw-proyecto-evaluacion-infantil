# Gestión de Usuarios y Autenticación (Simulación ERP)

Para dar cumplimiento a los requisitos del módulo de **Sistemas de Gestión Empresarial**, se ha implementado un panel de gestión (Backoffice) que simula la arquitectura de un ERP, permitiendo la futura gestión de clientes (profesores/centros) y roles.

## Arquitectura de Seguridad
Dado que el proyecto utiliza una arquitectura desacoplada (Frontend en Vue 3 y Backend en Laravel), se ha descartado el uso de sistemas de plantillas monolíticos (Blade). En su lugar, se ha implementado la capa de seguridad utilizando:

1. **Laravel Breeze (Modo API):** Se encarga de proveer todo el *scaffolding* (rutas y controladores) para el registro, inicio de sesión y cierre de sesión.
2. **Laravel Sanctum:** Actúa como el sistema de protección mediante tokens de la API, garantizando que el Frontend (Vue) se comunique de forma segura y autenticada con el Backend mediante peticiones SPA (Single Page Application).

## Configuración del Modelo de Usuario
Se ha modificado el modelo principal de la base de datos (`User.php`) añadiendo el trait `HasApiTokens` para permitir la emisión y validación de credenciales en la API.

composer require laravel/breeze --dev
php artisan breeze:install api