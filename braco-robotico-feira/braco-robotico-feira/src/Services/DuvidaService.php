<?php
namespace App\Services;

use App\Database;
use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Serviço de DÚVIDAS — perguntas dos visitantes sobre o braço (e a resposta da equipe).
 * Liga as tabelas visitantes e componentes.
 */
class DuvidaService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /** READ (lista) — LEFT JOIN: dúvida "geral" não tem componente. */
    public function listar(): array
    {
        $sql = 'SELECT d.*, v.nome AS visitante, c.nome AS componente
                  FROM duvidas d
                  JOIN visitantes v       ON v.id = d.visitante_id
                  LEFT JOIN componentes c ON c.id = d.componente_id
                 ORDER BY d.criado_em DESC, d.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    /** READ (um registro) */
    public function buscar(int $id): ?array
    {
        $st = $this->db->prepare('SELECT * FROM duvidas WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    /** CREATE */
    public function criar(array $dados): int
    {
        $d = $this->validar($dados);
        $st = $this->db->prepare(
            'INSERT INTO duvidas (visitante_id, componente_id, pergunta, resposta) VALUES (?, ?, ?, ?)'
        );
        $st->execute([$d['visitante_id'], $d['componente_id'], $d['pergunta'], $d['resposta']]);
        return (int) $this->db->lastInsertId();
    }

    /** UPDATE (também é como a equipe registra a resposta) */
    public function atualizar(int $id, array $dados): void
    {
        $d = $this->validar($dados);
        $st = $this->db->prepare(
            'UPDATE duvidas SET visitante_id = ?, componente_id = ?, pergunta = ?, resposta = ? WHERE id = ?'
        );
        $st->execute([$d['visitante_id'], $d['componente_id'], $d['pergunta'], $d['resposta'], $id]);
    }

    /** DELETE */
    public function excluir(int $id): void
    {
        $this->db->prepare('DELETE FROM duvidas WHERE id = ?')->execute([$id]);
    }

    private function validar(array $dados): array
    {
        $visitante = filter_var($dados['visitante_id'] ?? null, FILTER_VALIDATE_INT);
        $compRaw   = trim((string) ($dados['componente_id'] ?? ''));
        $componente = $compRaw === '' ? null : filter_var($compRaw, FILTER_VALIDATE_INT);
        $pergunta  = trim($dados['pergunta'] ?? '');
        $resposta  = trim($dados['resposta'] ?? '');

        if (!$visitante) {
            throw new InvalidArgumentException('Escolha o visitante que fez a pergunta.');
        }
        if ($compRaw !== '' && !$componente) {
            throw new InvalidArgumentException('Componente inválido.');
        }
        if (tam($pergunta) < 5 || tam($pergunta) > 500) {
            throw new InvalidArgumentException('Escreva a pergunta (de 5 a 500 caracteres).');
        }
        if (tam($resposta) > 500) {
            throw new InvalidArgumentException('A resposta pode ter até 500 caracteres.');
        }
        // Confere se visitante (e componente, se houver) existem
        $this->exigirExistente('visitantes', $visitante, 'Visitante inexistente.');
        if ($componente !== null) {
            $this->exigirExistente('componentes', $componente, 'Componente inexistente.');
        }
        return [
            'visitante_id'  => $visitante,
            'componente_id' => $componente,
            'pergunta'      => $pergunta,
            'resposta'      => $resposta !== '' ? $resposta : null,
        ];
    }

    private function exigirExistente(string $tabela, int $id, string $mensagem): void
    {
        // $tabela vem sempre de constantes deste arquivo (nunca do usuário)
        $st = $this->db->prepare("SELECT 1 FROM {$tabela} WHERE id = ?");
        $st->execute([$id]);
        if (!$st->fetchColumn()) {
            throw new InvalidArgumentException($mensagem);
        }
    }
}
