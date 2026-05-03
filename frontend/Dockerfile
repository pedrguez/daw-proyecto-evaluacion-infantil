FROM node:20-alpine

# Establecemos el directorio de trabajo
WORKDIR /app

# Copiamos el archivo de dependencias y las instalamos
COPY package*.json ./
RUN npm install

# Copiamos el resto del proyecto
COPY . .

# Exponemos el puerto de Vue
EXPOSE 5173

# Comando para arrancar Vue habilitando el acceso externo
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0" ]