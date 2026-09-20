<?php
require dirname(__DIR__, 2) . '/app/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

// Consulta as notícias salvas no banco.
try {
    $pdo = database();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = listar_noticias(
            $pdo,
            mb_substr(input($_GET, 'category'), 0, 40),
            mb_substr(input($_GET, 'q'), 0, 180),
            mb_substr(input($_GET, 'source'), 0, 30),
            (int) input($_GET, 'page'),
            input($_GET, 'reading') === 'full'
        );
    } else {
        header('Allow: GET');
        http_response_code(405);
        $result = ['error' => 'Método não permitido.'];
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
} catch (Throwable $erro) {
    error_log($erro->getMessage());
    http_response_code(503);
    echo json_encode(['error' => 'Não foi possível consultar as notícias.']);
}
