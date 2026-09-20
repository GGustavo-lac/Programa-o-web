<a class="back-link" href="index.php?action=admin">← Nosso blog</a>
<article class="article-page">
    <header>
<span class="category"><?= e($post['categoria']) ?></span>
<h1><?= e($post['titulo']) ?></h1>
<div class="article-meta">
<span>Por <strong><?= e($post['autor']) ?></strong>
</span>
<time datetime="<?= e($post['data_publicacao']) ?>"><?= date_br($post['data_publicacao']) ?></time>
</div>
</header>
    <?php if($post['imagem_url']): ?><figure class="article-figure">
<img src="<?= e($post['imagem_url']) ?>" data-news-image alt="Capa de <?= e($post['titulo']) ?>" referrerpolicy="no-referrer">
<figcaption>Foto: <?= e($post['imagem_credito']) ?></figcaption>
</figure><?php endif; ?><div class="article-content"><?= e($post['conteudo']) ?></div>
    <footer class="article-actions">
<a class="btn btn-outline-dark" href="index.php?action=edit&id=<?= $post['id'] ?>">Editar post</a>
<a class="btn btn-outline-danger" href="index.php?action=delete&id=<?= $post['id'] ?>">Excluir post</a>
</footer>
</article>
