# Motor de Evaluación y Gestión Integral (CRUD)

Esta sección documenta la implementación del núcleo lógico de la aplicación: el sistema de calificación interactivo y la finalización de las operaciones CRUD (Crear, Leer, Actualizar, Borrar) para la entidad Alumno.

## 1. Rúbrica de Evaluación Interactiva (UX/UI)

Se ha diseñado una interfaz de usuario avanzada para facilitar la labor docente, sustituyendo la evaluación tradicional numérica por un sistema visual de rúbricas basado en la normativa LOMLOE.

### Arquitectura de Datos Frontend (Mocking)
Para estructurar la información, se ha implementado un árbol de datos reactivo en Vue (`EvaluacionView.vue`) que respeta la jerarquía oficial:
* [cite_start]**Área** (ej. *Descubrimiento y Exploración del Entorno*) [cite: 1, 30]
  * [cite_start]**Competencia Específica** [cite: 12, 13]
    * [cite_start]**Criterio de Evaluación** [cite: 6, 7]
      * [cite_start]**Rúbrica** (4 niveles de logro con descripciones específicas). [cite: 66, 67]

### Lógica Computada (Reactividad)
El sistema prescinde de botones tradicionales. Cada celda de la rúbrica actúa como un componente interactivo que, al ser seleccionado:
1. Aplica un código de colores semántico (`#fee2e2` para Poco Adecuado, `#e0e7ff` para Excelente).
2. Oculta el valor numérico interno (1 a 4).
3. Recalcula instantáneamente la nota media del Área utilizando `computed()` properties de Vue, ignorando los criterios no evaluados (nulos).
4. Traduce dinámicamente el valor decimal resultante a la terminología oficial ("Adecuado", "Excelente") mediante una píldora visual en la cabecera.

## 2. Finalización del CRUD: Edición y Baja

La vista `PerfilAlumnoView.vue` se ha dotado de interactividad bidireccional, permitiendo al usuario modificar la información existente.

### Lógica de Actualización (PUT)
Se ha integrado un "Modo Edición" activado por el usuario. Al habilitarse:
1. Las etiquetas de texto se transforman dinámicamente en inputs de formulario (mediante directivas `v-if` / `v-else`).
2. Al confirmar, se emite una petición asíncrona (método HTTP `PUT`) hacia el endpoint `/api/alumnos/{id}`.
3. El controlador de Laravel localiza el registro mediante Eloquent (`Alumno::find($id)`) y persiste las modificaciones.

### Lógica de Borrado y Seguridad (DELETE)
Para la operación de "Dar de baja", se han implementado dos capas de seguridad:
1. **Confirmación nativa:** Vue invoca la API del navegador (`window.confirm`) para prevenir clics accidentales.
2. **Redirección de flujo:** Tras enviar la petición `DELETE` a Laravel, el framework Vue Router (`useRouter()`) intercepta la promesa de éxito y redirige automáticamente al usuario de vuelta al índice principal (`/alumnos`), evitando "pantallas fantasma".
   
# Lógica del Motor de Evaluación

El sistema ha pasado de un modelo estático a un modelo **idempotente y dinámico** conectado con el Backend.

## 1. Carga Dinámica de Calificaciones
Al acceder a la interfaz o cambiar el trimestre, el sistema ejecuta una petición `GET` al endpoint `/api/evaluacion/{id}/{trimestre}`. 
- La lógica recorre el árbol de la rúbrica y "pinta" las notas existentes.
- Se utiliza un `watch` en Vue para reaccionar al cambio de trimestre y recargar los datos automáticamente.

## 2. Persistencia Idempotente (Guardado)
El proceso de guardado utiliza la función `updateOrCreate` de Eloquent en Laravel.
- **Flujo:** El frontend envía un paquete JSON con todas las notas marcadas.
- **Acción:** El servidor busca si ya existe un registro con ese `alumno_id`, `criterio_id` y `trimestre`. 
  - Si existe: Actualiza el valor.
  - Si no existe: Crea el nuevo registro.