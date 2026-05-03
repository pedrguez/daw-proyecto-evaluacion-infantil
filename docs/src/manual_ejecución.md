# Manual de Ejecución del Proyecto

Este manual detalla los comandos exactos para arrancar el proyecto tras un periodo de inactividad o en un ordenador nuevo. Existen dos modalidades de ejecución:

## Modalidad A: Arranque completo con Docker (Recomendado)
Esta modalidad levanta la base de datos, el servidor backend y el frontend con un solo comando, sin necesidad de instalar PHP ni Node.js en la máquina local.

1. Abre una terminal en la carpeta raíz del proyecto.
2. Ejecuta el comando para encender y ensamblar los contenedores en segundo plano:
   ```bash
   docker compose up -d --build

3. Para apagar todo el sitema 
   ```bash
   docker compose down