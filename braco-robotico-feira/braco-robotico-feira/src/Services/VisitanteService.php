<?php
namespace App\Services;

use App\Database;
use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Serviço de VISITANTES — concentra a regra de negócio e o acesso ao banco.
 * As páginas (camada de apresentação) nunca escrevem SQL: só chamam estes métodos.
 */
class VisitanteService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /** READ (lista) */
    public function listar(): array
    {
        return $this->db->query('SELECT * FROM visitantes ORDER BY nome')->fetchAll();
    }

    /** READ (um registro) */
    public function buscar(int $id): ?array
    {
        $st = $this->db->prepare('SELECT * FROM visitantes WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    /** CREATE */
    public function criar(array $dados): int
    {
        $d = $this->validar($dados);
        try {
            $st = $this->db->prepare('INSERT INTO visitantes (nome, email, instituicao) VALUES (?, ?, ?)');
            $st->execute([$d['nome'], $d['email'], $d['instituicao']]);
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
            $st = $this->db->prepare('UPDATE visitantes SET nome = ?, email = ?, instituicao = ? WHERE id = ?');
            $st->execute([$d['nome'], $d['email'], $d['instituicao'], $id]);
        } catch (PDOException $e) {
            $this->tratarDuplicidade($e);
        }
    }

    /** DELETE (as dúvidas do visitante saem junto: ON DELETE CASCADE) */
    public function excluir(int $id): void
    {
        $this->db->prepare('DELETE FROM visitantes WHERE id = ?')->execute([$id]);
    }

    /** Valida e normaliza os dados vindos do formulário. */
    private function validar(array $dados): array
    {
        $nome  = trim($dados['nome'] ?? '');
        $email = strtolower(trim($dados['email'] ?? ''));
        $inst  = trim($dados['instituicao'] ?? '');

        if ($nome === '' || tam($nome) > 100) {
            throw new InvalidArgumentException('Informe o nome (até 100 caracteres).');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || tam($email) > 120) {
            throw new InvalidArgumentException('Informe um e-mail válido.');
        }
        if (tam($inst) > 100) {
            throw new InvalidArgumentException('A instituição pode ter até 100 caracteres.');
        }
        return ['nome' => $nome, 'email' => $email, 'instituicao' => $inst !== '' ? $inst : null];
    }

    /** Código 23000 = violação de integridade (aqui: e-mail repetido). */
    private function tratarDuplicidade(PDOException $e): never
    {
        if ($e->getCode() === '23000') {
            throw new InvalidArgumentException('Já existe um visitante com este e-mail.');
        }
        throw $e;
    }
}
