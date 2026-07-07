<?php require_once 'contact_data.php'; ?>
<footer class="site-footer">
        <div class="footer-top">
            <div class="container footer-top-grid">
                <div class="footer-column">
                    <h2>Адреса</h2>
                    <iframe src="<?php echo htmlspecialchars($siteContacts['map_embed_src']); ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="google-map" title="Карта: адреса ТРК Тернопільська хвиля"></iframe>
                    <p>
                        <?php echo htmlspecialchars($siteContacts['address']['line1']); ?><br>
                        <?php echo htmlspecialchars($siteContacts['address']['line2']); ?>
                    </p>
                </div>
                <div class="footer-column footer-phones">
                    <h2>Телефони</h2>
                    <ul>
                        <li>
                            <strong><?php echo htmlspecialchars($siteContacts['phones']['studio']['label']); ?>:</strong><br>
                            <a href="tel:<?php echo htmlspecialchars($siteContacts['phones']['studio']['tel']); ?>"><?php echo htmlspecialchars($siteContacts['phones']['studio']['display']); ?></a>
                        </li>
                        <li>
                            <strong><?php echo htmlspecialchars($siteContacts['phones']['ads']['label']); ?>:</strong><br>
                            <a href="tel:<?php echo htmlspecialchars($siteContacts['phones']['ads']['tel']); ?>"><?php echo htmlspecialchars($siteContacts['phones']['ads']['display']); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="footer-column footer-contacts">
                    <h2>Контакти</h2>
                    <ul>
                        <?php foreach (['ads', 'dir', 'prog', 'music'] as $key): $email = $siteContacts['emails'][$key]; ?>
                        <li>
                            <strong><?php echo htmlspecialchars($email['label']); ?>:</strong><br>
                            <a href="mailto:<?php echo htmlspecialchars($email['address']); ?>"><?php echo htmlspecialchars($email['address']); ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
<?php include 'footer_bottom.php'; ?>
