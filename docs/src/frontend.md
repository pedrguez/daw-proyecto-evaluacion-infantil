# Documentación Técnica: Refactorización del Frontend

## Resumen de la Intervención
Durante la fase final de desarrollo, se ha llevado a cabo una refactorización integral del frontend (Vue 3 + Vite) para asegurar un entorno de producción estable, un diseño profesional unificado y una correcta comunicación segura con el backend en Laravel (Sanctum).

## 1. Refactorización UI/UX
* **Migración a Bootstrap 5:** Se han eliminado los estilos CSS manuales y redundantes, sustituyéndolos por el sistema de utilidades y rejillas nativo de Bootstrap 5. Esto garantiza un diseño *responsive* (adaptable a dispositivos móviles) y una coherencia visual estricta en toda la aplicación.
* **Componentes Limpios:** Eliminación sistemática de sombras innecesarias (`shadow`) y contenedores redundantes en vistas críticas (como el Boletín de Calificaciones y la Rúbrica de Evaluación) para priorizar la legibilidad de la información (diseño plano/flat).

## 2. Vistas Dinámicas y Componentes
* **Diario de Aula:** Implementación de tarjetas dinámicas (*Cards*) con un diseño de línea temporal estructurada y filtros de búsqueda reactivos por fecha.
* **Panel de Evaluación:** Reestructuración de la rúbrica de calificación mediante navegación por pestañas (*Nav-Tabs*) para moverse ágilmente entre áreas evaluables.
* **Sistema CRUDs (Personal y Familias):** Sustitución de flujos de edición rígidos por ventanas emergentes superpuestas (*Modals*) integradas de Bootstrap. Esto mejora sustancialmente la experiencia de usuario al permitir ediciones (ej. modificación de correos o reseteos de contraseña) sin recargar la página ni perder el contexto de la tabla.

## 3. Gestión de Estado y Seguridad
* **Integración de Axios:** Se ha migrado toda la lógica de peticiones asíncronas de la API `fetch` nativa a una instancia preconfigurada de `Axios`.
* **Soporte Sanctum:** Este cambio garantiza el envío automático de credenciales y cookies de sesión (`withCredentials: true`), superando el middleware de seguridad (`auth:sanctum`) de Laravel y solucionando errores de tipo `401 Unauthenticated` al crear o evaluar alumnos.

## 4. Optimización y Despliegue
* **Limpieza de Código Boilerplate:** Eliminación de archivos y componentes autogenerados por Vite (`HomeView.vue`, `AboutView.vue`, iconos base) que no aportan valor a la lógica de negocio.
* **Desactivación de Herramientas de Desarrollo:** Extracción del plugin `vite-plugin-vue-devtools` del archivo de configuración `vite.config.ts` y del panel inferior del navegador, preparando el entorno para su compilación final a producción.

## 5. Diseño Responsive, Accesibilidad y Usabilidad
El frontend se ha desarrollado con Bootstrap 5 y una estructura responsive adaptada a móvil, tablet y escritorio. Se han aplicado criterios de legibilidad, navegación clara, jerarquía visual y consistencia entre pantallas para facilitar el uso del sistema en el entorno educativo.

Como comprobación automática, se ha realizado una auditoría con Lighthouse sobre una de las vistas principales de la aplicación, obteniendo una puntuación de `91` en accesibilidad y `100` en buenas prácticas. Estos valores sirven como evidencia de calidad técnica, aunque no sustituyen una auditoría formal completa de conformidad WCAG.

## 6. Sostenibilidad y Relación con ODS
El proyecto se ha planteado como una aplicación web ligera, modular y optimizada, evitando complejidad innecesaria y favoreciendo un consumo razonable de recursos tanto en cliente como en servidor.

Desde el punto de vista educativo y social, la digitalización del proceso de evaluación mejora la organización del trabajo docente, reduce tareas manuales y disminuye la dependencia de documentación en papel.

Por ello, el proyecto se relaciona principalmente con el **ODS 4: Educación de calidad**, al apoyar el seguimiento y la evaluación del alumnado mediante una herramienta digital, y de forma complementaria con el **ODS 12: Producción y consumo responsables**, al favorecer procesos de gestión más eficientes.