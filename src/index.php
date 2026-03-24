<?php include('includes/header.php'); ?>

<main>
    <section class="hero-premium">
        <div class="video-bg-wrapper">
            <video autoplay muted loop playsinline class="video-element">
                <source src="assets/img/video_ralenti.mp4" type="video/mp4">
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
                <div class="gallery-item">
                    <div class="image-box">
                        <img src="assets/img/Intérieur.jpg" alt="Intérieur">
                    </div>
                    <h3>Intérieur</h3>
                    <p>Des travaux d'intérieur sur mesure</p>
                </div>

                <div class="gallery-item">
                    <div class="image-box">
                        <img src="assets/img/extérieur.jpg" alt="Extérieur">
                    </div>
                    <h3>Extérieur</h3>
                    <p>Des créations en bois pour votre jardin et terrasse</p>
                </div>

                <div class="gallery-item">
                    <div class="image-box">
                        <img src="assets/img/mobilier.jpg" alt="Mobilier">
                    </div>
                    <h3>Mobilier</h3>
                    <p>Des créations signées pour votre intérieur</p>
                </div>
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
                <img src="assets/img/meuble-3d-base.png" id="main-furniture" alt="Meuble IEB">
                
                <svg viewBox="0 0 1000 800" class="interaction-layer">
                    <rect x="300" y="200" width="400" height="100" class="drawer-trigger" data-fact="fact1" />
                    <rect x="300" y="320" width="400" height="100" class="drawer-trigger" data-fact="fact2" />
                    <rect x="300" y="440" width="400" height="100" class="drawer-trigger" data-fact="fact3" />
                </svg>
            </div>

            <div class="fact-panel" id="fact-display">
                <div class="fact-content active" id="default-fact">
                    <i class="fas fa-hand-pointer"></i>
                    <p>Interagissez avec le meuble pour révéler nos secrets de fabrication.</p>
                </div>
                <div class="fact-content" id="fact1">
                    <h3>25 Ans d'Expertise</h3>
                    <p>Depuis 2001, nous transformons le bois noble en pièces uniques pour vos intérieurs.</p>
                </div>
                <div class="fact-content" id="fact2">
                    <h3>Matériaux Durables</h3>
                    <p>Nous sélectionnons nos essences de bois dans des forêts gérées durablement.</p>
                </div>
                <div class="fact-content" id="fact3">
                    <h3>Sur-Mesure Total</h3>
                    <p>Chaque millimètre est pensé pour s'adapter parfaitement à votre espace.</p>
                </div>
            </div>
        </div>
    </div>
</section>
</main>

<?php include('includes/footer.php'); ?>