# Arquitectura de Comunicación: API REST vs MVC Tradicional

En el desarrollo de este proyecto, se ha optado por una arquitectura moderna de aplicaciones web desacopladas, separando estrictamente el Frontend (Vue.js) del Backend (Laravel).

## Justificación Técnica para el Tribunal
A diferencia de un enfoque monolítico tradicional (donde el framework de backend como Laravel se encarga de procesar los datos y además de "dibujar" las vistas HTML mediante motores como *Blade*), este proyecto cumple con el requisito de ser una **SPA (Single Page Application)**. 

Para lograrlo, la comunicación entre ambos sistemas se realiza exclusivamente a través de una **API REST**.

1. **El Backend (Laravel - Puerto 8000):** Actúa únicamente como proveedor de datos y gestor de seguridad e interacciones con la base de datos PostgreSQL. Sus respuestas nunca contienen diseño (HTML/CSS), sino información pura formateada en **JSON**.
2. **El Frontend (Vue.js - Puerto 5173):** Actúa como el cliente de la API. Realiza peticiones asíncronas HTTP (usando `fetch` o `axios`) al backend, recibe el JSON, y actualiza la interfaz de usuario de forma reactiva sin necesidad de recargar la página del navegador.

---

## 1. Configuración del Backend (Laravel API)

Las versiones recientes de Laravel (v11+) instalan el sistema con las rutas API desactivadas por defecto para optimizar el rendimiento. Se procedió a su activación y a la creación del primer *endpoint* de prueba.

### Comandos de inicialización:

`php artisan install:api`
(Activa el entorno API y publica el archivo routes/api.php)

`php artisan make:controller ControladorPrueba`
(Crea un controlador específico para gestionar la petición)

### Código del Controlador (`app/Http/Controllers/ControladorPrueba.php`):
En lugar de retornar una vista tradicional, el controlador devuelve una respuesta JSON estandarizada:

```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ControladorPrueba extends Controller
{
    public function Saludar() {
        return response()->json([
            'mensaje' => '¡Hola! Soy tu ControladorPrueba de Laravel. Nuestra API funciona perfecto.'
        ]);
    }
}
?>
```

### Definición de la Ruta (`routes/api.php`):
Se expuso el controlador a través de una URL pública bajo el prefijo `/api`:

```php
<?php
use App\Http\Controllers\ControladorPrueba;
Route::get('/prueba', [ControladorPrueba::class, 'Saludar']);
?>
```

---

## 2. Consumo desde el Frontend (Vue.js)

En la interfaz gráfica, se configuró la vista del *Dashboard* (`DashboardView.vue`) para que, en el momento de montarse en pantalla (`onMounted`), realizara una petición GET a la nueva API de Laravel y enlazara la respuesta a una variable reactiva.

```ts
import { ref, onMounted } from 'vue'

const mensajeBackend = ref<string>('Esperando respuesta de Laravel...')

onMounted(async () => {
  try {
    const respuesta = await fetch('http://localhost:8000/api/prueba')
    const datos = await respuesta.json()
    mensajeBackend.value = datos.mensaje // Se extrae el mensaje del JSON
  } catch (error) {
    mensajeBackend.value = 'Error de conexión.'
  }
})
```

**Resultado:** Comunicación bidireccional exitosa en tiempo real entre servidores locales independientes.