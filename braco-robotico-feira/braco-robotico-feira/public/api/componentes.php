<?php
/**
 * API REST (JSON) do catálogo de componentes — mesma regra de negócio do site (ComponenteService).
 *
 *   GET    /api/componentes.php          → lista todos
 *   GET    /api/componentes.php?id=1     → um componente
 *   POST   /api/componentes.php          → cria   (corpo JSON)
 *   PUT    /api/componentes.php?id=1     → atualiza (corpo JSON)
 *   DELETE /api/componentes.php?id=1     → exclui
 */
require __DIR__ . '/../../src/bootstrap.php';

use App\Services\ComponenteService;

header('Content-Type: application/json; charset=utf-8');

/** Envia a resposta JSON com o código HTTP e encerra. */
function responder(int $codigo, mixed $corpo = null): never
{
    http_response_code($codigo);
    if ($corpo !== null) {
        echo json_encode($corpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    exit;
}

$servico = new ComponenteService();
$metodo  = $_SERVER['REQUEST_METHOD'];
$id      = (int) ($_GET['id'] ?? 0);
$corpo   = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];

try {
    switch ($metodo) {
        case 'GET':
            if ($id) {
                responder(200, $servico->buscar($id) ?? responder(404, ['erro' => 'Componente não encontrado']));
            }
            responder(200, $servico->listar());

        case 'POST':
            responder(201, $servico->buscar($servico->criar($corpo)));

        case 'PUT':
            if (!$id || !$servico->buscar($id)) {
                responder(404, ['erro' => 'Componente não encontrado']);
            }
            $servico->atualizar($id, $corpo);
            responder(200, $servico->buscar($id));

        case 'DELETE':
            if (!$id || !$servico->buscar($id)) {
                responder(404, ['erro' => 'Componente não encontrado']);
            }
            $servico->excluir($id);
            responder(204);

        default:
            responder(405, ['erro' => 'Método não permitido']);
    }
} catch (InvalidArgumentException $e) {
    responder(422, ['erro' => $e->getMessage()]);   // erro de validação
}
