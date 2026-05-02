# Modelado de Base de Datos y ORM

En lugar de interactuar directamente con el gestor de PostgreSQL mediante sentencias SQL crudas, el diseño de la base de datos se ha orquestado utilizando **Eloquent**, el ORM (Object-Relational Mapper) integrado en Laravel.

Esta decisión arquitectónica aporta dos grandes ventajas para el mantenimiento del proyecto:
1. **Abstracción de la Base de Datos:** Permite interactuar con los registros como si fueran objetos de PHP, agilizando el desarrollo.
2. **Control de Versiones del Esquema:** A través de las **Migraciones**, la estructura de la base de datos queda registrada en el código fuente, garantizando que el entorno de desarrollo local y el servidor de producción sean siempre idénticos.

## 1. Creación de la Entidad "Alumno"

Para generar el representante de la tabla en el código (Modelo) y su plano estructural (Migración) de forma simultánea, se utilizó la interfaz de línea de comandos de Artisan:

```bash
php artisan make:model Alumno -m
```

### El plano de la tabla (Migración)

En el archivo generado (`database/migrations/..._create_alumnos_table.php`), se definió estrictamente el tipado de los datos que conforman a un alumno. El método `up()` contiene la estructura que Laravel traducirá a PostgreSQL:

```php
public function up(): void
{
    Schema::create('alumnos', function (Blueprint $table) {
        $table->id(); // Llave primaria autoincremental
        $table->string('nombre');
        $table->string('apellidos');
        $table->date('fecha_nacimiento');
        $table->string('curso');
        $table->timestamps(); // Genera automáticamente created_at y updated_at
    });
}
```

## 2. Ejecución y Verificación

Una vez definido el esquema, se materializó en el motor de PostgreSQL mediante el comando de migración:

```bash
php artisan migrate
```

**Verificación Visual:**
Utilizando el cliente gráfico **DBeaver**, se confirmó que Laravel conectó exitosamente con el esquema `public` de la base de datos `evaluacion_infantil`, creando la tabla `alumnos` con los campos solicitados.

## 3. Tablas Nativas del Sistema (Scaffolding)

Al visualizar la base de datos, se observa la presencia de múltiples tablas adicionales que no fueron creadas manualmente (ej. `users`, `sessions`, `migrations`, `personal_access_tokens`). 

Esto obedece a la arquitectura base de Laravel 11, que incluye el *scaffolding* (andamiaje) esencial para el funcionamiento de una aplicación web moderna:
* **`migrations`:** Actúa como registro interno del framework para controlar qué migraciones ya han sido ejecutadas, evitando duplicidades.
* **`users`, `sessions`, `password_reset_tokens`:** Conforman la base del sistema de autenticación de usuarios.
* **`personal_access_tokens`:** Gestiona los tokens de seguridad de la API (mediante Laravel Sanctum) para proteger la comunicación entre el Frontend y el Backend.
* **`jobs`, `cache`:** Tablas destinadas al rendimiento, manejo de tareas en segundo plano y almacenamiento temporal.

## 4. Guía de Referencia: Añadir nuevos campos a una tabla

Cuando el proyecto ya está en marcha y necesitamos añadir un nuevo dato a recoger (ej. "Observaciones" o "Alergias"), el flujo de trabajo afecta a ambas capas de la aplicación:

### 1. Backend (Laravel - La Base de Datos)
1. **Modificar la Migración:** Ir a `database/migrations/..._create_alumnos_table.php` y añadir la nueva columna en la función `up()`. Ejemplo: `$table->text('observaciones')->nullable();`
2. **Reconstruir la Base de Datos:** Ejecutar en terminal `php artisan migrate:fresh` para que Laravel borre y vuelva a crear las tablas leyendo el nuevo plano.
3. **Actualizar el Controlador:** Ir a `app/Http/Controllers/ControladorPrueba.php` y en la función de guardado, decirle a Laravel que recoja el nuevo dato: `$alumno->observaciones = $request->observaciones;`.

### 2. Frontend (Vue.js - La Interfaz)
1. **Actualizar la Variable Reactiva:** En el `<script setup>`, añadir el nuevo campo al estado inicial del formulario para que Vue sepa que existe: `observaciones: ''`.
2. **Actualizar el Formulario HTML:** Añadir el `<input>` o `<textarea>` correspondiente y vincularlo con `v-model="nuevoAlumno.observaciones"`.
3. **Actualizar la Tabla Visual:** Añadir una nueva columna `<th>` en la cabecera y su celda `<td>` correspondiente para pintar el dato que devuelve el servidor.

## Tabla: Notas (Evaluaciones)
Esta tabla actúa como puente entre los alumnos y los criterios de evaluación, permitiendo almacenar una calificación única por trimestre.

### Estructura de la tabla `notas`
| Campo | Tipo | Descripción |
| :--- | :--- | :--- |
| `id` | BigInt | Clave primaria. |
| `alumno_id` | Foreign Key | Relación con la tabla `alumnos` (onDelete: cascade). |
| `criterio_id` | Foreign Key | Relación con la tabla `criterios` (onDelete: cascade). |
| `trimestre` | Integer | Identificador del periodo (1, 2 o 3). |
| `valor` | Integer | Calificación numérica (1 a 4). |

### Restricción de Integridad (Unique Constraint)
Se ha implementado una clave única compuesta para evitar duplicidad de datos:
`UNIQUE(alumno_id, criterio_id, trimestre)`
Esto garantiza que un alumno no pueda tener dos notas diferentes para el mismo criterio en el mismo periodo.

## Normativa Oficial (LOMLOE)
El sistema cuenta con un `RubricasSeeder` que inyecta automáticamente la estructura curricular completa de Educación Infantil (Áreas 1, 2 y 3) basándose en los textos oficiales, garantizando que el sistema esté listo para producción sin necesidad de carga manual. `php artisan db:seed --class=RubricasSeeder`