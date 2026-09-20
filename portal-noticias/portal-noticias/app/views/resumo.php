<?php if(tem_resumo($item)): ?>
<section class="ai-summary" aria-labelledby="ai-summary-heading">
 <div class="summary-label">
<span class="summary-symbol" aria-hidden="true">P.</span> Resumo gerado por IA</div>
 <h2 id="ai-summary-heading">Entenda a notícia</h2>
 <div class="ai-summary-text"><?= nl2br(e($item['ai_summary'])) ?></div>
 <p class="summary-basis"><?= e(origem_resumo($item['ai_basis'])) ?><?php $reference=safe_image_url($item['ai_reference_url'] ?? ''); if($reference && $reference!==$item['url']): ?> <a href="<?= e($reference) ?>" target="_blank" rel="noopener noreferrer">Fonte consultada ↗</a><?php endif; ?></p>
</section>
<?php endif; ?>
