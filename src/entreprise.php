<?php
$page_title = "Entreprise";
$page_css = "/css/atelier.css"; // CSS spécifique à cette page
include('includes/header.php'); // <-- chemin corrigé
?>

<!-- HERO -->
<section class="hero-premium hero-entreprise">
    <div class="hero-content-overlay">
        <h1>Notre Entreprise</h1>
        <p class="subtitle">L’excellence au service de vos projets</p>
    </div>
</section>

<!-- SECTION À PROPOS -->
<main>
    <section class="entreprise-intro container">
        <h2>Notre Savoir-Faire</h2>
        <p>Depuis des années, nous combinons innovation, qualité et artisanat pour réaliser des créations uniques et raffinées.</p>
    </section>

    <!-- GALERIE -->
    <section class="entreprise-gallery container">
        <div class="gallery-grid">
            <div class="gallery-item">
                <div class="image-box">
                    <img src="/images/entreprise/atelier1.jpg" alt="Atelier 1">
                </div>
                <h3>Création sur mesure</h3>
            </div>
            <div class="gallery-item">
                <div class="image-box">
                    <img src="/images/entreprise/atelier2.jpg" alt="Atelier 2">
                </div>
                <h3>Matériaux premium</h3>
            </div>
        </div>
    </section>

</main>

<?php include('includes/footer.php'); // <-- chemin corrigé ?>