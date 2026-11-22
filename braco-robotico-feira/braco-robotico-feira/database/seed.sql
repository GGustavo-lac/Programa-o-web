-- Dados de exemplo (opcional):
--   mysql -u root -p --default-character-set=utf8mb4 braco_robotico < database/seed.sql
-- Ajuste os textos de acordo com a montagem real do grupo.
SET NAMES utf8mb4;
USE braco_robotico;

INSERT INTO componentes (categoria_id, nome, descricao, quantidade) VALUES
  ((SELECT id FROM categorias WHERE nome='Controle'),    'Arduino Uno',
   'Placa que funciona como o cérebro do braço: lê os potenciômetros e manda o sinal para cada servomotor.', 1),
  ((SELECT id FROM categorias WHERE nome='Movimento'),   'Servomotor SG90',
   'Motor pequeno que gira até um ângulo exato (de 0 a 180 graus). Há um para cada articulação: base, ombro, cotovelo e garra.', 4),
  ((SELECT id FROM categorias WHERE nome='Entrada'),     'Potenciômetro',
   'Botão giratório que varia a tensão elétrica. Cada um comanda uma articulação do braço.', 4),
  ((SELECT id FROM categorias WHERE nome='Conexão'),     'Protoboard',
   'Placa de ligações sem solda, usada para distribuir energia e sinais entre os componentes.', 1),
  ((SELECT id FROM categorias WHERE nome='Conexão'),     'Jumpers (fios)',
   'Fios coloridos que ligam o Arduino, os potenciômetros e os servos na protoboard.', 1),
  ((SELECT id FROM categorias WHERE nome='Alimentação'), 'Bateria 9V',
   'Fonte de energia externa para os servomotores, que consomem mais corrente que a porta USB entrega.', 1),
  ((SELECT id FROM categorias WHERE nome='Alimentação'), 'Capacitor eletrolítico',
   'Estabiliza a tensão para evitar quedas quando os servos puxam corrente ao mesmo tempo.', 1),
  ((SELECT id FROM categorias WHERE nome='Estrutura'),   'Estrutura em acrílico',
   'Peças pretas que formam a base, os segmentos do braço e a garra, fixadas em uma placa de madeira.', 1);

INSERT INTO visitantes (nome, email, instituicao) VALUES
  ('Ana Souza',    'ana@exemplo.com',   'Escola Técnica Estadual'),
  ('Bruno Lima',   'bruno@exemplo.com', 'Universidade Federal'),
  ('Carla Mendes', 'carla@exemplo.com', NULL);

INSERT INTO duvidas (visitante_id, componente_id, pergunta, resposta) VALUES
  (1, (SELECT id FROM componentes WHERE nome='Servomotor SG90'),
      'Por que o servo não gira uma volta completa?',
      'Esse servo é feito para posições entre 0 e 180 graus, por isso serve para articulações.'),
  (2, NULL, 'Quanto tempo levou para montar o braço?', NULL),
  (3, (SELECT id FROM componentes WHERE nome='Bateria 9V'),
      'Por que precisa de uma bateria se tem o cabo USB?', NULL);
