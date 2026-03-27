<?php
$page_title = "L'Atelier - IEB";
// Chemin relatif direct car le dossier css est au même niveau
$page_css = "css/atelier.css?v=" . time(); 
include('includes/header.php');
?>

<main class="atelier-page">
    <section class="hero-premium hero-entreprise" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/img/fond_atelier.jpg');">
        <div class="hero-content-overlay">
            <span class="gold-subtitle">Depuis 2001</span>
            <h1>L'Atelier IEB</h1>
            <p class="subtitle">L’excellence au service de vos projets</p>
        </div>
    </section>

    <section class="entreprise-intro container section-padding">
        <div class="intro-grid">
            <div class="intro-text">
                <h2 class="section-title-gold">Notre Héritage</h2>
                <p class="lead">Chaque pièce est une rencontre entre une essence noble et un geste précis.</p>
                <p>Installés en Île-de-France, nous combinons les techniques traditionnelles et l'innovation pour réaliser des créations uniques et raffinées.</p>
            </div>
            <div class="intro-featured-img">
                <div class="image-frame">
                    <img src="assets/img/heritage_meuble.jpg" alt="Détail technique Héritage">
                </div>
            </div>
        </div>
    </section>

    <section class="entreprise-team section-padding">
        <div class="container">
            <h2 class="center-title">Les mains de l'expertise</h2>
            <div class="team-grid">
                <div class="team-item">
                    <div class="image-box">
                        <img src="assets/img/Alvariza.jpg" alt="Leonardo Freddy Alvariza">
                    </div>
                    <h3>Leonardo Freddy Alvariza</h3>
                    <p>Menuisier et gérant d'intérieur extérieur bois</p>
                </div>
                <div class="team-item">
                    <div class="image-box">
                        <img src="assets/img/employé_type.jpg" alt="Salarié type">
                    </div>
                    <h3>Julian Alvariza</h3>
                    <p>Menuisier et salarié de l'entreprise intérieur extérieur bois</p>
                </div>
            </div>
        </div>
    </section>

    <section class="entreprise-labels container">
        <div class="labels-wrapper">
            <div class="label-box"><span>PEFC</span><p>Gestion Durable</p></div>
            <div class="label-box"><span>Artisan d'Art</span><p>Reconnaissance</p></div>
            <div class="label-box"><span>Made in IDF</span><p>Circuit Court</p></div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>