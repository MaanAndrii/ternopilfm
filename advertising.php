<?php
    session_start();

    // Генерація CSRF-токена для захисту форми
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $pageTitle = "Реклама на радіо — ТРК \"Тернопільська хвиля\"";
    $pageDescription = "Замовте ефективну рекламу на радіо ТРК 'Тернопільська хвиля'. Заповніть форму, і наш менеджер з реклами зв'яжеться з вами.";
    $pageUrl = "https://ternopil.fm/advertising";
    include 'header.php'; 
?>

    <main class="main-content-wrapper">
        <div class="container">
            <form class="feedback-form" id="feedback-form" action="send_email.php" method="POST">
                <h2>Цікавить реклама</h2>
                
                <div class="form-group">
                    <label for="name">Ім'я / Компанія</label>
                    <input type="text" id="name" name="name" placeholder="Введіть ваше ім'я або назву компанії" required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" id="phone" name="phone" placeholder="+38 (___) ___-__-__" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="example@mail.com" required>
                </div>
                <div class="form-group">
                    <label for="message">Текст повідомлення</label>
                    <textarea id="message" name="message" rows="5" placeholder="Ваші побажання або запитання..." required></textarea>
                </div>
                <div class="form-group form-group-checkbox">
                    <input type="checkbox" id="consent" name="consent" required>
                    <label for="consent">Надаю згоду на використання та поширення особистих даних.</label>
                </div>
                
                <div class="form-group captcha-group">
                    <label for="captcha" id="captcha-label">Пройдіть перевірку:</label>
                    <input type="number" id="captcha" name="captcha" placeholder="Введіть відповідь" required>
                </div>

                <!-- CSRF-токен для захисту від міжсайтових підробок запитів -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <button type="submit" class="btn-submit" id="submit-btn">Відправити</button>
                <div class="form-status" id="form-status"></div>
            </form>
        </div>
    </main>

<?php include 'footer.php'; ?>
