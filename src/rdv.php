<?php
$page_title = "Prendre rendez-vous | IEB";
include('includes/header.php');

$L = require __DIR__ . '/includes/legal.php';
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

// URL Calendly valide uniquement si elle commence par https://calendly.com/
$calendly = trim($L['calendly_url'] ?? '');
$calendly_src = '';
if (preg_match('~^https://calendly\.com/[A-Za-z0-9._/-]+$~', $calendly)) {
    $calendly_src = $calendly . '?hide_event_type_details=1&background_color=080908&text_color=ffffff&primary_color=c5a67c';
}
?>

<link rel="stylesheet" href="css/rdv.css">

<main class="rdv-ultra-page">
    <section class="rdv-hero-split">
        <div class="hero-text-side">
            <div class="inner-content">
                <span class="label-gold">Disponibilités Exclusive</span>
                <h1 class="serif-gold">L'ART DE <br>VOUS ÉCOUTER</h1>
                <p class="gold-intro">Un projet d'exception commence par un échange de qualité. Réservez votre consultation privée.</p>
                <div class="hero-cta-group">
                    <a href="#booking" class="btn-submit-gold-full">RÉSERVER MON CRÉNEAU</a>
                    <span class="duration">Consultation : 30 à 45 min</span>
                </div>
            </div>
        </div>
        <div class="hero-image-side">
            <div class="image-overlay"></div>
        </div>
    </section>

    <section class="rdv-philosophy">
        <div class="container-ieb">
            <div class="philosophy-grid">
                <div class="philo-card">
                    <span class="philo-num">I</span>
                    <h3>Écoute Active</h3>
                    <p>Nous prenons le temps de comprendre l'âme de votre intérieur.</p>
                </div>
                <div class="philo-card">
                    <span class="philo-num">II</span>
                    <h3>Expertise Bois</h3>
                    <p>Conseils techniques sur les essences et la durabilité.</p>
                </div>
                <div class="philo-card">
                    <span class="philo-num">III</span>
                    <h3>Transparence</h3>
                    <p>Une approche claire, du premier croquis au devis final.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="rdv-booking-frame">
        <div class="frame-decoration">
            <h2 class="serif-gold">PLANIFIER L'ENTRETIEN</h2>
            <p class="frame-subtitle">Sélectionnez le moment qui vous convient le mieux</p>
        </div>

        <?php if ($calendly_src !== ''): ?>
            <!-- Le calendrier n'est chargé qu'après un clic : aucun cookie tiers avant -->
            <div class="calendly-container-premium" id="calendly-box">
                <div style="padding: 60px 20px; text-align: center;">
                    <p style="color: rgba(255,255,255,0.7); max-width: 560px; margin: 0 auto 25px; line-height: 1.7; font-size: 0.9rem;">
                        Ce calendrier est fourni par Calendly, société américaine. En l'affichant, votre adresse IP est transmise à Calendly, qui peut déposer ses propres cookies.
                        <a href="politique-confidentialite.php" style="color: #c5a67c; text-decoration: underline;">En savoir plus</a>
                    </p>
                    <button type="button" id="load-calendly" class="btn-submit-gold-full" style="border: 0; cursor: pointer;">AFFICHER LE CALENDRIER</button>
                </div>
            </div>
            <script>
                document.getElementById('load-calendly').addEventListener('click', function () {
                    const box = document.getElementById('calendly-box');
                    const f = document.createElement('iframe');
                    f.src = <?= json_encode($calendly_src, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) ?>;
                    f.width = '100%';
                    f.height = '750';
                    f.style.border = '0';
                    f.title = 'Prise de rendez-vous';
                    box.innerHTML = '';
                    box.appendChild(f);
                });
            </script>
        <?php else: ?>
            <div class="calendly-container-premium">
                <div style="padding: 60px 20px; text-align: center;">
                    <p style="color: rgba(255,255,255,0.75); max-width: 560px; margin: 0 auto 30px; line-height: 1.8;">
                        Pour fixer un rendez-vous, appelez-nous au
                        <a href="tel:<?= $e($L['telephone_href']) ?>" style="color: #c5a67c;"><?= $e($L['telephone']) ?></a>
                        (<?= $e($L['horaires']) ?>) ou envoyez-nous une demande de devis : nous vous répondons sous 48 h.
                    </p>
                    <a href="contact.php" class="btn-submit-gold-full">DEMANDER UN DEVIS</a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <section class="rdv-faq-teaser">
        <div class="teaser-content">
            <h2 class="serif-gold">UNE QUESTION ?</h2>
            <p>Besoin d'un renseignement immédiat avant de réserver ?</p>
            <a href="index.php#contact" class="link-gold">Nous contacter directement →</a>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>
