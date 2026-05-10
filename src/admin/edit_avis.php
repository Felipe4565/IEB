<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. Récupération de l'avis principal
$stmt = $pdo->prepare("SELECT * FROM avis WHERE id = ?");
$stmt->execute([$id]);
$avis = $stmt->fetch();

if (!$avis) {
    $_SESSION['error'] = "Ce témoignage est introuvable.";
    header('Location: avis.php');
    exit();
}

// 2. NOUVEAU : Récupération de toutes les images de la galerie pour cet avis
$stmt_images = $pdo->prepare("SELECT * FROM images_avis WHERE avis_id = ? ORDER BY id ASC");
$stmt_images->execute([$id]);
$galerie = $stmt_images->fetchAll();

// Mise à jour de l'avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $commentaire = $_POST['commentaire'];
    $note = intval($_POST['note']);
    $statut = $_POST['statut']; 
    $est_detaille = isset($_POST['est_detaille']) ? 1 : 0;

    $sql = "UPDATE avis SET nom = ?, commentaire = ?, note = ?, statut = ?, est_detaille = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql);
    
    if ($stmt_update->execute([$nom, $commentaire, $note, $statut, $est_detaille, $id])) {
        $_SESSION['success'] = "Le témoignage de " . htmlspecialchars($nom) . " a été mis à jour.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour.";
    }
    
    header('Location: avis.php');
    exit();
}

$base_path = '../';
include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h1 class="serif-gold">Éditer le Témoignage</h1>
            <a href="avis.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; color: #c5a67c; text-decoration: none;">← Retour aux avis</a>
        </div>

        <div class="card-premium">
            <form method="POST">
                <div style="margin-bottom: 25px;">
                    <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Nom du Client</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($avis['nom']) ?>" required 
                           style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Note</label>
                        <select name="note" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <option value="<?= $i ?>" <?= $avis['note'] == $i ? 'selected' : '' ?>><?= $i ?> Étoile<?= $i>1?'s':'' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Statut</label>
                        <select name="statut" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;">
                            <option value="affiche" <?= $avis['statut'] === 'affiche' ? 'selected' : '' ?>>En Ligne</option>
                            <option value="attente" <?= $avis['statut'] === 'attente' ? 'selected' : '' ?>>En Attente</option>
                            <option value="brouillon" <?= $avis['statut'] === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Commentaire</label>
                    <textarea name="commentaire" rows="5" required 
                              style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;"><?= htmlspecialchars($avis['commentaire']) ?></textarea>
                </div>

                <div style="margin-bottom: 25px; padding: 20px; background: rgba(255,255,255,0.02); border: 1px solid rgba(197,166,124,0.1);">
                    <label style="display:flex; align-items:center; gap:15px; cursor:pointer; color:var(--light-beige); margin-bottom: 20px;">
                        <input type="checkbox" name="est_detaille" <?= $avis['est_detaille'] ? 'checked' : '' ?> style="accent-color:var(--gold-accent);">
                        Transformer en "Étude de cas" (Affiche la galerie photo)
                    </label>

                    <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.7rem; text-transform:uppercase;">Photos associées (<?= count($galerie) ?>)</label>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <?php if(!empty($galerie)): ?>
                            <?php foreach($galerie as $img): ?>
                                <div style="position: relative;">
                                    <img src="../<?= htmlspecialchars($img['image_url']) ?>" 
                                         style="width:120px; height:120px; object-fit:cover; border:1px solid var(--gold-accent); border-radius: 4px;">
                                    <?php if($img['image_url'] == $avis['image']): ?>
                                        <span style="position:absolute; bottom:0; left:0; right:0; background:var(--gold-accent); color:black; font-size:10px; text-align:center; font-weight:bold;">PRINCIPALE</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:rgba(255,255,255,0.3); font-style:italic; font-size:0.9rem;">Aucune photo pour cet avis.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn-gold" style="width:100%; cursor:pointer; font-weight:bold; padding: 15px;">
                    Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>