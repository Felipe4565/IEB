<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<footer class="main-footer">
    <div class="footer-container">
        
        <div class="brand-identity">
            <div class="brand-flex">
                <img src="assets/img/logo_ieb.jpg" alt="Logo IEB" class="footer-logo">
                <div class="vertical-divider"></div>
                <div class="social-links">
                    <a href="#" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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
                        <a href="#" class="btn-gold-pill">Prendre un RDV</a>
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
                        <li><a href="#">Nous contacter</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">S'identifier</a></li>
                    </ul>
                    <ul class="clean-list">
                        <li><a href="#">Livraison & Pose</a></li>
                        <li><a href="#">Devis gratuit</a></li>
                        <li><a href="#">Mentions Légales</a></li>
                        <li><a href="#">CGV</a></li>
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
    
    let currentOpenDrawer = null;

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetFactId = this.getAttribute('data-fact');
            const drawerNumber = targetFactId.replace('fact', '');

            // Si on clique sur le tiroir déjà ouvert -> on ferme tout
            if (currentOpenDrawer === drawerNumber) {
                mainImg.src = 'assets/img/accueil/meuble_close.png';
                factContents.forEach(c => c.classList.remove('active'));
                if(defaultFact) defaultFact.classList.add('active');
                currentOpenDrawer = null;
            } 
            // Sinon -> on ouvre le nouveau tiroir
            else {
                mainImg.src = 'assets/img/accueil/meuble_open' + drawerNumber + '.png';
                
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