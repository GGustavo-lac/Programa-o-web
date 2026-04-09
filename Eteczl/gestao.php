<?php
$pagina = <<<'HTML'
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Gestão</title>
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
        <a href="contato.php">Contato</a>
        <a class="ativo" href="gestao.php">Gestão</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="topo-pagina">
      <div class="container">
        <p class="kicker">Gestão</p>
        <h1>Gestão escolar e organização administrativa</h1>
      
      </div>
    </section>

    <section class="secao">
      <div class="container layout-conteudo">
        <div class="conteudo-principal">
          <h2>Equipe gestora</h2>
          <p>
            A gestão escolar organiza o funcionamento da unidade, acompanha processos pedagógicos,
            administrativos e o relacionamento com a comunidade escolar.
          </p>

          <div class="grade-cards grade-dupla">
            <article class="card-info">
              <h3>Direção</h3>
              <p>Responsável pela coordenação geral da unidade e pelo acompanhamento institucional.</p>
            </article>
            <article class="card-info">
              <h3>Coordenação pedagógica</h3>
              <p>Acompanha práticas pedagógicas, planejamento e apoio ao processo de ensino e aprendizagem.</p>
            </article>
            <article class="card-info">
              <h3>Secretaria acadêmica</h3>
              <p>Realiza atendimento, documentação escolar, matrículas e orientações administrativas.</p>
            </article>
            <article class="card-info">
              <h3>Comunidade escolar</h3>
              <p>Integra estudantes, professores, responsáveis e equipe escolar no cotidiano da unidade.</p>
            </article>
          </div>
        </div>

        <aside class="painel">
          <h3>Atendimento</h3>
          <p><strong>Horário:</strong> segunda a sexta, das 9h às 21h</p>
          <p><strong>Telefone:</strong> (11) 2045-4000</p>
          <p><strong>E-mail:</strong> contato@eteczonaleste.com.br</p>
          <a class="link-painel" href="contato.php">Entrar em contato</a>
        </aside>
      </div>
    </section>
  </main>

  <footer class="rodape">
    <div class="container rodape-grid">
      <div>
        <h4>Etec Zona Leste</h4>
        <p>Área dedicada a informações de gestão escolar.</p>
      </div>
      <div>
        <h4>Links</h4>
        <p><a href="index.php">Início</a></p>
        <p><a href="cursos.php">Cursos</a></p>
        <p><a href="contato.php">Contato</a></p>
      </div>
      <div>
        <h4>Unidade</h4>
        <p>São Paulo/SP</p>
        <p>Centro Paula Souza</p>
      </div>
    </div>
  </footer>
</body>
</html>
HTML;
echo $pagina;
?>
