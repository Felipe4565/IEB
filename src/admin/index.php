<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// 1. Récupération des stats réelles pour les cartes
// Compteur des Devis (Table messages)
$nb_devis = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'non_lu'")->fetchColumn();

// Compteur des Contacts (Table contacts)
$nb_contacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut = 'non_lu'")->fetchColumn();

// Compteur des Projets
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();

// On définit le chemin pour le header/footer
$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Le lien vers ton CSS harmonisé -->
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
            
            <!-- Carte Devis (Table messages) -->
            <div class="card-premium">
                <div class="card-icon">📏</div>
                <h3 style="<?= $nb_devis > 0 ? 'color: var(--gold-accent);' : '' ?>">
                    <?= $nb_devis ?>
                </h3>
                <p>Nouveaux Devis</p>
                <div style="margin-top: 20px;">
                    <a href="message.php" class="btn-action">Voir les projets →</a>
                </div>
            </div>

            <!-- Carte Contacts (Table contacts) -->
            <div class="card-premium">
                <div class="card-icon">✉️</div>
                <h3 style="<?= $nb_contacts > 0 ? 'color: #ff5f40;' : '' ?>">
                    <?= $nb_contacts ?>
                </h3>
                <p>Demandes Contact</p>
                <div style="margin-top: 20px;">
                    <a href="contact.php" class="btn-action">Lire les messages →</a>
                </div>
            </div>

            <!-- Carte Portfolio (Table projets) -->
            <div class="card-premium">
                <div class="card-icon">🪵</div>
                <h3><?= $nb_projets ?></h3>
                <p>Réalisations en ligne</p>
                <div style="margin-top: 20px;">
                    <a href="projets.php" class="btn-action">Gérer le portfolio →</a>
                </div>
            </div>

            <!-- Carte Éditeur -->
            <div class="card-premium">
                <div class="card-icon">✍️</div>
                <h3>Éditeur</h3>
                <p>Textes & Images</p>
                <div style="margin-top: 20px;">
                    <a href="contenus.php" class="btn-action">Modifier le site →</a>
                </div>
            </div>

        </div>

        <div class="admin-footer-actions" style="margin-top: 50px; text-align: center;">
            <a href="logout.php" class="btn-gold" style="padding: 12px 30px; text-decoration: none;">Se déconnecter</a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>