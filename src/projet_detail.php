<?php
require_once('includes/db.php');
$slug = $_GET['slug'] ?? '';
if (empty($slug)) { header('Location: realisations.php'); exit(); }
// 1. Récupération du projet principal
$stmt = $pdo->prepare("SELECT * FROM projets WHERE slug = ? AND statut = 'publie'");
$stmt->execute([$slug]);
$projet = $stmt->fetch();
if (!$projet) { header('Location: realisations.php'); exit(); }
// 2. Récupération des images de la galerie
$stmt_images = $pdo->prepare("SELECT image_url FROM images_projets WHERE projet_id = ? ORDER BY id ASC");
$stmt_images->execute([$projet['id']]);
$galerie = $stmt_images->fetchAll();
// Ajouter l'image principale au début de la galerie
$image_principale_tab = ['image_url' => $projet['image_principale']];
array_unshift($galerie, $image_principale_tab);
// 3. Navigation
$stmt_next = $pdo->prepare("SELECT titre, slug, image_principale FROM projets WHERE id > ? AND statut = 'publie' ORDER BY id ASC LIMIT 1");
$stmt_next->execute([$projet['id']]);
$next_p = $stmt_next->fetch();
if (!$next_p) {
    $next_p = $pdo->query("SELECT titre, slug, image_principale FROM projets WHERE statut = 'publie' ORDER BY id ASC LIMIT 1")->fetch();
}
$page_title = $projet['titre'] . " - IEB";
$page_css = "css/projet_detail.css?v=" . time();
include('includes/header.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<main class="projet-premium">
    <section class="hero-project" style="background-image: url('<?= htmlspecialchars($projet['image_principale']) ?>');">
        <div class="hero-overlay">
            <div class="container hero-container">
                <div class="nav-top-wrapper">
                    <a href="realisations.php" class="back-link"><i class="fa-solid fa-arrow-left-long"></i> RETOUR</a>
                </div>
                <div class="hero-text-content">
                    <?php if(!empty($projet['type'])): ?><span class="category-label reveal"><?= htmlspecialchars($projet['type']) ?></span><?php endif; ?>
                    <h1 class="reveal"><?= mb_strtoupper(htmlspecialchars($projet['titre'])) ?></h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="project-info-grid">
            <div class="content-text reveal">
                <h2 class="gold-title">L'Esprit de l'Ouvrage</h2>
                <p class="description-large"><?= !empty($projet['description']) ? nl2br(htmlspecialchars($projet['description'])) : "Une réalisation d'exception." ?></p>
            </div>
            <div class="specs-box reveal">
                <h3 class="specs-title">Détails techniques</h3>
                <?php if(!empty($projet['localisation'])): ?>
                <div class="spec-item"><span class="label">Lieu</span><span class="value"><?= htmlspecialchars($projet['localisation']) ?></span></div>
                <?php endif; ?>
                <?php if(!empty($projet['materiaux'])): ?>
                <div class="spec-item"><span class="label">Matériaux</span><span class="value"><?= htmlspecialchars($projet['materiaux']) ?></span></div>
                <?php endif; ?>
            </div>
        </section>
        <?php if (!empty($galerie)): ?>
        <section class="project-gallery-section reveal">
            <div class="gallery-intro"><h2 class="section-title">GALERIE DE RÉALISATION</h2></div>
            <div class="mosaic-grid">
                <?php foreach($galerie as $index => $img):
                    $class = '';
                    if ($index % 5 == 0) $class = 'is-large';
                    elseif ($index % 5 == 3) $class = 'is-wide';
                ?>
                <div class="mosaic-item <?= $class ?> reveal" onclick="openLightbox('<?= htmlspecialchars($img['image_url']) ?>')">
                    <div class="mosaic-inner">
                        <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="IEB Menuiserie" loading="lazy">
                        <div class="mosaic-overlay"><span class="plus-icon">+</span></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        <section class="next-banner reveal">
            <a href="projet_detail.php?slug=<?= $next_p['slug'] ?>" class="next-link">
                <div class="next-bg" style="background-image: url('<?= htmlspecialchars($next_p['image_principale']) ?>');"></div>
                <div class="next-inner">
                    <span class="next-label">PROJET SUIVANT</span>
                    <h2><?= mb_strtoupper(htmlspecialchars($next_p['titre'])) ?></h2>
                </div>
            </a>
        </section>
    </div>
</main>
<div id="lightbox" class="lightbox" onclick="this.classList.remove('active')">
    <span class="close-lb">&times;</span>
    <img src="" id="lb-img">
</div>
<script>
function openLightbox(url) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lb-img').src = url;
    lb.classList.add('active');
}
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
<?php include('includes/footer.php'); ?>