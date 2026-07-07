<?php
// Єдине джерело контактних даних сайту.
// Використовується у footer.php та contacts.php — при зміні телефону чи адреси
// правити потрібно лише цей файл.

$siteContacts = [
    'company'  => 'ТзОВ «ТРК «Тернопільська хвиля»',
    'address'  => [
        'line1' => 'вул. Йосифа Сліпого Патріарха, будинок 5, приміщення 56',
        'line2' => 'Тернопіль, 46001',
    ],
    'phones'   => [
        'main'   => ['label' => 'Телефон',         'display' => '+38 (097) 133-14-70',  'tel' => '+380971331470'],
        'studio' => ['label' => 'Студія',           'display' => '+38 (097) 128-106-8',  'tel' => '+380971281068'],
        'ads'    => ['label' => 'Реклама',          'display' => '+38 (097) 322-03-30',  'tel' => '+380973220330'],
    ],
    'emails'   => [
        'main1' => ['label' => 'Адреса електронної пошти', 'address' => 'nazarfrankiv@gmail.com'],
        'main2' => ['label' => '',                          'address' => 'ternopilmedia@gmail.com'],
        'ads'   => ['label' => 'Реклама',                   'address' => 'reklama.ternopilwr@gmail.com'],
        'dir'   => ['label' => 'Директор – Олена Года',     'address' => 'olenahoda.ternopilwr@gmail.com'],
        'prog'  => ['label' => 'Програмний директор',       'address' => 'prog.ternopil.fm@gmail.com'],
        'music' => ['label' => 'Музичний редактор',         'address' => 'music.ternopil.fm@gmail.com'],
    ],
    'map_embed_src' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3097.380558702895!2d25.591414!3d49.551476!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473036b460aec8d3%3A0x7bfb1d020436a3a3!2z0LLRg9C70LjRhtGPINCf0LDRgtGA0ZbQsNGA0YXQsCDQmdC-0YHQuNGE0LAg0KHQu9GW0L_QvtCz0L4sIDUsINCi0LXRgNC90L7Qv9GW0LvRjCwg0KLQtdGA0L3QvtC_0ZbQu9GM0YHRjNC60LAg0L7QsdC70LDRgdGC0YwsINCj0LrRgNCw0ZfQvdCwLCA0NjAwMA!5e1!3m2!1suk!2sus!4v1751890523560!5m2!1suk!2sus',
];
