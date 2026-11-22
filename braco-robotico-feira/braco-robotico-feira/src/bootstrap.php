<?php
/**
 * Inicialização comum a todas as páginas:
 *  - autoload das classes do namespace App\ (pasta src/)
 *  - sessão (usada para mensagens flash e token CSRF)
 *  - funções auxiliares
 */
spl_autoload_register(function (string $classe): void {
    $prefixo = 'App\\';
    if (strncmp($classe, $prefixo, strlen($prefixo)) !== 0) {
        return;
    }
    $arquivo = __DIR__ . '/' . str_replace('\\', '/', substr($classe, strlen($prefixo))) . '.php';
    if (is_file($arquivo)) {
        require $arquivo;
    }
});

session_start();
require __DIR__ . '/helpers.php';
