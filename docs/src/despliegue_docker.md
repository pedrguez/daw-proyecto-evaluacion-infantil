# Infraestructura y Despliegue con Docker

Para garantizar que la aplicación pueda ejecutarse en cualquier entorno (producción, desarrollo o en las máquinas del tribunal evaluador) sin problemas de dependencias, se ha optado por contenerizar completamente la arquitectura mediante **Docker y Docker Compose**.

## Arquitectura de Microservicios

El sistema se compone de tres servicios orquestados, separados por responsabilidad:

### 1. Servicio de Base de Datos (`db`)
- **Imagen:** `postgres:16-alpine` (Versión ultraligera optimizada para contenedores).
- **Persistencia:** Se ha implementado un volumen de datos (`db_data:/var/lib/postgresql/data`) para garantizar que la información de los usuarios, alumnos y rúbricas de evaluación no se pierda al apagar, reiniciar o destruir los contenedores.
- **Aislamiento:** La base de datos opera en una red interna de Docker, lo que añade una capa extra de seguridad.

### 2. Servicio de Backend / API (`backend`)
- **Imagen:** Personalizada a partir de `php:8.3-cli`.
- **Configuración:** El `Dockerfile` inyecta a nivel de sistema operativo (`apt-get`) las dependencias `libpq-dev` y compila la extensión `pdo_pgsql` de PHP, permitiendo la comunicación nativa con PostgreSQL.
- **Sincronización:** Las credenciales de conexión se inyectan dinámicamente mediante variables de entorno configuradas en el `docker-compose.yml`, apuntando al hostname interno `postgres_db`.

### 3. Servicio de Frontend (`frontend`)
- **Imagen:** `node:20-alpine`.
- **Despliegue:** Expone la interfaz de usuario de Vue 3 (Vite) utilizando el flag `--host 0.0.0.0` para aceptar peticiones desde fuera de la red de Docker.
- **Volúmenes:** Utiliza volúmenes en caliente para reflejar los cambios en el código fuente en tiempo real durante el desarrollo local, pero manteniendo la carpeta `node_modules` aislada.

## Gestión de Migraciones y Estado Inicial
Dado que la contenerización genera instancias de bases de datos limpias y aisladas del sistema anfitrión, el protocolo para inicializar la estructura de datos tras un despliegue en limpio es ejecutar las migraciones directamente en el contenedor del backend:

```bash
# Migración de la estructura de tablas
sudo docker exec -it laravel_api php artisan migrate:fresh

# Creación manual de credenciales de acceso iniciales (Tinker)
sudo docker exec -it laravel_api php artisan tinker