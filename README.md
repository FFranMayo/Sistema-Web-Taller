# 🕒 Sistema Web de Gestión – Taller de Relojería

Aplicación web desarrollada en **PHP y MySQL** que implementa un sistema completo de gestión interna para un taller de relojería.

Este proyecto demuestra conocimientos en:

- Desarrollo backend con PHP
- Gestión de bases de datos relacionales (MySQL)
- Autenticación segura
- Operaciones CRUD
- Validaciones en frontend
- Arquitectura cliente-servidor
- Buenas prácticas de seguridad

---

## 🎯 Objetivo del Proyecto

Desarrollar una aplicación web funcional que permita:

- Gestionar empleados
- Administrar clientes
- Asociar relojes a clientes
- Registrar reparaciones realizadas por empleados

El sistema simula un entorno real de gestión empresarial.

---

## 🛠 Stack Tecnológico

### Backend
- PHP (programación estructurada)
- MySQL
- Consultas preparadas (`mysqli`)
- Gestión de sesiones

### Frontend
- HTML5
- CSS3 (Flexbox, diseño responsive)
- JavaScript
- Fetch API (peticiones asíncronas)

### Seguridad
- `password_hash()` y `password_verify()`
- Sanitización con `htmlspecialchars()`
- Protección de credenciales mediante archivo `.env`
- Control de acceso por sesión

---

## 🏗 Arquitectura

Arquitectura clásica cliente-servidor:

- El cliente (navegador) interactúa mediante formularios HTML.
- JavaScript gestiona validaciones y envío asíncrono del login.
- PHP procesa las peticiones y se conecta a la base de datos.
- MySQL almacena la información con relaciones mediante claves foráneas.

---

## 🔐 Sistema de Autenticación

El sistema incluye:

- Registro de empleados con contraseña encriptada.
- Login asíncrono mediante `fetch()` (sin recarga de página).
- Verificación segura de credenciales.
- Protección de rutas privadas mediante sesión PHP.

### Ejemplo de control de acceso

session_start();

if (!isset($_SESSION["empleado"])) {
    header("Location: login.php");
    exit();
}
## 📊 Funcionalidades Implementadas

### ✔ CRUD completo sobre Clientes
- Crear nuevos registros
- Visualizar tabla dinámica
- Actualizar datos existentes
- Eliminar registros por ID
- Eliminación múltiple mediante checkbox

### ✔ Visualización de tablas
- Clientes
- Empleados
- Relojes
- Reparaciones

### ✔ Interfaz dinámica
- Cambio de tabla mediante parámetros GET
- Renderizado dinámico desde el backend

---

## 🗄 Modelo de Datos

Base de datos relacional con:

- **Clientes** (entidad principal)
- **Empleados** (con contraseña encriptada)
- **Relojes** (relación con Clientes)
- **Reparaciones** (relación con Relojes y Empleados)

> Uso de claves foráneas para garantizar integridad referencial.

---

## 🚀 Cómo ejecutar el proyecto

1. Importar `taller.sql` en MySQL.
2. Configurar el archivo `.env`:

```env
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=taller

## 🚀 Ejecutar desde la carpeta PHP en servidor local

- **Con XAMPP:** [http://localhost/PHP/main.html](http://localhost/PHP/main.html)  
- **Usando servidor embebido:**

```bash
php -S localhost:8000

## 🧠 Competencias demostradas

Este proyecto demuestra:

- Desarrollo backend con lógica estructurada
- Gestión segura de credenciales
- Implementación de autenticación robusta
- Manejo de sesiones en PHP
- Uso de consultas preparadas contra inyección SQL
- Integración frontend-backend
- Organización modular del código

---

## 📈 Posibles mejoras

- Migración a arquitectura MVC (Laravel)
- Sistema de roles (admin / empleado)
- Filtros avanzados y búsquedas dinámicas
- Protección CSRF
- API REST
- Refactorización orientada a objetos

---

## 🧩 Estado del Proyecto

Proyecto funcional y completamente operativo en entorno local.  

Diseñado como práctica avanzada de desarrollo web backend con PHP y bases de datos relacionales.

---

## 👨‍💻 Autor

**Francisco José Mayo Gutiérrez**  

Proyecto desarrollado como parte de formación en desarrollo web.
