<div class="page-heading">
<div>
<span class="kicker">CONTEÚDO AUTORAL</span>
<h1>Nosso blog<span class="accent-dot">.</span>
</h1>
</div>
<a href="index.php?action=create" class="btn btn-primary">+ Novo post</a>
</div>
<p class="intro">Textos da nossa redação. Aqui você cadastra, lê, edita e exclui publicações.</p>
<div class="admin-stats">
<div>
<strong><?= count($items) ?></strong>
<span>posts publicados</span>
</div>
<div>
<strong><?= count(array_unique(array_column($items,'autor'))) ?></strong>
<span>autores</span>
</div>
<div>
<strong><?= count(array_unique(array_column($items,'categoria'))) ?></strong>
<span>editorias no blog</span>
</div>
</div>
<?php if(!$items): ?><div class="empty-state">
<h2>Qual vai ser a primeira pauta?</h2>
<p>Cadastre um post para começar.</p>
<a class="btn btn-primary" href="index.php?action=create">Criar primeiro post</a>
</div><?php else: ?><div class="row g-4"><?php foreach($items as $post): ?><div class="col-md-6 col-xl-4">
<article class="blog-card">
<a href="index.php?action=show&id=<?= $post['id'] ?>" tabindex="-1" aria-hidden="true">
<img src="<?= e($post['imagem_url'] ?: 'assets/editorial.svg') ?>" data-news-image alt="" loading="lazy" referrerpolicy="no-referrer">
</a>
<div class="blog-card-body">
<span class="kicker"><?= e($post['categoria']) ?></span>
<h2>
<a href="index.php?action=show&id=<?= $post['id'] ?>"><?= e($post['titulo']) ?></a>
</h2>
<p><?= e(mb_strimwidth($post['resumo'],0,150,'…')) ?></p>
<div class="story-meta"><?= e($post['autor']) ?> · <?= date_br($post['data_publicacao']) ?></div>
<div class="card-actions">
<a href="index.php?action=show&id=<?= $post['id'] ?>">Ler post →</a>
<div>
<a href="index.php?action=edit&id=<?= $post['id'] ?>">Editar</a>
<a class="delete-link" href="index.php?action=delete&id=<?= $post['id'] ?>">Excluir</a>
</div>
</div>
</div>
</article>
</div><?php endforeach; ?></div><?php endif; ?>
