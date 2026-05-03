<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// 1. Récupération des stats réelles pour les cartes (en excluant la corbeille)

// Compteur des Devis (Table messages) - Actifs uniquement
$nb_devis = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'non_lu'")->fetchColumn();

// Compteur des Contacts (Table contacts) - Actifs uniquement
$nb_contacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut = 'non_lu'")->fetchColumn();

// Compteur des Projets - En ligne uniquement (On exclut la corbeille)
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projets WHERE statut != 'corbeille'")->fetchColumn();

// Compteur pour la Corbeille (Somme de tous les éléments supprimés logiquement)
$p_trash = $pdo->query("SELECT COUNT(*) FROM projets WHERE statut = 'corbeille'")->fetchColumn();
$m_trash = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'corbeille'")->fetchColumn();
$c_trash = $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut = 'corbeille'")->fetchColumn();
$total_trash = $p_trash + $m_trash + $c_trash;

// On définit le chemin pour le header/footer
$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Le lien vers ton CSS harmonisé -->
<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <header class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold">TABLEAU DE BORD</h1>
                <p class="admin-welcome">
                    Bienvenue dans votre atelier digital, <span><?= htmlspecialchars($_SESSION['admin_email']) ?></span>
                </p>
            </div>
            
            <a href="corbeille.php" class="btn-action" style="background: rgba(255, 95, 64, <?= $total_trash > 0 ? '0.15' : '0.05' ?>); border-color: rgba(255, 95, 64, 0.3);">
                 Corbeille (<?= $total_trash ?>)
            </a>
        </header>

        <div class="dashboard-grid">
            
            <!-- Carte Devis (Table messages) -->
            <div class="card-premium">
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
                <h3><?= $nb_projets ?></h3>
                <p>Réalisations actives</p>
                <div style="margin-top: 20px;">
                    <a href="projets.php" class="btn-action">Gérer le portfolio →</a>
                </div>
            </div>

            <div class="card-premium">
                <?php 
                    $nb_avis = $pdo->query("SELECT COUNT(*) FROM avis WHERE statut = 'attente'")->fetchColumn(); 
                ?>
                <h3 style="<?= $nb_avis > 0 ? 'color: var(--gold-accent);' : '' ?>"><?= $nb_avis ?></h3>
                <p>Avis à modérer</p>
                <div style="margin-top: 20px;">
                    <a href="avis.php" class="btn-action">Gérer les avis →</a>
                </div>
            </div>

        </div>

        <div class="admin-footer-actions" style="margin-top: 50px; text-align: center; border-top: 1px solid rgba(197, 166, 124, 0.1); padding-top: 30px;">
            <a href="logout.php" class="btn-gold" style="padding: 12px 30px; text-decoration: none;">Se déconnecter</a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>