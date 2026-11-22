<?php
/**
 * Página de COMPONENTES — catálogo das peças do braço robótico (CRUD completo).
 * Rotas: ?acao=listar (padrão) | ?acao=novo | ?acao=editar&id=N
 * POST:  acao=salvar (cria ou atualiza) | acao=excluir
 */
require __DIR__ . '/../src/bootstrap.php';

use App\Services\ComponenteService;

$servico = new ComponenteService();
$acao    = $_GET['acao'] ?? 'listar';
$id      = (int) ($_GET['id'] ?? 0);
$valores = ['nome' => '', 'categoria_id' => '', 'quantidade' => 1, 'descricao' => ''];

// ---------- Processa formulários (CREATE / UPDATE / DELETE) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validar();
    $idPost = (int) ($_POST['id'] ?? 0);
    try {
        if (($_POST['acao'] ?? '') === 'salvar') {
            if ($idPost) {
                $servico->atualizar($idPost, $_POST);
                flash('ok', 'Componente atualizado.');
            } else {
                $servico->criar($_POST);
                flash('ok', 'Componente cadastrado.');
            }
        } elseif (($_POST['acao'] ?? '') === 'excluir') {
            $servico->excluir($idPost);
            flash('ok', 'Componente excluído. As dúvidas sobre ele viraram dúvidas gerais.');
        }
        redirecionar('componentes.php');
    } catch (InvalidArgumentException $e) {
        flash('erro', $e->getMessage());
        $valores = array_merge($valores, $_POST);
        $acao    = $idPost ? 'editar' : 'novo';
        $id      = $idPost;
    }
} elseif ($acao === 'editar') {
    // ---------- READ de um registro para preencher o formulário ----------
    $valores = $servico->buscar($id) ?? redirecionar('componentes.php');
}

cabecalho('Componentes', 'componentes');

if ($acao === 'novo' || $acao === 'editar') { ?>
    <h1><?= $acao === 'editar' ? 'Editar componente' : 'Novo componente' ?></h1>
    <form method="post" class="cartao form">
        <?= csrf_campo() ?>
        <input type="hidden" name="acao" value="salvar">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Nome
            <input name="nome" maxlength="80" required value="<?= e($valores['nome']) ?>">
        </label>
        <label>Categoria
            <select name="categoria_id" required>
                <option value="">Selecione…</option>
                <?php foreach ($servico->categorias() as $c) { ?>
                    <option value="<?= $c['id'] ?>" <?= (int) $valores['categoria_id'] === (int) $c['id'] ? 'selected' : '' ?>>
                        <?= e($c['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <label>Quantidade no braço
            <input type="number" name="quantidade" min="1" max="99" required value="<?= (int) $valores['quantidade'] ?>">
        </label>
        <label>O que faz no braço
            <textarea name="descricao" maxlength="500" rows="4" required><?= e($valores['descricao']) ?></textarea>
        </label>
        <div class="acoes">
            <button class="btn" type="submit">Salvar</button>
            <a class="btn sec" href="componentes.php">Cancelar</a>
        </div>
    </form>
<?php } else {
    // Agrupa os componentes por categoria para exibir como vitrine
    $grupos = [];
    foreach ($servico->listar() as $c) {
        $grupos[$c['categoria']][] = $c;
    } ?>
    <div class="titulo-linha">
        <h1>Componentes do braço</h1>
        <a class="btn" href="componentes.php?acao=novo">+ Novo componente</a>
    </div>
    <?php if (!$grupos) { ?>
        <div class="cartao"><p class="vazio">Nenhum componente cadastrado ainda.</p></div>
    <?php } ?>
    <?php foreach ($grupos as $categoria => $itens) { ?>
        <h2 class="categoria"><?= e($categoria) ?></h2>
        <div class="grade">
            <?php foreach ($itens as $c) { ?>
                <article class="cartao peca">
                    <h3><?= e($c['nome']) ?> <span class="qtd">× <?= (int) $c['quantidade'] ?></span></h3>
                    <p><?= e($c['descricao']) ?></p>
                    <div class="linha-acoes">
                        <a class="btn peq sec" href="componentes.php?acao=editar&id=<?= $c['id'] ?>">Editar</a>
                        <form method="post" onsubmit="return confirm('Excluir este componente?')">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button class="btn peq perigo" type="submit">Excluir</button>
                        </form>
                    </div>
                </article>
            <?php } ?>
        </div>
    <?php } ?>
<?php }
rodape();
