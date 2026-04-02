<?php include('includes/header.php'); ?>

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
                    <img src="assets/img/google.png" alt="Google">
                    <span>Évaluations vérifiées par <strong>Google Business</strong></span>
                </div>
            </a>
            
        </div>
    </div>
</section>

    <section class="section-transformation">
        <div class="container">
            <h2 class="title-label">Étude de cas : La métamorphose</h2>
            
            <div class="comparison-card">
                <div class="comparison-slider">
                    <div class="img-after" style="background-image: url('assets/img/apres.jpg');"></div>
                    <div class="img-before" style="background-image: url('assets/img/avant.jpg');"></div>
                    <input type="range" min="0" max="100" value="50" class="slider-handle" id="compare-slider">
                    <div class="slider-line"></div>
                    <div class="label-before">Avant</div>
                    <div class="label-after">Après</div>
                </div>

                <div class="transformation-text">
                    <span class="gold-corner"></span>
                    <h3 class="client-name">Maison Haussmannienne</h3>
                    <p class="project-type">Rénovation complète - Salon & Bibliothèque</p>
                    <blockquote class="main-quote">
                        "Nous avions un espace sombre et mal optimisé. L'équipe IEB a su redonner vie à notre pièce avec un travail du bois d'une finesse rare. Le résultat dépasse nos espérances."
                    </blockquote>
                    <p class="signature-client">— Famille de V., Paris VII</p>
                </div>
            </div>
        </div>
    </section>

    <section class="all-reviews">
        <div class="container">
            <div class="reviews-header">
                <h2 class="serif-gold">Derniers Témoignages</h2>
                <a href="https://g.page/r/votre-lien-google/review" target="_blank" class="btn-gold-outline">Laisser un avis</a>
            </div>

            <div class="reviews-grid">
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p class="review-content">"Une équipe à l'écoute et un savoir-faire artisanal qu'on ne trouve plus ailleurs. Ma terrasse est superbe."</p>
                    <span class="review-author">Marc-Antoine P.</span>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p class="review-content">"Précision millimétrée pour mon dressing sur-mesure. Chantier très propre, je recommande vivement."</p>
                    <span class="review-author">Sophie L.</span>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p class="review-content">"Intervention rapide pour nos fenêtres. Le bois est de qualité supérieure, l'isolation est parfaite."</p>
                    <span class="review-author">Julien R.</span>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    // Script simple pour le curseur Avant/Après
    const slider = document.getElementById('compare-slider');
    const beforeImg = document.querySelector('.img-before');
    const sliderLine = document.querySelector('.slider-line');

    slider.addEventListener('input', (e) => {
        let value = e.target.value;
        beforeImg.style.width = value + "%";
        sliderLine.style.left = value + "%";
    });
</script>

<?php include('includes/footer.php'); ?>