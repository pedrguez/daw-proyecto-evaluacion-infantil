# Estructura de Datos: Sistema de Rúbricas

Para abandonar el "mocking" de datos en el Frontend y crear un sistema dinámico y escalable, se ha diseñado una arquitectura de base de datos relacional en PostgreSQL que refleja exactamente la jerarquía de la normativa educativa (LOMLOE).

## Arquitectura de Tablas y Relaciones (1:N)

Se han creado tres entidades principales conectadas mediante claves foráneas (Foreign Keys) con integridad referencial estricta (`onDelete('cascade')`).

### 1. Tabla `areas`
Actúa como la entidad padre de máximo nivel.
* `id`: Clave primaria.
* `nombre`: String (Ej: "Área 2. Descubrimiento y Exploración del Entorno").

### 2. Tabla `competencias`
Entidad hija de `areas`. Una área posee múltiples competencias.
* `id`: Clave primaria.
* `area_id`: Clave foránea que vincula con la tabla `areas`.
* `texto`: Text (Descripción completa de la competencia específica).

### 3. Tabla `criterios`
Entidad hija de `competencias`. Una competencia se evalúa mediante múltiples criterios.
* `id`: Clave primaria.
* `competencia_id`: Clave foránea que vincula con la tabla `competencias`.
* `identificador`: String (Ej: "1.1", "2.3").
* `texto`: Text (Descripción del criterio de evaluación).

#### Desglose de la Rúbrica
Para facilitar la consulta desde el Frontend sin necesidad de procesar JSON complejos en base de datos, los 4 niveles de la rúbrica se han normalizado en columnas independientes dentro de la tabla `criterios`:
* `rubrica_1`: Text (Poco Adecuado)
* `rubrica_2`: Text (Adecuado)
* `rubrica_3`: Text (Muy Adecuado)
* `rubrica_4`: Text (Excelente)


## Automatización de la Carga de Datos (Seeders)

Para garantizar la integridad y la portabilidad del sistema, se ha implementado un mecanismo de **Seeders** en Laravel. Esto permite regenerar toda la normativa educativa en la base de datos de forma automática, eliminando la dependencia de carga manual o inyección de datos estáticos en el Frontend.

### Flujo de trabajo implementado:
1. **Definición del modelo**: Configuración de modelos Eloquent con `$guarded = []` para permitir la asignación masiva de datos estructurados.
2. **Generación del Sembrador**: Creación de `RubricasSeeder`, una clase encargada de instanciar las entidades (`Area`, `Competencia`, `Criterio`) con los textos oficiales.
3. **Persistencia**: Ejecución mediante `php artisan db:seed`, que dispara una transacción atómica para poblar las tablas relacionadas en PostgreSQL, garantizando que el árbol de competencias esté perfectamente vinculado desde el primer segundo.