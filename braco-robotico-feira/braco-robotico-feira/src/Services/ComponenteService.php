<?php
namespace App\Services;

use App\Database;
use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Serviço de COMPONENTES — catálogo das peças que formam o braço robótico.
 * Concentra validação, regras de negócio e SQL (as páginas não escrevem SQL).
 */
class ComponenteService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /** Categorias disponíveis (alimenta o <select> do formulário). */
    public function categorias(): array
    {
        return $this->db->query('SELECT id, nome FROM categorias ORDER BY nome')->fetchAll();
    }

    /** READ (lista) — JOIN traz o nome da categoria. */
    public function listar(): array
    {
        $sql = 'SELECT c.*, g.nome AS categoria
                  FROM componentes c
                  JOIN categorias g ON g.id = c.categoria_id
                 ORDER BY g.nome, c.nome';
        return $this->db->query($sql)->fetchAll();
    }

    /** READ (um registro) */
    public function buscar(int $id): ?array
    {
        $st = $this->db->prepare('SELECT * FROM componentes WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    /** CREATE */
    public function criar(array $dados): int
    {
        $d = $this->validar($dados);
        try {
            $st = $this->db->prepare(
                'INSERT INTO componentes (categoria_id, nome, descricao, quantidade) VALUES (?, ?, ?, ?)'
            );
            $st->execute([$d['categoria_id'], $d['nome'], $d['descricao'], $d['quantidade']]);
        } catch (PDOException $e) {
            $this->tratarDuplicidade($e);
        }
        return (int) $this->db->lastInsertId();
    }

    /** UPDATE */
    public function atualizar(int $id, array $dados): void
    {
        $d = $this->validar($dados);
        try {
            $st = $this->db->prepare(
                'UPDATE componentes SET categoria_id = ?, nome = ?, descricao = ?, quantidade = ? WHERE id = ?'
            );
            $st->execute([$d['categoria_id'], $d['nome'], $d['descricao'], $d['quantidade'], $id]);
        } catch (PDOException $e) {
            $this->tratarDuplicidade($e);
        }
    }

    /** DELETE — as dúvidas ligadas ao componente continuam, como "gerais" (ON DELETE SET NULL). */
    public function excluir(int $id): void
    {
        $this->db->prepare('DELETE FROM componentes WHERE id = ?')->execute([$id]);
    }

    private function validar(array $dados): array
    {
        $nome = trim($dados['nome'] ?? '');
        $desc = trim($dados['descricao'] ?? '');
        $cat  = filter_var($dados['categoria_id'] ?? null, FILTER_VALIDATE_INT);
        $qtd  = filter_var($dados['quantidade'] ?? null, FILTER_VALIDATE_INT);

        if ($nome === '' || tam($nome) > 80) {
            throw new InvalidArgumentException('Informe o nome do componente (até 80 caracteres).');
        }
        if ($desc === '' || tam($desc) > 500) {
            throw new InvalidArgumentException('Explique o que o componente faz (até 500 caracteres).');
        }
        if ($qtd === false || $qtd < 1 || $qtd > 99) {
            throw new InvalidArgumentException('A quantidade deve ser um número entre 1 e 99.');
        }
        // Confere se a categoria existe, assim o erro 23000 abaixo só pode ser nome repetido
        $st = $this->db->prepare('SELECT 1 FROM categorias WHERE id = ?');
        $st->execute([(int) $cat]);
        if (!$cat || !$st->fetchColumn()) {
            throw new InvalidArgumentException('Escolha uma categoria válida.');
        }
        return ['categoria_id' => $cat, 'nome' => $nome, 'descricao' => $desc, 'quantidade' => $qtd];
    }

    private function tratarDuplicidade(PDOException $e): never
    {
        if ($e->getCode() === '23000') {
            throw new InvalidArgumentException('Já existe um componente com este nome.');
        }
        throw $e;
    }
}
