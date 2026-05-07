<?php
require_once('includes/auth_check.php'); // Contient session_start()[cite: 2]
require_once('../includes/db.php');
include('../includes/header.php');

$page_filter = $_GET['page'] ?? 'home';

// --- LOGIQUE DE MISE À JOUR AVEC SESSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    foreach ($_POST['content'] as $cle => $valeur) {
        $stmt = $pdo->prepare("UPDATE contenus SET valeur = ? WHERE cle = ?");
        $stmt->execute([$valeur, $cle]);
    }
    
    // On stocke le message en session pour la pop-up
    $_SESSION['success'] = "Les textes ont été mis à jour avec succès !";
    
    // Redirection pour nettoyer le POST et afficher la notification
    header("Location: " . $_SERVER['PHP_SELF'] . "?page=" . $page_filter);
    exit();
}

// --- LOGIQUE DE FILTRAGE ---
$prefix = $page_filter . '_%';
$stmt = $pdo->prepare("SELECT * FROM contenus WHERE cle LIKE ? ORDER BY id ASC");
$stmt->execute([$prefix]);
$textes = $stmt->fetchAll();
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- INCLUSION DU SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 class="serif-gold" style="font-size: 2rem;">Textes & Accroches</h1>
            <a href="editeur.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                ← Editeur
            </a>
        </div>

        <!-- Système de Filtres -->
        <nav class="filter-nav">
            <?php 
            $nav = ['home' => 'Accueil', 'services' => 'Services', 'atelier' => 'Atelier', 'avis' => 'Avis'];
            foreach($nav as $slug => $label): ?>
                <a href="?page=<?= $slug ?>" class="btn-filter <?= $page_filter === $slug ? 'active' : '' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <form method="POST">
            <input type="hidden" name="update_content" value="1">
            
            <?php foreach($textes as $t): ?>
                <div class="text-card">
                    <label class="label-cle"><?= str_replace('_', ' • ', $t['cle']) ?></label>
                    
                    <?php if(strlen($t['valeur']) > 100): ?>
                        <textarea name="content[<?= $t['cle'] ?>]" class="input-text textarea-text"><?= htmlspecialchars($t['valeur']) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="content[<?= $t['cle'] ?>]" value="<?= htmlspecialchars($t['valeur']) ?>" class="input-text">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div style="text-align: right; position: sticky; bottom: 20px; z-index: 10;">
                <button type="submit" class="btn-save">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>