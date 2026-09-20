<?php

// Abre as páginas do menu.
if ($action === 'news') {
    $newsId = filter_var(input($_GET, 'id'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $item = $newsId ? buscar_noticia($pdo, $newsId) : false;
    if (!$item) {
        error_page(404, 'Notícia não encontrada', 'Esta notícia não está disponível.');
    }
    $result = listar_noticias($pdo, $item['category']);
    $related = [];
    foreach ($result['items'] as $other) {
        if ($other['id'] !== $item['id']) {
            $related[] = $other;
        }
        if (count($related) === 3) {
            break;
        }
    }
    render('news', ['item' => $item, 'related' => $related, 'title' => $item['title']]);
} elseif ($action === 'admin') {
    render('admin', ['items' => listar_posts($pdo), 'title' => 'Redação']);
} elseif ($action === 'sources') {
    $states = [];
    foreach (situacao_fontes($pdo) as $state) {
        $states[$state['source_key']] = $state;
    }
    render('sources', ['states' => $states, 'title' => 'Nossas fontes']);
} elseif ($action === 'saved') {
    render('saved', ['title' => 'Salvos']);
} else {
    render('about', ['title' => 'Sobre o portal']);
}
