<?php
// 1. EN PREMIER : Authentification et Base de données
require_once('includes/auth_check.php'); // Contient session_start()
require_once('../includes/db.php');
require_once('../includes/upload.php');

$error = "";
$allowed_pages = ['home', 'services', 'atelier', 'avis'];
$requested_page = $_GET['page'] ?? 'home';
$page_filter = in_array($requested_page, $allowed_pages, true) ? $requested_page : 'home';
$photos = [];

// 2. LOGIQUE DE TRAITEMENT (Avant tout envoi de HTML pour que la redirection fonctionne)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['new_image'])) {
    csrf_require_post();
    $id    = (int)($_POST['target_id'] ?? 0);
    $table = $_POST['target_table'] ?? '';

    // Liste blanche : table => colonne (plus d'injection possible)
    $allowed = ['images_projets' => 'image_url', 'avis' => 'image'];
    if (!isset($allowed[$table]) || $id <= 0) {
        $_SESSION['error'] = "Requête invalide.";
        header('Location: edit_photos.php?page=' . urlencode($page_filter));
        exit();
    }
    $column = $allowed[$table];

    // Dossier de destination
    if ($table === 'avis') {
        $folder = 'avis/';
    } elseif ($page_filter === 'services') {
        $folder = 'services/';
    } elseif ($page_filter === 'atelier') {
        $folder = 'atelier/';
    } else {
        $folder = 'accueil/';
    }

    $saved = save_image($_FILES['new_image'], __DIR__ . '/../assets/img/' . $folder, 'img-');

    if ($saved === null) {
        $error = "Image refusée (JPG, PNG ou WebP, 5 Mo max).";
    } else {
        $stmt = $pdo->prepare("UPDATE $table SET $column = ? WHERE id = ?");
        if ($stmt->execute(['assets/img/' . $folder . $saved, $id])) {
            $_SESSION['success'] = "Image mise à jour avec succès !";
            header('Location: edit_photos.php?page=' . urlencode($page_filter));
            exit();
        }
        $error = "Erreur lors de l'enregistrement en base.";
    }
}

// 3. RÉCUPÉRATION DES DONNÉES (Pour l'affichage)
if ($page_filter === 'home') {
    $types = "'home_interieur', 'home_exterieur', 'home_mobilier', 'home_meuble', 'home_meuble_close', 'home_meuble_open1', 'home_meuble_open2', 'home_meuble_open3'";
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ($types)");
    $stmt->execute();
    $photos = $stmt->fetchAll();
} elseif ($page_filter === 'services') {
    $types = "'home_precision', 'home_geste', 'home_technologie', 'home_matiere', 'home_expertise_exterieur', 'home_expertise_interieur'";
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ($types)");
    $stmt->execute();
    $photos = $stmt->fetchAll();
} elseif ($page_filter === 'atelier') {
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type = 'atelier_heritage'");
    $stmt->execute();
    $photos = $stmt->fetchAll();
} elseif ($page_filter === 'avis') {
    // Inclusion de 'avis_hero' pour qu'il soit visible dans l'admin
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ('avis_avant', 'avis_apres', 'avis_hero')");
    $stmt->execute();
    $photos = $stmt->fetchAll();
    
    $stmt2 = $pdo->prepare("SELECT id, image as url, nom as label, 'avis' as origin FROM avis WHERE image IS NOT NULL AND image != ''");
    $stmt2->execute();
    $photos = array_merge($photos, $stmt2->fetchAll());
}

// 4. DÉBUT DE L'AFFICHAGE HTML
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 class="serif-gold">Médiathèque</h1>
            <a href="editeur.php" class="btn-gold" style="text-decoration:none; width:auto; padding:12px 25px;">← Editeur</a>
        </div>

        <nav class="filter-nav">
            <?php 
            $nav = ['home' => 'Accueil', 'services' => 'Services', 'atelier' => 'Atelier', 'avis' => 'Avis'];
            foreach($nav as $slug => $label): ?>
                <a href="?page=<?= $slug ?>" class="btn-filter <?= $page_filter === $slug ? 'active' : '' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php if (!empty($error)): ?>
            <p style="color: #ff4d4d; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach($photos as $p): ?>
                <div class="card-premium" style="padding: 15px;">
                    <span class="label-cle" style="display:block; margin-bottom:10px;">
                        <?= htmlspecialchars(strtoupper(str_replace(['home_', 'avis_'], '', $p['label']))) ?>
                    </span>
                    
                    <div style="width: 100%; height: 160px; overflow: hidden; margin-bottom: 15px; background: #1a1a1a;">
                        <img src="../<?= htmlspecialchars($p['url']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='../assets/img/placeholder.jpg';">
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                        <input type="hidden" name="target_id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="target_table" value="<?= $p['origin'] ?>">
                        <label class="btn-mini-gold" style="display: block; text-align: center; cursor: pointer; font-size: 0.7rem;">
                            Remplacer la photo
                            <input type="file" name="new_image" style="display: none;" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>