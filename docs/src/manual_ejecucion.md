# Manual de Ejecución del Proyecto

Este manual describe los pasos necesarios para arrancar el proyecto en un entorno local usando Docker Compose, verificar que los servicios están activos y detenerlos correctamente.

## Requisitos previos

- Docker instalado.
- Docker Compose disponible en el sistema.
- Terminal abierta en la raíz del proyecto.

## Arranque completo con Docker

Esta modalidad levanta la base de datos, el backend Laravel y el frontend Vue con un solo comando.

1. Abre una terminal en la carpeta raíz del proyecto.
2. Levanta los contenedores en segundo plano:

```bash
sudo docker compose up -d --build
```

3. Comprueba que los servicios están activos:

```bash
sudo docker compose ps
```

Si todo ha arrancado correctamente, deberían aparecer estos servicios:

- `postgres_db` en el puerto `5433`.
- `laravel_api` en el puerto `8000`.
- `vue_app` en el puerto `5173`.

## Inicialización de datos

Si se necesita cargar la estructura oficial de rúbricas y criterios en una base de datos vacía, ejecuta el seeder desde el contenedor del backend una vez que el sistema ya esté levantado:

```bash
sudo docker exec -it laravel_api php artisan db:seed --class=RubricasSeeder
```

## Verificación del sistema

Una vez arrancado el proyecto, puedes comprobar los accesos principales en estas direcciones:

- Frontend: `http://localhost:5173`
- Backend: `http://localhost:8000`
- Base de datos PostgreSQL: puerto `5433`

## Apagado del sistema

Para detener todos los servicios y liberar los puertos utilizados:

```bash
sudo docker compose down
```

## Notas

- Si los contenedores ya existen y no necesitas reconstruir imágenes, puedes usar `sudo docker compose up -d`.
- Si solo quieres revisar el estado de los contenedores, usa `sudo docker compose ps`.
- Si aparece un conflicto de puertos, revisa qué proceso local está ocupando `5173`, `8000` o `5433` antes de volver a levantar el proyecto.
