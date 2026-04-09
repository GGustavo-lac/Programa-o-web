<?php
$pagina = <<<'HTML'
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Cursos</title>
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
        <a class="ativo" href="cursos.php">Cursos</a>
        <a href="calendario.php">Calendário 2026</a>
        <a href="noticias.php">Notícias</a>
        <a href="contato.php">Contato</a>
              <a href="gestao.php">Gestão</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="topo-pagina">
      <div class="container">
        <p class="kicker">Cursos</p>
        <h1>Áreas de formação oferecidas</h1>
        <p class="descricao-pagina">
          Conheça os cursos oferecidos pela unidade de maneira organizada e objetiva.
        </p>
      </div>
    </section>

    <section class="secao">
      <div class="container">
        <div class="grade-cards">
          <article class="card-info card-curso">
            <span class="tag-curso">Técnico</span>
            <h3>Administração</h3>
            <p>Conteúdos voltados à organização empresarial, planejamento, finanças e empreendedorismo.</p>
          </article>
          <article class="card-info card-curso">
            <span class="tag-curso">Técnico</span>
            <h3>Desenvolvimento de Sistemas</h3>
            <p>Lógica de programação, desenvolvimento web, banco de dados e construção de software.</p>
          </article>
          <article class="card-info card-curso">
            <span class="tag-curso">Técnico</span>
            <h3>Logística</h3>
            <p>Fluxo de materiais, armazenamento, distribuição, cadeia de suprimentos e processos.</p>
          </article>
          <article class="card-info card-curso">
            <span class="tag-curso">Técnico</span>
            <h3>Recursos Humanos</h3>
            <p>Gestão de pessoas, recrutamento, seleção, treinamento e rotinas do setor corporativo.</p>
          </article>
          <article class="card-info card-curso">
            <span class="tag-curso">Integrado</span>
            <h3>Ensino Médio com itinerários</h3>
            <p>Formação geral articulada com desenvolvimento acadêmico, protagonismo e projeto de vida.</p>
          </article>
          <article class="card-info card-curso">
            <span class="tag-curso">Projetos</span>
            <h3>Práticas interdisciplinares</h3>
            <p>Atividades que unem tecnologia, comunicação, pesquisa e solução de problemas reais.</p>
          </article>
        </div>
      </div>
    </section>
  </main>

  <footer class="rodape">
    <div class="container rodape-grid">
      <div>
        <h4>Etec Zona Leste</h4>
        <p>Informações sobre cursos, áreas de formação e modalidades oferecidas pela unidade.</p>
      </div>
      <div>
        <h4>Links</h4>
        <p><a href="instituicao.php">Instituição</a></p>
        <p><a href="noticias.php">Notícias</a></p>
        <p><a href="calendario.php">Calendário 2026</a></p>
      </div>
      <div>
        <h4>Contato</h4>
        <p>(11) 2045-4000</p>
        <p>contato@eteczonaleste.com.br</p>
        <p><a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="noopener noreferrer">Instagram oficial</a></p>
      </div>
    </div>
  </footer>
</body>
</html>

HTML;
echo $pagina;
?>
