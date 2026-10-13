<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la protection
require_once('../includes/db.php');
require_once('../includes/upload.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM equipe WHERE id = ?");
$stmt->execute([$id]);
$m = $stmt->fetch();

if (!$m) {
    $_SESSION['error'] = "Ce membre est introuvable.";
    header('Location: equipe.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_post();
    $prenom      = trim($_POST['prenom'] ?? '');
    $nom         = trim($_POST['nom'] ?? '');
    $poste       = trim($_POST['poste'] ?? '');
    $description = $_POST['description'] ?? '';
    $statut      = in_array($_POST['statut'] ?? '', ['actif', 'brouillon'], true) ? $_POST['statut'] : $m['statut'];
    $photo_path  = $m['photo']; // On garde l'ancienne par défaut

    if ($prenom === '' || $nom === '' || $poste === '') {
        $_SESSION['error'] = "Prénom, nom et poste sont obligatoires.";
        header('Location: edit_membre.php?id=' . $id);
        exit();
    }

    // Gestion d'une nouvelle photo (validée)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $saved = save_image($_FILES['photo'], __DIR__ . '/../assets/img/equipe/', 'membre-');
        if ($saved === null) {
            $_SESSION['error'] = "Photo invalide (JPG, PNG ou WebP, 5 Mo max).";
            header('Location: edit_membre.php?id=' . $id);
            exit();
        }
        // Supprimer l'ancienne photo si elle existe et n'est pas celle par défaut
        if ($m['photo'] && $m['photo'] != 'assets/img/equipe/default.jpg') {
            $old_file = __DIR__ . '/../' . $m['photo'];
            if (is_file($old_file)) unlink($old_file);
        }
        $photo_path = 'assets/img/equipe/' . $saved;
    }

    $sql = "UPDATE equipe SET prenom = ?, nom = ?, poste = ?, description = ?, photo = ?, statut = ? WHERE id = ?";
    try {
        $pdo->prepare($sql)->execute([$prenom, $nom, $poste, $description, $photo_path, $statut, $id]);
        $_SESSION['success'] = "Le profil de " . $prenom . " " . $nom . " a été mis à jour.";
    } catch (PDOException $e) {
        error_log('edit_membre : ' . $e->getMessage());
        $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour.";
    }

    header('Location: equipe.php');
    exit();
}

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <?php include('includes/notifications.php'); ?>
    <div class="container" style="max-width: 900px;">
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="equipe.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; text-decoration:none;">← Retour à l'équipe</a>
            <h1 class="serif-gold">Modifier Profil : <?= htmlspecialchars($m['prenom'] . ' ' . $m['nom']) ?></h1>
        </header>

        <form method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); padding: 40px;">
                <?= csrf_field() ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;">
                <!-- Gauche -->
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">PRÉNOM</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($m['prenom']) ?>" required 
                           style="width:100%; background:#161811; border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; box-sizing: border-box;">
                </div>
                <!-- Droite -->
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">NOM</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($m['nom']) ?>" required 
                           style="width:100%; background:#161811; border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;">
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">POSTE / SPÉCIALITÉ</label>
                    <input type="text" name="poste" value="<?= htmlspecialchars($m['poste']) ?>" required 
                           style="width:100%; background:#161811; border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; box-sizing: border-box;">
                </div>
                <div>
                    <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">STATUT</label>
                    <select name="statut" style="width:100%; background:#161811; border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; box-sizing: border-box;">
                        <option value="actif" <?= $m['statut'] == 'actif' ? 'selected' : '' ?>>En ligne</option>
                        <option value="brouillon" <?= $m['statut'] == 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">DESCRIPTION</label>
                <textarea name="description" rows="5" 
                          style="width:100%; background:#161811; border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; box-sizing: border-box; resize: vertical;"><?= htmlspecialchars($m['description']) ?></textarea>
            </div>

            <div style="display: flex; align-items: center; gap: 30px; padding: 20px; border: 1px dashed rgba(197, 166, 124, 0.3); margin-bottom: 30px; background: rgba(0,0,0,0.1);">
                <div style="text-align: center;">
                    <p style="font-size: 0.6rem; color: var(--gold-accent); margin-bottom: 5px; text-transform: uppercase;">Actuelle</p>
                    <img src="../<?= htmlspecialchars($m['photo']) ?>" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid var(--gold-accent);">
                </div>
                <div style="flex-grow: 1;">
                    <p style="font-size: 0.8rem; margin-bottom: 10px; opacity: 0.7;">Remplacer la photo de profil</p>
                    <input type="file" name="photo" accept="image/*" style="font-size: 0.8rem; color: var(--gold-accent);">
                </div>
            </div>

            <button type="submit" class="btn-gold" style="width:100%; cursor:pointer; padding: 18px; font-weight: 700;">
                METTRE À JOUR LE PROFIL
            </button>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>