<?php
$nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '';
$endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : '';
$telefone = isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

$mensagem = "Obrigado {$nome}, por entrar em contato. Enviaremos uma mensagem para seu e-mail: {$email}.";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Processamento do Contato</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="cabecalho">
    <div class="container cabecalho-conteudo">
      <a class="marca" href="index.php">
        <img class="marca-logo" src="arquivos/logo-etec.png" alt="Logo da Etec">
      </a>
      <nav class="navegacao">
        <a href="index.php">Início</a>
        <a href="instituicao.php">Instituição</a>
        <a href="cursos.php">Cursos</a>
        <a href="calendario.php">Calendário 2026</a>
        <a href="noticias.php">Notícias</a>
        <a class="ativo" href="contato.php">Contato</a>
        <a href="gestao.php">Gestão</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="topo-pagina">
      <div class="container">
        <p class="kicker">Contato enviado</p>
        <h1>Mensagem processada com sucesso</h1>
       
      </div>
    </section>

    <section class="secao">
      <div class="container layout-conteudo">
        <div class="conteudo-principal">
          <div class="card-info">
            <h2>Confirmação</h2>
            <p><strong><?php echo $mensagem; ?></strong></p>
            <p><strong>Endereço informado:</strong> <?php echo $endereco; ?></p>
            <p><strong>Telefone informado:</strong> <?php echo $telefone; ?></p>
            <p><a href="contato.php">Voltar para contato</a></p>
          </div>
        </div>

        <aside class="painel">
          <h3>Resumo</h3>
          <p><strong>Nome:</strong> <?php echo $nome; ?></p>
          <p><strong>E-mail:</strong> <?php echo $email; ?></p>
        </aside>
      </div>
    </section>
  </main>
</body>
</html>