# API RESTful: Gestión de Mantenimiento "Energy and Water" (PHP/MySQL)

Proyecto de **Desarrollo Backend** implementado como **Evaluación Sumativa de la Unidad 2**, en el marco del Taller de Tecnologías Web. La solución consiste en una API RESTful funcional diseñada para gestionar los servicios e información de la empresa **Energy and Water**.

El objetivo es demostrar la capacidad de **construir, integrar, mantener y probar** un servicio API complejo, cumpliendo con los resultados de aprendizaje de la asignatura.

---

## Arquitectura y Tecnología Backend

* **Tecnología Principal:** **PHP** (Backend Server-Side Scripting).
* **Base de Datos:** **MySQL** (`ciisa_backend_v1_eva2_A`) para la persistencia de datos, garantizando la integridad de las operaciones CRUD.
* **Patrón de Diseño:** El sistema sigue un **Patrón MVC simplificado** con un Front Controller (`version1.php`) para la gestión de rutas y recursos.
* **Diseño de API:** La API se diseñó para ser **funcional, consistente** y documentada de forma clara, permitiendo la interacción total con el Frontend.

### Endpoints y Métodos
La API expone **6 recursos principales** (Endpoints), cumpliendo el requisito de desarrollar servicios web RESTful para CRUD:

| Recurso (Ruta) | Funcionalidad Principal | Métodos Implementados |
| :--- | :--- | :--- |
| `categoria_servicio` | Gestión de categorías de servicio (Climatización, Electricidad, etc.). | **GET, POST, PUT, PATCH, DELETE** |
| `mantenimiento_info` | Registros de mantenimiento (preventivo/correctivo). | **GET, POST, PUT, PATCH, DELETE** |
| `info_contacto` | Gestión de los datos de contacto de la empresa. | **GET, POST, PUT, PATCH, DELETE** |
| `historia` | Hitos e historia de la empresa. | **GET, POST, PUT, PATCH, DELETE** |
| `equipo` | Información y gestión de los miembros del equipo. | **GET, POST, PUT, PATCH, DELETE** |
| `pregunta_frecuente` | Listado y gestión de FAQs. | **GET, POST, PUT, PATCH, DELETE** |

### Resultados del Desarrollo
* **Códigos de Estado HTTP:** La API devuelve respuestas JSON con los códigos de estado HTTP correctos para cada método (ej: `201 Created`, `400 Bad Request`).
* **Validación de Datos:** Se implementó la validación de entrada de datos para asegurar la integridad de la información antes de las operaciones en la base de datos.
* **CORS:** El *Front Controller* incluye las cabeceras CORS necesarias para ser consumida por clientes externos, incluyendo el visor HTML de prueba.

---

## Pruebas y Control de Calidad

* **Pruebas Unitarias CRUD:** Se realizaron pruebas exhaustivas con **Postman** (Colección adjunta) para verificar la funcionalidad de cada método individual (**POST, PUT, DELETE**) con entradas válidas e inválidas.
* **Prueba de Integración Front-End (Visor):** Se incluye el archivo **`index.php`** (Front-End) que utiliza JavaScript (`fetch()`) para consumir los 6 endpoints de la API en `localhost`. Esto valida la correcta **exposición** y **accesibilidad** de los servicios.
* **Pruebas de Integración:** Se verificó el flujo completo *End-to-End* (Crear -> Listar -> Actualizar -> Eliminar) para asegurar la **integración funcional** del sistema.
* **Pruebas de Rendimiento:** Pruebas básicas con Postman Runner mostraron un tiempo de respuesta promedio de **20 ms a 40 ms** en entorno local.

---

## Instalación y Despliegue Local

Este proyecto requiere un entorno de servidor local (ej. **XAMPP/WAMP**) que soporte **PHP** y **MySQL**.

1. **Montar en Servidor:** Copiar la carpeta raíz (`API-RESTful-Energy-and-Water-PHP`) al directorio `htdocs` de XAMPP.
2. **Configurar DB:** Importar el script **`schema_user_tables_data_A.sql`** en MySQL para crear la base de datos (`ciisa_backend_v1_eva2_A`) y las tablas.
3. **Probar API (Back-End):** Utilizar la colección **`backend_U2_Energy and Water.postman_collection.json`** para ejecutar todas las pruebas CRUD de los 6 recursos.
4. **Probar Visor (Front-End):** Abrir en el navegador para verificar la carga de datos en tiempo real (si la API está activa):
```

http://localhost/API-RESTful-Energy-and-Water-PHP/Energy%20and%20Water/index.php

```

## Estructura del Proyecto

```

.
├── Energy and Water/              \# Carpeta Principal del Web Server
│   ├── index.php                  \# Visor HTML de prueba (Front-End)
│   └── backend/                   \# Lógica del Servidor (PHP)
│       └── v1/
│           └── api/               \# Versión 1 de los Endpoints
│               ├── version1.php   \# Front Controller
│               ├── conexion.php   \# Conexión a MySQL
│               ├── schema\_user\_tables\_data\_A.sql \# Script SQL
│               └── categoria\_servicio/ \# Endpoint (y los otros 5 recursos)
├── backend\_U2\_Energy and Water.postman\_collection.json \# Colección de Pruebas Postman
└── README.md

```
```