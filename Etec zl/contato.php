<?php
$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$assunto = trim($_POST["assunto"] ?? "");
$mensagem = trim($_POST["mensagem"] ?? "");
$enviado = $_SERVER["REQUEST_METHOD"] === "POST";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Mensagem enviada</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="cabecalho">
    <div class="container cabecalho-conteudo">
      <a class="marca" href="index.html">
        <img class="marca-logo" src="arquivos/logo-etec.png" alt="Logo da Etec">
      </a>

      <nav class="navegacao">
        <a href="index.html">Início</a>
        <a href="instituicao.html">Instituição</a>
        <a href="cursos.html">Cursos</a>
        <a href="calendario.html">Calendário 2026</a>
        <a href="noticias.html">Notícias</a>
        <a class="ativo" href="contato.html">Contato</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="secao">
      <div class="container">
        <div class="painel mensagem-retorno">
          <?php if ($enviado && $nome !== "" && $email !== "" && $assunto !== "" && $mensagem !== ""): ?>
            <p class="kicker">Contato</p>
            <h1>Mensagem recebida com sucesso</h1>
            <p>
              Sua mensagem foi registrada com os dados informados abaixo.
              Em caso de necessidade, a unidade poderá retornar pelos canais cadastrados.
            </p>

            <div class="dados-enviados">
              <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome, ENT_QUOTES, "UTF-8"); ?></p>
              <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?></p>
              <p><strong>Assunto:</strong> <?php echo htmlspecialchars($assunto, ENT_QUOTES, "UTF-8"); ?></p>
              <p><strong>Mensagem:</strong> <?php echo nl2br(htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8")); ?></p>
            </div>

            <a class="botao botao-primario" href="contato.html">Enviar outra mensagem</a>
          <?php else: ?>
            <p class="kicker">Atenção</p>
            <h1>Envio não realizado</h1>
            <p>
              Esta página deve ser acessada pelo formulário de contato. Preencha todos os campos
              para visualizar a confirmação de envio.
            </p>
            <a class="botao botao-primario" href="contato.html">Voltar ao formulário</a>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="rodape">
    <div class="container rodape-grid">
      <div>
        <h4>Etec Zona Leste</h4>
        <p>Retorno de confirmação do formulário de contato.</p>
      </div>
      <div>
        <h4>Links</h4>
        <p><a href="index.html">Início</a></p>
        <p><a href="contato.html">Contato</a></p>
        <p><a href="calendario.html">Calendário 2026</a></p>
      </div>
      <div>
        <h4>Contato</h4>
        <p>(11) 2045-4000</p>
        <p><a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="noopener noreferrer">Instagram oficial</a></p>
      </div>
    </div>
  </footer>
</body>
</html>
