<div class="edition-bar">
<span>
<i aria-hidden="true">
</i> <?= $lastUpdate?'Última coleta: '.news_date($lastUpdate):'Edição sem notícias importadas' ?></span>
<button type="button" class="text-button" data-refresh>↻ Atualizar notícias</button>
</div>
<div class="page-heading">
<h1><?= e($search?'Resultados da busca':($category ?: 'Na pauta')) ?><span class="accent-dot">.</span>
</h1>
<span><?= (int)$result['total'] ?> notícias<?= $search?' para “'.e($search).'”':'' ?></span>
</div>
<nav class="reading-tabs" aria-label="Tipo de leitura">
<a class="<?= $reading==='full'?'active':'' ?>" href="index.php?<?= e(http_build_query(['reading'=>'full','category'=>$category,'q'=>$search,'source'=>$source])) ?>">Matérias completas</a>
<a class="<?= $reading==='all'?'active':'' ?>" href="index.php?<?= e(http_build_query(['reading'=>'all','category'=>$category,'q'=>$search,'source'=>$source])) ?>">Giro dos portais</a>
</nav>
<form class="filter-form" action="index.php">
<input type="hidden" name="reading" value="<?= e($reading) ?>">
<input type="hidden" name="category" value="<?= e($category) ?>">
<input type="hidden" name="q" value="<?= e($search) ?>">
<label for="source-filter">Acompanhar</label>
<select name="source" id="source-filter">
<option value="">Todas as fontes</option><?php foreach(fontes_noticias() as $key=>$feed): ?><option value="<?= e($key) ?>" <?= $source===$key?'selected':'' ?>><?= e($feed['name']) ?></option><?php endforeach; ?></select>
<button type="submit">Filtrar</button><?php if($search || $source): ?><a href="index.php<?= $category?'?category='.urlencode($category):'' ?>">Limpar filtros</a><?php endif; ?></form>
<?php $items=$result['items']; if(!$items): ?>
<section class="empty-state">
<h2><?= $search?'Nenhum resultado por aqui.':($reading==='full'?'Nenhuma matéria completa neste filtro.':'Esta editoria ainda está sem notícias.') ?></h2>
<p><?= $search?'Tente outro assunto ou retire o filtro de fonte.':'Experimente o Giro dos portais ou retire um filtro.' ?></p>
<a class="btn btn-primary" href="index.php">Ver todas as notícias</a>
</section>
<?php else: ?>
<?php if(!$search && $result['page']===1):
 $headlines=array_slice(array_values(array_filter($items,fn($story)=>$story['image_url']!=='')),0,3);
 foreach($items as $story) { if(count($headlines)>=3) break; if(!in_array($story['id'],array_column($headlines,'id'),true)) $headlines[]=$story; }
?>
<section class="headline-grid" aria-label="Destaques"><?php foreach($headlines as $index=>$item): ?>
 <article class="headline <?= $index===0?'headline-main':'' ?> <?= !$item['image_url']?'headline-no-image':'' ?>"><?php if($item['image_url']): ?><a class="photo-link" href="<?= news_link($item) ?>" tabindex="-1" aria-hidden="true">
<img src="<?= e(news_image($item)) ?>" data-news-image alt="" <?= $index?'loading="lazy"':'' ?> referrerpolicy="no-referrer">
</a><?php endif; ?><div class="headline-copy">
<span class="kicker"><?= e($item['category']) ?> <span>/ <?= e($item['source_name']) ?></span>
</span>
<h2>
<a href="<?= news_link($item) ?>"><?= e($item['title']) ?></a>
</h2><?php if($index===0 && news_teaser($item)): ?><p><?= e(news_teaser($item)) ?></p><?php endif; ?><div class="story-meta">
<time><?= news_date($item['published_at']) ?></time>
<span><?= news_reading_label($item) ?></span>
</div>
</div>
</article>
<?php endforeach; ?></section>
<?php $items=array_values(array_filter($items,fn($story)=>!in_array($story['id'],array_column($headlines,'id'),true))); endif; ?>
<div class="news-layout">
<section class="news-stream">
<div class="section-heading">
<h2><?= $search?'Notícias encontradas':'Últimas publicações' ?></h2>
<span>Mais recentes primeiro</span>
</div>
<?php foreach($items as $item): ?><article class="stream-item <?= !$item['image_url']?'stream-no-image':'' ?>"><?php if($item['image_url']): ?><a class="stream-image" href="<?= news_link($item) ?>" tabindex="-1" aria-hidden="true">
<img src="<?= e(news_image($item)) ?>" data-news-image alt="" loading="lazy" referrerpolicy="no-referrer">
</a><?php endif; ?><div>
<span class="kicker"><?= e($item['category']) ?> <span>/ <?= e($item['source_name']) ?></span>
</span>
<h3>
<a href="<?= news_link($item) ?>"><?= e($item['title']) ?></a>
</h3>
<p><?= e(news_teaser($item)) ?></p>
<time class="story-meta"><?= news_date($item['published_at']) ?></time>
</div>
</article><?php endforeach; ?>
</section>
<aside class="news-sidebar">
<section class="side-box">
<h2>Escolha sua pauta</h2>
<p>Uma editoria para cada interesse.</p><?php foreach(['Brasil'=>'O país em movimento','Mundo'=>'Além das fronteiras','Economia'=>'Dinheiro e negócios','Esportes'=>'Dentro e fora de campo','Tecnologia'=>'O próximo capítulo','Famosos'=>'TV, música e bastidores'] as $label=>$description): ?><a class="category-link" href="index.php?category=<?= urlencode($label) ?>">
<span>
<strong><?= e($label) ?></strong>
<small><?= e($description) ?></small>
</span>
<span>↗</span>
</a><?php endforeach; ?></section>
<section class="side-note">
<span class="kicker">DA NOSSA REDAÇÃO</span>
<h2>Você também tem uma pauta.</h2>
<p>Conheça o blog e publique seu próprio texto, com autoria e imagem.</p>
<a href="index.php?action=admin">Abrir o blog →</a>
</section>
</aside>
</div>
<?php if($result['pages']>1): ?><nav class="pagination-wrap" aria-label="Páginas de notícias"><?php for($n=1;$n<=$result['pages'];$n++): ?><a class="<?= $n===$result['page']?'active':'' ?>" <?= $n===$result['page']?'aria-current="page"':'' ?> href="index.php?<?= e(http_build_query(['category'=>$category,'q'=>$search,'source'=>$source,'page'=>$n,'reading'=>$reading])) ?>"><?= $n ?></a><?php endfor; ?></nav><?php endif; ?>
<?php endif; ?>
