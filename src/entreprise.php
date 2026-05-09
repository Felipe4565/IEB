<?php
require_once('includes/db.php'); 

// --- 1. RÉCUPÉRATION DE L'IMAGE DE L'ATELIER ---
$query_img = $pdo->query("SELECT image_url FROM images_projets WHERE type = 'atelier_heritage' LIMIT 1");
$img_heritage = $query_img->fetchColumn() ?: 'assets/img/atelier/heritage_meuble.jpg';

// --- 2. RÉCUPÉRATION DES TEXTES DEPUIS LA BD ---
$query_txt = $pdo->query("SELECT cle, valeur FROM contenus WHERE cle LIKE 'atelier_%'");
$textes = $query_txt->fetchAll(PDO::FETCH_KEY_PAIR);

// Variables avec valeurs de secours (fallbacks)
$txt_hero_sub    = $textes['atelier_hero_subtitle']    ?? "Depuis 2001";
$txt_hero_title  = $textes['atelier_hero_title']       ?? "L'Atelier IEB";
$txt_hero_desc   = $textes['atelier_hero_description'] ?? "L’excellence au service de vos projets";

$txt_intro_title = $textes['atelier_intro_title']      ?? "Notre Héritage";
$txt_intro_lead  = $textes['atelier_intro_lead']       ?? "Chaque pièce est une rencontre entre une essence noble et un geste précis.";
$txt_intro_text  = $textes['atelier_intro_text']       ?? "Installés en Île-de-France, nous combinons les techniques traditionnelles et l'innovation.";


$query_equipe = $pdo->query("SELECT * FROM equipe WHERE statut = 'actif' ORDER BY ordre ASC, id ASC");
$membres = $query_equipe->fetchAll();

// --- CONFIGURATION DE LA PAGE ---
$page_title = "L'Atelier - IEB";
$page_css = "css/atelier.css?v=" . time(); 

include('includes/header.php');
?>

<main class="atelier-page">
    <section class="hero-premium hero-entreprise" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/img/atelier/fond_atelier.jpg');">
        <div class="hero-content-overlay">
            <span class="gold-subtitle"><?= htmlspecialchars($txt_hero_sub) ?></span>
            <h1><?= htmlspecialchars($txt_hero_title) ?></h1>
            <p class="subtitle"><?= htmlspecialchars($txt_hero_desc) ?></p>
        </div>
    </section>

    <section class="entreprise-intro container section-padding">
        <div class="intro-grid">
            <div class="intro-text">
                <h2 class="section-title-gold"><?= htmlspecialchars($txt_intro_title) ?></h2>
                <p class="lead"><?= htmlspecialchars($txt_intro_lead) ?></p>
                <p><?= nl2br(htmlspecialchars($txt_intro_text)) ?></p>
            </div>
            <div class="intro-featured-img">
                <div class="image-frame">
                    <img src="<?= $img_heritage ?>" alt="Détail technique Héritage">
                </div>
            </div>
        </div>
    </section>

    <div class="transition-luxe"></div>

    <section class="entreprise-team section-padding">
        <div class="container">
            <h2 class="center-title">Les mains de l'expertise</h2>
            <div class="team-grid">
                <?php foreach ($membres as $membre): ?>
                    <div class="team-item">
                        <div class="image-box">
                            <img src="<?= htmlspecialchars($membre['photo']) ?>" alt="<?= htmlspecialchars($membre['nom']) ?>">
                            
                            <a href="personne_page.php?id=<?= $membre['id'] ?>" class="btn-more">En savoir plus</a>
                        </div>
                        <h3><?= htmlspecialchars($membre['nom']) ?></h3>
                        <p><?= htmlspecialchars($membre['poste']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="entreprise-labels container">
        <div class="labels-wrapper">
        <div class="label-box">
            <img src="assets/img/atelier/icon_exp.png" alt="Expérience">
            <span>+20 ans d'expérience</span>
            <p>Savoir-faire</p>
        </div>

        <div class="label-box">
            <img src="assets/img/atelier/icon_qualite.png" alt="Sur mesure">
            <span>Fabrication sur mesure</span>
            <p>Qualité</p>
        </div>

        <div class="label-box">
            <img src="assets/img/atelier/icon_prox.png" alt="Île-de-France">
            <span>Intervention en Île-de-France et en France</span>
            <p>Proximité</p>
        </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>