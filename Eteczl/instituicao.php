<?php
$pagina = <<<'HTML'
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etec Zona Leste | Instituição</title>
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
        <a class="ativo" href="instituicao.php">Instituição</a>
        <a href="cursos.php">Cursos</a>
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
        <p class="kicker">Instituição</p>
        <h1>Conheça a Etec Zona Leste</h1>
        <p class="descricao-pagina">
          Página institucional com resumo da unidade, missão, estrutura e atendimento.
        </p>
      </div>
    </section>

    <section class="secao">
      <div class="container layout-conteudo">
        <div class="conteudo-principal">
          <h2>História e propósito</h2>
          <p>
            A Etec Zona Leste integra a rede do Centro Paula Souza e atua na formação de estudantes
            com foco em educação pública, técnica e de qualidade.
          </p>
          <p>
            A escola busca desenvolver competências acadêmicas, profissionais e sociais,
            promovendo aprendizagem significativa, cidadania e preparação para diferentes trajetórias.
          </p>

          <div class="galeria-institucional">
            <figure class="foto-destaque">
              <img src="arquivos/imagens/vista-campus.jpg" alt="Vista aérea da Etec Zona Leste">
              <figcaption>Vista geral da Etec Zona Leste e de seus espaços de convivência.</figcaption>
            </figure>
            <div class="galeria-grid">
              <figure>
                <img src="arquivos/imagens/bloco-a.jpg" alt="Bloco de acesso da Etec Zona Leste">
                <figcaption>Área de circulação e acesso entre os blocos da unidade.</figcaption>
              </figure>
              <figure>
                <img src="arquivos/imagens/sala-aula.jpeg" alt="Sala de aula da Etec Zona Leste">
                <figcaption>Salas preparadas para aulas regulares e atividades orientadas.</figcaption>
              </figure>
              <figure>
                <img src="arquivos/imagens/auditorio.jpeg" alt="Auditório da Etec Zona Leste">
                <figcaption>Auditório utilizado em palestras, eventos e apresentações escolares.</figcaption>
              </figure>
            </div>
          </div>

          <h2>Missão educacional</h2>
          <p>
            Formar estudantes com base sólida, pensamento crítico, domínio técnico e compromisso
            com ética, inovação e participação na sociedade.
          </p>

          <h2>Estrutura</h2>
          <div class="grade-cards grade-dupla">
            <article class="card-info">
              <h3>Laboratórios</h3>
              <p>Ambientes para informática, desenvolvimento de projetos, aulas práticas e atividades aplicadas.</p>
            </article>
            <article class="card-info">
              <h3>Biblioteca</h3>
              <p>Espaço de estudo, consulta e apoio à pesquisa em diferentes áreas do conhecimento.</p>
            </article>
            <article class="card-info">
              <h3>Salas de aula</h3>
              <p>Ambientes preparados para ensino regular, atividades colaborativas e apresentações.</p>
            </article>
            <article class="card-info">
              <h3>Projetos</h3>
              <p>Feiras, ações interdisciplinares, atividades culturais e participação estudantil.</p>
            </article>
          </div>
        </div>

        <aside class="painel">
          <h3>Atendimento</h3>
          <p><strong>Secretaria:</strong> segunda a sexta-feira</p>
          <p><strong>Horário:</strong> 9h às 21h</p>
          <p><strong>Telefone:</strong> (11) 2045-4000</p>
          <p><strong>E-mail:</strong> contato@eteczonaleste.com.br</p>
          <p><strong>Instagram:</strong> <a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="noopener noreferrer">@eteczonalesteoficial</a></p>
          <a class="link-painel" href="contato.php">Ir para contato</a>
        </aside>
      </div>
    </section>
  </main>

  <footer class="rodape">
    <div class="container rodape-grid">
      <div>
        <h4>Etec Zona Leste</h4>
        <p>Informações institucionais e acadêmicas.</p>
      </div>
      <div>
        <h4>Navegação</h4>
        <p><a href="index.php">Início</a></p>
        <p><a href="cursos.php">Cursos</a></p>
        <p><a href="calendario.php">Calendário 2026</a></p>
      </div>
      <div>
        <h4>Unidade</h4>
        <p>São Paulo/SP</p>
        <p>Centro Paula Souza</p>
        <p><a href="https://www.instagram.com/eteczonalesteoficial/" target="_blank" rel="noopener noreferrer">Instagram oficial</a></p>
      </div>
    </div>
  </footer>
</body>
</html>

HTML;
echo $pagina;
?>
