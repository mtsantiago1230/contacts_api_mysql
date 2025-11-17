<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacts API – Inicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f7f9;
            margin: 0;
            padding: 0;
        }
        header {
            background: #4a90e2;
            color: white;
            padding: 20px 30px;
            font-size: 24px;
        }
        .container {
            padding: 30px;
            max-width: 900px;
            margin: auto;
            background: white;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        code {
            background: #eee;
            padding: 4px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
        }
        .endpoint {
            margin-bottom: 25px;
            padding: 15px;
            background: #fafafa;
            border-left: 4px solid #4a90e2;
        }
        footer {
            text-align: center;
            margin: 30px 0;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #4a90e2;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn:hover {
            background: #3b7ec4;
        }
    </style>
</head>

<body>

<header>
    Contacts API – Documentación
</header>

<div class="container">
    <h2>📌 Bienvenido</h2>
    <p>
        Esta es la API REST creada con PHP (sin framework) para manejar contactos con múltiples números telefónicos.
    </p>

    <h2>🚀 Endpoints disponibles</h2>

    <div class="endpoint">
        <strong>GET /contacts</strong>
        <p>Listar todos los contactos.</p>
        <code>http://localhost/contacts_api_mysql/contacts</code>
    </div>

    <div class="endpoint">
        <strong>POST /contacts</strong>
        <p>Crear un nuevo contacto.</p>

        <pre>
{
  "first_name": "Ana",
  "last_name": "Lopez",
  "email": "ana@example.com",
  "phones": ["3001112222"]
}
        </pre>

        <code>http://localhost/contacts_api_mysql/contacts</code>
    </div>

    <div class="endpoint">
        <strong>DELETE /contacts/{id}</strong>
        <p>Eliminar un contacto por ID.</p>
        <code>http://localhost/contacts_api_mysql/contacts/1</code>
    </div>

</div>

</body>
</html>
