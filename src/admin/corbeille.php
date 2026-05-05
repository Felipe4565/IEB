<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// Actions de restauration ou suppression définitive
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['target'])) {
    $id = intval($_GET['id']);
    $table = $_GET['target']; 
    
    if ($_GET['action'] === 'restore') {
        // Logique de restauration par table
        if ($table === 'projets') {
            $nouveau_statut = 'brouillon';
        } elseif ($table === 'equipe') {
            $nouveau_statut = 'brouillon'; // Restauré en brouillon par défaut
        } elseif ($table === 'avis') {
            $nouveau_statut = 'affiche'; 
        } elseif ($table === 'contacts') {
            $nouveau_statut = 'non_lu';
        } else {
            $nouveau_statut = 'lu';
        }

        $pdo->prepare("UPDATE $table SET statut = ? WHERE id = ?")->execute([$nouveau_statut, $id]);

    } elseif ($_GET['action'] === 'flush') {
        // Nettoyage des fichiers avant suppression définitive
        if ($table === 'projets') {
            $stmt = $pdo->prepare("SELECT image_principale FROM projets WHERE id = ?");
            $stmt->execute([$id]);
            $p = $stmt->fetch();
            if ($p && $p['image_principale'] && $p['image_principale'] != 'assets/img/realisations/default.jpg') {
                $file = '../' . $p['image_principale'];
                if (file_exists($file)) unlink($file);
            }
        } elseif ($table === 'equipe') {
            // Suppression de la photo de l'artisan[cite: 2]
            $stmt = $pdo->prepare("SELECT photo FROM equipe WHERE id = ?");
            $stmt->execute([$id]);
            $e = $stmt->fetch();
            if ($e && $e['photo'] && $e['photo'] != 'assets/img/equipe/default.jpg') {
                $file = '../' . $e['photo'];
                if (file_exists($file)) unlink($file);
            }
        } elseif ($table === 'avis') {
            $stmt = $pdo->prepare("SELECT image FROM avis WHERE id = ?");
            $stmt->execute([$id]);
            $a = $stmt->fetch();
            if ($a && $a['image']) {
                $file = '../' . $a['image'];
                if (file_exists($file)) unlink($file);
            }
        }

        $pdo->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
    }
    
    header('Location: corbeille.php');
    exit();
}

// Récupération des éléments à la corbeille
$p_trash = $pdo->query("SELECT id, titre as label, 'projets' as tab FROM projets WHERE statut='corbeille'")->fetchAll();
$m_trash = $pdo->query("SELECT id, CONCAT(nom, ' (Devis)') as label, 'messages' as tab FROM messages WHERE statut='corbeille'")->fetchAll();
$c_trash = $pdo->query("SELECT id, CONCAT(nom, ' (Contact)') as label, 'contacts' as tab FROM contacts WHERE statut='corbeille'")->fetchAll();
$a_trash = $pdo->query("SELECT id, CONCAT(nom, ' (Avis)') as label, 'avis' as tab FROM avis WHERE statut='corbeille'")->fetchAll();
$e_trash = $pdo->query("SELECT id, CONCAT(prenom, ' ', nom, ' (Équipe)') as label, 'equipe' as tab FROM equipe WHERE statut='corbeille'")->fetchAll();

$full_trash = array_merge($p_trash, $m_trash, $c_trash, $a_trash, $e_trash);

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px;">
            <div>
                <h1 class="serif-gold" style="margin: 0;">Centre de Récupération</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Gérez les éléments supprimés de l'atelier</p>
            </div>
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>
        
        <div class="card-premium" style="padding: 10px 25px;">
            <?php if (empty($full_trash)): ?>
                <div style="text-align:center; padding: 60px 20px;">
                    <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                        La corbeille est parfaitement vide.
                    </p>
                </div>
            <?php else: ?>
                <table class="admin-table" style="margin-top: 0; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding-bottom: 20px; text-align: left; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Élément</th>
                            <th style="text-align:right; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($full_trash as $item): ?>
                        <tr>
                            <td style="padding: 15px 0; color: var(--light-beige); opacity: 0.8; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <?= htmlspecialchars($item['label']) ?>
                            </td>
                            <td style="text-align:right; padding: 15px 0; white-space: nowrap; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                    <a href="?action=restore&id=<?= $item['id'] ?>&target=<?= $item['tab'] ?>" 
                                       class="btn-mini-gold" style="text-decoration: none;">
                                        Restaurer
                                    </a>
                                    
                                    <a href="?action=flush&id=<?= $item['id'] ?>&target=<?= $item['tab'] ?>" 
                                       class="btn-mini-flush" 
                                       style="text-decoration: none;"
                                       onclick="return confirm('Attention : Cette action est irréversible. Détruire définitivement ?')">
                                        Détruire
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>