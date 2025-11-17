<?php

declare(strict_types=1);

namespace App\Helpers;

class Response
{
    // Envía una respuesta JSON con el código de estado HTTP dado
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8'); // decir que vamos a enviar JSON

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit; // terminamos la ejecución del script
    }

    // Envía una respuesta de error en formato JSON 
    public static function error(string $message, int $status = 400): void
    {
        self::json(['error' => $message], $status);
    }
}
