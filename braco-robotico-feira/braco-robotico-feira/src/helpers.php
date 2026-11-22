<?php
/** Funções auxiliares de apresentação e segurança. */

/** Escapa texto para HTML (proteção contra XSS). */
function e(?string $texto): string
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}

/** Redireciona e encerra (padrão Post/Redirect/Get). */
function redirecionar(string $url): never
{
    header("Location: $url");
    exit;
}

/** Guarda uma mensagem para ser exibida na próxima página. */
function flash(string $tipo, string $mensagem): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'mensagem' => $mensagem];
}

/** Token CSRF: impede que outro site envie formulários em nome do usuário. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_campo(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_validar(): void
{
    $esperado = $_SESSION['csrf'] ?? '';
    // Token vazio nunca é válido (senão '' == '' passaria sem sessão)
    if ($esperado === '' || !hash_equals($esperado, (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(419);
        exit('Sessão expirada. Volte e tente novamente.');
    }
}

/** Cabeçalho comum das páginas. $ativo marca o item do menu. */
function cabecalho(string $titulo, string $ativo = ''): void
{
    $itens = [
        'inicio'       => ['index.php',        'Início'],
        'como'         => ['como-funciona.php', 'Como funciona'],
        'componentes'  => ['componentes.php',  'Componentes'],
        'visitantes'   => ['visitantes.php',   'Visitantes'],
        'duvidas'      => ['duvidas.php',      'Dúvidas'],
    ];
    echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . e($titulo) . ' · Braço Robótico IoT</title>';
    echo '<link rel="stylesheet" href="css/style.css"></head><body>';
    echo '<header class="topo"><a class="marca" href="index.php">🦾 Braço Robótico IoT</a><nav>';
    foreach ($itens as $chave => [$url, $rotulo]) {
        $classe = $chave === $ativo ? ' class="ativo"' : '';
        echo "<a href=\"$url\"$classe>$rotulo</a>";
    }
    echo '</nav></header><main>';
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="aviso ' . e($f['tipo']) . '">' . e($f['mensagem']) . '</div>';
    }
}

function rodape(): void
{
    echo '</main><footer>Feira Tecnológica · Projeto em grupo · PHP + MySQL</footer></body></html>';
}

/** Conta caracteres (usa mbstring quando disponível, para acentos contarem como 1). */
function tam(string $texto): int
{
    return function_exists('mb_strlen') ? mb_strlen($texto) : strlen($texto);
}
