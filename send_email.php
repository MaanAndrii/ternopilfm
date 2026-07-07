<?php
session_start();

// Захист від прямого доступу — лише POST-запити
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    echo "Виникла помилка. Спробуйте ще раз.";
    exit;
}

// --- Перевірка CSRF-токена ---
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo "Недійсний токен безпеки. Будь ласка, оновіть сторінку та спробуйте ще раз.";
    exit;
}

// --- Серверна перевірка капчі ---
if (
    !isset($_SESSION['captcha_answer']) ||
    !isset($_POST['captcha']) ||
    intval($_POST['captcha']) !== intval($_SESSION['captcha_answer'])
) {
    http_response_code(400);
    // Генеруємо нову капчу для наступної спроби
    unset($_SESSION['captcha_answer']);
    echo "Неправильна відповідь на питання капчі.";
    exit;
}

// Капча пройдена — очищуємо, щоб не можна було повторно використати
unset($_SESSION['captcha_answer']);

// --- Очищення та валідація вхідних даних ---
$name    = strip_tags(trim($_POST["name"] ?? ''));
$phone   = strip_tags(trim($_POST["phone"] ?? ''));
$email   = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
$message = strip_tags(trim($_POST["message"] ?? ''));

// Захист від email header injection: видаляємо переноси рядків з усіх полів заголовків
$name  = preg_replace('/[\r\n\t]/', ' ', $name);
$phone = preg_replace('/[\r\n\t]/', ' ', $phone);

// Перевірка обов'язкових полів
if (empty($name) || empty($phone) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Будь ласка, заповніть усі поля форми коректно.";
    exit;
}

// Перевірка довжини полів (захист від спаму)
if (strlen($name) > 200 || strlen($phone) > 30 || strlen($message) > 5000) {
    http_response_code(400);
    echo "Одне або кілька полів перевищують допустиму довжину.";
    exit;
}

// --- Формування та відправка листа ---
$recipient = "reklama.ternopilwr@gmail.com";
$subject   = "=?UTF-8?B?" . base64_encode("Нова заявка на рекламу з сайту від: $name") . "?=";

$email_content  = "Ім'я/Компанія: $name\n";
$email_content .= "Телефон: $phone\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Повідомлення:\n$message\n";

// Використовуємо фіксований відправник, а reply-to — адреса клієнта
$email_headers  = "From: Сайт ternopil.fm <noreply@ternopil.fm>\r\n";
$email_headers .= "Reply-To: $name <$email>\r\n";
$email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$email_headers .= "Content-Transfer-Encoding: 8bit\r\n";

if (mail($recipient, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Дякуємо! Ваше повідомлення відправлено. Ми зв'яжемось з вами найближчим часом.";
} else {
    http_response_code(500);
    echo "Виникла помилка на сервері. Не вдалося відправити повідомлення. Спробуйте пізніше.";
}
?>
