<?php
require_once('includes/db.php'); 

$query_img = $pdo->query("SELECT image_url, type FROM images_projets WHERE type LIKE 'service_%'");
$images_services = $query_img->fetchAll(PDO::FETCH_KEY_PAIR);

$img_precision = $images_services['service_precision'] ?? 'assets/img/services/precision.jpg';
$img_geste     = $images_services['service_geste']     ?? 'assets/img/services/geste.jpg';
$img_techno    = $images_services['service_technologie'] ?? 'assets/img/services/technologie.jpg';
$img_matiere   = $images_services['service_matiere']   ?? 'assets/img/services/matiere.jpg';

$img_card_ext  = $images_services['service_card_exterieur'] ?? 'assets/img/services/exterieur.jpg';
$img_card_int  = $images_services['service_card_interieur'] ?? 'assets/img/services/interieur.jpg';

$query_txt = $pdo->query("SELECT cle, valeur FROM contenus WHERE cle LIKE 'services_%'");
$textes = $query_txt->fetchAll(PDO::FETCH_KEY_PAIR);

$txt_show_subtitle = $textes['services_showroom_subtitle'] ?? "ÉVÉNEMENT";
$txt_show_title    = $textes['services_showroom_title']    ?? "Bientôt : L'expérience IEB prend vie";
$txt_show_text     = $textes['services_showroom_text']     ?? "Nous avons hâte de vous accueillir dans notre futur Showroom. Un espace dédié à l'inspiration.";
$txt_show_btn      = $textes['services_showroom_btn']      ?? "Restez informé";

$txt_adn_subtitle  = $textes['services_adn_subtitle']      ?? "NOTRE SAVOIR-FAIRE";
$txt_adn_title     = $textes['services_adn_title']         ?? "L'ADN IEB : La Haute Mesure";

$txt_adn_trans_h3  = $textes['services_adn_transformation_title'] ?? "TRANSFORMATION";
$txt_adn_trans_p   = $textes['services_adn_transformation_text']  ?? "Nous adaptons l'existant et concevons des structures sans limites.";

$txt_adn_fab_h3    = $textes['services_adn_fabrication_title']    ?? "FABRICATION SUR MESURE";
$txt_adn_fab_p     = $textes['services_adn_fabrication_text']     ?? "Fabrication sur mesure à partir de vos projets et de vos matières.";

$txt_exp_subtitle  = $textes['services_expertise_subtitle'] ?? "NOS DOMAINES D'EXCELLENCE";
$txt_exp_title     = $textes['services_expertise_title']    ?? "Une Expertise Complète";

$txt_ext_title     = $textes['services_ext_title']          ?? "MENUISERIE EXTÉRIEURE";
$txt_ext_btn       = $textes['services_ext_btn']            ?? "Voir les réalisations";
$txt_ext_l1_h      = $textes['services_ext_list1_title']    ?? "OUVERTURES";
$txt_ext_l1_i1     = $textes['services_ext_list1_item1']    ?? "Portes d'entrée";
$txt_ext_l1_i2     = $textes['services_ext_list1_item2']    ?? "Châssis";
$txt_ext_l1_i3     = $textes['services_ext_list1_item3']    ?? "Fenêtres Performantes";
$txt_ext_l2_h      = $textes['services_ext_list2_title']    ?? "AMÉNAGEMENTS";
$txt_ext_l2_i1     = $textes['services_ext_list2_item1']    ?? "Terrasses";
$txt_ext_l2_i2     = $textes['services_ext_list2_item2']    ?? "Bardages";
$txt_ext_l2_i3     = $textes['services_ext_list2_item3']    ?? "Portails & Garde-corps";

$txt_int_title     = $textes['services_int_title']          ?? "MENUISERIE INTÉRIEURE";
$txt_int_l1_h      = $textes['services_int_list1_title']    ?? "AMÉNAGEMENTS";
$txt_int_l1_i1     = $textes['services_int_list1_item1']    ?? "Escaliers";
$txt_int_l1_i2     = $textes['services_int_list1_item2']    ?? "Cloisons & Portes";
$txt_int_l1_i3     = $textes['services_int_list1_item3']    ?? "Rangements";
$txt_int_l2_h      = $textes['services_int_list2_title']    ?? "MOBILIER SIGNATURE";
$txt_int_l2_i1     = $textes['services_int_list2_item1']    ?? "Tables & Consoles";
$txt_int_l2_i2     = $textes['services_int_list2_item2']    ?? "Plans de travail";
$txt_int_l2_i3     = $textes['services_int_list2_item3']    ?? "Bibliothèques";

$txt_proc_subtitle = $textes['services_process_subtitle']   ?? "Processus IEB";
$txt_proc_title    = $textes['services_process_title']      ?? "Un Accompagnement Complet";
$txt_proc1_h       = $textes['services_process1_title']     ?? "Conseil & Étude";
$txt_proc1_p       = $textes['services_process1_text']      ?? "Analyse personnalisée et choix des essences.";
$txt_proc2_h       = $textes['services_process2_title']     ?? "Installation Expertise";
$txt_proc2_p       = $textes['services_process2_text']      ?? "Pose millimétrée par nos équipes qualifiées.";
$txt_proc3_h       = $textes['services_process3_title']     ?? "Entretien & Suivi";
$txt_proc3_p       = $textes['services_process3_text']      ?? "Suivi durable pour garantir la longévité.";

$page_title = "Nos Services - IEB";
$page_css = "css/services.css?v=" . time();

