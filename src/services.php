<?php
$page_title = "Nos Services - IEB";
$page_css = "css/services.css?v=" . time();
include('includes/header.php');
?>

<main class="services-page">
    <section class="showroom-banner">
        <div class="showroom-content">
            <div class="showroom-text">
                <span class="subtitle">ÉVÉNEMENT</span>
                <h2>Bientôt : L'expérience IEB prend vie</h2>
                <p>Nous avons hâte de vous accueillir dans notre futur <strong>Showroom</strong>.<br> 
                Un espace dédié à l'inspiration et à la visualisation de vos projets les plus ambitieux.</p>
                <a href="#contact" class="btn-gold">Restez informé</a>
            </div>
        </div>
    </section>

    <section class="adn-section adn-redesign">
        <div class="container adn-grid-main">
            
            <div class="adn-visuals">
                <div class="adn-image-wrapper">
                    <img src="assets/img/precision.jpg" alt="Tracé de précision">
                </div>
                <div class="adn-image-wrapper">
                    <img src="assets/img/geste.jpg" alt="Assemblage à tenon mortaise">
                </div>
                <div class="adn-image-wrapper">
                    <img src="assets/img/technologie.jpg" alt="Usinage de précision">
                </div>
                <div class="adn-image-wrapper">
                    <img src="assets/img/matiere.jpg" alt="Finition artisanale">
                </div>
            </div>

            <div class="adn-content-list">
                <span class="subtitle-ieb">NOTRE SAVOIR-FAIRE</span>
                <h2 class="title-ieb">L'ADN IEB : La Haute Mesure</h2>
                
                <div class="adn-list-container">
                    <div class="adn-list-item">
                        <div class="adn-list-icon">
                            <img src="assets/img/compas_icon.png" alt="Transformation">
                        </div>
                        <div class="adn-list-text">
                            <h3>TRANSFORMATION</h3>
                            <p>Nous adaptons l’existant et concevons des structures sans limites, du traçage préliminaire à la concrétisation du projet.</p>
                        </div>
                    </div>

                    <div class="adn-list-item">
                        <div class="adn-list-icon">
                            <img src="assets/img/equerre_icon.png" alt="Fabrication">
                        </div>
                        <div class="adn-list-text">
                            <h3>FABRICATION SUR MESURE</h3>
                            <p>Fabrication sur mesure à partir de vos projets et de vos matières, avec un souci du détail artisanal et technologique.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

<section class="expertise-ieb expertise-redesign expertise-interactive">
    <div class="container">
        
        <span class="subtitle-ieb subtitle-expertise center-ieb">NOS DOMAINES D'EXCELLENCE</span>
        <h2 class="title-ieb title-expertise center-ieb">Une Expertise Complète</h2>

        <div class="expertise-flex-container">
            
            <div class="expertise-card">
                <div class="expertise-image">
                    <img src="assets/img/exterieur.jpg" alt="Menuiserie Extérieure">
                </div>
                <div class="expertise-content">
                    <h3>MENUISERIE EXTÉRIEURE</h3>
                    <div class="expertise-lists">
                        <ul>
                            <li><strong>OUVERTURES</strong></li>
                            <li>Portes d'entrée</li>
                            <li>Châssis</li>
                            <li>Fenêtres Performantes</li>
                        </ul>
                        <ul>
                            <li><strong>AMÉNAGEMENTS</strong></li>
                            <li>Terrasses</li>
                            <li>Bardages</li>
                            <li>Portails & Garde-corps</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="expertise-card">
                <div class="expertise-image">
                    <img src="assets/img/interieur.jpg" alt="Menuiserie Intérieure">
                </div>
                <div class="expertise-content">
                    <h3>MENUISERIE INTÉRIEURE</h3>
                    <div class="expertise-lists">
                        <ul>
                            <li><strong>AMÉNAGEMENTS</strong></li>
                            <li>Escaliers</li>
                            <li>Cloisons & Portes</li>
                            <li>Rangements</li>
                        </ul>
                        <ul>
                            <li><strong>MOBILIER SIGNATURE</strong></li>
                            <li>Tables & Consoles</li>
                            <li>Plans de travail</li>
                            <li>Bibliothèques</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="complementary-services">
    <div class="container">
        <span class="subtitle-ieb center-ieb">Processus IEB</span>
        <h2 class="title-ieb center-ieb">Un Accompagnement Complet</h2>
        
        <div class="services-icons-grid">
            <div class="s-icon-card">
                <div class="icon-wrapper">
                    <img src="assets/img/stylo_icon.png" alt="Conseil">
                </div>
                <h4>Conseil & Étude</h4>
                <p>Analyse personnalisée et choix des essences pour un projet qui vous ressemble.</p>
            </div>

            <div class="s-icon-card">
                <div class="icon-wrapper">
                    <img src="assets/img/maillet_icon.png" alt="Installation">
                </div>
                <h4>Installation Expertise</h4>
                <p>Pose millimétrée par nos équipes qualifiées, dans le respect des règles de l'art.</p>
            </div>

            <div class="s-icon-card">
                <div class="icon-wrapper">
                    <img src="assets/img/bouclier_icon.png" alt="Entretien">
                </div>
                <h4>Entretien & Suivi</h4>
                <p>Suivi durable pour garantir la longévité et l'éclat de vos ouvrages en bois.</p>
            </div>
        </div>
    </div>
</section>
</main>

<?php include('includes/footer.php'); ?>