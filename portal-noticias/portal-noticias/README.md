# Ponto & Pauta

**Gustavo Lacerda — Projeto de Programação Web**

O Ponto & Pauta é um portal de notícias com um blog para publicações próprias. O projeto aplica o CRUD em PHP e MySQL, com páginas em HTML, CSS e Bootstrap e recursos de interação em JavaScript.

## Funcionamento

Na aba **Nosso blog**, é possível cadastrar, consultar, editar e excluir posts. Cada publicação possui título, autor, categoria, data e conteúdo completo. A imagem de capa e seu crédito são opcionais. Os formulários verificam os campos obrigatórios, e a exclusão exige confirmação.

A página inicial reúne notícias de Agência Brasil, g1, ge, UOL e gshow por meio de feeds RSS. Há busca, filtros por categoria e fonte, paginação e uma lista de notícias salvas no navegador. A consulta às fontes acontece ao abrir ou recarregar uma página de notícias e pelo botão **Atualizar notícias**. Se uma fonte não responder, os registros anteriores permanecem disponíveis.

As notícias externas mantêm os créditos e o link da publicação original. Parte delas possui resumos já salvos no banco; não há geração de novos resumos por IA nesta versão. Os posts próprios são exibidos com o conteúdo completo.

## Banco de dados

O arquivo `database/instalar.sql` cria o banco `portal_noticias` e inclui dados de exemplo. As tabelas são:

- `posts`: publicações cadastradas no blog.
- `news`: notícias recebidas dos portais.
- `feed_status`: situação e horário da última consulta a cada fonte.

O PHP utiliza PDO para as consultas ao MySQL. Os posts de exemplo são fictícios.

## Execução local

O projeto utiliza PHP 8 ou superior e MySQL. No XAMPP, a pasta `portal-noticias` fica dentro de `htdocs`, com Apache e MySQL iniciados. A instalação consiste na importação de `database/instalar.sql` pelo phpMyAdmin e na cópia de `config/database.example.php` para `config/database.php`, com os dados da conexão local.

Endereço: `http://localhost/portal-noticias/public/`.

A leitura dos feeds depende de internet e das extensões cURL, SimpleXML e mbstring. A conexão com o banco utiliza PDO MySQL. O sistema foi preparado para uso local e não possui login.

[Vídeo de demonstração do CRUD](docs/tutorial.webm) · [Repositório do projeto](https://github.com/GGustavo-lac/Programa-o-web)

