<?php
    require_once 'contact_data.php';

    $pageTitle = "Контакти — ТРК \"Тернопільська хвиля\"";
    $pageDescription = "Контактна інформація ТРК 'Тернопільська хвиля'. Зв'яжіться з нами! Адреса, телефони студії та рекламного відділу, електронні пошти.";
    $pageUrl = "https://ternopil.fm/contacts";
    include 'header.php';
?>

    <main class="main-content-wrapper">
        <div class="container">
            <div class="contact-page-grid">
                <div class="contact-info">
                    <h2><?php echo htmlspecialchars($siteContacts['company']); ?></h2>
                    <p>
                        <?php echo htmlspecialchars($siteContacts['address']['line1']); ?>.<br>
                        <?php echo htmlspecialchars($siteContacts['address']['line2']); ?>
                    </p>
                    <p>
                        <strong>Контакти для зв'язку:</strong><br>
                        <strong><?php echo htmlspecialchars($siteContacts['phones']['main']['label']); ?>:</strong> <a href="tel:<?php echo htmlspecialchars($siteContacts['phones']['main']['tel']); ?>"><?php echo htmlspecialchars($siteContacts['phones']['main']['display']); ?></a><br>
                        <strong><?php echo htmlspecialchars($siteContacts['emails']['main1']['label']); ?>:</strong> <a href="mailto:<?php echo htmlspecialchars($siteContacts['emails']['main1']['address']); ?>"><?php echo htmlspecialchars($siteContacts['emails']['main1']['address']); ?></a><br>
                        <a href="mailto:<?php echo htmlspecialchars($siteContacts['emails']['main2']['address']); ?>"><?php echo htmlspecialchars($siteContacts['emails']['main2']['address']); ?></a>
                    </p>
                    <p>
                        <strong>Студія:</strong> <a href="tel:<?php echo htmlspecialchars($siteContacts['phones']['studio']['tel']); ?>"><?php echo htmlspecialchars($siteContacts['phones']['studio']['display']); ?></a><br>
                        <strong>Рекламний відділ:</strong> <a href="tel:<?php echo htmlspecialchars($siteContacts['phones']['ads']['tel']); ?>"><?php echo htmlspecialchars($siteContacts['phones']['ads']['display']); ?></a>
                    </p>
                    <p>
                        <?php foreach (['ads', 'dir', 'prog', 'music'] as $key): $email = $siteContacts['emails'][$key]; ?>
                        <strong><?php echo htmlspecialchars($email['label']); ?>:</strong> <a href="mailto:<?php echo htmlspecialchars($email['address']); ?>"><?php echo htmlspecialchars($email['address']); ?></a><br>
                        <?php endforeach; ?>
                    </p>
                </div>
                <div class="contact-map">
                    <iframe src="<?php echo htmlspecialchars($siteContacts['map_embed_src']); ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="google-map" title="Карта: адреса ТРК Тернопільська хвиля"></iframe>
                </div>
            </div>
        </div>
    </main>

<?php
    // Підключаємо лише нижню частину футера, оскільки на цій сторінці вже є карта
    include 'footer_bottom_only.php';
?>
