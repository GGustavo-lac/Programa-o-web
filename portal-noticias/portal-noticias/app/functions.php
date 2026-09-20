<?php
declare(strict_types=1);

const CATEGORIES = ['Brasil', 'Mundo', 'Economia', 'Tecnologia', 'Educação', 'Cultura', 'Esportes', 'Famosos', 'Comunidade'];

function safe_image_url(string $value): string
{
    $value=trim($value);
    if(strlen($value)>2048 || !filter_var($value,FILTER_VALIDATE_URL)) return '';
    $parts=parse_url($value);
    $host=strtolower($parts['host'] ?? '');
    if(($parts['scheme'] ?? '')!=='https' || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])) return '';
    if(!$host || $host==='localhost' || !str_contains($host,'.') || filter_var($host,FILTER_VALIDATE_IP) || str_ends_with($host,'.local')) return '';
    return $value;
}

function news_image(array $item): string { return $item['image_url'] ?: 'assets/editorial.svg'; }
function news_date(string $date): string { return (new DateTimeImmutable($date))->format('d/m · H:i'); }
function news_link(array $item): string { return 'index.php?action=news&id='.(int)$item['id']; }

// Exibe o texto sem executar HTML.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function input(array $source, string $key): string
{
    return isset($source[$key]) && is_string($source[$key]) ? trim($source[$key]) : '';
}

// Guarda um código para conferir o envio dos formulários.
function csrf_token()
{
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function valid_csrf(): bool
{
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], input($_POST, 'csrf'));
}

function redirect($url)
{
    header('Location: ' . $url, true, 303);
    exit;
}

function flash(string $message): void
{
    $_SESSION['flash'] = $message;
}

function date_br(string $date): string
{
    return (new DateTimeImmutable($date))->format('d/m/Y');
}

// Confere os campos antes de salvar o post.
function validate_post($source)
{
    $data = [];
    foreach (['titulo', 'autor', 'categoria', 'data_publicacao', 'conteudo'] as $field) {
        $data[$field] = input($source, $field);
    }
    $errors = [];
    $data['imagem_url']=input($source,'imagem_url');
    $data['imagem_credito']=input($source,'imagem_credito');
    if($data['imagem_url'] && !safe_image_url($data['imagem_url'])) $errors['imagem_url']='Informe uma URL HTTPS pública válida, sem usuário, senha ou porta.';
    if(mb_strlen($data['imagem_credito'])>180) $errors['imagem_credito']='Use no máximo 180 caracteres no crédito.';
    if($data['imagem_url'] && !$data['imagem_credito']) $errors['imagem_credito']='Informe o autor ou a origem da imagem.';
    foreach (['titulo' => ['título', 180], 'autor' => ['autor', 100], 'conteudo' => ['conteúdo completo', 20000]] as $field => [$label, $max]) {
        if ($data[$field] === '') {
            $errors[$field] = 'Informe o ' . $label . '.';
        } elseif (mb_strlen($data[$field], 'UTF-8') > $max) {
            $errors[$field] = 'Use no máximo ' . $max . ' caracteres.';
        }
    }
    if (!in_array($data['categoria'], CATEGORIES, true)) {
        $errors['categoria'] = 'Selecione uma categoria da lista.';
    }
    $date = preg_match('/^\d{4}-\d{2}-\d{2}$/D', $data['data_publicacao'])
        ? DateTimeImmutable::createFromFormat('!Y-m-d', $data['data_publicacao']) : false;
    if (!$date || $date->format('Y-m-d') !== $data['data_publicacao'] || $data['data_publicacao'] < '1000-01-01' || $data['data_publicacao'] > '9999-12-31') {
        $errors['data_publicacao'] = 'Informe uma data válida.';
    }
    return [$data, $errors];
}

function render(string $view, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    $title = $vars['title'] ?? 'Portal de Notícias';
    require __DIR__ . '/views/header.php';
    require __DIR__ . '/views/' . $view . '.php';
    require __DIR__ . '/views/footer.php';
}

function error_page($status, $title, $message)
{
    http_response_code($status);
    render('error', compact('title', 'message'));
    exit;
}

function news_teaser(array $item): string
{ return mb_strimwidth(tem_resumo($item) ? $item['ai_summary'] : ($item['summary'] ?? ''),0,280,'…','UTF-8'); }

function news_reading_label(array $item): string
{ return tem_resumo($item) ? 'Resumo com IA →' : (!empty($item['content_html']) ? 'Matéria completa →' : 'Chamada da fonte →'); }


function tem_resumo($noticia)
{
    return !empty($noticia['ai_summary']);
}

function origem_resumo($base)
{
    if ($base === 'full' || $base === 'article') {
        return 'Baseado no texto consultado na fonte.';
    }
    if ($base === 'excerpt') {
        return 'Baseado no título e no trecho disponibilizados pela fonte.';
    }
    return 'Baseado somente na manchete disponibilizada pela fonte.';
}
