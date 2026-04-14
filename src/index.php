<?php include('includes/header.php'); ?>

<main>
    <section class="hero-premium">
        <div class="video-bg-wrapper">
            <video autoplay muted loop playsinline class="video-element">
                <source src="/assets/img/accueil/video_ralenti.mp4" type="video/mp4">
            </video>
            <div class="video-overlay-dark"></div>
        </div>

        <div class="hero-content-overlay">
            <div class="container">
                <div class="top-announcement">
                    <p>Artisan Menuisier en Île-de-France depuis 2001</p>
                </div>
                
                <div class="main-hero-text">
                    <span class="subtitle">Conception & Fabrication</span>
                    <h1>L'art du bois, <br><span class="gold-text">le sens du détail.</span></h1>
                    <p class="description">Conception unique de cuisines, escaliers et mobilier sur-mesure.</p>
                    
                    <div class="hero-btns">
                        <a href="realisations.php" class="btn-link-gold">Voir nos projets</a>
                        <a href="contact.php" class="btn-devis-solid">Demander un devis</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="section-gallery">
    <div class="container">
        <div class="gallery-intro">
            <h2>Bienvenue chez Intérieur Extérieur Bois</h2>
            <p class="gold-subtitle">Découvrez l'art du bois sur-mesure</p>
        </div>

        <div class="gallery-grid">
            <a href="realisations.php?filter=interieur" class="gallery-item">
                <div class="image-box">
                    <img src="assets/img/accueil/Intérieur.jpg" alt="Intérieur">
                </div>
                <h3>Intérieur</h3>
                <p>Des travaux d'intérieur sur mesure</p>
            </a>

            <a href="realisations.php?filter=exterieur" class="gallery-item">
                <div class="image-box">
                    <img src="assets/img/accueil/extérieur.jpg" alt="Extérieur">
                </div>
                <h3>Extérieur</h3>
                <p>Des créations en bois pour votre jardin et terrasse</p>
            </a>

            <a href="realisations.php?filter=sur-mesure" class="gallery-item">
                <div class="image-box">
                    <img src="assets/img/accueil/mobilier.jpg" alt="Mobilier">
                </div>
                <h3>Mobilier</h3>
                <p>Des créations signées pour votre intérieur</p>
            </a>
        </div>
    </div>
</section>

<section class="furniture-experience">
    <div class="container">
        <div class="experience-intro">
            <span class="gold-subtitle">Immersion</span>
            <h2>Explorez notre savoir-faire</h2>
            <p>Cliquez sur les tiroirs pour découvrir l'histoire d'IEB</p>
        </div>

        <div class="interactive-container">
            <div class="furniture-wrapper">
                <img src="assets/img/accueil/meuble_close.png" id="main-furniture" alt="Meuble IEB">
                
                <svg viewBox="0 0 2205 790" preserveAspectRatio="none" class="interaction-layer">
                    <polygon points="610,400 1080,380 1100,530 610,600" class="drawer-trigger" data-fact="fact1" style="fill: transparent;"></polygon>                    
                    <polygon points="1100,275 1500,275 1475,525 1175,530" class="drawer-trigger" data-fact="fact2" />
                    
                    <polygon points="625,640 1475,540 1490,700 625,780" class="drawer-trigger" data-fact="fact3"></polygon>
                </svg>
            </div>

            <div class="fact-panel" id="fact-display">
                <div class="fact-content active" id="default-fact">
                    <i class="fas fa-hand-pointer"></i>
                    <p>Interagissez avec le meuble pour révéler nos secrets de fabrication.</p>
                </div>
                <div class="fact-content" id="fact1">
                    <h3>25 Ans d'Expertise</h3>
                    <p>Depuis 2001, nous transformons le bois noble en pièces uniques.</p>
                </div>
                <div class="fact-content" id="fact2">
                    <h3>Matériaux Durables</h3>
                    <p>Bois issus de forêts gérées durablement.</p>
                </div>
                <div class="fact-content" id="fact3">
                    <h3>Sur-Mesure Total</h3>
                    <p>Chaque millimètre est pensé pour votre espace.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-split-container">
    <div class="container-contact-wrapper">
        
        <div class="contact-column-form">
            <div class="floating-contact-card">
                <span class="gold-subtitle">Contact</span>
                <h2>Un projet bois ?</h2>
                <div class="gold-line"></div>
                
                <form class="premium-dark-form">
                    <input type="text" placeholder="Votre Nom" required>
                    <input type="email" placeholder="Votre Email" required>
                    <textarea rows="4" placeholder="Décrivez votre projet..."></textarea>
                    <button type="submit" class="btn-gold">Envoyer le message</button>
                </form>
            </div>
        </div>

        <div class="contact-column-map">
            <div class="map-inner">
                <iframe 
                    src="https://www.google.com/maps/embed?..." 
                    style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
                <div class="map-overlay-gradient"></div>
            </div>
        </div>

    </div>
</section>

</main>

<?php include('includes/footer.php'); ?>