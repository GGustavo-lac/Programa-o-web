-- =====================================================================
-- Projeto: Braço Robótico IoT - Feira Tecnológica
-- Site explicativo: catálogo de componentes + cadastro de visitantes
-- Banco relacional (MySQL / MariaDB)
-- ---------------------------------------------------------------------
-- Como importar:  mysql -u root -p < database/schema.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS braco_robotico
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE braco_robotico;
SET NAMES utf8mb4;

-- Remove na ordem inversa das dependências (filhas primeiro, pais depois)
DROP TABLE IF EXISTS duvidas;
DROP TABLE IF EXISTS componentes;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS visitantes;

-- ---------------------------------------------------------------------
-- TABELA DE DOMÍNIO: categorias
-- Agrupa os componentes do braço (Controle, Movimento, Entrada...).
-- Os valores são fixos e já vêm carregados abaixo.
-- ---------------------------------------------------------------------
CREATE TABLE categorias (
  id   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(40)  NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categorias_nome (nome)
) ENGINE=InnoDB;

INSERT INTO categorias (nome) VALUES
  ('Controle'), ('Entrada'), ('Movimento'), ('Alimentação'), ('Conexão'), ('Estrutura');

-- ---------------------------------------------------------------------
-- ENTIDADE 1: componentes  (catálogo das peças do braço)
-- Relação 1:N — uma categoria tem vários componentes.
--   * categoria em uso não pode ser apagada (ON DELETE RESTRICT)
-- ---------------------------------------------------------------------
CREATE TABLE componentes (
  id            INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  categoria_id  INT UNSIGNED     NOT NULL,
  nome          VARCHAR(80)      NOT NULL,
  descricao     VARCHAR(500)     NOT NULL,                 -- o que a peça faz no braço
  quantidade    TINYINT UNSIGNED NOT NULL DEFAULT 1,       -- quantas unidades existem no braço
  criado_em     TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_componentes_nome (nome),
  KEY idx_componentes_categoria (categoria_id),
  CONSTRAINT ck_componentes_qtd CHECK (quantidade BETWEEN 1 AND 99),
  CONSTRAINT fk_componentes_categoria FOREIGN KEY (categoria_id)
    REFERENCES categorias (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ENTIDADE 2: visitantes  (pessoas que passam pelo estande)
-- ---------------------------------------------------------------------
CREATE TABLE visitantes (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome        VARCHAR(100) NOT NULL,
  email       VARCHAR(120) NOT NULL,
  instituicao VARCHAR(100) NULL,                           -- escola, empresa etc. (opcional)
  criado_em   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_visitantes_email (email)                   -- um cadastro por e-mail
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ENTIDADE 3: duvidas  (perguntas dos visitantes sobre o braço)
-- Cada dúvida é de um visitante e, opcionalmente, sobre um componente.
--   * apagar o visitante apaga as dúvidas dele   (ON DELETE CASCADE)
--   * apagar o componente mantém a dúvida, que passa a ser "geral"
--     (componente_id vira NULL)                  (ON DELETE SET NULL)
-- A equipe responde editando o registro (coluna "resposta").
-- ---------------------------------------------------------------------
CREATE TABLE duvidas (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  visitante_id  INT UNSIGNED NOT NULL,
  componente_id INT UNSIGNED NULL,
  pergunta      VARCHAR(500) NOT NULL,
  resposta      VARCHAR(500) NULL,
  criado_em     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_duvidas_visitante (visitante_id),
  KEY idx_duvidas_componente (componente_id),
  CONSTRAINT fk_duvidas_visitante FOREIGN KEY (visitante_id)
    REFERENCES visitantes (id)  ON DELETE CASCADE  ON UPDATE CASCADE,
  CONSTRAINT fk_duvidas_componente FOREIGN KEY (componente_id)
    REFERENCES componentes (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;
