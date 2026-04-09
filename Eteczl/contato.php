<?php
$pagina = <<<'HTML'
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Contato</title>
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
        <p class="kicker">Contato</p>
        <h1>Envie sua mensagem para a unidade para solicitar informações e atendimento.</h1>
       
      </div>
    </section>

    <section class="secao">
      <div class="container layout-conteudo">
        <div class="conteudo-principal">
          <form class="formulario" action="processa.php" method="POST">
            <label for="nome">Nome</label>
            <input id="nome" name="nome" type="text" placeholder="Digite seu nome" required>

            <label for="endereco">Endereço</label>
            <input id="endereco" name="endereco" type="text" placeholder="Digite seu endereço" required>

            <label for="telefone">Telefone</label>
            <input id="telefone" name="telefone" type="text" placeholder="Digite seu telefone" required>

            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" placeholder="Digite seu e-mail" required>

            <button type="submit" class="botao botao-primario botao-formulario">Enviar mensagem</button>
          </form>
        </div>

        <aside class="painel">
          <h3>Informações de contato</h3>
          <p><strong>Telefone:</strong> (11) 2045-4000 / (11) 2045-4016</p>
          <p><strong>Endereço:</strong> Avenida Águia de Haia, 2.633 - São Paulo/SP</p>
          <p><strong>Atendimento:</strong> segunda a sexta, das 9h às 21h</p>
          <p><strong>Instagram:</strong> <a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="noopener noreferrer">@eteczonalesteoficial</a></p>
        </aside>
      </div>
    </section>
  </main>

  <footer class="rodape">
    <div class="container rodape-grid">
      <div>
        <h4>Etec Zona Leste</h4>
        <p>Página de contato.</p>
      </div>
      <div>
        <h4>Links</h4>
        <p><a href="index.php">Início</a></p>
        <p><a href="instituicao.php">Instituição</a></p>
        <p><a href="calendario.php">Calendário 2026</a></p>
      </div>
      <div>
        <h4>Contato</h4>
        <p>contato@eteczonaleste.com.br</p>
        <p>(11) 2045-4000</p>
        <p><a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="ig">Instagram oficial</a></p>
      </div>
    </div>
  </footer>
</body>
</html>

HTML;
echo $pagina;
?>
