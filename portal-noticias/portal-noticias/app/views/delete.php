<a class="back-link" href="index.php?action=show&id=<?= $post['id'] ?>">← Voltar ao post</a>
<section class="confirmation-panel">
<p class="eyebrow text-danger">EXCLUSÃO DE POST</p>
<h1>Excluir esta notícia?</h1>
<p class="delete-title"><?= e($post['titulo']) ?></p>
<p>O post e seu conteúdo completo serão removidos do banco de dados. Esta ação não pode ser desfeita.</p>
<form method="post" action="index.php?action=delete&id=<?= $post['id'] ?>">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<div class="d-flex flex-wrap gap-3 mt-4">
<a class="btn btn-outline-dark" href="index.php?action=show&id=<?= $post['id'] ?>">Cancelar</a>
<button class="btn btn-danger" type="submit">Sim, excluir post</button>
</div>
</form>
</section>
