# Gestión de Alumnos: Integración Frontend y Backend

Para la gestión integral de la entidad "Alumno", se ha desarrollado un flujo completo de comunicación bidireccional entre la interfaz de usuario (Vue.js) y la API REST (Laravel), implementando las operaciones de lectura (GET) y escritura (POST).

## 1. Adaptación de la Base de Datos
Se detectó la necesidad de incluir un campo para "Observaciones" médicas o académicas iniciales. Utilizando el sistema de migraciones de Laravel, se modificó el esquema estructural y se reconstruyó la base de datos de forma automatizada:

```bash
# Reconstrucción completa de las tablas leyendo el nuevo esquema
php artisan migrate:fresh
```

El método `up()` de la migración incluye ahora el campo de tipo texto (`nullable` para permitir registros iniciales sin observaciones):
```php
$table->text('observaciones')->nullable();
```

## 2. Lógica del Controlador (API REST)
El controlador `ControladorPrueba` se ha expandido para manejar el flujo de datos real utilizando el ORM Eloquent.

* **Petición GET (`/api/alumnos`):** Recupera todos los registros de la base de datos utilizando `Alumno::all()` y los retorna estandarizados en formato JSON.
* **Petición POST (`/api/alumnos`):** Instancia un nuevo objeto `Alumno`, mapea los datos recibidos en el cuerpo de la petición (`$request`) y los persiste en PostgreSQL mediante el método `save()`.

## 3. Interfaz de Usuario Reactiva (Vue.js)
La vista `ListaAlumnosView.vue` se diseñó siguiendo el principio de Single Page Application (SPA). 

### Reactividad y Estado
Se declararon variables reactivas (`ref`) para mantener el estado de la aplicación sincronizado con la interfaz:
* `alumnos`: Almacena el array de datos proveniente del servidor.
* `nuevoAlumno`: Un objeto que captura en tiempo real las pulsaciones del usuario en el formulario mediante directivas `v-model`.

### Flujo de Ejecución Asíncrono
1. **Montaje (`onMounted`):** Al cargar la pantalla, Vue ejecuta una petición `fetch` al endpoint GET de Laravel para poblar la tabla de observaciones automáticamente.
2. **Envío del Formulario (`@submit.prevent`):** Al guardar, se intercepta el comportamiento por defecto del navegador. Se lanza un `fetch` de tipo POST con los datos serializados (`JSON.stringify`).
3. **Sincronización:** Tras recibir el código de éxito del servidor HTTP, Vue limpia el formulario visual y vuelve a ejecutar la petición GET, actualizando la tabla instantáneamente sin refrescar la página web.