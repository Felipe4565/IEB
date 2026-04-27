<?php 
require_once('includes/db.php'); // Connexion BDD

// Récupère les avis marqués comme 'affiche'
$query = $pdo->query("SELECT * FROM avis WHERE statut = 'affiche' ORDER BY date DESC");
$avis_bdd = $query->fetchAll();

$page_title = "Avis Clients - IEB";
include('includes/header.php'); 
?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/avis.css">

<main class="page-avis">

<section class="hero-score">
    <div class="container">
        <h1 class="serif-gold">L'Excellence à travers vos yeux</h1>
        <div class="score-display">
            <span class="score-number">5.0</span>
            <div class="stars-row unifie">★★★★★</div>
            
            <a href="https://www.google.com/search?sca_esv=79d8b74525041619&sxsrf=ANbL-n6R2NhUKwSKHa_61BxhGqiY6ctZ0w:1775095186881&q=Sarl+Interieur+Exterieur+Bois+Avis&rflfq=1&num=20&stick=H4sIAAAAAAAAAONgkxIxNDQ2Mjc3MjY2MjAzNrawNDI0NtnAyPiKUSk4sShHwTOvJLUoM7W0SMG1AsZyys8sVnAsyyxexEqEIgCxAQvvZQAAAA&rldimm=11327723320633892134&tbm=lcl&hl=fr-FR&sa=X&ved=2ahUKEwjM1LnwiM6TAxXXnycCHa5cJBAQ9fQKegQIQxAG#lkt=LocalPoiReviews" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="google-badge-link">
                <div class="google-badge">
                    <img src="assets/img/avis/google.png" alt="Google">
                    <span>Évaluations vérifiées par <strong>Google Business</strong></span>
                </div>
            </a>
            
        </div>
    </div>
</section>

<section class="section-transformation">
    <div class="container">
        <h1 class="serif-gold">Étude de cas : La métamorphose</h1>
        
        <div class="comparison-card">
            
            <div class="comparison-slider">
                <div class="img-after" style="background-image: url('assets/img/avis/apres.png');"></div>
                <div class="img-before" style="background-image: url('assets/img/avis/avant.png');"></div>
                
                <input type="range" min="0" max="100" value="50" class="slider-handle" id="compare-slider">
                <div class="slider-line" id="slider-line"></div>
                
                <div class="label-before">Avant</div>
                <div class="label-after">Après</div>
            </div>

            <div class="transformation-text">
                <div class="transformation-header">
                    <h2 class="title-section-unifie">Rénovation Salon & Bibliothèque</h2>
                    <h3 class="client-name">Maison Haussmannienne</h3>
                    <p class="client-project">Paris VII</p>
                </div>
                
                <div class="quote-wrapper">
                    <blockquote class="main-quote">
                        "Nous avions un espace sombre et mal optimisé. L'équipe IEB a su redonner vie à notre pièce avec un travail du bois d'une finesse rare. Le résultat dépasse nos espérances."
                    </blockquote>
                </div>
                
                <p class="signature-client">— Famille de V.</p>
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

                        <?php if ($avis['est_detaille']): ?>
                            <a href="review-<?= $avis['slug'] ?>.php" class="btn-gold-outline btn-small">Voir plus</a>
                        <?php endif; ?>
                        
                    </div>
                <?php endforeach; ?>
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
        sliderLine.style.left = value + "%"; // La ligne suit le mouvement
    });
</script>   

<?php include('includes/footer.php'); ?>