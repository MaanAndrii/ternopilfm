document.addEventListener('DOMContentLoaded', function() {

    // --- Логіка для меню-"бургера" ---
    const burgerMenu = document.getElementById('burger-menu');
    const mainNav = document.getElementById('main-nav');
    if (burgerMenu && mainNav) {
        burgerMenu.addEventListener('click', function() {
            mainNav.classList.toggle('active');
        });
        // Закриваємо меню при кліку на посилання
        mainNav.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                mainNav.classList.remove('active');
            });
        });
    }

    // --- Логіка для кнопки "Вгору" ---
    const scrollToTopBtn = document.getElementById('scroll-to-top');
    if (scrollToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // --- Логіка для форми зі серверною капчею ---
    const feedbackForm = document.getElementById('feedback-form');
    if (feedbackForm) {
        const captchaLabel = document.getElementById('captcha-label');
        const captchaInput = document.getElementById('captcha');

        // Завантажуємо питання капчі з сервера (правильна відповідь зберігається в PHP-сесії)
        function loadCaptcha() {
            fetch('captcha.php')
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    captchaLabel.textContent = data.question;
                    captchaInput.value = '';
                })
                .catch(function() {
                    captchaLabel.textContent = 'Пройдіть перевірку:';
                });
        }

        // Завантажуємо перше питання при відкритті сторінки
        loadCaptcha();

        feedbackForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formStatus = document.getElementById('form-status');
            const submitBtn = document.getElementById('submit-btn');

            // Блокуємо кнопку на час відправки
            submitBtn.disabled = true;
            submitBtn.textContent = 'Відправка...';
            formStatus.textContent = '';
            formStatus.className = 'form-status';

            const formData = new FormData(feedbackForm);

            fetch('send_email.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.text().then(function(text) {
                    return { ok: response.ok, text: text };
                });
            })
            .then(function(result) {
                if (result.ok) {
                    // ВИПРАВЛЕНО: редирект на index.php (не index.html)
                    alert(result.text);
                    window.location.href = '/';
                } else {
                    formStatus.textContent = result.text;
                    formStatus.className = 'form-status error';
                    // Оновлюємо капчу після невдалої спроби
                    loadCaptcha();
                }
            })
            .catch(function(error) {
                formStatus.textContent = 'Виникла помилка мережі. Спробуйте пізніше.';
                formStatus.className = 'form-status error';
                console.error('Error:', error);
                loadCaptcha();
            })
            .finally(function() {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Відправити';
            });
        });
    }
});
