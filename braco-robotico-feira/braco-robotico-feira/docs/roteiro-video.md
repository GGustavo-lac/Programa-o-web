# Roteiro do vídeo (YouTube) — ~5 a 7 minutos, toda a equipe aparece

O enunciado pede que a **equipe apresente os requisitos técnicos**. Sugestão de divisão (um integrante por bloco):

| # | Tempo | Quem | O que mostrar |
|---|---|---|---|
| 1 | 0:00–0:45 | Integrante 1 | Apresentação da equipe e o **braço robótico funcionando**. Explicar o tema IoT e o objetivo do site (explicar o braço para os visitantes). |
| 2 | 0:45–1:45 | Integrante 2 | **Banco de dados:** diagrama ER em `docs/modelo-logico.md` e `schema.sql` mostrando os **comentários**, PK/FK, `UNIQUE`, `CHECK` e `CASCADE` × `SET NULL` × `RESTRICT`. |
| 3 | 1:45–3:00 | Integrante 3 | **Arquitetura em serviços:** pasta `src/Services`, explicar que as páginas não têm SQL e só chamam o serviço. Mostrar PDO + prepared statements e o token CSRF. |
| 4 | 3:00–5:00 | Integrante 4 | **Site + CRUD ao vivo em 2+ entidades:** percorrer *Como funciona*; cadastrar visitante → registrar dúvida → responder (editar) → excluir; cadastrar/editar componente. Mostrar e-mail duplicado e a validação. |
| 5 | 5:00–6:00 | Integrante 1 ou 2 | Excluir um componente e mostrar que a dúvida vira **"Geral"**; excluir um visitante e mostrar as dúvidas sumindo. Abrir `api/componentes.php` (JSON). |
| 6 | 6:00–6:30 | Todos | **GitHub:** repositório público e README com prints. Encerramento. |

**Checklist antes de gravar**
- [ ] Banco criado e `seed.sql` importado
- [ ] Repositório do GitHub **público**
- [ ] Prints novos em `docs/img/` e nomes/links preenchidos no README
- [ ] Vídeo do YouTube como **Não listado** ou Público (conforme o professor pedir)
