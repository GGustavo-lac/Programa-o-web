<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Ponto & Pauta: Brasil, mundo, economia, esportes, tecnologia e famosos, com a origem da informação sempre à vista.">
<meta name="csrf-token" content="<?= e(csrf_token()) ?>">
<title><?= e($title) ?> | Ponto & Pauta</title>
<link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="assets/vendor/bootstrap.min.css">
<link rel="stylesheet" href="assets/style.css?v=7">
<script src="assets/app.js?v=7" defer>
</script>
</head>
<body>
<a class="skip-link" href="#conteudo-principal">Pular para o conteúdo</a>
<div class="utility">
<div class="container">
<span><?= date('d/m/Y') ?> <span class="utility-sep">/</span> Edição digital</span>
<div>
<a href="index.php?action=about">Sobre nós</a>
<a href="index.php?action=sources">Fontes</a>
<a href="index.php?action=admin">Redação ↗</a>
</div>
</div>
</div>
<header class="site-header">
<div class="container masthead">
<a class="brand" href="index.php" aria-label="Ponto e Pauta — início">
<img src="assets/logo.svg" width="300" height="64" alt="Ponto & Pauta">
</a>
<form class="search-form" action="index.php" role="search">
<label class="visually-hidden" for="site-search">Buscar notícias</label>
<input id="site-search" name="q" maxlength="180" value="<?= e(input($_GET,'q')) ?>" placeholder="O que você procura?">
<button aria-label="Buscar" type="submit">
<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
<circle cx="10" cy="10" r="6"/>
<path d="m15 15 6 6"/>
</svg>
</button>
</form>
<a class="saved-nav" href="index.php?action=saved">
<svg width="18" height="20" viewBox="0 0 20 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
<path d="M4 2h12v19l-6-4-6 4z"/>
</svg> Salvos <span data-saved-count>0</span>
</a>
</div>
<nav class="section-nav" aria-label="Editorias">
<div class="container">
<a href="index.php" class="<?= !input($_GET,'category') && !input($_GET,'action')?'active':'' ?>">Início</a><?php foreach(['Brasil','Mundo','Economia','Esportes','Tecnologia','Famosos'] as $navCategory): ?><a class="<?= input($_GET,'category')===$navCategory?'active':'' ?>" href="index.php?category=<?= urlencode($navCategory) ?>"><?= e($navCategory) ?></a><?php endforeach; ?><a href="index.php?action=admin" class="<?= input($_GET,'action')==='admin'?'active':'' ?>">Nosso blog</a>
</div>
</nav>
</header>
<main class="container main-content" id="conteudo-principal">
<?php if(isset($_SESSION['flash'])): ?><div class="alert alert-success" role="status"><?= e($_SESSION['flash']) ?></div><?php unset($_SESSION['flash']); endif; ?>
