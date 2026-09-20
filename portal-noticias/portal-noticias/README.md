# Ponto & Pauta

Portal de notícias e blog desenvolvido por **Gustavo Lacerda** para a atividade de Programação Web.

Tecnologias: PHP, MySQL, Bootstrap, JavaScript, HTML e CSS.

## Etapa 1 — Preparação

É necessário ter PHP 8 ou superior e MySQL. O XAMPP reúne esses programas.

1. Coloque a pasta `portal-noticias` dentro de `htdocs` do XAMPP.
2. Inicie o Apache e o MySQL.
3. Abra o phpMyAdmin e importe `database/instalar.sql`.
4. Copie `config/database.example.php` para `config/database.php`.
5. Confira o nome do banco, usuário, senha e porta nesse arquivo.
6. Acesse `http://localhost/portal-noticias/public/`.

O SQL cria o banco `portal_noticias`, com três tabelas: `posts`, `news` e `feed_status`. Também inclui os posts de exemplo e as notícias da edição de 09/09/2026. A reimportação não apaga os registros existentes.

Outra opção, com o MySQL já iniciado, é abrir um terminal na pasta do projeto e executar:

```bash
php -S 127.0.0.1:8087 -t public
```

Nesse caso, o endereço é `http://127.0.0.1:8087/`.

## Etapa 2 — Usar o blog

Na aba **Nosso blog**:

1. Clique em **Novo post**.
2. Preencha título, autor, categoria, data e conteúdo completo.
3. Adicione uma imagem e seu crédito, se necessário.
4. Salve e abra o post para ler.
5. Use **Editar post** para alterar os dados.
6. Use **Excluir post** e confirme a exclusão.

Os dados ficam salvos no MySQL. O PHP confere os campos obrigatórios antes de cadastrar ou atualizar.

## Etapa 3 — Ler notícias

A página inicial reúne notícias de Agência Brasil, g1, ge, UOL e gshow. Há categorias, busca, filtro por fonte, paginação e uma lista de notícias salvas no navegador.

As fontes são consultadas ao entrar ou recarregar uma página de notícias, ou ao apertar **Atualizar notícias**. Não há consultas por temporizador nem coleta em segundo plano. Se uma fonte falhar, as notícias anteriores permanecem disponíveis.

O painel **Fontes** mostra o resultado e o horário de cada coleta. Novas notícias dependem das publicações dos portais e da conexão com a internet. A coleta usa cURL, SimpleXML e mbstring do PHP; o banco usa PDO MySQL.

Esta edição inclui resumos preparados com auxílio de IA. Eles já estão no banco e não precisam de chave de API. Quando a fonte altera o texto de uma notícia, o resumo antigo é retirado para não mostrar informações desatualizadas. Novas notícias usam o texto disponibilizado pelo RSS; esta versão não gera novos resumos automaticamente.

Cada notícia mantém o crédito e o link da fonte. A aba **Matérias completas** reúne os textos próprios da Agência Brasil permitidos para reprodução com crédito, conforme os [termos da EBC](https://www.ebc.com.br/termos-de-uso-e-condicoes-gerais-do-portal-da-ebc). As fotos externas dependem da disponibilidade dos portais. Os posts de exemplo do blog são fictícios.

## Etapa 4 — Entender os arquivos

| Arquivo ou pasta | Função |
| --- | --- |
| `public/index.php` | Recebe os pedidos e escolhe a página |
| `app/posts.php` | Cadastra, consulta, edita e exclui posts |
| `app/noticias.php` | Consulta o banco e lê os feeds RSS |
| `app/functions.php` | Confere os formulários e formata os dados |
| `app/bootstrap.php` | Inicia a sessão e conecta ao MySQL |
| `app/home.php` e `app/pages.php` | Preparam os dados das páginas |
| `app/views/` | Contém o HTML das páginas |
| `public/api/news.php` | Responde aos pedidos de notícias em JSON |
| `public/assets/` | Contém CSS, JavaScript, Bootstrap e imagens do portal |
| `config/` | Contém os dados do banco e os endereços dos feeds |
| `database/instalar.sql` | Cria as tabelas e adiciona os dados iniciais |
| `docs/tutorial.webm` | Demonstra a navegação e o CRUD |

## Etapa 5 — Apresentação

1. Abra o portal, escolha uma categoria e consulte uma notícia.
2. Acesse **Nosso blog** e cadastre um post de teste.
3. Abra o post, edite seu conteúdo e confira a alteração.
4. Exclua o post e mostre a listagem novamente.
5. Apresente o README e o arquivo SQL.

O vídeo incluído demonstra o CRUD e a leitura de notícias. Foi gravado antes da inclusão do bloco de resumos.

Repositório: [GGustavo-lac/Programa-o-web](https://github.com/GGustavo-lac/Programa-o-web).

O portal é um projeto local sem login. A licença do Bootstrap está em `public/assets/vendor/LICENSE-bootstrap.txt`.
