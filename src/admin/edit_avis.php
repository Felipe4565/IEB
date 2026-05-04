<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupération de l'avis
$stmt = $pdo->prepare("SELECT * FROM avis WHERE id = ?");
$stmt->execute([$id]);
$avis = $stmt->fetch();

if (!$avis) {
    header('Location: avis.php');
    exit();
}

// Mise à jour de l'avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $commentaire = $_POST['commentaire'];
    $note = intval($_POST['note']);
    $statut = $_POST['statut']; // 'affiche' ou 'brouillon'
    
    // Gestion de l'affichage de l'image (est_detaille dans ta base)
    $est_detaille = isset($_POST['est_detaille']) ? 1 : 0;

    $sql = "UPDATE avis SET nom = ?, commentaire = ?, note = ?, statut = ?, est_detaille = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$nom, $commentaire, $note, $statut, $est_detaille, $id]);
    
    header('Location: avis.php');
    exit();
}

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h1 class="serif-gold">Éditer le Témoignage</h1>
            <a href="avis.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; text-decoration: none;">
                ← Retour
            </a>
        </div>

        <div class="card-premium">
            <form method="POST">
                <div style="margin-bottom: 25px;">
                    <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Nom du Client</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($avis['nom']) ?>" required 
                           style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; font-family:'Montserrat';">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Note (1 à 5)</label>
                        <select name="note" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <option value="<?= $i ?>" <?= $avis['note'] == $i ? 'selected' : '' ?>><?= $i ?> Étoile<?= $i>1?'s':'' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Statut de publication</label>
                        <select name="statut" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white;">
                            <option value="affiche" <?= $avis['statut'] === 'affiche' ? 'selected' : '' ?>>En Ligne (Public)</option>
                            <option value="brouillon" <?= $avis['statut'] === 'brouillon' ? 'selected' : '' ?>>Brouillon (Masqué)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display:block; color:var(--gold-accent); margin-bottom:10px; font-size:0.8rem; text-transform:uppercase;">Commentaire</label>
                    <textarea name="commentaire" rows="5" required 
                              style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(197,166,124,0.2); padding:12px; color:white; font-family:'Montserrat';"><?= htmlspecialchars($avis['commentaire']) ?></textarea>
                </div>

                <?php if($avis['image']): ?>
                <div style="margin-bottom: 25px; padding: 20px; background: rgba(255,255,255,0.02); border: 1px solid rgba(197,166,124,0.1);">
                    <label style="display:flex; align-items:center; gap:15px; cursor:pointer; color:var(--light-beige);">
                        <input type="checkbox" name="est_detaille" <?= $avis['est_detaille'] ? 'checked' : '' ?> style="accent-color:var(--gold-accent);">
                        Afficher l'image associée à cet avis sur le site
                    </label>
                    <div style="margin-top:15px;">
                        <img src="../<?= $avis['image'] ?>" style="width:100px; height:100px; object-fit:cover; border:1px solid var(--gold-accent);">
                    </div>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn-gold" style="width:100%; cursor:pointer; font-weight:bold;">
                    Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>