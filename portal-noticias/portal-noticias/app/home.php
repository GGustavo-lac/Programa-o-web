<?php

// Recebe os filtros da página inicial.
$category = input($_GET, 'category');
$source = input($_GET, 'source');
$search = mb_substr(input($_GET, 'q'), 0, 180);
$reading = input($_GET, 'reading');
if ($category && !in_array($category, CATEGORIES, true)) {
    error_page(404, 'Editoria não encontrada', 'Escolha uma das editorias do menu.');
}
if ($source && !isset(fontes_noticias()[$source])) {
    error_page(404, 'Fonte não encontrada', 'Escolha uma fonte na lista.');
}
if ($reading !== 'full') {
    $reading = 'all';
}
$result = listar_noticias($pdo, $category, $search, $source, (int) input($_GET, 'page'), $reading === 'full');
$lastUpdate = null;
foreach (situacao_fontes($pdo) as $state) {
    if ($state['last_success'] && (!$lastUpdate || $state['last_success'] > $lastUpdate)) {
        $lastUpdate = $state['last_success'];
    }
}
$title = $search ? 'Busca: ' . $search : ($category ?: 'Notícias do dia');
render('home', compact('category', 'search', 'source', 'result', 'lastUpdate', 'title', 'reading'));
