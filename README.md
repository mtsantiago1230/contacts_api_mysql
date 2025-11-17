# Contacts API – PHP Backend

API REST desarrollada como parte de una prueba técnica para backend en PHP.  
Permite gestionar contactos con uno o varios números telefónicos.

La API permite:

- Listar todos los contactos
- Crear un nuevo contacto
- Eliminar un contacto por ID
- Validar campos obligatorios
- Validar formato de email
- Administrar múltiples números telefónicos por contacto

---

## 🛠️ Tecnologías utilizadas

- PHP 7+
- MySQL
- Composer

---

## 📦 Instalación y configuración

### 1️⃣ Clonar el repositorio

```bash
git https://github.com/mtsantiago1230/contacts_api_mysql.git
cd contacts_api_mysql
```

### 2️⃣ Instalar dependencias de Composer

```bash
composer install
```

### 3️⃣ Configurar la base de datos MySQL

Crear una base de datos llamada: contacts_db

Ejecutar el archivo SQL de la carpeta migrations/:

```bash
migrations/schema_mysql.sql
```

### 4️⃣ Ejecutar localmente (XAMPP recomendado)

Mover el proyecto a:

```bash
C:\xampp\htdocs\contacts_api_mysql
```

Acceder en navegador o Postman:
http://localhost/contacts_api_mysql/

## 🔹 Ejemplos de solicitudes

Listar todos los contactos:
GET /contacts

```bash
http://localhost/contacts_api_mysql/contacts
```

Crear un nuevo contacto:
POST /contacts

```bash
{
  "first_name": "Ana",
  "last_name": "Lopez",
  "email": "ana@example.com",
  "phones": ["3001112222", "3102223344"]
}

http://localhost/contacts_api_mysql/contacts
```

Eliminar un contacto por ID:
DELETE /contacts/{id}

```bash
http://localhost/contacts_api_mysql/contacts/1
```

## ⏱️ Tiempo de desarrollo

El ejercicio completo fue desarrollado en aproximadamente **6 horas**, incluyendo:

- Configuración del entorno
- Arquitectura en capas
- Validaciones y manejo de errores
- Conexión a MySQL con PDO
- Documentación y página de inicio
- Pruebas y correcciones
