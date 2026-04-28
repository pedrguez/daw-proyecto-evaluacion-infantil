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