<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la sécurité
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) { 
    header('Location: projets.php'); 
    exit(); 
}

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

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/img/realisations/';
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('ieb_') . '.' . $extension;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_path = 'assets/img/realisations/' . $filename;
        }
    }

    $sql = "UPDATE projets SET titre=?, description=?, type=?, localisation=?, surface=?, materiaux=?, duree=?, image_principale=?, statut=? WHERE id=?";
    $stmt_update = $pdo->prepare($sql);

    // TENTATIVE D'EXÉCUTION ET NOTIFICATION POUR LE POP-UP
    if ($stmt_update->execute([$titre, $description, $type, $localisation, $surface, $materiaux, $duree, $image_path, $statut, $id])) {
        $_SESSION['success'] = "Le projet '" . htmlspecialchars($titre) . "' a été mis à jour avec succès.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour du projet.";
    }

    // Redirection vers la liste qui affiche le message de session
    header('Location: projets.php');
    exit();
}

$base_path = '../';
include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="projets.php" class="btn-action" style="margin-bottom: 20px; display: inline-block;">← Retour au portfolio</a>
            <h1 class="serif-gold">Modifier : <?= htmlspecialchars($p['titre']) ?></h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Titre</label>
                    <input type="text" name="titre" value="<?= htmlspecialchars($p['titre']) ?>" required style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                </div>
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Catégorie</label>
                    <select name="type" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        <?php 
                        $categories = ['interieur', 'exterieur', 'sur-mesure', 'pro', 'renovation'];
                        foreach($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($p['type'] == $cat) ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Localisation</label>
                    <input type="text" name="localisation" value="<?= htmlspecialchars($p['localisation'] ?? '') ?>" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                </div>
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Visibilité</label>
                    <select name="statut" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        <option value="brouillon" <?= ($p['statut'] == 'brouillon') ? 'selected' : '' ?>>Brouillon</option>
                        <option value="publie" <?= ($p['statut'] == 'publie') ? 'selected' : '' ?>>Publié</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Surface</label>
                    <input type="text" name="surface" value="<?= htmlspecialchars($p['surface'] ?? '') ?>" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                </div>
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Matériaux</label>
                    <input type="text" name="materiaux" value="<?= htmlspecialchars($p['materiaux'] ?? '') ?>" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Durée du chantier</label>
                <input type="text" name="duree" value="<?= htmlspecialchars($p['duree'] ?? '') ?>" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
            </div>

            <div style="margin-top: 20px;">
                <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 20px; align-items: center; border: 1px dashed rgba(197, 166, 124, 0.3); padding: 20px;">
                <img src="../<?= $p['image_principale'] ?>" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid var(--gold-accent);">
                <div style="flex: 1;">
                    <p style="font-size: 0.7rem; margin-bottom: 10px; opacity: 0.7;">Changer la photo :</p>
                    <input type="file" name="image" accept="image/*" style="font-size: 0.8rem; color: var(--gold-accent);">
                </div>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; cursor: pointer; margin-top: 30px; padding: 15px;">Mettre à jour</button>
        </form>
    </div>
</main>
<?php include('../includes/footer.php'); ?>