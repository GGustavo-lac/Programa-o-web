<?php
namespace App;

use PDO;

/**
 * Camada de conexão.
 * Usa PDO com prepared statements (protege contra SQL Injection)
 * e mantém uma única conexão por requisição (padrão Singleton).
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function conectar(): PDO
    {
        if (self::$pdo === null) {
            $c = (require __DIR__ . '/../config/config.php')['db'];
            $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}";
            self::$pdo = new PDO($dsn, $c['user'], $c['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // erros viram exceções
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,                    // prepared statements reais
            ]);
        }
        return self::$pdo;
    }
}
