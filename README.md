# daw-proyecto-evaluacion-infantil

Proyecto final de DAW para la evaluación en Educación Infantil.

La aplicación está compuesta por:

- Frontend en Vue 3 + TypeScript
- Backend API en Laravel 13
- Base de datos PostgreSQL
- Entorno de desarrollo y ejecución con Docker Compose

## Arranque rápido

Desde la raíz del proyecto:

```bash
sudo docker compose up -d --build
sudo docker compose ps
```

Servicios disponibles:

- Frontend: http://localhost:5173
- Backend: http://localhost:8000
- PostgreSQL: puerto 5433

Para detener el entorno:

```bash
sudo docker compose down
```

## Documentación

La documentación técnica completa está en la carpeta `docs/` y se genera con mdBook.

- Índice fuente: [docs/src/SUMMARY.md](docs/src/SUMMARY.md)
- Workflow de publicación: [/.github/workflows/despliegue-docs.yml](.github/workflows/despliegue-docs.yml)
