<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// On récupère les stats réelles pour les cartes
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
$nb_messages = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'non_lu'")->fetchColumn();

// On définit le chemin pour le header/footer
$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Le lien vers ton CSS corrigé selon ton arborescence -->
<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <header class="dashboard-header">
            <h1 class="serif-gold">TABLEAU DE BORD</h1>
            <p class="admin-welcome">
                Bienvenue dans votre atelier digital, <span><?= htmlspecialchars($_SESSION['admin_email']) ?></span>
            </p>
        </header>

        <div class="dashboard-grid">
            
            <!-- Carte Projets -->
            <div class="card-premium">
                <div class="card-icon">🪵</div>
                <h3><?= $nb_projets ?></h3>
                <p>Réalisations en ligne</p>
                <div style="margin-top: 20px;">
                    <a href="projets.php" class="btn-action">Gérer les projets →</a>
                </div>
            </div>

            <!-- Carte Messages -->
            <div class="card-premium">
                <div class="card-icon">✉️</div>
                <h3 style="<?= $nb_messages > 0 ? 'color: #ff5f40;' : '' ?>">
                    <?= $nb_messages ?>
                </h3>
                <p>Nouveaux messages</p>
                <div style="margin-top: 20px;">
                    <a href="messages.php" class="btn-action">Voir les demandes →</a>
                </div>
            </div>

            <!-- Carte Contenus -->
            <div class="card-premium">
                <div class="card-icon">✍️</div>
                <h3>Éditeur</h3>
                <p>Textes & Images du site</p>
                <div style="margin-top: 20px;">
                    <a href="contenus.php" class="btn-action">Modifier le site →</a>
                </div>
            </div>

        </div>

        <div class="admin-footer-actions">
            <a href="logout.php" class="btn-gold">Se déconnecter</a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>