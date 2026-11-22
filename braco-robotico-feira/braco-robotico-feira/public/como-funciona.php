<?php
/** Página explicativa (conteúdo fixo): como o braço robótico funciona. */
require __DIR__ . '/../src/bootstrap.php';

cabecalho('Como funciona', 'como');
?>
<h1>Como o braço robótico funciona</h1>
<p class="intro">O braço é um protótipo IoT feito com Arduino. Quem gira os potenciômetros decide o ângulo de cada articulação — o Arduino faz a ponte entre o que a pessoa faz e o movimento dos motores.</p>

<div class="passos">
    <div class="cartao passo"><span class="num">1</span><h3>Você gira o potenciômetro</h3>
        <p>Cada botão giratório muda a tensão elétrica que chega ao Arduino.</p></div>
    <div class="cartao passo"><span class="num">2</span><h3>O Arduino lê o sinal</h3>
        <p>A entrada analógica transforma a tensão em um número de 0 a 1023.</p></div>
    <div class="cartao passo"><span class="num">3</span><h3>O número vira ângulo</h3>
        <p>O programa converte esse valor para um ângulo entre 0° e 180°.</p></div>
    <div class="cartao passo"><span class="num">4</span><h3>O servo se move</h3>
        <p>O Arduino envia o sinal ao servomotor, que gira até o ângulo pedido.</p></div>
</div>

<h2 class="categoria">As 4 articulações</h2>
<div class="cartao">
    <table>
        <thead><tr><th>Articulação</th><th>O que move</th><th>Comando</th></tr></thead>
        <tbody>
            <tr><td><strong>Base</strong></td><td>Gira o braço para os lados</td><td>1 potenciômetro + 1 servo</td></tr>
            <tr><td><strong>Ombro</strong></td><td>Levanta e abaixa o braço</td><td>1 potenciômetro + 1 servo</td></tr>
            <tr><td><strong>Cotovelo</strong></td><td>Estica e dobra o braço</td><td>1 potenciômetro + 1 servo</td></tr>
            <tr><td><strong>Garra</strong></td><td>Abre e fecha para segurar objetos</td><td>1 potenciômetro + 1 servo</td></tr>
        </tbody>
    </table>
</div>

<h2 class="categoria">Veja por dentro</h2>
<div class="galeria">
    <figure><img src="img/braco-robotico.jpeg" alt="Braço robótico montado"><figcaption>O braço montado</figcaption></figure>
    <figure><img src="img/arduino-protoboard.jpeg" alt="Arduino Uno e protoboard"><figcaption>Arduino Uno e protoboard</figcaption></figure>
    <figure><img src="img/esquema-tinkercad.jpeg" alt="Esquema elétrico feito no Tinkercad"><figcaption>Esquema no Tinkercad</figcaption></figure>
</div>

<p><a class="btn" href="componentes.php">Conhecer cada componente</a></p>
<?php rodape();
