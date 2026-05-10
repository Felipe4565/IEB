<?php 
require_once 'includes/db.php'; // Ton fichier de connexion

// Récupération du slug (par défaut marc-antoine comme dans ta BD)
$slug = $_GET['slug'] ?? 'marc-antoine';

// On récupère l'avis précis
$query = $pdo->prepare("SELECT * FROM avis WHERE slug = :slug");
$query->execute(['slug' => $slug]);
$avis = $query->fetch();

if (!$avis) {
    die("Avis non trouvé.");
}

include 'includes/header.php'; 
?>

<link rel="stylesheet" href="css/description_avis.css">

<main class="container">
    <h1 class="main-title">TÉMOIGNAGE CLIENT : <?= htmlspecialchars(strtoupper($avis['nom'])) ?></h1>
    <hr class="separator">

    <section class="content-grid">
        <div class="gallery-section">
            <div class="main-images">
                <div class="img-container">
                    <img src="<?= htmlspecialchars($avis['image']) ?>" alt="Projet <?= htmlspecialchars($avis['nom']) ?>" class="img-large">
                </div>
            </div>
            
            <div class="thumbnails">
                <div class="thumb active"><img src="<?= htmlspecialchars($avis['image']) ?>"></div>
                <div class="thumb-arrow">></div>
            </div>
            <p class="gallery-caption">VUES DÉTAILLÉES DU PROJET PARTAGÉES PAR LE CLIENT</p>
        </div>

        <div class="testimonial-card">
            <div class="card-header">
                <div class="avatar-placeholder"></div>
                <p>Publié le <?= date('d/m/Y', strtotime($avis['date'])) ?></p>
            </div>
            
            <div class="card-body">
                <div class="section-block">
                    <h3>LE REGARD DU CLIENT</h3>
                    <blockquote class="quote">
                        "<?= htmlspecialchars($avis['commentaire']) ?>"
                    </blockquote>
                    <p class="client-signature"><?= htmlspecialchars($avis['nom']) ?></p>
                </div>

                <div class="section-block artisan-note">
                    <h3>LES DÉTAILS DE L'ARTISAN</h3>
                    <p>
                        Pour ce projet de <?= strtolower(htmlspecialchars($avis['nom'])) ?>, 
                        nous avons mis l'accent sur la sélection d'essences durables et une pose millimétrée.
                        Chaque détail reflète notre engagement pour la haute menuiserie.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="footer-actions">
        <a href="avis.php" class="btn-back">RETOUR À TOUS LES AVIS</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>