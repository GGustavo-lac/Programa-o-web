<?php
// ─── Ex 01 ───────────────────────────────────────────────────────────────────
$ex01_numero = isset($_POST['ex01_numero']) ? (int)$_POST['ex01_numero'] : null;

// ─── Ex 02 ───────────────────────────────────────────────────────────────────
$ex02_preco      = isset($_POST['ex02_preco'])      ? (float)$_POST['ex02_preco']      : null;
$ex02_percentual = isset($_POST['ex02_percentual']) ? (float)$_POST['ex02_percentual'] : null;

// ─── Ex 03 ───────────────────────────────────────────────────────────────────
$ex03_notas = []; $ex03_erro = '';
if (isset($_POST['ex03_submit'])) {
    for ($i = 1; $i <= 4; $i++) {
        $n = isset($_POST["ex03_nota$i"]) ? (float)$_POST["ex03_nota$i"] : null;
        if ($n === null || $n < 1 || $n > 10) { $ex03_erro = "Todas as notas devem estar entre 1 e 10."; break; }
        $ex03_notas[] = $n;
    }
}

// ─── Ex 05 ───────────────────────────────────────────────────────────────────
$ex05_nums = [];
if (isset($_POST['ex05_submit'])) {
    for ($i = 1; $i <= 3; $i++) $ex05_nums[] = isset($_POST["ex05_n$i"]) ? (float)$_POST["ex05_n$i"] : 0;
}

// ─── Ex 06 ───────────────────────────────────────────────────────────────────
$ex06_salario = isset($_POST['ex06_salario']) ? (float)$_POST['ex06_salario'] : null;

// ─── Ex 07 ───────────────────────────────────────────────────────────────────
$ex07_notas = [];
if (isset($_POST['ex07_submit'])) {
    for ($i = 1; $i <= 4; $i++) $ex07_notas[] = isset($_POST["ex07_nota$i"]) ? (float)$_POST["ex07_nota$i"] : 0;
}

// ─── Ex 08 ───────────────────────────────────────────────────────────────────
$ex08_nums = [];
if (isset($_POST['ex08_submit'])) {
    for ($i = 1; $i <= 3; $i++) $ex08_nums[] = (float)($_POST["ex08_n$i"] ?? 0);
}

// ─── Ex 09 ───────────────────────────────────────────────────────────────────
$ex09_ini = isset($_POST['ex09_ini']) ? (int)$_POST['ex09_ini'] : null;
$ex09_fim = isset($_POST['ex09_fim']) ? (int)$_POST['ex09_fim'] : null;

// ─── Ex 10 ───────────────────────────────────────────────────────────────────
$ex10_numero = isset($_POST['ex10_numero']) ? (int)$_POST['ex10_numero'] : null;

