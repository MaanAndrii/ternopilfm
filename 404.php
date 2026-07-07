<?php
    http_response_code(404);
    $pageTitle = "Сторінку не знайдено — ТРК \"Тернопільська хвиля\"";
    $pageDescription = "На жаль, такої сторінки не існує. Поверніться на головну сторінку радіо ТРК 'Тернопільська хвиля'.";
    $pageUrl = "https://ternopil.fm/";
    include 'header.php';
?>

    <main class="main-content-wrapper">
        <div class="container">
            <div class="error-page">
                <h1>404</h1>
                <h2>Сторінку не знайдено</h2>
                <p>На жаль, сторінки, яку ви шукаєте, не існує або її було переміщено.</p>
                <a href="/" class="btn-submit">Повернутись на головну</a>
            </div>
        </div>
    </main>

<?php include 'footer_bottom_only.php'; ?>
