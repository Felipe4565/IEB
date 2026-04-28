<?php
require_once('includes/db.php');

$query_img = $pdo->query("SELECT image_url, type FROM images_projets WHERE type LIKE 'home_%'");
$images_accueil = $query_img->fetchAll(PDO::FETCH_KEY_PAIR);

$img_int = $images_accueil['home_interieur'] ?? 'assets/img/accueil/Intérieur.jpg';
$img_ext = $images_accueil['home_exterieur'] ?? 'assets/img/accueil/extérieur.jpg';
$img_mob = $images_accueil['home_mobilier'] ?? 'assets/img/accueil/mobilier.jpg';
$img_meuble = $images_accueil['home_meuble_close'] ?? 'assets/img/accueil/meuble_close.png';


$query_txt = $pdo->query("SELECT cle, valeur FROM contenus");
$textes_accueil = $query_txt->fetchAll(PDO::FETCH_KEY_PAIR);

$txt_announcement = $textes_accueil['home_top_announcement'] ?? "Artisan Menuisier en Île-de-France depuis 2001";
$txt_subtitle     = $textes_accueil['home_hero_subtitle']     ?? "Conception & Fabrication";
$txt_h1_main      = $textes_accueil['home_hero_title_main']   ?? "L'art du bois,";
$txt_h1_gold      = $textes_accueil['home_hero_title_gold']   ?? "le sens du détail.";
$txt_description  = $textes_accueil['home_hero_description']  ?? "Conception unique de cuisines, escaliers et mobilier sur-mesure.";
$txt_btn_projets  = $textes_accueil['home_btn_projets']       ?? "Voir nos projets";
$txt_btn_devis    = $textes_accueil['home_btn_devis']         ?? "Demander un devis";

$gal_title    = $textes_accueil['home_gallery_title']    ?? "Bienvenue chez Intérieur Extérieur Bois";
$gal_subtitle = $textes_accueil['home_gallery_subtitle'] ?? "Découvrez l'art du bois sur-mesure";
$cat_int_title = $textes_accueil['home_gallery_card1_title'] ?? "Intérieur";
$cat_int_desc  = $textes_accueil['home_gallery_card1_desc']  ?? "Des travaux d'intérieur sur mesure";
$cat_ext_title = $textes_accueil['home_gallery_card2_title'] ?? "Extérieur";
$cat_ext_desc  = $textes_accueil['home_gallery_card2_desc']  ?? "Des créations en bois pour votre jardin et terrasse";
$cat_mob_title = $textes_accueil['home_gallery_card3_title'] ?? "Mobilier";
$cat_mob_desc  = $textes_accueil['home_gallery_card3_desc']  ?? "Des créations signées pour votre intérieur";

$fact_default = $textes_accueil['home_fact_default'] ?? "Interagissez avec le meuble pour révéler nos secrets de fabrication.";
$fact1_title  = $textes_accueil['home_fact1_title']   ?? "25 Ans d'Expertise";
$fact1_desc   = $textes_accueil['home_fact1_desc']    ?? "Depuis 2001, nous transformons le bois noble en pièces uniques.";
$fact2_title  = $textes_accueil['home_fact2_title']   ?? "Matériaux Durables";
$fact2_desc   = $textes_accueil['home_fact2_desc']    ?? "Bois issus de forêts gérées durablement.";
$fact3_title  = $textes_accueil['home_fact3_title']   ?? "Sur-Mesure Total";
$fact3_desc   = $textes_accueil['home_fact3_desc']    ?? "Chaque millimètre est pensé pour votre espace.";

include('includes/header.php'); 
?>

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
                        <p><?= $txt_announcement ?></p>
                    </div>
                    
                    <div class="main-hero-text">
                        <span class="subtitle"><?= $txt_subtitle ?></span>
                        <h1><?= $txt_h1_main ?><br><span class="gold-text"><?= $txt_h1_gold ?></span></h1>
                        <p class="description"><?= $txt_description ?></p>
                        
                        <div class="hero-btns">
                            <a href="realisations.php" class="btn-link-gold">Voir nos projets</a>
                            <a href="contact.php" class="btn-devis-solid">Demander un devis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-gallery">
        <div class="container">
            <div class="gallery-intro">
                <h2><?= $gal_title ?></h2>
                <p class="gold-subtitle"><?= $gal_subtitle ?></p>
            </div>

            <div class="gallery-grid">
                <a href="realisations.php?filter=interieur" class="gallery-item">
                    <div class="image-box">
                        <img src="<?= $img_int ?>" alt="Intérieur">
                    </div>
                    <h3><?= $cat_int_title ?></h3>
                    <p><?= $cat_int_desc ?></p>
                </a>

                <a href="realisations.php?filter=exterieur" class="gallery-item">
                    <div class="image-box">
                        <img src="<?= $img_ext ?>" alt="Extérieur">
                    </div>
                    <h3><?= $cat_ext_title ?></h3>
                    <p><?= $cat_ext_desc ?></p>
                </a>

                <a href="realisations.php?filter=sur-mesure" class="gallery-item">
                    <div class="image-box">
                        <img src="<?= $img_mob ?>" alt="Mobilier">
                    </div>
                    <h3><?= $cat_mob_title ?></h3>
                    <p><?= $cat_mob_desc ?></p>
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
                <img src="<?= $img_meuble ?>" id="main-furniture" alt="Meuble IEB">
                
                <svg viewBox="0 0 2205 790" preserveAspectRatio="none" class="interaction-layer">
                    <polygon points="610,400 1080,380 1100,530 610,600" class="drawer-trigger" data-fact="fact1"></polygon>                     
                    <polygon points="1100,275 1500,275 1475,525 1175,530" class="drawer-trigger" data-fact="fact2" />
                    <polygon points="625,640 1475,540 1490,700 625,780" class="drawer-trigger" data-fact="fact3"></polygon>
                </svg>
            </div>

            <div class="fact-panel" id="fact-display">
                <div class="fact-content active" id="default-fact">
                    <i class="fas fa-hand-pointer"></i>
                    <p><?= $fact_default ?></p>
                </div>
                <div class="fact-content" id="fact1">
                    <h3><?= $fact1_title ?></h3>
                    <p><?= $fact1_desc ?></p>
                </div>
                <div class="fact-content" id="fact2">
                    <h3><?= $fact2_title ?></h3>
                    <p><?= $fact2_desc ?></p>
                </div>
                <div class="fact-content" id="fact3">
                    <h3><?= $fact3_title ?></h3>
                    <p><?= $fact3_desc ?></p>
                </div>
            </div>
        </div> </div>
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