<?php

function fontes_noticias()
{
    return require dirname(__DIR__) . '/config/feeds.php';
}

// Remove as tags e mantém as quebras de linha do texto.
function texto_noticia($html)
{
    $html = preg_replace('/<(script|style|iframe|object)\b[^>]*>.*?<\/\1>/is', '', $html);
    $html = preg_replace('/<\/(p|div|h[1-6]|li|tr|blockquote)>|<br\s*\/?\s*>/i', "\n\n", $html);
    $texto = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim(preg_replace('/\n\s*\n\s*\n/u', "\n\n", $texto));
}

function buscar_noticia($pdo, $id)
{
    $consulta = $pdo->prepare('SELECT id, url_hash, source_key, source_name, category, title, summary,
        url, image_url, published_at, content_html, author, license_url, ai_summary, ai_basis, ai_reference_url
        FROM news WHERE id = ?');
    $consulta->execute([$id]);
    return $consulta->fetch();
}

// Aplica os filtros e divide as notícias em páginas.
function listar_noticias($pdo, $categoria = '', $busca = '', $fonte = '', $pagina = 1, $completas = false)
{
    $filtros = [];
    $valores = [];
    if ($categoria !== '') {
        $filtros[] = 'category = ?';
        $valores[] = $categoria;
    }
    if ($busca !== '') {
        $filtros[] = '(title LIKE ? OR summary LIKE ?)';
        $valores[] = '%' . $busca . '%';
        $valores[] = '%' . $busca . '%';
    }
    if ($fonte !== '') {
        $filtros[] = 'source_key = ?';
        $valores[] = $fonte;
    }
    if ($completas) {
        $filtros[] = "COALESCE(content_html, '') <> ''";
    }
    $where = $filtros ? ' WHERE ' . implode(' AND ', $filtros) : '';
    $consulta = $pdo->prepare('SELECT COUNT(*) FROM news' . $where);
    $consulta->execute($valores);
    $total = (int) $consulta->fetchColumn();
    $paginas = max(1, (int) ceil($total / 18));
    $pagina = min(max(1, (int) $pagina), $paginas);
    $inicio = ($pagina - 1) * 18;

    $consulta = $pdo->prepare('SELECT id, url_hash, source_key, source_name, category, title, summary,
        url, image_url, published_at, content_html, author, license_url, ai_summary, ai_basis, ai_reference_url
        FROM news' . $where . ' ORDER BY published_at DESC, id DESC LIMIT 18 OFFSET ' . $inicio);
    $consulta->execute($valores);
    return ['items' => $consulta->fetchAll(), 'total' => $total, 'page' => $pagina, 'pages' => $paginas];
}

function situacao_fontes($pdo)
{
    return $pdo->query('SELECT * FROM feed_status ORDER BY source_key')->fetchAll();
}

// Lê o título, a imagem, a data e o texto enviados pelo RSS.
function ler_rss($xml, $fonte)
{
    $fontes = fontes_noticias();
    if (!isset($fontes[$fonte]) || strlen($xml) > 4000000 || stripos($xml, '<!DOCTYPE') !== false) {
        throw new Exception('Feed inválido.');
    }
    if (str_starts_with($fonte, 'uol') && !mb_check_encoding($xml, 'UTF-8')) {
        $xml = mb_convert_encoding($xml, 'UTF-8', 'Windows-1252');
    }
    $anterior = libxml_use_internal_errors(true);
    $rss = simplexml_load_string($xml, SimpleXMLElement::class, LIBXML_NONET | LIBXML_NOCDATA);
    libxml_clear_errors();
    libxml_use_internal_errors($anterior);
    if (!$rss || !isset($rss->channel)) {
        throw new Exception('RSS não reconhecido.');
    }

    $noticias = [];
    foreach ($rss->channel->item as $item) {
        $url = safe_image_url((string) $item->link);
        $titulo = texto_noticia((string) $item->title);
        if (!$url || !$titulo) {
            continue;
        }
        $subtitulo = (string) $item->children('http://www.w3.org/2005/Atom')->subtitle;
        $resumo = preg_replace('/\s+/u', ' ', texto_noticia($subtitulo));
        $resumo = implode(' ', array_slice(explode(' ', $resumo), 0, 35));
        $midia = $item->children('http://search.yahoo.com/mrss/');
        $imagem = safe_image_url((string) ($midia->content['url'] ?? ''));
        $descricao = (string) $item->description;
        if (!$imagem && preg_match('/<img[^>]+src=["\']([^"\']+)/i', $descricao, $foto)) {
            $imagem = safe_image_url(html_entity_decode($foto[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }
        $data = preg_replace('/^[^,]+,\s*/', '', (string) $item->pubDate);
        $data = strtr($data, ['Fev'=>'Feb', 'Abr'=>'Apr', 'Mai'=>'May', 'Ago'=>'Aug', 'Set'=>'Sep', 'Out'=>'Oct', 'Dez'=>'Dec']);
        $horario = strtotime($data);
        if (!$horario) {
            continue;
        }
        $conteudo = '';
        $autor = '';
        $licenca = '';
        $categoria = $fontes[$fonte]['category'];

        // A Agência Brasil permite republicar seus textos próprios com crédito.
        if ($fonte === 'agenciabrasil') {
            $autor = mb_substr(trim((string) $item->children('http://purl.org/dc/elements/1.1/')->creator), 0, 180);
            $imagem = '';
            if (parse_url($url, PHP_URL_HOST) === 'agenciabrasil.ebc.com.br'
                && preg_match('/Ag[êe]ncia Brasil/ui', $autor)
                && !preg_match('/Reuters|Associated Press|France.Presse|Proibida reprodu[çc][ãa]o/ui', $autor . ' ' . $descricao)) {
                $conteudo = texto_noticia($descricao);
                $licenca = 'https://www.ebc.com.br/termos-de-uso-e-condicoes-gerais-do-portal-da-ebc';
            }
            $resumo = mb_strimwidth(preg_replace('/\s+/u', ' ', texto_noticia($descricao)), 0, 260, '…', 'UTF-8');
            $categorias = ['Economia'=>'Economia', 'Internacional'=>'Mundo', 'Esportes'=>'Esportes', 'Cultura'=>'Cultura', 'Educação'=>'Educação'];
            $categoria = $categorias[(string) $item->category] ?? 'Brasil';
        }
        $noticias[] = [
            'url_hash' => hash('sha256', $url), 'source_key' => $fonte,
            'source_name' => $fontes[$fonte]['name'], 'category' => $categoria,
            'title' => mb_substr($titulo, 0, 300), 'summary' => mb_substr($resumo, 0, 600),
            'url' => $url, 'image_url' => $imagem, 'published_at' => date('Y-m-d H:i:s', $horario),
            'content_html' => $conteudo, 'author' => $autor, 'license_url' => $licenca,
        ];
        if (count($noticias) >= 24) {
            break;
        }
    }
    if (!$noticias) {
        throw new Exception('O feed não trouxe notícias válidas.');
    }
    return $noticias;
}

// Atualiza notícias existentes e evita cadastrar a mesma URL duas vezes.
function salvar_noticias($pdo, $noticias)
{
    $alteradas = 0;
    $buscar = $pdo->prepare('SELECT * FROM news WHERE url_hash = :url_hash');
    $inserir = $pdo->prepare('INSERT INTO news (url_hash, source_key, source_name, category, title, summary, url, image_url, published_at, content_html, author, license_url)
        VALUES (:url_hash, :source_key, :source_name, :category, :title, :summary, :url, :image_url, :published_at, :content_html, :author, :license_url)
        ON DUPLICATE KEY UPDATE url_hash = VALUES(url_hash)');
    $atualizar = $pdo->prepare('UPDATE news SET title = :title, summary = :summary, content_html = :content_html,
        image_url = :image_url, published_at = :published_at, author = :author, license_url = :license_url,
        ai_summary = :ai_summary, ai_basis = :ai_basis, ai_reference_url = :ai_reference_url WHERE id = :id');

    foreach ($noticias as $noticia) {
        $buscar->execute(['url_hash' => $noticia['url_hash']]);
        $antiga = $buscar->fetch();
        if (!$antiga) {
            $inserir->execute($noticia);
            $alteradas += $inserir->rowCount() > 0 ? 1 : 0;
            continue;
        }
        $mudou = $antiga['title'] !== $noticia['title'] || $antiga['summary'] !== $noticia['summary']
            || texto_noticia($antiga['content_html'] ?? '') !== texto_noticia($noticia['content_html']);
        if ($mudou || $antiga['image_url'] !== $noticia['image_url']
            || $antiga['published_at'] !== $noticia['published_at']
            || $antiga['author'] !== $noticia['author'] || $antiga['license_url'] !== $noticia['license_url']) {
            $alteradas++;
        }
        $atualizar->execute([
            'title' => $noticia['title'], 'summary' => $noticia['summary'], 'content_html' => $noticia['content_html'],
            'image_url' => $noticia['image_url'], 'published_at' => $noticia['published_at'],
            'author' => $noticia['author'], 'license_url' => $noticia['license_url'], 'id' => $antiga['id'],
            'ai_summary' => $mudou ? null : $antiga['ai_summary'],
            'ai_basis' => $mudou ? '' : $antiga['ai_basis'],
            'ai_reference_url' => $mudou ? '' : $antiga['ai_reference_url'],
        ]);
    }
    return $alteradas;
}

function baixar_feed($url)
{
    $corpo = '';
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
        CURLOPT_ENCODING => '',
        CURLOPT_USERAGENT => 'PontoPauta RSS Reader',
        CURLOPT_WRITEFUNCTION => function ($conexao, $trecho) use (&$corpo) {
            if (strlen($corpo) + strlen($trecho) > 4000000) {
                return 0;
            }
            $corpo .= $trecho;
            return strlen($trecho);
        },
    ]);
    if (PHP_OS_FAMILY === 'Windows' && defined('CURLSSLOPT_NATIVE_CA')) {
        curl_setopt($curl, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
    }
    $resposta = curl_exec($curl);
    $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $erro = curl_error($curl);
    curl_close($curl);
    if ($resposta === false || $codigo !== 200) {
        throw new Exception($erro ?: 'A fonte respondeu com HTTP ' . $codigo . '.');
    }
    return $corpo;
}

// Informa quando o banco recebeu a última edição.
function versao_noticias($pdo)
{
    $consulta = $pdo->query('SELECT MAX(last_success) FROM feed_status');
    return $consulta->fetchColumn() ?: '';
}

// Consulta as fontes e mantém as notícias anteriores em caso de falha.
function atualizar_noticias($pdo)
{
    if (!function_exists('curl_init')) {
        throw new Exception('Habilite a extensão cURL do PHP.');
    }
    // Evita que duas abas atualizem as fontes ao mesmo tempo.
    if (!(int) $pdo->query("SELECT GET_LOCK('ponto_pauta_atualizacao', 0)")->fetchColumn()) {
        return ['results' => [], 'changed' => 0, 'busy' => true, 'version' => versao_noticias($pdo)];
    }
    $resultados = [];
    $alteradas = 0;
    try {
      foreach (fontes_noticias() as $chave => $fonte) {
        $consulta = $pdo->prepare("INSERT INTO feed_status (source_key, last_attempt, status) VALUES (?, NOW(), 'updating')
            ON DUPLICATE KEY UPDATE last_attempt = NOW(), status = 'updating'");
        $consulta->execute([$chave]);
        try {
            $itens = ler_rss(baixar_feed($fonte['url']), $chave);
            $alteradas += salvar_noticias($pdo, $itens);
            $consulta = $pdo->prepare("UPDATE feed_status SET status = 'ok', last_success = NOW(), item_count = ?, message = '' WHERE source_key = ?");
            $consulta->execute([count($itens), $chave]);
            $resultados[$chave] = 'ok';
        } catch (Throwable $erro) {
            error_log('RSS ' . $chave . ': ' . $erro->getMessage());
            $consulta = $pdo->prepare("UPDATE feed_status SET status = 'error', message = 'A fonte não respondeu. As notícias anteriores foram mantidas.' WHERE source_key = ?");
            $consulta->execute([$chave]);
            $resultados[$chave] = 'error';
        }
      }
    } finally {
        $pdo->query("SELECT RELEASE_LOCK('ponto_pauta_atualizacao')");
    }
    $falhas = (int) $pdo->query("SELECT COUNT(*) FROM feed_status WHERE status = 'error'")->fetchColumn();
    return ['results' => $resultados, 'changed' => $alteradas, 'busy' => false,
        'errors' => $falhas, 'version' => versao_noticias($pdo)];
}
