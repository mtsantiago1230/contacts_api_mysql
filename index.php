<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Database;
use App\Helpers\Response;
use App\Repositories\ContactRepository;
use App\Services\ContactService;
use App\Controllers\ContactController;

// Configurar la conexión a la base de datos
$pdo = Database::getConnection();

// instanciar las capas de la aplicación
$repo = new ContactRepository($pdo);
$service = new ContactService($repo);
$controller = new ContactController($service);

// obtener método y ruta 
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// obtenemos la ruta relativa y limpiamos el prefijo
$uri = str_replace('/contacts_api_mysql', '', $uri);

// quitamos barras al inicio y final
$uri = trim($uri, '/');

// Segmentar
$segments = $uri === '' ? [] : explode('/', $uri);

// Validar ruta base - Ruta base: /contacts
if (!isset($segments[0]) || $segments[0] !== 'contacts') {
    Response::error('Recurso no encontrado', 404);
}

// Rutas para /contacts 
try {
    // Listar contactos
    if ($method === 'GET' && count($segments) === 1) {
        $controller->index();
    // Crear contacto
    } elseif ($method === 'POST' && count($segments) === 1) {
        $controller->store();
    // Eliminar contacto
    } elseif ($method === 'DELETE' && count($segments) === 2) {
        $controller->delete((int)$segments[1]);
    // Método no permitido
    } else {
        Response::error('Método no permitido', 405);
    }
} catch (InvalidArgumentException $ex) {
    // si el error es por argumentos inválidos
    Response::error($ex->getMessage(), 400);
} catch (Exception $ex) {
    Response::error('Error del servidor: ' . $ex->getMessage(), 500);
}
