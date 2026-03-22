# Manual Técnico y de Instalación

## Entorno de Desarrollo (Linux Mint)
Para la creación de este proyecto se ha configurado un entorno basado en Linux Mint. Las herramientas base instaladas y configuradas son:

* **Control de versiones:** Git inicializado para el seguimiento del código del proyecto.
* **NVM y Node.js:** Se instaló Node.js (versión LTS 24.14.0) mediante NVM para gestionar el entorno de ejecución del cliente.
* **Docker y Docker-Compose:** Instalados de forma nativa para la futura orquestación de servicios y dependencias.
* **PHP y Composer:** Preparados para el desarrollo de la API REST con Laravel.

## Configuración del Frontend
El frontend se ha inicializado dentro de la carpeta `/frontend` utilizando la herramienta oficial de Vue.

Se ha configurado la base del proyecto para cumplir con los siguientes requisitos técnicos:
* Vue 3 haciendo uso de Composition API y SFC (Single File Components).
* Soporte estricto para TypeScript.
* Uso de Vue Router para la gestión de rutas (Página no contínua).
* Uso de Pinia para la gestión del estado y datos de la aplicación.
* ESLint y Prettier configurados para asegurar la calidad y correcta legibilidad del código fuente.