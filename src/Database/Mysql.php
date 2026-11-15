<?php

namespace App\Database;

class Mysql
{
    // garde sa valeur pendant toute la durée de la requête.
    private static ?\PDO $pdo = null;

    public static function connectBdd(): \PDO
    {
        // Si la connexion existe déjà, on la renvoie sans en recréer une
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        // Sinon elle la créer
        $hostValue = $_ENV["DATABASE_HOST"] ?? "localhost";
        $port = $_ENV["DATABASE_PORT"] ?? null;

        if ($port === null && str_contains($hostValue, ':')) {
            [$hostValue, $port] = explode(':', $hostValue, 2);
        }

        $dsn = 'mysql:host=' . $hostValue
            . (!empty($port) ? ';port=' . $port : '')
            . ';dbname=' . $_ENV["DATABASE_NAME"]
            . ';charset=utf8mb4';

        self::$pdo = new \PDO(
            $dsn,
            $_ENV["DATABASE_USERNAME"],
            $_ENV["DATABASE_PASSWORD"],
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return self::$pdo;
    }
}