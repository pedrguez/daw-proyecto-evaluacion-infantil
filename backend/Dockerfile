FROM php:8.3-cli

# Instalamos las dependencias del sistema y el driver de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Establecemos el directorio de trabajo
WORKDIR /app

# Copiamos los archivos del proyecto
COPY . .

# Exponemos el puerto de la API
EXPOSE 8000

# Comando para encender el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
