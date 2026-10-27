<?php
declare(strict_types=1);

/**
 * Consulta o CEP na API ViaCEP.
 * Retorna ['dados' => [...]] em caso de sucesso ou ['erro' => '...'] em caso de falha.
 */
function consultarCep(string $entrada): array
{
    // Mantém só os números (aceita "01001-000" ou "01001000")
    $cep = preg_replace('/\D/', '', $entrada);

    if (strlen($cep) !== 8) {
        return ['erro' => 'O CEP precisa ter 8 números. Exemplo: 01001-000.'];
    }

    // Requisição HTTP GET para a API pública
    $ch = curl_init("https://viacep.com.br/ws/{$cep}/json/");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
    ]);
    $resposta = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    if ($resposta === false || $status !== 200) {
        return ['erro' => 'Não foi possível acessar o ViaCEP agora. Tente novamente em instantes.'];
    }

    // Converte o JSON recebido em array PHP
    $dados = json_decode($resposta, true);

    // Para CEP inexistente a API responde 200 com {"erro": true}
    if (!is_array($dados) || isset($dados['erro'])) {
        return ['erro' => 'CEP não encontrado. Confira os números e tente de novo.'];
    }

    return ['dados' => $dados];
}

// Escapa o texto antes de imprimir no HTML (evita XSS)
function e(?string $texto): string
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}

// Rótulo exibido => chave no JSON do ViaCEP
$campos = [
    'CEP'        => 'cep',
    'Logradouro' => 'logradouro',
    'Bairro'     => 'bairro',
    'Cidade'     => 'localidade',
    'Estado'     => 'uf',
];

$cepDigitado = is_string($_POST['cep'] ?? null) ? trim($_POST['cep']) : '';
$resultado   = $_SERVER['REQUEST_METHOD'] === 'POST' ? consultarCep($cepDigitado) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de CEP</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
date_default_timezone_set('America/Sao_Paulo');

$erro   = $resultado['erro'] ?? null;
$aberto = isset($resultado['dados']);
$d      = $resultado['dados'] ?? [];

// Texto que o botão "Copiar endereço" coloca na área de transferência
$enderecoTexto = $aberto
    ? implode(', ', array_filter([
        $d['logradouro'] ?? '',
        $d['bairro'] ?? '',
        ($d['localidade'] ?? '') . '/' . ($d['uf'] ?? ''),
    ])) . ' - CEP ' . ($d['cep'] ?? '')
    : '';
?>
<header class="topo">
    <div class="topo-conteudo">
        <h1>Consulta de CEP</h1>
        <p class="intro">Digite um CEP e veja o endereço completo.</p>

        <form method="post">
            <label for="cep">CEP</label>
            <div class="busca">
                <input type="text" id="cep" name="cep" value="<?= e($cepDigitado) ?>"
                       placeholder="01001-000" inputmode="numeric" maxlength="9"
                       autocomplete="postal-code" required <?= $resultado === null ? 'autofocus' : '' ?>>
                <button type="submit">Consultar</button>
            </div>
        </form>
    </div>
</header>

<main class="mesa">
    <section class="resultado" aria-live="polite">
        <?php if ($erro): ?>
            <p class="erro" role="alert"><?= e($erro) ?></p>
        <?php elseif ($resultado === null): ?>
            <p class="vazio">Digite um CEP acima e abra a correspondência.</p>
        <?php endif; ?>

        <div class="correio<?= $aberto ? ' aberto' : '' ?><?= $erro ? ' recusado' : '' ?>">
            <?php if ($aberto): ?>
                <article class="carta">
                    <button type="button" class="copiar" data-texto="<?= e($enderecoTexto) ?>">Copiar endereço</button>
                    <dl>
                        <?php foreach ($campos as $rotulo => $chave): ?>
                            <div>
                                <dt><?= e($rotulo) ?></dt>
                                <dd><?= e($d[$chave] ?? '') ?: '—' ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </article>
            <?php endif; ?>

            <div class="envelope" aria-hidden="true">
                <div class="aba"></div>
                <div class="frente"></div>
                <?php if ($aberto): ?>
                    <div class="selo"><?= e($d['uf'] ?? '') ?></div>
                    <div class="carimbo"><?= e($d['localidade'] ?? '') ?><small><?= date('d/m/Y') ?></small></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script>
const campo = document.getElementById('cep');
const form  = campo.form;
const botao = form.querySelector('button');

// Máscara 00000-000 enquanto digita
campo.addEventListener('input', () => {
    const n = campo.value.replace(/\D/g, '').slice(0, 8);
    campo.value = n.length > 5 ? n.slice(0, 5) + '-' + n.slice(5) : n;
});

// Feedback enquanto a consulta acontece
form.addEventListener('submit', () => {
    botao.disabled = true;
    botao.textContent = 'Consultando';
});

// Se voltar pelo histórico, o botão volta ao normal
window.addEventListener('pageshow', () => {
    botao.disabled = false;
    botao.textContent = 'Consultar';
});

// Copiar endereço
const copiar = document.querySelector('.copiar');
if (copiar) {
    copiar.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(copiar.dataset.texto);
            copiar.textContent = 'Copiado';
        } catch {
            copiar.textContent = 'Não foi possível copiar';
        }
        setTimeout(() => { copiar.textContent = 'Copiar endereço'; }, 2000);
    });
}
</script>
</body>
</html>
