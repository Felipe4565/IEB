<?php
// 1. Détection automatique du dossier pour corriger les chemins (Logo, CSS, Liens)
$base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';

require_once($base_path . 'includes/db.php');

// Récupération de toutes les images liées au meuble interactif
$query = $pdo->query("SELECT type, image_url FROM images_projets WHERE type LIKE 'home_meuble_%'");
$meuble_images = $query->fetchAll(PDO::FETCH_KEY_PAIR);

// Définition des chemins avec $base_path pour éviter les erreurs dans l'admin
$img_close = $meuble_images['home_meuble_close'] ?? $base_path . 'assets/img/accueil/meuble_close.png';
$img_open1 = $meuble_images['home_meuble_open1'] ?? $base_path . 'assets/img/accueil/meuble_open1.png';
$img_open2 = $meuble_images['home_meuble_open2'] ?? $base_path . 'assets/img/accueil/meuble_open2.png';
$img_open3 = $meuble_images['home_meuble_open3'] ?? $base_path . 'assets/img/accueil/meuble_open3.png';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?php echo $base_path; ?>css/footer.css">

<footer class="main-footer">
    <div class="footer-container">
        
        <div class="brand-identity">
            <div class="brand-flex">
                <img src="<?php echo $base_path; ?>assets/img/logo_ieb.jpg" alt="Logo IEB" class="footer-logo">
                <div class="vertical-divider"></div>
                <div class="social-links">
                    <a href="https://www.instagram.com/interieur_exterieur_bois_/" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-main-grid">
            
            <div class="footer-col">
                <h4 class="col-title">L'Atelier</h4>
                <div class="col-content">
                    <p class="address">4 RUE SAINT CLAUDE<br>77340 PONTAULT-COMBAULT</p>
                    <p class="schedule">Lun - Ven : 8h à 20h</p>
                    <div class="btn-alignment">
                        <a href="<?php echo $base_path; ?>rdv.php" class="btn-gold-pill">Prendre un RDV</a>
                    </div>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Nos Réalisations</h4>
                <ul class="clean-list">
                    <li><a href="<?php echo $base_path; ?>realisations.php?filter=interieur">Aménagement Intérieur</a></li>
                    <li><a href="<?php echo $base_path; ?>realisations.php?filter=exterieur">Menuiserie Extérieure</a></li>
                    <li><a href="<?php echo $base_path; ?>realisations.php?filter=sur-mesure">Mobilier sur-mesure</a></li>
                    <li><a href="<?php echo $base_path; ?>realisations.php?filter=all">Toutes nos créations</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Service Clients</h4>
                <div class="sub-grid-lists">
                    <ul class="clean-list">
                        <li><a href="<?php echo $base_path; ?>index.php#contact">Contact</a></li>
                        <li><a href="<?php echo $base_path; ?>faq.php">FAQ</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/login.php">Espace Pro</a></li>
                    </ul>
                    <ul class="clean-list">
                        <li><a href="<?php echo $base_path; ?>politique-confidentialite.php">Politique de Confidentialité</a></li>
                        <li><a href="<?php echo $base_path; ?>contact.php">Devis gratuit</a></li>
                        <li><a href="<?php echo $base_path; ?>mentions_legales.php">Légal</a></li>
                        <li><a href="<?php echo $base_path; ?>cgv.php">CGV</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="footer-legal-bar">
            <div class="contact-details">
                <a href="tel:0621080622">06 21 08 06 22</a>
                <span class="dot-sep"></span>
                <a href="mailto:interieurexterieurbois@orange.fr">interieurexterieurbois@orange.fr</a>
            </div>
            
            <div class="payment-icons">
                <img src="<?php echo $base_path; ?>assets/img/footer/visa-mastercard.jpg" alt="Paiement sécurisé" class="img-pay">
            </div>

            <p class="copyright">
                &copy; <?php echo date('Y'); ?> INTÉRIEUR EXTÉRIEUR BOIS | CRÉATION FELIPE ALVARIZA
            </p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImg = document.getElementById('main-furniture');
    const triggers = document.querySelectorAll('.drawer-trigger');
    const factContents = document.querySelectorAll('.fact-content');
    const defaultFact = document.getElementById('default-fact');
    
    // Mapping des images depuis la BDD
    const drawerImages = {
        '0': '<?= $img_close ?>',
        '1': '<?= $img_open1 ?>',
        '2': '<?= $img_open2 ?>',
        '3': '<?= $img_open3 ?>'
    };

    let currentOpenDrawer = null;

    if (triggers.length > 0) {
        triggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const targetFactId = this.getAttribute('data-fact');
                const drawerNumber = targetFactId.replace('fact', '');

                // Si on clique sur le tiroir déjà ouvert -> on ferme tout
                if (currentOpenDrawer === drawerNumber) {
                    if(mainImg) mainImg.src = drawerImages['0'];
                    factContents.forEach(c => c.classList.remove('active'));
                    if(defaultFact) defaultFact.classList.add('active');
                    currentOpenDrawer = null;
                } 
                // Sinon on ouvre le nouveau tiroir
                else {
                    if(mainImg) mainImg.src = drawerImages[drawerNumber] || drawerImages['0'];
                    
                    factContents.forEach(c => c.classList.remove('active'));
                    const activeContent = document.getElementById(targetFactId);
                    if(activeContent) activeContent.classList.add('active');
                    
                    currentOpenDrawer = drawerNumber;
                }

                // Petit effet visuel sur le clic
                this.style.fill = "rgba(197, 166, 124, 0.3)";
                setTimeout(() => { this.style.fill = "transparent"; }, 300);
            });
        });
    }
});
</script>

<?php include($base_path . 'includes/element_flottant.php'); ?>
</body>
</html>