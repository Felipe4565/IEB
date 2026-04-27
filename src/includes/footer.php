<?php
require_once('includes/db.php');

// Récupération de toutes les images liées au meuble interactif
$query = $pdo->query("SELECT type, image_url FROM images_projets WHERE type LIKE 'home_meuble_%'");
$meuble_images = $query->fetchAll(PDO::FETCH_KEY_PAIR);

// On définit les chemins avec des valeurs par défaut au cas où
$img_close = $meuble_images['home_meuble_close'] ?? 'assets/img/accueil/meuble_close.png';
$img_open1 = $meuble_images['home_meuble_open1'] ?? 'assets/img/accueil/meuble_open1.png';
$img_open2 = $meuble_images['home_meuble_open2'] ?? 'assets/img/accueil/meuble_open2.png';
$img_open3 = $meuble_images['home_meuble_open3'] ?? 'assets/img/accueil/meuble_open3.png';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/footer.css">

<footer class="main-footer">
    <div class="footer-container">
        
        <div class="brand-identity">
            <div class="brand-flex">
                <img src="assets/img/logo_ieb.jpg" alt="Logo IEB" class="footer-logo">
                <div class="vertical-divider"></div>
                <div class="social-links">
                    <a href="https://www.instagram.com/interieur_exterieur_bois_/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-main-grid">
            
            <div class="footer-col">
                <h4 class="col-title">Infos Entreprise</h4>
                <div class="col-content">
                    <p class="address">4 RUE SAINT CLAUDE<br>77340 PONTAULT-COMBAULT</p>
                    <p class="schedule">Lun - Ven : 8h à 20h</p>
                    <div class="btn-alignment">
                        <a href="rdv.php" class="btn-gold-pill">Prendre un RDV</a>
                    </div>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Nos Réalisations</h4>
                <ul class="clean-list">
                    <li><a href="realisations.php?filter=interieur">Intérieur</a></li>
                    <li><a href="realisations.php?filter=exterieur">Extérieur</a></li>
                    <li><a href="realisations.php?filter=sur-mesure">Nos meubles</a></li>
                    <li><a href="realisations.php?filter=all">Nos créations</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Service Clients</h4>
                <div class="sub-grid-lists">
                    <ul class="clean-list">
                        <li><a href="index.php#contact">Nous contacter</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="identification.php">S'identifier</a></li>
                    </ul>
                    <ul class="clean-list">
                        <li><a href="contact.php">Devis gratuit</a></li>
                        <li><a href="mentions_legales.php">Mentions Légales</a></li>
                        <li><a href="cgv.php">CGV</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="footer-bottom-bar">
            <div class="legal-flex">
                <div class="contact-details">
                    <a href="tel:0621080622">06 21 08 06 22</a>
                    <span class="dot-sep"></span>
                    <a href="mailto:interieurexterieurbois@orange.fr">interieurexterieurbois@orange.fr</a>
                </div>
                <div class="payment-icons">
                    <img src="assets/img/footer/visa-mastercard.jpg" alt="Paiement sécurisé" class="img-pay">
                </div>
            </div>
            <p class="copyright">&copy; 2026 INTÉRIEUR EXTÉRIEUR BOIS | CRÉATION FELIPE ALVARIZA</p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const triggers = document.querySelectorAll('.drawer-trigger');
    const factContents = document.querySelectorAll('.fact-content');
    const defaultFact = document.getElementById('default-fact');
    const mainImg = document.getElementById('main-furniture');
    
    // On crée un objet de correspondance entre le numéro du tiroir et l'image BDD
    const drawerImages = {
        '0': '<?= $img_close ?>',
        '1': '<?= $img_open1 ?>',
        '2': '<?= $img_open2 ?>',
        '3': '<?= $img_open3 ?>'
    };

    let currentOpenDrawer = null;

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetFactId = this.getAttribute('data-fact');
            const drawerNumber = targetFactId.replace('fact', '');

            // Si on clique sur le tiroir déjà ouvert -> on ferme tout
            if (currentOpenDrawer === drawerNumber) {
                mainImg.src = drawerImages['0']; // Utilise l'image close de la BDD
                factContents.forEach(c => c.classList.remove('active'));
                if(defaultFact) defaultFact.classList.add('active');
                currentOpenDrawer = null;
            } 
            // Sinon -> on ouvre le nouveau tiroir
            else {
                // On récupère l'image correspondante dans notre objet drawerImages
                mainImg.src = drawerImages[drawerNumber] || drawerImages['0'];
                
                factContents.forEach(c => c.classList.remove('active'));
                const activeContent = document.getElementById(targetFactId);
                if(activeContent) {
                    activeContent.classList.add('active');
                }
                
                currentOpenDrawer = drawerNumber;
            }

            // Effet visuel de clic
            this.style.fill = "rgba(197, 166, 124, 0.3)";
            setTimeout(() => { this.style.fill = "transparent"; }, 300);
        });
    });
});
</script>