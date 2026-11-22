<?php
/**
 * Página de VISITANTES — CRUD completo.
 * Rotas: ?acao=listar (padrão) | ?acao=novo | ?acao=editar&id=N
 * POST:  acao=salvar (cria ou atualiza) | acao=excluir
 */
require __DIR__ . '/../src/bootstrap.php';

use App\Services\VisitanteService;

$servico = new VisitanteService();
$acao    = $_GET['acao'] ?? 'listar';
$id      = (int) ($_GET['id'] ?? 0);
$valores = ['nome' => '', 'email' => '', 'instituicao' => ''];

// ---------- Processa formulários (CREATE / UPDATE / DELETE) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validar();
    $idPost = (int) ($_POST['id'] ?? 0);
    try {
        if (($_POST['acao'] ?? '') === 'salvar') {
            if ($idPost) {
                $servico->atualizar($idPost, $_POST);
                flash('ok', 'Visitante atualizado.');
            } else {
                $servico->criar($_POST);
                flash('ok', 'Visitante cadastrado.');
            }
        } elseif (($_POST['acao'] ?? '') === 'excluir') {
            $servico->excluir($idPost);
            flash('ok', 'Visitante excluído (e as dúvidas dele).');
        }
        redirecionar('visitantes.php');
    } catch (InvalidArgumentException $e) {
        // Erro de validação: mostra a mensagem e reabre o formulário com o que foi digitado
        flash('erro', $e->getMessage());
        $valores = array_merge($valores, $_POST);
        $acao    = $idPost ? 'editar' : 'novo';
        $id      = $idPost;
    }
} elseif ($acao === 'editar') {
    // ---------- READ de um registro para preencher o formulário ----------
    $valores = $servico->buscar($id) ?? redirecionar('visitantes.php');
}

cabecalho('Visitantes', 'visitantes');

if ($acao === 'novo' || $acao === 'editar') { ?>
    <h1><?= $acao === 'editar' ? 'Editar visitante' : 'Novo visitante' ?></h1>
    <form method="post" class="cartao form">
        <?= csrf_campo() ?>
        <input type="hidden" name="acao" value="salvar">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Nome
            <input name="nome" maxlength="100" required value="<?= e($valores['nome']) ?>">
        </label>
        <label>E-mail
            <input type="email" name="email" maxlength="120" required value="<?= e($valores['email']) ?>">
        </label>
        <label>Instituição (opcional)
            <input name="instituicao" maxlength="100" value="<?= e($valores['instituicao']) ?>">
        </label>
        <div class="acoes">
            <button class="btn" type="submit">Salvar</button>
            <a class="btn sec" href="visitantes.php">Cancelar</a>
        </div>
    </form>
<?php } else { $lista = $servico->listar(); ?>
    <div class="titulo-linha">
        <h1>Visitantes</h1>
        <a class="btn" href="visitantes.php?acao=novo">+ Novo visitante</a>
    </div>
    <div class="cartao">
    <?php if (!$lista) { ?>
        <p class="vazio">Nenhum visitante cadastrado ainda.</p>
    <?php } else { ?>
        <table>
            <thead><tr><th>Nome</th><th>E-mail</th><th>Instituição</th><th>Cadastro</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($lista as $v) { ?>
                <tr>
                    <td><?= e($v['nome']) ?></td>
                    <td><?= e($v['email']) ?></td>
                    <td><?= e($v['instituicao'] ?? '—') ?></td>
                    <td><?= e(date('d/m/Y H:i', strtotime($v['criado_em']))) ?></td>
                    <td class="linha-acoes">
                        <a class="btn peq sec" href="visitantes.php?acao=editar&id=<?= $v['id'] ?>">Editar</a>
                        <form method="post" onsubmit="return confirm('Excluir este visitante e as dúvidas dele?')">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $v['id'] ?>">
                            <button class="btn peq perigo" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    </div>
<?php }
rodape();
