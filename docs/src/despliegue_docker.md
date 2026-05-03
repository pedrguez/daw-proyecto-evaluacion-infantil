# Infraestructura y Despliegue con Docker

Para garantizar que la aplicación pueda ejecutarse en cualquier entorno (producción, desarrollo o en las máquinas del tribunal evaluador) sin problemas de dependencias, se ha optado por contenerizar completamente la arquitectura mediante **Docker y Docker Compose**.

## Arquitectura de Microservicios

El sistema se compone de tres servicios orquestados, separados por responsabilidad:

1. **Servicio de Base de Datos (`db`)**: 
   - Utiliza la imagen oficial `postgres:16-alpine`.
   - Implementa un volumen persistente (`db_data`) para garantizar que la información de los alumnos y rúbricas no se pierda al reiniciar o destruir el contenedor.

2. **Servicio de Backend (`backend`)**:
   - Construido a partir de una imagen personalizada basada en `php:8.3-cli`.
   - Se compila inyectando a nivel de sistema operativo (`apt-get`) los drivers `libpq-dev` y la extensión PHP `pdo_pgsql`, esenciales para la comunicación con PostgreSQL.
   - El servicio se levanta usando el servidor integrado de Artisan, mapeando el puerto 8000 y configurando las variables de entorno para que apunten al *hostname* del contenedor de la base de datos (`DB_HOST=db`).

3. **Servicio de Frontend (`frontend`)**:
   - Utiliza la imagen ultraligera `node:20-alpine`.
   - Mapea un volumen en caliente para el código fuente, pero aísla internamente la carpeta `node_modules`. Esto permite que el entorno Node.js se ejecute eficientemente dentro de Alpine Linux.
   - Vite es expuesto al exterior mediante el flag `--host` en el puerto 5173.

Esta estructura cumple con los objetivos del módulo de **Despliegue de Aplicaciones Web (DPL)**, aislando los entornos y garantizando la escalabilidad.