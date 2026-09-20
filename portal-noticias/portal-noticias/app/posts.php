<?php

// Consulta os posts do blog.
function listar_posts($pdo)
{
    $sql = 'SELECT *, LEFT(conteudo, 190) AS resumo FROM posts ORDER BY data_publicacao DESC, id DESC';
    return $pdo->query($sql)->fetchAll();
}

function buscar_post($pdo, $id)
{
    $consulta = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $consulta->execute(['id' => $id]);
    return $consulta->fetch();
}

// Salva um novo post no banco.
function cadastrar_post($pdo, $dados)
{
    $sql = 'INSERT INTO posts (titulo, autor, categoria, data_publicacao, conteudo, imagem_url, imagem_credito)
            VALUES (:titulo, :autor, :categoria, :data_publicacao, :conteudo, :imagem_url, :imagem_credito)';
    $consulta = $pdo->prepare($sql);
    $consulta->execute($dados);
    return (int) $pdo->lastInsertId();
}

// Atualiza os dados do post escolhido.
function editar_post($pdo, $id, $dados)
{
    $sql = 'UPDATE posts SET titulo = :titulo, autor = :autor, categoria = :categoria,
            data_publicacao = :data_publicacao, conteudo = :conteudo,
            imagem_url = :imagem_url, imagem_credito = :imagem_credito WHERE id = :id';
    $dados['id'] = $id;
    $consulta = $pdo->prepare($sql);
    $consulta->execute($dados);
}

// Exclui apenas o post informado.
function excluir_post($pdo, $id)
{
    $consulta = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $consulta->execute(['id' => $id]);
}
