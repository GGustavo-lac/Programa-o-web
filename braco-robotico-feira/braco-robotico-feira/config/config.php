<?php
/**
 * Configuração do banco de dados.
 * Os valores podem ser trocados por variáveis de ambiente (DB_HOST, DB_NAME...)
 * ou editados direto aqui para o ambiente da feira (XAMPP / Laragon).
 */
return [
    'db' => [
        'host'    => getenv('DB_HOST') ?: '127.0.0.1',
        'port'    => getenv('DB_PORT') ?: '3306',
        'name'    => getenv('DB_NAME') ?: 'braco_robotico',
        'user'    => getenv('DB_USER') ?: 'root',
        'pass'    => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
        'charset' => 'utf8mb4',
    ],
];
