<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// 1. Initialisation des variables pour éviter l'erreur "Undefined variable"
$success = "";
$error = "";
$page_filter = $_GET['page'] ?? 'home';
$photos = [];

// 2. Logique d'upload (si un fichier est envoyé)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['new_image'])) {
    $id = $_POST['target_id'];
    $table = $_POST['target_table'];
    $file = $_FILES['new_image'];
    
    $folder = ($table === 'avis') ? 'avis/' : (($page_filter === 'services') ? 'services/' : 'accueil/');
    $target_dir = "../assets/img/" . $folder;
    
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;
    $target_file = $target_dir . $new_name;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $db_path = "assets/img/" . $folder . $new_name;
        $column = ($table === 'avis') ? 'image' : 'image_url';
        
        $stmt = $pdo->prepare("UPDATE $table SET $column = ? WHERE id = ?");
        if ($stmt->execute([$db_path, $id])) {
            $success = "Image mise à jour avec succès !";
        }
    }
}

// 3. Logique de filtrage STRICTE basée sur ton SQL dump
if ($page_filter === 'home') {
    // Uniquement les cards d'accueil et le meuble interactif
    $types = "'home_interieur', 'home_exterieur', 'home_mobilier', 'home_meuble', 'home_meuble_close', 'home_meuble_open1', 'home_meuble_open2', 'home_meuble_open3'";
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ($types)");
    $stmt->execute();
    $photos = $stmt->fetchAll();

} elseif ($page_filter === 'services') {
    // Précision, Geste, Technologie, Matière ET Expertises
    $types = "'home_precision', 'home_geste', 'home_technologie', 'home_matiere', 'home_expertise_exterieur', 'home_expertise_interieur'";
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ($types)");
    $stmt->execute();
    $photos = $stmt->fetchAll();

} elseif ($page_filter === 'atelier') {
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type = 'atelier_heritage'");
    $stmt->execute();
    $photos = $stmt->fetchAll();

} elseif ($page_filter === 'avis') {
    // Images Avant/Après
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ('avis_avant', 'avis_apres')");
    $stmt->execute();
    $photos = $stmt->fetchAll();
    
    // Ajout des photos des clients (table avis)
    $stmt2 = $pdo->prepare("SELECT id, image as url, nom as label, 'avis' as origin FROM avis WHERE image IS NOT NULL AND image != ''");
    $stmt2->execute();
    $photos = array_merge($photos, $stmt2->fetchAll());
}
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 class="serif-gold">Médiathèque</h1>
                <a href="editeur.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                    ← Editeur
                </a>
        </div>

        <!-- Navigation des filtres -->
        <div style="display: flex; gap: 10px; margin-bottom: 40px;">
            <?php 
            $nav = ['home' => 'Accueil', 'services' => 'Services', 'atelier' => 'Atelier', 'avis' => 'Avis & Études'];
            foreach($nav as $slug => $label): ?>
                <a href="?page=<?= $slug ?>" class="<?= $page_filter === $slug ? 'btn-mini-gold' : 'btn-mini-flush' ?>" style="text-decoration:none; padding: 8px 15px;">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Message de succès -->
        <?php if($success): ?>
            <div style="color: #c5a67c; background: rgba(197,166,124,0.1); padding: 15px; border-left: 4px solid #c5a67c; margin-bottom: 20px;">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- Grille -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach($photos as $p): ?>
                <div class="card-premium" style="padding: 15px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <span style="font-size: 0.6rem; color: #c5a67c; display: block; margin-bottom: 10px; letter-spacing: 1px;">
                        <?= strtoupper(str_replace(['home_', 'avis_'], '', $p['label'])) ?>
                    </span>
                    
                    <div style="width: 100%; height: 160px; overflow: hidden; margin-bottom: 15px; border-radius: 2px;">
                        <img src="../<?= $p['url'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="target_id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="target_table" value="<?= $p['origin'] ?>">
                        <label class="btn-mini-flush" style="display: block; text-align: center; cursor: pointer; font-size: 0.7rem;">
                            Remplacer la photo
                            <input type="file" name="new_image" style="display: none;" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>