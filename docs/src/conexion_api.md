# Comunicación API y Tipado TypeScript

Para asegurar la robustez del sistema, se ha implementado un tipado estricto en el Frontend que refleja la estructura del Backend.

## Interfaces de TypeScript (Contratos de Datos)
Se han definido interfaces para evitar errores de "undefined" durante la carga:
- **Area:** Define el nombre y el array de competencias.
- **Competencia:** Define el texto descriptivo y sus criterios asociados.
- **Criterio:** Incluye los textos de la rúbrica (1-4) y el estado de la `nota` actual.

## Endpoints de la API
| Método | Ruta | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/rubricas` | Obtiene el árbol completo de áreas, competencias y criterios. |
| `GET` | `/api/evaluacion/{id}/{tri}` | Recupera las notas guardadas de un alumno específico. |
| `POST` | `/api/evaluacion` | Envía el paquete de calificaciones para su persistencia. |

## Solución de Problemas de Navegación
Se ha corregido el enrutamiento dinámico en `PerfilAlumnoView.vue` utilizando *Template Literals* para inyectar correctamente el ID del alumno en la URL:
```typescript
router.push(`/evaluacion/${alumno.id}`)

## Cliente HTTP (Axios) e Integración con Sanctum
Para la gestión de la autenticación se ha sustituido la API nativa `fetch` por **Axios**. Se ha creado una instancia global (`axios.ts`) configurada con la propiedad `withCredentials: true`. Esto es un requisito indispensable para la arquitectura SPA (Single Page Application), ya que permite a Vue recibir y enviar automáticamente las cookies de seguridad (CSRF tokens) generadas por Laravel Sanctum en cada petición.

## Tipado Estricto (TypeScript)
Para asegurar la robustez del Frontend y eliminar la vulnerabilidad a errores en tiempo de ejecución, se han eliminado los tipos genéricos (`any`) implementando **Interfaces** exactas que mapean la estructura de la base de datos (Modelos: `Alumno`, `Area`, `Competencia`, `Criterio`, `NotaGuardada`). Asimismo, el `ControladorPrueba` del Backend ha sido tipado fuertemente.