// ─── Ex 11 ───────────────────────────────────────────────────────────────────
$ex11_a = isset($_POST['ex11_a']) ? (float)$_POST['ex11_a'] : null;
$ex11_b = isset($_POST['ex11_b']) ? (float)$_POST['ex11_b'] : null;
$ex11_op = isset($_POST['ex11_op']) ? $_POST['ex11_op'] : null;
$ex11_resultado = null; $ex11_erro = '';
if ($ex11_a !== null && $ex11_b !== null && $ex11_op !== null) {
    switch ($ex11_op) {
        case '+': $ex11_resultado = $ex11_a + $ex11_b; break;
        case '-': $ex11_resultado = $ex11_a - $ex11_b; break;
        case '*': $ex11_resultado = $ex11_a * $ex11_b; break;
        case '/':
            if ($ex11_b == 0) $ex11_erro = 'Divisão por zero não é permitida.';
            else $ex11_resultado = $ex11_a / $ex11_b;
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exercícios PHP</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="page-header">
  <h1>Exercícios PHP</h1>
 
</header>

<div class="grid">

  <!-- EX 01 -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 01</span>
      <h2>Tabuada</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Número</label>
          <input type="number" name="ex01_numero" value="<?= htmlspecialchars($_POST['ex01_numero'] ?? '') ?>">
        </div>
        <button class="btn" type="submit" name="ex01_submit">Gerar</button>
      </form>
      <?php if ($ex01_numero !== null): ?>
      <div class="result">
        <div style="margin-bottom:.4rem;color:var(--muted);font-size:.7rem;">TABUADA DO <?= $ex01_numero ?></div>
        <ul class="tab-grid">
          <?php for ($i = 1; $i <= 10; $i++): ?>
            <li><?= $ex01_numero ?> × <?= $i ?> = <span><?= $ex01_numero * $i ?></span></li>
          <?php endfor; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!--  EX 02  -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 02</span>
      <h2>Cálculo de Desconto</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Preço (R$)</label>
          <input type="number" step="0.01" name="ex02_preco" value="<?= htmlspecialchars($_POST['ex02_preco'] ?? '') ?>">
        </div>
        <div class="field">
          <label>Desconto (%)</label>
          <input type="number" step="0.01" name="ex02_percentual" value="<?= htmlspecialchars($_POST['ex02_percentual'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Calcular</button>
      </form>
      <?php if ($ex02_preco !== null && $ex02_percentual !== null):
        $desc = $ex02_preco * ($ex02_percentual / 100);
        $final = $ex02_preco - $desc; ?>
      <div class="result">
        Original: R$ <?= number_format($ex02_preco, 2, ',', '.') ?><br>
        Desconto (<?= $ex02_percentual ?>%): − R$ <?= number_format($desc, 2, ',', '.') ?><br>
        <strong>Final: R$ <?= number_format($final, 2, ',', '.') ?></strong>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- EX 03 -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 03</span>
      <h2>Aprovado ou Reprovado</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <?php for ($i = 1; $i <= 4; $i++): ?>
        <div class="field">
          <label>Nota <?= $i ?></label>
          <input type="number" step="0.1" min="1" max="10" name="ex03_nota<?= $i ?>" value="<?= htmlspecialchars($_POST["ex03_nota$i"] ?? '') ?>">
        </div>
        <?php endfor; ?>
        <button class="btn" type="submit" name="ex03_submit">Verificar</button>
      </form>
      <?php if ($ex03_erro): ?>
        <div class="result"><span class="err"><?= $ex03_erro ?></span></div>
      <?php elseif (count($ex03_notas) === 4):
        $media = array_sum($ex03_notas) / 4;
        $aprovado = $media >= 5; ?>
        <div class="result">
          Média: <?= number_format($media, 2, ',', '.') ?><br>
          <strong class="<?= $aprovado ? 'ok' : 'err' ?>">
            <?= $aprovado ? 'Aprovado ✓' : 'Reprovado ✗' ?>
          </strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- EX 05  -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 05</span>
      <h2>Soma dos Quadrados</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="field">
          <label>Número <?= $i ?></label>
          <input type="number" step="any" name="ex05_n<?= $i ?>" value="<?= htmlspecialchars($_POST["ex05_n$i"] ?? '') ?>">
        </div>
        <?php endfor; ?>
        <button class="btn" type="submit" name="ex05_submit">Calcular</button>
      </form>
      <?php if (count($ex05_nums) === 3):
        $soma = $ex05_nums[0]**2 + $ex05_nums[1]**2 + $ex05_nums[2]**2; ?>
        <div class="result">
          <?= $ex05_nums[0] ?>² + <?= $ex05_nums[1] ?>² + <?= $ex05_nums[2] ?>²<br>
          <strong>= <?= $soma ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!--  EX 06 -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 06</span>
      <h2>Salário Líquido</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Salário Bruto (R$)</label>
          <input type="number" step="0.01" min="0" name="ex06_salario" value="<?= htmlspecialchars($_POST['ex06_salario'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Calcular</button>
      </form>
      <?php if ($ex06_salario !== null):
        $grat = $ex06_salario * 0.10;
        $imp  = $ex06_salario * 0.20;
        $liq  = $ex06_salario + $grat - $imp; ?>
        <div class="result">
          Bruto: R$ <?= number_format($ex06_salario, 2, ',', '.') ?><br>
          Gratificação +10%: R$ <?= number_format($grat, 2, ',', '.') ?><br>
          IR −20%: R$ <?= number_format($imp, 2, ',', '.') ?><br>
          <strong>Líquido: R$ <?= number_format($liq, 2, ',', '.') ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- EX 07  -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 07</span>
      <h2>Média com Descrição</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <?php for ($i = 1; $i <= 4; $i++): ?>
        <div class="field">
          <label>Nota <?= $i ?></label>
          <input type="number" step="0.1" min="0" max="10" name="ex07_nota<?= $i ?>" value="<?= htmlspecialchars($_POST["ex07_nota$i"] ?? '') ?>">
        </div>
        <?php endfor; ?>
        <button class="btn" type="submit" name="ex07_submit">Calcular</button>
      </form>
      <?php if (count($ex07_notas) === 4):
        $media = array_sum($ex07_notas) / 4;
        if ($media >= 6)    { $desc = 'Aprovado'; $cls = 'ok'; }
        elseif ($media < 3) { $desc = 'Retido';   $cls = 'err'; }
        else                { $desc = 'Exame';    $cls = 'warn'; } ?>
        <div class="result">
          Média: <?= number_format($media, 2, ',', '.') ?><br>
          <strong class="<?= $cls ?>"><?= $desc ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!--  EX 08 -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 08</span>
      <h2>Maior e Menor</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="field">
          <label>Número <?= $i ?></label>
          <input type="number" step="any" name="ex08_n<?= $i ?>" value="<?= htmlspecialchars($_POST["ex08_n$i"] ?? '') ?>">
        </div>
        <?php endfor; ?>
        <button class="btn" type="submit" name="ex08_submit">Verificar</button>
      </form>
      <?php if (count($ex08_nums) === 3): ?>
        <div class="result">
          <strong>Maior: <?= max($ex08_nums) ?></strong><br>
          <strong>Menor: <?= min($ex08_nums) ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- EX 09 -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 09</span>
      <h2>Soma dos Ímpares</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Valor Inicial</label>
          <input type="number" name="ex09_ini" value="<?= htmlspecialchars($_POST['ex09_ini'] ?? '') ?>">
        </div>
        <div class="field">
          <label>Valor Final</label>
          <input type="number" name="ex09_fim" value="<?= htmlspecialchars($_POST['ex09_fim'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Calcular</button>
      </form>
      <?php if ($ex09_ini !== null && $ex09_fim !== null):
        $s = min($ex09_ini, $ex09_fim); $e = max($ex09_ini, $ex09_fim);
        $soma = 0; $lista = [];
        for ($i = $s; $i <= $e; $i++) { if ($i % 2 !== 0) { $soma += $i; $lista[] = $i; } } ?>
        <div class="result">
          Ímpares: <?= $lista ? implode(', ', $lista) : '—' ?><br>
          <strong>Soma: <?= $soma ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!--  EX 10  -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 10</span>
      <h2>Par ou Ímpar</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Número</label>
          <input type="number" name="ex10_numero" value="<?= htmlspecialchars($_POST['ex10_numero'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Verificar</button>
      </form>
      <?php if ($ex10_numero !== null):
        $par = $ex10_numero % 2 === 0; ?>
        <div class="result">
          <strong class="<?= $par ? 'ok' : 'warn' ?>">
            <?= $ex10_numero ?> é <?= $par ? 'Par' : 'Ímpar' ?>
          </strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- EX 11  -->
  <div class="card">
    <div class="card-head">
      <span class="ex-badge">EX 11</span>
      <h2>Calculadora Básica</h2>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="field">
          <label>Valor A</label>
          <input type="number" step="any" name="ex11_a" value="<?= htmlspecialchars($_POST['ex11_a'] ?? '') ?>">
        </div>
        <div class="field">
          <label>Operador</label>
          <select name="ex11_op">
            <?php foreach (['+' => 'Soma (+)', '-' => 'Subtração (−)', '*' => 'Multiplicação (×)', '/' => 'Divisão (÷)'] as $o => $lbl): ?>
              <option value="<?= $o ?>" <?= (isset($_POST['ex11_op']) && $_POST['ex11_op'] === $o) ? 'selected' : '' ?>><?= $lbl ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>Valor B</label>
          <input type="number" step="any" name="ex11_b" value="<?= htmlspecialchars($_POST['ex11_b'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Calcular</button>
      </form>
      <?php if ($ex11_erro): ?>
        <div class="result"><span class="err"><?= $ex11_erro ?></span></div>
      <?php elseif ($ex11_resultado !== null): ?>
        <div class="result">
          <?= $ex11_a ?> <?= $ex11_op ?> <?= $ex11_b ?><br>
          <strong>= <?= number_format($ex11_resultado, 4, ',', '.') ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>
</body>
</html>
