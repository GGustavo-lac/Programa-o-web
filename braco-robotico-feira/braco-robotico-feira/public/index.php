<?php
/** Página inicial: apresenta o projeto e mostra contadores do banco. */
require __DIR__ . '/../src/bootstrap.php';

use App\Services\ComponenteService;
use App\Services\DuvidaService;
use App\Services\VisitanteService;

$totais = [
    'Componentes' => count((new ComponenteService())->listar()),
    'Visitantes'  => count((new VisitanteService())->listar()),
    'Dúvidas'     => count((new DuvidaService())->listar()),
];

cabecalho('Início', 'inicio');
?>
<section class="hero">
    <div>
        <h1>Conheça o nosso braço robótico</h1>
        <p>Protótipo IoT com Arduino e 4 servomotores, apresentado na Feira Tecnológica.
           Este site explica como ele funciona, mostra cada componente e recebe as dúvidas de quem visita o estande.</p>
        <p>
            <a class="btn" href="como-funciona.php">Como funciona</a>
            <a class="btn sec" href="visitantes.php?acao=novo">Cadastrar visitante</a>
        </p>
    </div>
    <img src="img/braco-robotico.jpeg" alt="Braço robótico montado com servomotores">
</section>

<section class="contadores">
    <?php foreach ($totais as $rotulo => $n) { ?>
        <div class="cartao contador"><strong><?= $n ?></strong><span><?= e($rotulo) ?></span></div>
    <?php } ?>
</section>
<?php rodape();
