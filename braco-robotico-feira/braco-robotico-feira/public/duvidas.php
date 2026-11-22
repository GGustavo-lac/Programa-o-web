<?php
/**
 * Página de DÚVIDAS — perguntas dos visitantes e respostas da equipe (CRUD completo).
 * Relaciona visitantes e componentes.
 */
require __DIR__ . '/../src/bootstrap.php';

use App\Services\ComponenteService;
use App\Services\DuvidaService;
use App\Services\VisitanteService;

$servico = new DuvidaService();
$acao    = $_GET['acao'] ?? 'listar';
$id      = (int) ($_GET['id'] ?? 0);
$valores = ['visitante_id' => '', 'componente_id' => '', 'pergunta' => '', 'resposta' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validar();
    $idPost = (int) ($_POST['id'] ?? 0);
    try {
        if (($_POST['acao'] ?? '') === 'salvar') {
            if ($idPost) {
                $servico->atualizar($idPost, $_POST);
                flash('ok', 'Dúvida atualizada.');
            } else {
                $servico->criar($_POST);
                flash('ok', 'Dúvida registrada.');
            }
        } elseif (($_POST['acao'] ?? '') === 'excluir') {
            $servico->excluir($idPost);
            flash('ok', 'Dúvida excluída.');
        }
        redirecionar('duvidas.php');
    } catch (InvalidArgumentException $e) {
        flash('erro', $e->getMessage());
        $valores = array_merge($valores, $_POST);
        $acao    = $idPost ? 'editar' : 'novo';
        $id      = $idPost;
    }
} elseif ($acao === 'editar') {
    $valores = $servico->buscar($id) ?? redirecionar('duvidas.php');
}

cabecalho('Dúvidas', 'duvidas');

if ($acao === 'novo' || $acao === 'editar') {
    $visitantes  = (new VisitanteService())->listar();
    $componentes = (new ComponenteService())->listar();
    ?>
    <h1><?= $acao === 'editar' ? 'Editar dúvida' : 'Nova dúvida' ?></h1>
    <?php if (!$visitantes) { ?>
        <div class="aviso erro">Cadastre pelo menos um visitante antes de registrar dúvidas.</div>
    <?php } ?>
    <form method="post" class="cartao form">
        <?= csrf_campo() ?>
        <input type="hidden" name="acao" value="salvar">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Quem perguntou
            <select name="visitante_id" required>
                <option value="">Selecione…</option>
                <?php foreach ($visitantes as $v) { ?>
                    <option value="<?= $v['id'] ?>" <?= (int) $valores['visitante_id'] === (int) $v['id'] ? 'selected' : '' ?>>
                        <?= e($v['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <label>Sobre qual componente? (opcional)
            <select name="componente_id">
                <option value="">Pergunta geral sobre o braço</option>
                <?php foreach ($componentes as $c) { ?>
                    <option value="<?= $c['id'] ?>" <?= (int) $valores['componente_id'] === (int) $c['id'] ? 'selected' : '' ?>>
                        <?= e($c['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <label>Pergunta
            <textarea name="pergunta" maxlength="500" rows="3" required><?= e($valores['pergunta']) ?></textarea>
        </label>
        <label>Resposta da equipe (opcional)
            <textarea name="resposta" maxlength="500" rows="3"><?= e($valores['resposta']) ?></textarea>
        </label>
        <div class="acoes">
            <button class="btn" type="submit">Salvar</button>
            <a class="btn sec" href="duvidas.php">Cancelar</a>
        </div>
    </form>
<?php } else { $lista = $servico->listar(); ?>
    <div class="titulo-linha">
        <h1>Dúvidas dos visitantes</h1>
        <a class="btn" href="duvidas.php?acao=novo">+ Nova dúvida</a>
    </div>
    <div class="cartao">
    <?php if (!$lista) { ?>
        <p class="vazio">Nenhuma dúvida registrada ainda.</p>
    <?php } else { ?>
        <table>
            <thead><tr><th>Visitante</th><th>Sobre</th><th>Pergunta e resposta</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($lista as $d) { ?>
                <tr>
                    <td><?= e($d['visitante']) ?><br><small><?= e(date('d/m/Y H:i', strtotime($d['criado_em']))) ?></small></td>
                    <td><?= e($d['componente'] ?? 'Geral') ?></td>
                    <td>
                        <strong><?= e($d['pergunta']) ?></strong><br>
                        <?php if ($d['resposta']) { ?>
                            <span class="resp"><?= e($d['resposta']) ?></span>
                        <?php } else { ?>
                            <span class="selo">Sem resposta</span>
                        <?php } ?>
                    </td>
                    <td class="linha-acoes">
                        <a class="btn peq sec" href="duvidas.php?acao=editar&id=<?= $d['id'] ?>">Editar</a>
                        <form method="post" onsubmit="return confirm('Excluir esta dúvida?')">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
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