include('includes/header.php');
?>

<main class="services-page">
    <section class="showroom-banner">
        <div class="showroom-content">
            <div class="showroom-text">
                <span class="subtitle"><?= $txt_show_subtitle ?></span>
                <h2><?= $txt_show_title ?></h2>
                <p><?= $txt_show_text ?></p>
                <a href="#contact" class="btn-gold"><?= $txt_show_btn ?></a>
            </div>
        </div>
    </section>

    <section class="adn-section adn-redesign">
        <div class="container adn-grid-main">
            <div class="adn-visuals">
                <div class="adn-image-wrapper"><img src="<?= $img_precision ?>" alt="Précision"></div>
                <div class="adn-image-wrapper"><img src="<?= $img_geste ?>" alt="Geste"></div>
                <div class="adn-image-wrapper"><img src="<?= $img_techno ?>" alt="Technologie"></div>
                <div class="adn-image-wrapper"><img src="<?= $img_matiere ?>" alt="Matière"></div>
            </div>

            <div class="adn-content-list">
                <span class="subtitle-ieb"><?= $txt_adn_subtitle ?></span>
                <h2 class="title-ieb"><?= $txt_adn_title ?></h2>
                
                <div class="adn-list-container">
                    <div class="adn-list-item">
                        <div class="adn-list-icon"><img src="assets/img/services/compas_icon.png" alt="Transformation"></div>
                        <div class="adn-list-text">
                            <h3><?= $txt_adn_trans_h3 ?></h3>
                            <p><?= $txt_adn_trans_p ?></p>
                        </div>
                    </div>

                    <div class="adn-list-item">
                        <div class="adn-list-icon"><img src="assets/img/services/equerre_icon.png" alt="Fabrication"></div>
                        <div class="adn-list-text">
                            <h3><?= $txt_adn_fab_h3 ?></h3>
                            <p><?= $txt_adn_fab_p ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="expertise-ieb expertise-redesign expertise-interactive">
        <div class="container">
            <span class="subtitle-ieb subtitle-expertise center-ieb"><?= $txt_exp_subtitle ?></span>
            <h2 class="title-ieb title-expertise center-ieb"><?= $txt_exp_title ?></h2>

            <div class="expertise-flex-container">
                <div class="expertise-card">
                    <a href="realisations.php?filter=exterieur" class="expertise-link-wrapper">
                        <div class="expertise-image">
                            <img src="<?= $img_card_ext ?>" alt="Extérieur">
                            <div class="expertise-overlay-hover">
                                <span><?= $txt_ext_btn ?> <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="expertise-content">
                        <a href="realisations.php?filter=exterieur"><h3><?= $txt_ext_title ?></h3></a>
                        <div class="expertise-lists">
                            <ul>
                                <li><strong><?= $txt_ext_l1_h ?></strong></li>
                                <li><?= $txt_ext_l1_i1 ?></li>
                                <li><?= $txt_ext_l1_i2 ?></li>
                                <li><?= $txt_ext_l1_i3 ?></li>
                            </ul>
                            <ul>
                                <li><strong><?= $txt_ext_l2_h ?></strong></li>
                                <li><?= $txt_ext_l2_i1 ?></li>
                                <li><?= $txt_ext_l2_i2 ?></li>
                                <li><?= $txt_ext_l2_i3 ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="expertise-card">
                    <a href="realisations.php?filter=interieur" class="expertise-link-wrapper">
                        <div class="expertise-image">
                            <img src="<?= $img_card_int ?>" alt="Intérieur">   
                            <div class="expertise-overlay-hover">
                                <span><?= $txt_ext_btn ?> <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="expertise-content">
                        <a href="realisations.php?filter=interieur"><h3><?= $txt_int_title ?></h3></a>
                        <div class="expertise-lists">
                            <ul>
                                <li><strong><?= $txt_int_l1_h ?></strong></li>
                                <li><?= $txt_int_l1_i1 ?></li>
                                <li><?= $txt_int_l1_i2 ?></li>
                                <li><?= $txt_int_l1_i3 ?></li>
                            </ul>
                            <ul>
                                <li><strong><?= $txt_int_l2_h ?></strong></li>
                                <li><?= $txt_int_l2_i1 ?></li>
                                <li><?= $txt_int_l2_i2 ?></li>
                                <li><?= $txt_int_l2_i3 ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="complementary-services">
        <div class="container">
            <span class="subtitle-ieb center-ieb"><?= $txt_proc_subtitle ?></span>
            <h2 class="title-ieb center-ieb"><?= $txt_proc_title ?></h2>
            
            <div class="services-icons-grid">
                <div class="s-icon-card">
                    <div class="icon-wrapper"><img src="assets/img/services/stylo_icon.png" alt="Conseil"></div>
                    <h4><?= $txt_proc1_h ?></h4>
                    <p><?= $txt_proc1_p ?></p>
                </div>

                <div class="s-icon-card">
                    <div class="icon-wrapper"><img src="assets/img/services/maillet_icon.png" alt="Installation"></div>
                    <h4><?= $txt_proc2_h ?></h4>
                    <p><?= $txt_proc2_p ?></p>
                </div>

                <div class="s-icon-card">
                    <div class="icon-wrapper"><img src="assets/img/services/bouclier_icon.png" alt="Entretien"></div>
                    <h4><?= $txt_proc3_h ?></h4>
                    <p><?= $txt_proc3_p ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>