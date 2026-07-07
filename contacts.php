<?php 
    $pageTitle = "Контакти — ТРК \"Тернопільська хвиля\"";
    $pageDescription = "Контактна інформація ТРК 'Тернопільська хвиля'. Зв'яжіться з нами! Адреса, телефони студії та рекламного відділу, електронні пошти.";
    $pageUrl = "https://ternopil.fm/contacts";
    include 'header.php'; 
?>

    <main class="main-content-wrapper">
        <div class="container">
            <div class="contact-page-grid">
                <div class="contact-info">
                    <h2>ТзОВ «ТРК «Тернопільська хвиля»</h2>
                    <p>
                        вул. Йосифа Сліпого Патріарха, будинок 5, приміщення 56.<br>
                        Тернопіль, 46001
                    </p>
                    <p>
                        <strong>Контакти для зв'язку:</strong><br>
                        <strong>Телефон:</strong> <a href="tel:+380971331470">+38 (097) 133-14-70</a><br>
                        <strong>Адреса електронної пошти:</strong> <a href="mailto:nazarfrankiv@gmail.com">nazarfrankiv@gmail.com</a><br>
                        <a href="mailto:ternopilmedia@gmail.com">ternopilmedia@gmail.com</a>
                    </p>
                    <p>
                        <strong>Студія:</strong> <a href="tel:+380971281068">+38 (097) 128-106-8</a><br>
                        <strong>Рекламний відділ:</strong> <a href="tel:+380973220330">+38 (097) 322-03-30</a>
                    </p>
                    <p>
                        <strong>Реклама:</strong> <a href="mailto:reklama.ternopilwr@gmail.com">reklama.ternopilwr@gmail.com</a><br>
                        <strong>Директор – Олена Года:</strong> <a href="mailto:olenahoda.ternopilwr@gmail.com">olenahoda.ternopilwr@gmail.com</a><br>
                        <strong>Програмний директор:</strong> <a href="mailto:prog.ternopil.fm@gmail.com">prog.ternopil.fm@gmail.com</a><br>
                        <strong>Музичний редактор:</strong> <a href="mailto:music.ternopil.fm@gmail.com">music.ternopil.fm@gmail.com</a>
                    </p>
                </div>
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3097.380558702895!2d25.591414!3d49.551476!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473036b460aec8d3%3A0x7bfb1d020436a3a3!2z0LLRg9C70LjRhtGPINCf0LDRgtGA0ZbQsNGA0YXQsCDQmdC-0YHQuNGE0LAg0KHQu9GW0L_QvtCz0L4sIDUsINCi0LXRgNC90L7Qv9GW0LvRjCwg0KLQtdGA0L3QvtC_0ZbQu9GM0YHRjNC60LAg0L7QsdC70LDRgdGC0YwsINCj0LrRgNCw0ZfQvdCwLCA0NjAwMA!5e1!3m2!1suk!2sus!4v1751890523560!5m2!1suk!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="google-map"></iframe>
                </div>
            </div>
        </div>
    </main>

<?php 
    // Підключаємо лише нижню частину футера, оскільки на цій сторінці вже є карта
    include 'footer_bottom_only.php'; 
?>