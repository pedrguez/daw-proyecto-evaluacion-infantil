# Infraestructura y Despliegue con Docker

Para garantizar que la aplicación pueda ejecutarse en cualquier entorno (producción, desarrollo o en las máquinas del tribunal evaluador) sin problemas de dependencias, se ha optado por contenerizar completamente la arquitectura mediante **Docker y Docker Compose**.

## Arquitectura de Microservicios

El sistema se compone de tres servicios orquestados, separados por responsabilidad:

### 1. Servicio de Base de Datos (`db`)
- **Imagen:** `postgres:16-alpine` (Versión ultraligera optimizada para contenedores).
- **Persistencia:** Se ha implementado un volumen de datos (`db_data:/var/lib/postgresql/data`) para garantizar que la información de los usuarios, alumnos y rúbricas de evaluación no se pierda al apagar, reiniciar o destruir los contenedores.
- **Aislamiento:** La base de datos opera en una red interna de Docker, lo que añade una capa extra de seguridad.
- **Puerto publicado:** El servicio expone PostgreSQL en el puerto `5433` del host, enlazado con el puerto interno `5432` del contenedor.

### 2. Servicio de Backend / API (`backend`)
- **Imagen:** Personalizada a partir de `php:8.3-cli`.
- **Configuración:** El `Dockerfile` inyecta a nivel de sistema operativo (`apt-get`) las dependencias `libpq-dev` y compila la extensión `pdo_pgsql` de PHP, permitiendo la comunicación nativa con PostgreSQL.
- **Sincronización:** Las credenciales de conexión se inyectan dinámicamente mediante variables de entorno configuradas en el `docker-compose.yml`, apuntando al servicio interno `db` mediante `DB_HOST=db`.
- **Puerto publicado:** La API Laravel queda accesible desde el host en `http://localhost:8000`.

### 3. Servicio de Frontend (`frontend`)
- **Imagen:** `node:20-alpine`.
- **Despliegue:** Expone la interfaz de usuario de Vue 3 (Vite) utilizando el flag `--host 0.0.0.0` para aceptar peticiones desde fuera de la red de Docker.
- **Volúmenes:** Utiliza volúmenes en caliente para reflejar los cambios en el código fuente en tiempo real durante el desarrollo local, pero manteniendo la carpeta `node_modules` aislada.
- **Puerto publicado:** La aplicación Vue queda accesible desde el host en `http://localhost:5173`.

## Gestión de Migraciones y Estado Inicial
Dado que la contenerización genera instancias de bases de datos limpias y aisladas del sistema anfitrión, el protocolo para inicializar la estructura de datos tras un despliegue en limpio es ejecutar las migraciones directamente en el contenedor del backend:

```bash
# Migración de la estructura de tablas
sudo docker exec -it laravel_api php artisan migrate:fresh

# Creación manual de credenciales de acceso iniciales (Tinker)
sudo docker exec -it laravel_api php artisan tinker
```

## Resolución de Problemas (Troubleshooting)

### Conflicto de Permisos de Archivos entre Docker y el Host (Linux)


**Problema:**
Al ejecutar comandos de generación de código de Laravel (como `make:migration` o `make:controller`) a través del contenedor de Docker (`docker exec`), los nuevos archivos se crean con permisos de superusuario (`root`). Esto provoca que el editor de código (VS Code) en el entorno host (Linux) bloquee la edición o requiera contraseña de administrador para guardar los cambios.

**Causa:**
El contenedor de Docker opera internamente con privilegios de root por defecto. Al mapear el volumen hacia el sistema host, la propiedad de los archivos generados se transfiere como root, dejando al usuario local sin permisos de escritura directa.

**Solución:**
Para recuperar la propiedad de los archivos sin alterar el funcionamiento del contenedor, se ejecuta el siguiente comando en la raíz del proyecto para reasignar recursivamente la propiedad al usuario actual del sistema operativo:

```bash
sudo chown -R $USER:$USER .
```

## Despliegue automático de la documentación con GitHub Pages

Además del despliegue local del proyecto con Docker, la documentación técnica del proyecto se publica automáticamente mediante **GitHub Pages** y **GitHub Actions**. Esto permite que el libro generado con mdBook esté accesible en la web sin necesidad de compilarlo manualmente tras cada cambio.

La URL pública de la documentación es:

- <https://pedrguez.github.io/daw-proyecto-evaluacion-infantil/>

### 1. Activación de GitHub Pages

En la configuración del repositorio, dentro de **Settings > Pages**, se ha establecido el apartado **Build and deployment** con la opción **Source = GitHub Actions**. Esta configuración indica a GitHub que la publicación de la documentación no depende de una rama estática, sino de un flujo de automatización controlado por un workflow.

### 2. Workflow de publicación

El proceso de despliegue continuo está definido en el archivo `/.github/workflows/despliegue-docs.yml`.

Este workflow realiza las siguientes tareas:

- Se ejecuta automáticamente al hacer `push` sobre las ramas principales del repositorio.
- Descarga el código fuente del proyecto.
- Instala la herramienta `mdBook` en la máquina virtual de GitHub Actions.
- Compila la documentación ubicada en la carpeta `docs`.
- Empaqueta la salida HTML generada en `docs/book`.
- Publica el resultado en GitHub Pages.

### 3. Flujo de funcionamiento

El proceso automatizado de publicación sigue esta secuencia:

1. Se realiza un cambio en los archivos de documentación o en la configuración del libro.
2. Se ejecutan los comandos habituales de control de versiones (`git add`, `git commit` y `git push`).
3. GitHub detecta el `push` y lanza automáticamente el workflow `despliegue-docs.yml`.
4. El runner instala `mdBook` y ejecuta la compilación del libro con `mdbook build` dentro de la carpeta `docs`.
5. GitHub empaqueta el contenido estático generado y lo despliega en GitHub Pages.
6. La web pública de documentación queda actualizada sin intervención manual adicional.

### 4. Evidencia de validación

La validación práctica de este sistema se ha realizado mediante una ejecución correcta del workflow en la pestaña **Actions** del repositorio.

Los indicadores de verificación observados son:

- Job `deploy` completado con estado `Success`.
- Artefacto `github-pages` generado correctamente durante la ejecución.
- Publicación completada en GitHub Pages tras el proceso de build.

Como observación de mantenimiento, GitHub muestra una advertencia de deprecación relacionada con la transición futura de algunas acciones basadas en Node.js 20. Esta advertencia no impide el despliegue actual, pero conviene revisar el workflow en futuras actualizaciones del repositorio.