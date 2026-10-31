<?php
// BetterWay Multilingual Dynamic OG & Language Controller
// Supports full Open Graph, Twitter Card, and Meta Tags for Telegram, WhatsApp, Viber, Facebook, Twitter, and Browsers

$lang = isset($_GET['lang']) ? strtolower(trim($_GET['lang'])) : '';
if ($lang === 'ua') $lang = 'uk';
if ($lang !== 'ru' && $lang !== 'uk') {
    $lang = 'en';
}

$meta = [
    'uk' => [
        'title' => 'Артем Варганич | Клубні подорожі до 67% та онлайн-бізнес (BetterWay)',
        'description' => 'Привіт, я Артем! Реальний досвід, проєкти в Канаді та Україні, подорожі в готелях 5★ зі знижкою до 67% та онлайн-бізнес.',
        'og_title' => 'BetterWay — Квиток у твоє краще життя',
        'og_desc' => 'Привіт, я Артем! Мій шлях, реальні проєкти, досвід у Канаді та Україні, і нові можливості для зростання та підвищення якості життя.',
        'og_image' => 'https://artem.thebetterway.top/betterway_og_uk.jpg',
        'locale' => 'uk_UA',
        'url' => 'https://artem.thebetterway.top/?lang=uk'
    ],
    'ru' => [
        'title' => 'Артём Варганич | Клубные путешествия до 67% и онлайн-бизнес (BetterWay)',
        'description' => 'Привет, я Артём! Мой путь, реальные проекты, опыт в Канаде и Украине, и новые возможности для роста и повышения качества жизни.',
        'og_title' => 'BetterWay — Билет в твою лучшую жизнь',
        'og_desc' => 'Привет, я Артём! Мой путь, реальные проекты, опыт в Канаде и Украине, и новые возможности для роста и повышения качества жизни.',
        'og_image' => 'https://artem.thebetterway.top/betterway_og_ru.jpg',
        'locale' => 'ru_RU',
        'url' => 'https://artem.thebetterway.top/?lang=ru'
    ],
    'en' => [
        'title' => 'Artem Varganych | Club Travel up to 67% off & Online Business (BetterWay)',
        'description' => "Hi, I'm Artem! Real journey, projects, experience in Canada and Ukraine, and new opportunities for travel, growth, and lifestyle.",
        'og_title' => 'BetterWay — Ticket to your better life',
        'og_desc' => "Hi, I'm Artem! Real journey, projects, experience in Canada and Ukraine, and new opportunities for travel, growth, and lifestyle.",
        'og_image' => 'https://artem.thebetterway.top/betterway_og_en.jpg',
        'locale' => 'en_US',
        'url' => 'https://artem.thebetterway.top/'
    ]
];

$cur = $meta[$lang];

function escapeMetaAttr($str) {
    return str_replace(['"', '<', '>'], ['&quot;', '&lt;', '&gt;'], $str);
}

$html = file_get_contents(__DIR__ . '/index.html');
if ($html === false) {
    http_response_code(500);
    echo "Site temporarily unavailable.";
    exit;
}

// 1. Replace <html ...>
$html = preg_replace('/<html[^>]*>/i', '<html lang="' . escapeMetaAttr($lang) . '">', $html, 1);

// 2. Replace <title>
$html = preg_replace('/<title>.*?<\/title>/is', '<title>' . escapeMetaAttr($cur['title']) . '</title>', $html, 1);

// 3. Replace <meta name="description" ...>
$html = preg_replace('/<meta\s+name="description"\s+content="[^"]*"/is', '<meta name="description" content="' . escapeMetaAttr($cur['description']) . '"', $html, 1);

// 4. Replace <link rel="canonical" ...>
$html = preg_replace('/<link\s+rel="canonical"\s+href="[^"]*"/is', '<link rel="canonical" href="' . escapeMetaAttr($cur['url']) . '"', $html, 1);

// 5. Replace Open Graph tags
$html = preg_replace('/<meta\s+property="og:title"\s+content="[^"]*"/is', '<meta property="og:title" content="' . escapeMetaAttr($cur['og_title']) . '"', $html, 1);
$html = preg_replace('/<meta\s+property="og:description"\s+content="[^"]*"/is', '<meta property="og:description" content="' . escapeMetaAttr($cur['og_desc']) . '"', $html, 1);
$html = preg_replace('/<meta\s+property="og:url"\s+content="[^"]*"/is', '<meta property="og:url" content="' . escapeMetaAttr($cur['url']) . '"', $html, 1);
$html = preg_replace('/<meta\s+property="og:image"\s+content="[^"]*"/is', '<meta property="og:image" content="' . escapeMetaAttr($cur['og_image']) . '"', $html, 1);
$html = preg_replace('/<meta\s+property="og:image:secure_url"\s+content="[^"]*"/is', '<meta property="og:image:secure_url" content="' . escapeMetaAttr($cur['og_image']) . '"', $html, 1);
$html = preg_replace('/<meta\s+property="og:locale"\s+content="[^"]*"/is', '<meta property="og:locale" content="' . escapeMetaAttr($cur['locale']) . '"', $html, 1);

// 6. Replace Twitter Card tags
$html = preg_replace('/<meta\s+name="twitter:title"\s+content="[^"]*"/is', '<meta name="twitter:title" content="' . escapeMetaAttr($cur['og_title']) . '"', $html);
$html = preg_replace('/<meta\s+name="twitter:description"\s+content="[^"]*"/is', '<meta name="twitter:description" content="' . escapeMetaAttr($cur['og_desc']) . '"', $html);
$html = preg_replace('/<meta\s+name="twitter:image"\s+content="[^"]*"/is', '<meta name="twitter:image" content="' . escapeMetaAttr($cur['og_image']) . '"', $html);

// 7. Inject SERVER_LANG definition
$server_script = '<script>window.SERVER_LANG = ' . json_encode($lang) . ';</script></head>';
$html = str_replace('</head>', $server_script, $html);

header('Content-Type: text/html; charset=UTF-8');
echo $html;
