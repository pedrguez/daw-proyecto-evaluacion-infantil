# Guía de Mantenimiento de Contenidos

El sistema utiliza un mecanismo de **Seeders** en Laravel para gestionar los contenidos curriculares (Áreas, Competencias y Criterios). Este enfoque permite que la base de datos sea "autodefinida" y fácil de actualizar.

## Cómo Añadir o Modificar Criterios

Para realizar cambios en la normativa o añadir nuevas áreas, el flujo de trabajo es el siguiente:

1.  **Edición del Seeder**: Localizar el archivo `backend/database/seeders/RubricasSeeder.php`.
2.  **Identificación del Bloque**: 
    * Para una nueva **Área**: Usar `Area::create(['nombre' => '...'])`.
    * Para una **Competencia**: Usar `Competencia::create(['area_id' => $area->id, 'texto' => '...'])`.
    * Para un **Criterio**: Usar el bloque `Criterio::create([...])` asegurando que el `competencia_id` apunte a la competencia correcta.

## Comandos de Actualización en Base de Datos

Dependiendo del entorno (Desarrollo o Producción), se utilizarán diferentes comandos para actualizar los datos:

**Opción A: Entorno de Desarrollo (Reinicio Total)**
Si estás construyendo la aplicación y quieres limpiar la base de datos entera (CUIDADO: Borra alumnos y notas):
```bash
php artisan migrate:fresh --seed
```

**Opción B: Entorno de Producción (Añadir/Actualizar sin borrar)**
Si el colegio ya está usando la app y solo has añadido un Criterio nuevo al archivo `RubricasSeeder.php`, debes usar este comando para inyectar solo los datos nuevos sin destruir las tablas existentes:
```bash
php artisan db:seed --class=RubricasSeeder
```
*(Nota técnica: Para que la Opción B no duplique áreas existentes, en el futuro el código del Seeder utilizará el método `updateOrCreate()` de Laravel en lugar de `create()`)*.

## Resolución de Problemas Frecuentes

### 4. Error 500: Session store not set on request
* **El Problema:** Al intentar enviar las credenciales al endpoint `/api/login`, Laravel arrojaba un error interno (500). Esto se debe a que las rutas bajo el grupo `api` están diseñadas para ser *stateless* (sin estado/sin memoria) y no procesan sesiones.
* **La Solución:** Se reubicó la importación de las rutas de autenticación (`require __DIR__.'/auth.php';`) eliminándola de `api.php` y colocándola en `web.php`, el cual sí cuenta con los middlewares necesarios para iniciar y mantener sesiones web.

### 5. Error 419: CSRF Token Mismatch
* **El Problema:** El Frontend obtenía correctamente la cookie en `/sanctum/csrf-cookie`, pero el servidor rechazaba la petición POST posterior (`/login`) con un error 419. Esto ocurría porque Axios no estaba devolviendo el token en las cabeceras y por restricciones de dominio cruzado en Chromium.
* **La Solución:**
  1. **Backend:** Se vació la variable `SESSION_DOMAIN=` en el archivo `.env` para permitir que Laravel gestione el dominio automáticamente en el entorno de desarrollo local.
  2. **Frontend:** Se actualizó la configuración global de Axios (`axios.ts`) añadiendo la directiva `withXSRFToken: true`, adaptándose a las nuevas exigencias de seguridad de la librería para adjuntar el token automáticamente.