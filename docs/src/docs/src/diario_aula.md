# Diario de Aula Digital

Este módulo permite al docente llevar un registro narrativo y cronológico de la actividad diaria en el aula, facilitando el seguimiento grupal del curso.

## Implementación Técnica

### Base de Datos (PostgreSQL)
Se ha creado la tabla `diario_aulas` mediante una migración de Laravel para asegurar la persistencia de los datos:
* `fecha`: Almacena la fecha de la entrada (Date).
* `contenido`: Almacena la descripción de la actividad (Text).

### Lógica de Negocio (Backend)
El `DiarioAulaController` gestiona dos operaciones fundamentales:
1. `index()`: Recupera todas las entradas ordenadas cronológicamente de forma descendente.
2. `store()`: Valida y persiste nuevas entradas en la bitácora.

### Interfaz de Usuario (Vue + Bootstrap)
* **Visualización:** Las entradas se presentan en tarjetas (Cards) de Bootstrap, limitando la vista principal a un máximo de 5 entradas para evitar la fatiga visual.
* **Paginación:** Sistema de navegación para consultar el histórico de 5 en 5.
* **Filtro por Calendario:** Implementación de un buscador reactivo que permite seleccionar una fecha específica para recuperar la entrada exacta de ese día.
* 