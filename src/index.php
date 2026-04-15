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

    <section id="contact" class="contact-split-container">
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
                    <div id="map-zoom-container">
                        <img src="assets/img/accueil/carte-france-dark.png" class="map-base-img" alt="Carte des implantations IEB">

                        <div class="map-hotspot" style="top: 26%; left: 51%;" 
                            onclick="showLocation('showroom', this)"></div>

                        <div class="map-hotspot" style="top: 23%; left: 47%;" 
                            onclick="showLocation('ateliers', this)"></div>
                    </div>

                    <div class="map-overlay-gradient"></div>
                </div>

                <div id="location-details" class="location-info-card">
                    <div id="info-default">
                        <p><i class="fas fa-mouse-pointer"></i> Cliquez sur un point pour voir les détails</p>
                    </div>
                    <div id="info-content" class="hide">
                        <h3 id="loc-title">Nom du lieu</h3>
                        <a id="loc-addr" href="#" target="_blank" class="map-link">Adresse complète</a>
                        <p id="loc-desc" class="gold-subtitle">Description légère</p>
                    </div>
                </div>
            </div>

            <script>
            function showLocation(type, element) {
                const container = document.getElementById('map-zoom-container');
                const infoDefault = document.getElementById('info-default');
                const infoContent = document.getElementById('info-content');
                
                const locations = {
                    'showroom': {
                        title: "Le Showroom",
                        addr: "123 Rue du Design, 75000 Paris",
                        desc: "Découvrez nos plus belles essences de bois et nos réalisations finies.",
                        origin: "51% 26%",
                        mapUrl: "https://www.google.com/maps/search/?api=1&query=123+Rue+du+Design+75000+Paris"
                    },
                    'ateliers': {
                        title: "L'Atelier de fabrication",
                        addr: "1 Chemin de Mezy, 95450 Seraincourt",
                        desc: "Lieu de fabrication où la magie opère et où le bois prend forme.",
                        origin: "47% 23%",
                        mapUrl: "https://www.google.com/maps/place//data=!4m2!3m1!1s0x47e6ecdd64fde6f9:0x9d342857e04a9d26?sa=X&ved=1t:8290&ictx=111"
                    }
                };

                const data = locations[type];

                if (data) {
                    document.querySelectorAll('.map-hotspot').forEach(pt => pt.classList.remove('active'));
                    element.classList.add('active');

                    container.style.transformOrigin = data.origin;
                    container.style.transform = "scale(2.8)";

                    if (infoDefault) infoDefault.classList.add('hide');
                    
                    infoContent.style.transition = "none";
                    infoContent.style.opacity = 0;
                    infoContent.classList.remove('hide');

                    // Mise à jour des textes
                    document.getElementById('loc-title').innerText = data.title;
                    
                    // Mise à jour du lien d'adresse
                    const addrElement = document.getElementById('loc-addr');
                    addrElement.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${data.addr} <i class="fas fa-external-link-alt" style="font-size: 0.7rem; margin-left: 5px;"></i>`;
                    addrElement.href = data.mapUrl;

                    document.getElementById('loc-desc').innerText = data.desc;

                    setTimeout(() => {
                        infoContent.style.transition = "opacity 0.5s ease";
                        infoContent.style.opacity = 1;
                    }, 50);
                }
            }

            // Dézoomer
            document.getElementById('map-zoom-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('map-base-img')) {
                    this.style.transform = "scale(1)";
                    document.querySelectorAll('.map-hotspot').forEach(pt => pt.classList.remove('active'));
                    document.getElementById('info-content').classList.add('hide');
                    document.getElementById('info-default').classList.remove('hide');
                }
            });
            </script>

    </section>

</main>

<?php include('includes/footer.php'); ?>