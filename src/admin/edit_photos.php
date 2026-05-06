<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');
include('../includes/header.php'); 

$success = "";
$error = "";
$page_filter = $_GET['page'] ?? 'home';
$photos = [];

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
    $stmt = $pdo->prepare("SELECT id, image_url as url, type as label, 'images_projets' as origin FROM images_projets WHERE type IN ('avis_avant', 'avis_apres')");
    $stmt->execute();
    $photos = $stmt->fetchAll();
    
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

        <?php if($success): ?>
            <div style="color: #c5a67c; background: rgba(197,166,124,0.1); padding: 15px; border-left: 4px solid #c5a67c; margin-bottom: 20px;">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach($photos as $p): ?>
                <div class="card-premium" style="padding: 15px;">
                    <span class="label-cle" style="display:block; margin-bottom:10px;">
                        <?= strtoupper(str_replace(['home_', 'avis_'], '', $p['label'])) ?>
                    </span>
                    <div style="width: 100%; height: 160px; overflow: hidden; margin-bottom: 15px;">
                        <img src="../<?= $p['url'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="target_id" value="<?= $p['id'] ?>">
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