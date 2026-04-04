# Hoja de Comandos Útiles

En este documento se recopilan todos los comandos de terminal utilizados para configurar el entorno de desarrollo del proyecto.

## 1. Documentación (mdBook)
Comandos utilizados para instalar la herramienta de apuntes de forma manual y limpia.

```bash
# 1. Descargar la versión precompilada oficial
wget [https://github.com/rust-lang/mdBook/releases/download/v0.4.37/mdbook-v0.4.37-x86_64-unknown-linux-gnu.tar.gz](https://github.com/rust-lang/mdBook/releases/download/v0.4.37/mdbook-v0.4.37-x86_64-unknown-linux-gnu.tar.gz)

# 2. Descomprimir el archivo descargado
tar -xzf mdbook-v0.4.37-x86_64-unknown-linux-gnu.tar.gz

# 3. Mover el programa a la carpeta del sistema para usarlo en cualquier sitio
sudo mv mdbook /usr/local/bin/

# 4. Borrar el archivo comprimido (Limpieza)
rm mdbook-v0.4.37-x86_64-unknown-linux-gnu.tar.gz

# 5. Inicializar la estructura del libro (Se ejecuta en la raíz del proyecto)
mdbook init docs

# 6. Arrancar el servidor local para ver la web de apuntes (Dentro de la carpeta docs)
mdbook serve -o
```

## 2. Control de Versiones (Git)
Comandos básicos para guardar el progreso.

```bash
# 1. Preparar todos los archivos modificados para guardarlos
git add .

# 2. Crear el punto de guardado (Commit) con un mensaje descriptivo
git commit -m "Escribe aquí tu mensaje de guardado"
```

## 3. Frontend (Vue.js)
Comandos básicos de ejecución del entorno de cliente.

```bash
# 1. Entrar a la carpeta del frontend
cd frontend

# 2. Encender el servidor local de Vue (con Hot-Reload)
npm run dev
```

## 4. Entorno Backend (Extensiones de PHP)
Comandos para instalar las piezas vitales de PHP que Linux Mint no trae por defecto.

```bash
# 1. Instalar extensiones para procesamiento de documentos y XML
sudo apt install php-xml php8.3-xml -y

# 2. Instalar extensión para lectura de caracteres especiales (tildes, eñes)
sudo apt install php-mbstring php8.3-mbstring -y
```

## 5. Backend (Laravel)
Instalación del framework y ejecución de constructores de base de datos.

```bash
# 1. Crear el proyecto Laravel dentro de una nueva carpeta llamada 'backend'
composer create-project laravel/laravel backend

# 2. Entrar a la carpeta del backend
cd backend

# 3. Ejecutar las migraciones (Crear las tablas en PostgreSQL)
php artisan migrate
```

## 6. Base de Datos (PostgreSQL)
Comandos para interactuar con el motor de la base de datos directamente desde la terminal de Linux.

```bash
# 1. Entrar al gestor de bases de datos como administrador (Pedirá contraseña de Linux)
sudo -u postgres psql
```

```sql
-- 2. Crear la base de datos en blanco (El punto y coma es obligatorio)
CREATE DATABASE evaluacion_infantil;

-- 3. Cambiar la contraseña del usuario principal por seguridad (Ejemplo: '1111')
ALTER USER postgres WITH PASSWORD '1111';

-- 4. Salir de la terminal de PostgreSQL
\q
```

## 7. Herramienta Gráfica (DBeaver)
Comandos para descargar e instalar el cliente visual de bases de datos.

```bash
# 1. Descargar el instalador oficial más reciente
wget [https://dbeaver.io/files/dbeaver-ce_latest_amd64.deb](https://dbeaver.io/files/dbeaver-ce_latest_amd64.deb)

# 2. Ejecutar la instalación del paquete
sudo dpkg -i dbeaver-ce_latest_amd64.deb

# 3. Reparar posibles dependencias faltantes en el sistema
sudo apt install -f

# 4. Borrar el instalador (Limpieza)
rm dbeaver-ce_latest_amd64.deb
```