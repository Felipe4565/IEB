<?php 
require_once('includes/db.php'); 

// 1. Récupération des images pour le comparateur Avant/Après
$query_slider = $pdo->query("SELECT image_url, type FROM images_projets WHERE type IN ('avis_avant', 'avis_apres')");
$imgs_slider = $query_slider->fetchAll(PDO::FETCH_KEY_PAIR);

$img_avant = $imgs_slider['avis_avant'] ?? 'assets/img/avis/avant.png';
$img_apres = $imgs_slider['avis_apres'] ?? 'assets/img/avis/apres.png';

// 2. Récupération de l'image du Hero spécifique à la page Avis
$query_hero = $pdo->query("SELECT image_url FROM images_projets WHERE type = 'avis_hero' LIMIT 1");
$hero_row = $query_hero->fetch();
$hero_background = (!empty($hero_row['image_url'])) ? $hero_row['image_url'] : 'assets/img/avis/matiere.jpg';

// 3. Récupération des textes dynamiques
$query_txt = $pdo->query("SELECT cle, valeur FROM contenus WHERE cle LIKE 'avis_%'");
$textes = $query_txt->fetchAll(PDO::FETCH_KEY_PAIR);

// Textes du Hero (Nouveaux)
$txt_hero_title    = $textes['avis_hero_title'] ?? "Découvrez l'expérience de nos clients";
$txt_hero_subtitle = $textes['avis_hero_subtitle'] ?? "L'excellence à travers vos yeux";
$txt_hero_tagline  = $textes['avis_hero_tagline'] ?? "Une précision millimétrée, un résultat d'exception.";

// Textes de l'étude de cas
$txt_trans_title    = $textes['avis_transformation_title'] ?? "Étude de cas : La métamorphose";
$txt_case_title     = $textes['avis_case_title']           ?? "Rénovation Salon & Bibliothèque";
$txt_case_client    = $textes['avis_case_client']          ?? "Maison Haussmannienne";
$txt_case_location  = $textes['avis_case_location']        ?? "Paris VII";
$txt_case_quote     = $textes['avis_case_quote']           ?? "Nous avions un espace sombre et mal optimisé. L'équipe IEB a su redonner vie à notre pièce avec un travail du bois d'une finesse rare.";
$txt_case_signature = $textes['avis_case_signature']       ?? "— Famille de V.";

// 4. Récupération des avis clients
$query_avis = $pdo->query("SELECT * FROM avis WHERE statut = 'affiche' ORDER BY date DESC");
$avis_bdd = $query_avis->fetchAll();

$page_title = "Avis Clients - IEB";
$page_css = "css/avis.css?v=" . time(); 

include('includes/header.php'); 
?>

<?php if (isset($_GET['success'])): ?>
    <div id="success-message" style="background: rgba(197, 164, 126, 0.1); border: 1px solid var(--gold); color: var(--gold); padding: 20px; text-align: center; margin: 20px auto; max-width: 800px; position: relative; z-index: 10;">
        <span style="font-family: 'Playfair Display', serif; letter-spacing: 1px;">
            Merci ! Votre témoignage a été envoyé avec succès et sera publié après validation.
        </span>
        <span onclick="this.parentElement.style.display='none'" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 20px;">×</span>
    </div>
<?php endif; ?>

<main class="page-avis">

<section class="hero-score" style="background-image: linear-gradient(to bottom, rgba(10, 10, 10, 0.6) 0%, #0A0A0A 100%), url('<?= $hero_background ?>');">
    <div class="container">
        <h1 class="serif-gold main-hero-title"><?= htmlspecialchars($txt_hero_title) ?></h1>
        
        <div class="score-display">
            <p class="hero-subtitle"><?= htmlspecialchars($txt_hero_subtitle) ?></p>
            
            <span class="score-number">5.0</span>
            
            <div class="stars-row unifie">★★★★★</div>
            
            <a href="https://www.google.com/search?q=Sarl+Interieur+Exterieur+Bois+Avis..." 
               target="_blank" 
               rel="noopener noreferrer" 
               class="google-badge-link">
                <div class="google-badge">
                    <img src="assets/img/avis/google.png" alt="Google">
                    <span>Évaluations vérifiées par <strong>Google Business</strong></span>
                </div>
            </a>
            
            <p class="hero-tagline"><?= htmlspecialchars($txt_hero_tagline) ?></p>
        </div>
    </div>
</section>

<section class="section-transformation">
    <div class="container">
        <h2 class="serif-gold text-center mb-5"><?= htmlspecialchars($txt_trans_title) ?></h2>
        
        <div class="comparison-card">
            <div class="comparison-slider">
                <div class="img-after" style="background-image: url('<?= $img_apres ?>');"></div>
                <div class="img-before" style="background-image: url('<?= $img_avant ?>');"></div>
                
                <input type="range" min="0" max="100" value="50" class="slider-handle" id="compare-slider">
                <div class="slider-line" id="slider-line"></div>
                
                <div class="label-before">Avant</div>
                <div class="label-after">Après</div>
            </div>

            <div class="transformation-text">
                <div class="transformation-header">
                    <h2 class="title-section-unifie"><?= htmlspecialchars($txt_case_title) ?></h2>
                    <h3 class="client-name"><?= htmlspecialchars($txt_case_client) ?></h3>
                    <p class="client-project"><?= htmlspecialchars($txt_case_location) ?></p>
                </div>
                
                <div class="quote-wrapper">
                    <blockquote class="main-quote">
                        "<?= htmlspecialchars($txt_case_quote) ?>"
                    </blockquote>
                </div>
                
                <p class="signature-client"><?= htmlspecialchars($txt_case_signature) ?></p>
            </div>
        </div>
    </div>
</section>

<section class="all-reviews">
    <div class="container">
        <div class="reviews-header">
            <h2 class="serif-gold">Derniers Témoignages</h2>
            <a href="laisser_avis.php" class="btn-gold-outline">Laisser un avis</a>
        </div>

        <div class="reviews-grid">
            <?php foreach ($avis_bdd as $avis): ?>
                <div class="review-card <?= ($avis['est_detaille']) ? 'has-images' : '' ?>">
                    <div class="stars">
                        <?= str_repeat('★', $avis['note']) . str_repeat('☆', 5 - $avis['note']) ?>
                    </div>
                    <p class="review-content">"<?= htmlspecialchars($avis['commentaire']) ?>"</p>
                    <span class="review-author"><?= htmlspecialchars($avis['nom']) ?></span>

                    <?php if (!empty($avis['image'])): ?>
                        <a href="description_avis.php?slug=<?= htmlspecialchars($avis['slug']) ?>" class="btn-gold-outline btn-small">Voir plus</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</main>

<script>
    const slider = document.getElementById('compare-slider');
    const beforeImg = document.querySelector('.img-before');
    const sliderLine = document.getElementById('slider-line');

    slider.addEventListener('input', (e) => {
        const value = e.target.value;
        beforeImg.style.width = value + "%";
        sliderLine.style.left = value + "%";
    });
</script>   

<?php include('includes/footer.php'); ?>