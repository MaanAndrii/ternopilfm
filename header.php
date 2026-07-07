<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'ТРК "Тернопільська хвиля"'; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : ''; ?>">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo isset($pageUrl) ? htmlspecialchars($pageUrl) : 'https://ternopil.fm/'; ?>">
    <meta property="og:title" content="<?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'ТРК "Тернопільська хвиля"'; ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : ''; ?>">
    <meta property="og:image" content="https://ternopil.fm/images/og-image.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo isset($pageUrl) ? htmlspecialchars($pageUrl) : 'https://ternopil.fm/'; ?>">
    <meta property="twitter:title" content="<?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'ТРК "Тернопільська хвиля"'; ?>">
    <meta property="twitter:description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : ''; ?>">
    <meta property="twitter:image" content="https://ternopil.fm/images/og-image.jpg">

    <link rel="icon" href="icons/icon.png" type="image/png">
    <!-- Версіонування через filemtime: після зміни файлу браузери одразу тягнуть свіжу версію -->
    <link rel="stylesheet" href="styles.css?v=<?php echo filemtime(__DIR__ . '/styles.css'); ?>">
</head>
<body>

    <div class="social-bar">
        <a href="https://www.facebook.com/profile.php?id=61577361314413" target="_blank" class="social-icon facebook"><img src="icons/facebook.png" alt="Facebook"></a>
        <a href="https://www.instagram.com/ternopil_fm" target="_blank" class="social-icon instagram"><img src="icons/instagram.png" alt="Instagram"></a>
        <a href="https://www.tiktok.com/@radioternopilskakhvylia" target="_blank" class="social-icon tiktok"><img src="icons/tiktok.png" alt="TikTok"></a>
        <a href="mrplayer/mRPlayer.html" target="_blank" class="social-icon stream"><img src="icons/radio.png" alt="Трансляція"></a>
        <a href="https://lviv.fm/" target="_blank" class="social-icon lviv-wave"><img src="icons/hot-air-balloon.png" alt="Львівська Хвиля"></a>
    </div>

    <header class="site-header">
        <div class="container header-content">
            <div class="logo">
                <a href="/"><img src="images/logo.png" alt="ТРК Тернопільська хвиля" width="692" height="150"></a>
            </div>
            <nav class="main-nav" id="main-nav">
                <ul>
                    <li><a href="/">Головна</a></li>
                    <li><a href="/advertising">Реклама</a></li>
                    <li><a href="/contacts">Контакти</a></li>
                </ul>
            </nav>
            <button class="burger-menu" id="burger-menu">
                <span class="burger-bar"></span>
                <span class="burger-bar"></span>
                <span class="burger-bar"></span>
            </button>
        </div>
    </header>
