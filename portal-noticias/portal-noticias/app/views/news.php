<?php $isFull=!empty($item['content_html']); $hasAi=tem_resumo($item); $minutes=max(1,(int)ceil(str_word_count(strip_tags($item['content_html'] ?? ''))/200)); ?>
<a class="back-link" href="index.php<?= $isFull?'?reading=full':'?category='.urlencode($item['category']) ?>">← <?= $isFull?'Matérias completas':e($item['category']) ?></a>
<article class="article-page external-article <?= $isFull?'full-report':'' ?>">
<span class="kicker"><?= e($item['category']) ?> / <?= e($item['source_name']) ?> · <?= $isFull?'MATÉRIA COMPLETA':($hasAi?'RESUMO COM IA':'CHAMADA DA FONTE') ?></span>
<h1><?= e($item['title']) ?></h1>
<div class="article-meta">
<span><?= $isFull?'Por '.e($item['author']):'Fonte: '.e($item['source_name']) ?></span>
<time><?= news_date($item['published_at']) ?></time><?php if($isFull): ?><span><?= $minutes ?> min de leitura</span><?php endif; ?></div>
<?php if($item['image_url']): ?><figure class="article-figure">
<img src="<?= e($item['image_url']) ?>" data-news-image alt="Imagem divulgada por <?= e($item['source_name']) ?> para esta notícia" referrerpolicy="no-referrer">
<figcaption>Imagem divulgada por <?= e($item['source_name']) ?>.</figcaption>
</figure><?php endif; ?>
<?php require __DIR__.'/resumo.php'; ?>
<?php if($isFull): ?>
<h2 class="full-text-heading">Leia a matéria</h2>
<div class="reader-tools" aria-label="Tamanho do texto">
<span>Leitura</span>
<button type="button" data-font="decrease" aria-label="Diminuir o tamanho do texto">A−</button>
<button type="button" data-font="increase" aria-label="Aumentar o tamanho do texto">A+</button>
</div>
<div class="full-article-body" id="texto-da-materia"><?= nl2br(e(texto_noticia($item['content_html']))) ?></div>
<div class="article-attribution">
<strong><?= e($item['source_name']) ?></strong>
<p>Publicado originalmente pela Agência Brasil. Texto reproduzido com crédito à fonte e autoria preservada.</p>
<a href="<?= e($item['license_url']) ?>" target="_blank" rel="noopener noreferrer">Reprodução com crédito — termos da EBC ↗</a>
</div>
<?php elseif(!$hasAi): ?>
<div class="article-summary">
<p><?= e($item['summary'] ?: 'A fonte disponibilizou apenas o título desta publicação.') ?></p>
</div>
<p class="summary-credit">Chamada disponibilizada por <?= e($item['source_name']) ?>. <a href="index.php?reading=full">Ver textos completos no portal →</a>
</p>
<?php endif; ?>
<div class="article-actions">
<a href="<?= e($item['url']) ?>" class="btn btn-primary original-article" target="_blank" rel="noopener noreferrer">Ler matéria completa ↗</a>
<button class="btn btn-outline-dark" type="button" data-save data-id="<?= (int)$item['id'] ?>" data-title="<?= e($item['title']) ?>" data-source="<?= e($item['source_name']) ?>" data-link="<?= news_link($item) ?>">Salvar para ler depois</button>
<button class="btn btn-outline-dark" type="button" data-share>Copiar link</button>
</div>
</article>
<?php if($related): ?><section class="related">
<div class="section-heading">
<h2>Continue a leitura</h2>
</div>
<div class="row g-4"><?php foreach($related as $other): ?><article class="col-md-4">
<a href="<?= news_link($other) ?>">
<span class="kicker"><?= e($other['source_name']) ?> · <?= e(news_reading_label($other)) ?></span>
<h3><?= e($other['title']) ?></h3>
</a>
</article><?php endforeach; ?></div>
</section><?php endif; ?>
