<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';

// Escolhe a página solicitada.
$action = input($_GET, 'action') ?: 'list';
if (!in_array($action, ['list', 'show', 'create', 'edit', 'delete', 'news', 'admin', 'sources', 'saved', 'about'], true)) {
    error_page(404, 'Página não encontrada', 'O endereço informado não existe.');
}
$method = $_SERVER['REQUEST_METHOD'];
if (!in_array($method, ['GET', 'POST'], true) || ($method === 'POST' && !in_array($action, ['create', 'edit', 'delete'], true))) {
    header('Allow: ' . (in_array($action, ['create','edit','delete'], true) ? 'GET, POST' : 'GET'));
    error_page(405, 'Operação não permitida', 'Use os botões e formulários do portal.');
}
// Confere se o envio veio de um formulário do portal.
if ($method === 'POST' && !valid_csrf()) {
    error_page(403, 'Não foi possível confirmar a solicitação', 'Reabra o formulário e tente novamente. Sua sessão pode ter expirado.');
}

try {
    $pdo = database();
    // Consulta as fontes quando uma página de notícias é aberta.
    if ($method === 'GET' && in_array($action, ['list', 'news', 'sources'], true)) {
        try {
            atualizar_noticias($pdo);
        } catch (Throwable $erro) {
            error_log('Atualização: ' . $erro->getMessage());
        }
    }
    $post = null;
    $id = 0;
    if (in_array($action, ['show', 'edit', 'delete'], true)) {
        $rawId = input($_GET, 'id');
        $parsedId = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($parsedId === false || !($post = buscar_post($pdo, $parsedId))) {
            error_page(404, 'Post não encontrado', 'Este post não existe ou já foi excluído.');
        }
        $id = $parsedId;
    }
    if ($action === 'list') {
        require dirname(__DIR__) . '/app/home.php';
    } elseif (in_array($action,['news','admin','sources','saved','about'],true)) {
        require dirname(__DIR__).'/app/pages.php';
    } elseif ($action === 'show') {
        render('show', ['post' => $post, 'title' => $post['titulo']]);
    } elseif ($action === 'delete') {
        if ($method === 'POST') {
            excluir_post($pdo, $id);
            flash('Post excluído com sucesso.');
            redirect('index.php?action=admin');
        }
        render('delete', ['post' => $post, 'title' => 'Excluir post']);
    } else {
        $data = [
            'titulo' => '', 'autor' => '', 'categoria' => '',
            'data_publicacao' => date('Y-m-d'), 'conteudo' => '',
            'imagem_url' => '', 'imagem_credito' => '',
        ];
        if ($post) {
            foreach ($data as $campo => $valor) {
                $data[$campo] = $post[$campo];
            }
        }
        $errors = [];
        if ($method === 'POST') {
            [$data, $errors] = validate_post($_POST);
            if (!$errors) {
                if ($action === 'create') {
                    $id = cadastrar_post($pdo, $data);
                    flash('Post cadastrado com sucesso.');
                } else {
                    editar_post($pdo, $id, $data);
                    flash('Post atualizado com sucesso.');
                }
                redirect('index.php?action=show&id=' . $id);
            }
            http_response_code(422);
        }
        render('form', compact('data', 'errors', 'action', 'id') + ['title' => $action === 'create' ? 'Novo post' : 'Editar post']);
    }
} catch (Throwable $exception) {
    error_log('Portal de Notícias: ' . $exception->getMessage());
    error_page(503, 'Portal temporariamente indisponível', 'Não foi possível acessar o banco. Confira a configuração, a importação do SQL e se o MySQL está iniciado.');
}
