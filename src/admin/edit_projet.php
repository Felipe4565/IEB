<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la sécurité
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. Récupération des infos du projet
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) { 
    header('Location: projets.php'); 
    exit(); 
}

// 2. Récupération de la galerie actuelle pour l'affichage
$stmt_gal = $pdo->prepare("SELECT * FROM images_projets WHERE projet_id = ? ORDER BY id DESC");
$stmt_gal->execute([$id]);
$images_galerie = $stmt_gal->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $localisation = $_POST['localisation'] ?? '';
    $surface = $_POST['surface'] ?? '';
    $materiaux = $_POST['materiaux'] ?? '';
    $duree = $_POST['duree'] ?? '';
    $statut = $_POST['statut'] ?? 'brouillon';
    
    $image_path = $p['image_principale']; 
    $upload_dir = '../assets/img/realisations/';

    // --- A. GESTION DE L'IMAGE PRINCIPALE (REMPLACEMENT) ---
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'main-' . uniqid() . '.' . $extension;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_path = 'assets/img/realisations/' . $filename;
        }
    }

    // --- B. MISE À JOUR DES INFOS GÉNÉRALES ---
    $sql = "UPDATE projets SET titre=?, description=?, type=?, localisation=?, surface=?, materiaux=?, duree=?, image_principale=?, statut=? WHERE id=?";
    $stmt_update = $pdo->prepare($sql);
    $stmt_update->execute([$titre, $description, $type, $localisation, $surface, $materiaux, $duree, $image_path, $statut, $id]);

    // --- C. AJOUT DE NOUVELLES PHOTOS À LA GALERIE ---
    if (isset($_FILES['galerie']) && !empty($_FILES['galerie']['name'][0])) {
        foreach ($_FILES['galerie']['name'] as $key => $name) {
            if ($_FILES['galerie']['error'][$key] === 0) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $gal_filename = 'gal-' . $id . '-' . uniqid() . '.' . $ext;
                
                if (move_uploaded_file($_FILES['galerie']['tmp_name'][$key], $upload_dir . $gal_filename)) {
                    $gal_path = 'assets/img/realisations/' . $gal_filename;
                    $stmt_ins_gal = $pdo->prepare("INSERT INTO images_projets (projet_id, image_url) VALUES (?, ?)");
                    $stmt_ins_gal->execute([$id, $gal_path]);
                }
            }
        }
    }

    $_SESSION['success'] = "Le projet a été mis à jour avec succès.";
    // Redirige vers la liste globale des réalisations au lieu de rester sur la page d'édition
    header("Location: projets.php"); 
    exit();
}

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
        
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="projets.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; color: #c5a67c; text-decoration: none;">← Retour au portfolio</a>
            <h1 class="serif-gold" style="color: #c5a67c; font-family: 'Playfair Display', serif; font-size: 2.5rem;">Modifier : <?= htmlspecialchars($p['titre']) ?></h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); padding: 30px; border: 1px solid rgba(197, 166, 124, 0.1);">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Titre</label>
                        <input type="text" name="titre" value="<?= htmlspecialchars($p['titre']) ?>" required style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Catégorie</label>
                        <select name="type" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            <?php 
                            $categories = ['interieur', 'exterieur', 'sur-mesure', 'pro', 'renovation'];
                            foreach($categories as $cat): ?>
                                <option value="<?= $cat ?>" <?= ($p['type'] == $cat) ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Localisation</label>
                        <input type="text" name="localisation" value="<?= htmlspecialchars($p['localisation'] ?? '') ?>" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                    </div>
                </div>

                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Surface / Matériaux</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="surface" placeholder="Surface" value="<?= htmlspecialchars($p['surface'] ?? '') ?>" style="flex: 1; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            <input type="text" name="materiaux" placeholder="Matériaux" value="<?= htmlspecialchars($p['materiaux'] ?? '') ?>" style="flex: 1; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Durée & Visibilité</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="duree" placeholder="Durée" value="<?= htmlspecialchars($p['duree'] ?? '') ?>" style="flex: 1; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            <select name="statut" style="flex: 1; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                                <option value="brouillon" <?= ($p['statut'] == 'brouillon') ? 'selected' : '' ?>>Brouillon</option>
                                <option value="publie" <?= ($p['statut'] == 'publie') ? 'selected' : '' ?>>Publié</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                         <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Description</label>
                         <textarea name="description" rows="3" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; font-family: sans-serif;"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <h3 class="serif-gold" style="margin-top: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 10px; font-size: 1.1rem; color: #c5a67c;">Gestion des visuels</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div style="background: rgba(255,255,255,0.03); padding: 20px; border: 1px solid rgba(197, 166, 124, 0.1);">
                    <p style="font-size: 0.7rem; color: #c5a67c; text-transform: uppercase; margin-bottom: 15px;">Image principale actuelle</p>
                    <img src="../<?= $p['image_principale'] ?>" style="width: 100%; height: 150px; object-fit: cover; border: 1px solid #c5a67c; margin-bottom: 15px;">
                    <label style="font-size: 0.7rem; color: #fff; opacity: 0.6; display: block; margin-bottom: 5px;">Remplacer :</label>
                    <input type="file" name="image" accept="image/*" style="font-size: 0.8rem; color: #c5a67c;">
                </div>

                <div style="background: rgba(197, 166, 124, 0.05); padding: 20px; border: 1px dashed #c5a67c; display: flex; flex-direction: column; justify-content: center; text-align: center;">
                    <p style="font-size: 0.8rem; color: #c5a67c; margin-bottom: 15px; font-weight: bold;">+ AJOUTER DES PHOTOS À LA GALERIE</p>
                    <input type="file" name="galerie[]" multiple accept="image/*" style="font-size: 0.8rem; color: #c5a67c; margin: 0 auto;">
                    <p style="font-size: 0.6rem; color: #fff; opacity: 0.5; margin-top: 10px;">Sélectionnez plusieurs fichiers d'un coup.</p>
                </div>
            </div>

            <?php if (!empty($images_galerie)): ?>
            <div style="margin-top: 30px;">
                <p style="font-size: 0.7rem; color: #c5a67c; text-transform: uppercase; margin-bottom: 15px;">Photos déjà dans la galerie (<?= count($images_galerie) ?>)</p>
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">
                    <?php foreach($images_galerie as $img): ?>
                        <div style="aspect-ratio: 1; border: 1px solid rgba(255,255,255,0.1); position: relative; overflow: hidden;">
                            <img src="../<?= $img['image_url'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-gold" style="width: 100%; cursor: pointer; margin-top: 40px; padding: 18px; background: #c5a67c; color: #0d0e0a; border: none; font-weight: bold; letter-spacing: 2px; text-transform: uppercase;">
                Enregistrer toutes les modifications
            </button>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>