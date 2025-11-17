<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use App\Helpers\Response;

class Database
{
    // Configuración de la base de datos
    private const HOST = '127.0.0.1';
    private const DBNAME = 'contacts_db';
    private const USER = 'root';
    private const PASS = '';
    private const CHARSET = 'utf8mb4';

    // Obtener conexión a la base de datos
    public static function getConnection(): PDO
    {
        // Construir la url de conexión
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::HOST,
            self::DBNAME,
            self::CHARSET
        );

        // realizamos la conexión a la base de datos
        try {
            return new PDO($dsn, self::USER, self::PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // si falla lanza excepciones
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // devuelve arrays asociativos
            ]);
        } catch (PDOException $e) {
            Response::error('DB connection error: ' . $e->getMessage(), 500);
        }
    }
}
