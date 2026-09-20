<div class="page-heading">
<h1>De onde vem a notícia<span class="accent-dot">.</span>
</h1>
<button class="btn btn-primary" data-refresh type="button">↻ Atualizar fontes</button>
</div>
<p class="intro">A origem da informação fica à vista. Conectamos feeds RSS públicos e organizamos as chamadas por editoria.</p>
<div class="source-grid"><?php foreach(fontes_noticias() as $key=>$feed): $state=$states[$key] ?? null; ?><article class="source-card">
<div>
<span class="kicker"><?= e($feed['category']) ?></span>
<h2><?= e($feed['name']) ?></h2>
</div>
<span class="status-pill <?= ($state['status'] ?? '')==='ok'?'status-ok':'' ?>"><?= ($state['status'] ?? '')==='ok'?'Feed conectado':(($state['status'] ?? '')==='error'?'Última tentativa falhou':'Aguardando coleta') ?></span>
<p><?= $state && $state['last_success']?'Última coleta bem-sucedida: '.news_date($state['last_success']):'Nenhuma coleta bem-sucedida registrada.' ?></p>
<p class="small"><?= e($state['message'] ?? '') ?></p>
<a href="index.php?source=<?= e($key) ?>">Ver notícias →</a>
</article><?php endforeach; ?>
</div>
<section class="editorial-policy">
<h2>Como esta edição funciona</h2>
<p>O portal reúne notícias de diferentes fontes. Os resumos preparados com auxílio de IA ficam identificados e possuem um link para a publicação original. Os textos próprios da Agência Brasil são apresentados na íntegra, com crédito à fonte. As imagens são divulgadas pelos respectivos portais.</p>
<p>As fontes são consultadas ao abrir ou recarregar uma página de notícias, ou ao apertar o botão de atualização. Quando uma fonte não responde, a edição anterior permanece disponível. A data acima mostra a última coleta bem-sucedida de cada fonte.</p>
<p>Os resumos já incluídos ficam salvos no banco; novas notícias mostram o trecho enviado pelo RSS. O horário de coleta é diferente da data de publicação: cada portal define quando publica uma notícia nova.</p>
</section>
