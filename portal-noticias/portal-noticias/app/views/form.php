<a class="back-link" href="<?= $action === 'edit' ? 'index.php?action=show&id=' . $id : 'index.php' ?>">← <?= $action === 'edit' ? 'Voltar ao post' : 'Todas as notícias' ?></a>
<div class="form-heading">
<p class="eyebrow">ESPAÇO DA REDAÇÃO</p>
<h1><?= e($title) ?></h1>
<p>Uma boa história começa com os detalhes. Título, autor, categoria, data e conteúdo são obrigatórios.</p>
</div>
<?php if ($errors): ?><div class="alert alert-danger" role="alert">
<strong>Revise os campos indicados.</strong> Os dados preenchidos foram mantidos.</div><?php endif; ?>
<form class="post-form" method="post" action="index.php?action=<?= e($action) ?><?= $id ? '&id=' . $id : '' ?>" data-post-form>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-panel">
                <h2>Conteúdo da notícia</h2>
                <div class="mb-4">
<label class="form-label" for="titulo">Título</label>
<input class="form-control form-control-lg <?= isset($errors['titulo']) ? 'is-invalid' : '' ?>" id="titulo" name="titulo" value="<?= e($data['titulo']) ?>" maxlength="180" required placeholder="Qual é a notícia?" <?= isset($errors['titulo']) ? 'aria-invalid="true" aria-describedby="titulo-error"' : '' ?>><?php if (isset($errors['titulo'])): ?><div class="invalid-feedback" id="titulo-error"><?= e($errors['titulo']) ?></div><?php endif; ?></div>
                <div class="mt-4">
<label class="form-label" for="imagem_url">Imagem de capa (opcional)</label>
<input class="form-control <?= isset($errors['imagem_url'])?'is-invalid':'' ?>" type="url" id="imagem_url" name="imagem_url" maxlength="2048" placeholder="https://…" value="<?= e($data['imagem_url']) ?>"><?php if(isset($errors['imagem_url'])): ?><div class="invalid-feedback"><?= e($errors['imagem_url']) ?></div><?php endif; ?><p class="form-text">Use uma imagem própria ou autorizada, disponível em HTTPS.</p>
<img id="image-preview" class="image-preview" alt="Prévia da capa" hidden>
</div>
<div class="mt-3">
<label class="form-label" for="imagem_credito">Crédito da imagem</label>
<input class="form-control <?= isset($errors['imagem_credito'])?'is-invalid':'' ?>" id="imagem_credito" name="imagem_credito" maxlength="180" placeholder="Fotógrafo / origem" value="<?= e($data['imagem_credito']) ?>"><?php if(isset($errors['imagem_credito'])): ?><div class="invalid-feedback"><?= e($errors['imagem_credito']) ?></div><?php endif; ?></div>
<div class="mt-4">
<label class="form-label" for="conteudo">Conteúdo completo</label>
<textarea class="form-control <?= isset($errors['conteudo']) ? 'is-invalid' : '' ?>" id="conteudo" name="conteudo" rows="13" maxlength="20000" required placeholder="Conte a história com suas palavras…" aria-describedby="conteudo-help<?= isset($errors['conteudo']) ? ' conteudo-error' : '' ?>" <?= isset($errors['conteudo']) ? 'aria-invalid="true"' : '' ?>><?= e($data['conteudo']) ?></textarea><?php if (isset($errors['conteudo'])): ?><div class="invalid-feedback" id="conteudo-error"><?= e($errors['conteudo']) ?></div><?php endif; ?><div class="d-flex flex-wrap justify-content-between form-text gap-2" id="conteudo-help">
<span>Texto simples. As quebras de linha serão preservadas.</span>
<span id="character-count">0 / 20.000</span>
</div>
</div>
            </div>
        </div>
        <div class="col-lg-4">
<div class="form-panel publication-panel">
<h2>Publicação</h2>
            <div class="mb-4">
<label class="form-label" for="autor">Autor</label>
<input class="form-control <?= isset($errors['autor']) ? 'is-invalid' : '' ?>" id="autor" name="autor" value="<?= e($data['autor']) ?>" maxlength="100" required placeholder="Nome do autor" <?= isset($errors['autor']) ? 'aria-invalid="true" aria-describedby="autor-error"' : '' ?>><?php if (isset($errors['autor'])): ?><div class="invalid-feedback" id="autor-error"><?= e($errors['autor']) ?></div><?php endif; ?></div>
            <div class="mb-4">
<label class="form-label" for="categoria">Categoria</label>
<select class="form-select <?= isset($errors['categoria']) ? 'is-invalid' : '' ?>" name="categoria" id="categoria" required <?= isset($errors['categoria']) ? 'aria-invalid="true" aria-describedby="categoria-error"' : '' ?>>
<option value="">Selecione uma categoria</option><?php foreach (CATEGORIES as $category): ?><option value="<?= e($category) ?>" <?= $data['categoria'] === $category ? 'selected' : '' ?>><?= e($category) ?></option><?php endforeach; ?></select><?php if (isset($errors['categoria'])): ?><div class="invalid-feedback" id="categoria-error"><?= e($errors['categoria']) ?></div><?php endif; ?></div>
            <div class="mb-4">
<label class="form-label" for="data_publicacao">Data de publicação</label>
<input class="form-control <?= isset($errors['data_publicacao']) ? 'is-invalid' : '' ?>" type="date" name="data_publicacao" id="data_publicacao" min="1000-01-01" max="9999-12-31" value="<?= e($data['data_publicacao']) ?>" required <?= isset($errors['data_publicacao']) ? 'aria-invalid="true" aria-describedby="data-error"' : '' ?>><?php if (isset($errors['data_publicacao'])): ?><div class="invalid-feedback" id="data-error"><?= e($errors['data_publicacao']) ?></div><?php endif; ?></div>
            <p class="form-text">O post ficará disponível no portal assim que você salvar. A data é informativa; não há agendamento.</p>
            <button class="btn btn-primary w-100 mb-2" type="submit"><?= $action === 'create' ? 'Cadastrar post' : 'Salvar alterações' ?></button>
<a class="btn btn-light w-100" href="<?= $action === 'edit' ? 'index.php?action=show&id=' . $id : 'index.php' ?>">Cancelar</a>
        </div>
</div>
    </div>
</form>
