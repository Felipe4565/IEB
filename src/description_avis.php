<?php 
require_once 'includes/db.php'; 

// 1. Récupération du slug (par défaut marc-antoine)
$slug = $_GET['slug'] ?? 'marc-antoine';

// 2. Récupération de l'avis précis
$query = $pdo->prepare("SELECT * FROM avis WHERE slug = :slug");
$query->execute(['slug' => $slug]);
$avis = $query->fetch();

if (!$avis) {
    die("Avis non trouvé.");
}

// 3. Récupération de TOUTES les images associées à cet avis (Galerie)
$queryImages = $pdo->prepare("SELECT image_url FROM images_avis WHERE avis_id = ? ORDER BY id ASC");
$queryImages->execute([$avis['id']]);
$galerie = $queryImages->fetchAll(PDO::FETCH_ASSOC);

// Si la galerie est vide, on crée un tableau avec l'image principale pour ne pas avoir de vide
if (empty($galerie) && !empty($avis['image'])) {
    $galerie = [['image_url' => $avis['image']]];
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
                    <img src="<?= htmlspecialchars($avis['image']) ?>" 
                         id="mainView" 
                         alt="Projet <?= htmlspecialchars($avis['nom']) ?>" 
                         class="img-large">
                </div>
            </div>
            
            <div class="thumbnails">
                <?php foreach ($galerie as $index => $img): ?>
                    <div class="thumb <?= ($img['image_url'] == $avis['image']) ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($img['image_url']) ?>" 
                             onclick="changeImage(this)" 
                             alt="Vue détaillée <?= $index + 1 ?>">
                    </div>
                <?php endforeach; ?>
                
                <?php if (count($galerie) > 3): ?>
                    <div class="thumb-arrow">></div>
                <?php endif; ?>
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
                        Pour ce projet de <strong><?= htmlspecialchars($avis['type_projet'] ?? 'Menuiserie') ?></strong>, 
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

<script>

function changeImage(element) {
    document.getElementById('mainView').src = element.src;
    
    const thumbs = document.querySelectorAll('.thumb');
    thumbs.forEach(t => t.classList.remove('active'));
    
    element.parentElement.classList.add('active');
}
</script>

<?php include 'includes/footer.php'; ?>