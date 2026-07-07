<?php
session_start();
header('Content-Type: application/json');

// Масив чисел та їх текстових представлень українською
$captchaNumbers = [
    ['value' => 1, 'word' => 'один'],
    ['value' => 2, 'word' => 'два'],
    ['value' => 3, 'word' => 'три'],
    ['value' => 4, 'word' => 'чотири'],
    ['value' => 5, 'word' => "п'ять"],
    ['value' => 6, 'word' => 'шість'],
    ['value' => 7, 'word' => 'сім'],
    ['value' => 8, 'word' => 'вісім'],
    ['value' => 9, 'word' => "дев'ять"],
];

$num1 = $captchaNumbers[array_rand($captchaNumbers)];
$num2 = $captchaNumbers[array_rand($captchaNumbers)];

// Зберігаємо правильну відповідь у сесії (на сервері)
$_SESSION['captcha_answer'] = $num1['value'] + $num2['value'];

// Випадково показуємо одне число текстом, інше — цифрою
if (rand(0, 1) === 1) {
    $question = "Скільки буде {$num1['word']} + {$num2['value']}?";
} else {
    $question = "Скільки буде {$num1['value']} + {$num2['word']}?";
}

echo json_encode(['question' => $question]);
?>
