<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

$nb_devis = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'non_lu'")->fetchColumn();

$nb_equipe = $pdo->query("SELECT COUNT(*) FROM equipe")->fetchColumn();

$nb_contacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut = 'non_lu'")->fetchColumn();

$nb_projets = $pdo->query("SELECT COUNT(*) FROM projets WHERE statut != 'corbeille'")->fetchColumn();

$nb_avis = $pdo->query("SELECT COUNT(*) FROM avis WHERE statut = 'affiche'")->fetchColumn();

$nb_avis_alerte = $pdo->query("SELECT COUNT(*) FROM avis WHERE statut != 'affiche' AND statut != 'corbeille'")->fetchColumn();

$p_trash = $pdo->query("SELECT COUNT(*) FROM projets WHERE statut = 'corbeille'")->fetchColumn();
$m_trash = $pdo->query("SELECT COUNT(*) FROM messages WHERE statut = 'corbeille'")->fetchColumn();
$c_trash = $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut = 'corbeille'")->fetchColumn();
$a_trash = $pdo->query("SELECT COUNT(*) FROM avis WHERE statut = 'corbeille'")->fetchColumn();
$count_e_trash = $pdo->query("SELECT COUNT(*) FROM equipe WHERE statut='corbeille'")->fetchColumn();

$total_trash = $p_trash + $m_trash + $c_trash + $a_trash + $count_e_trash;

$base_path = '../'; 
include('../includes/header.php'); 
?>

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
            
            <!-- Bouton Corbeille Doré si pleine -->
            <a href="corbeille.php" class="btn-action" style="background: rgba(197, 166, 124, <?= $total_trash > 0 ? '0.15' : '0.05' ?>); border-color: var(--gold-accent); color: var(--gold-accent);">
                 Corbeille (<?= $total_trash ?>)
            </a>
        </header>

        <div class="dashboard-grid">
            
            <!-- Carte Devis -->
            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_devis ?></h3>
                <p>Nouveaux Devis</p>
                <div style="margin-top: 20px;">
                    <a href="message.php" class="btn-action">Voir les messages →</a>
                </div>
            </div>

            <!-- Carte Contacts -->
            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_contacts ?></h3>
                <p>Demandes Contact</p>
                <div style="margin-top: 20px;">
                    <a href="contact.php" class="btn-action">Lire les messages →</a>
                </div>
            </div>

            <!-- Carte Portfolio -->
            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_projets ?></h3>
                <p>Réalisations actives</p>
                <div style="margin-top: 20px;">
                    <a href="projets.php" class="btn-action">Gérer le portfolio →</a>
                </div>
            </div>

            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_equipe ?></h3>
                <p>Gestion de l'équipe</p>
                <div style="margin-top: 20px;">
                    <a href="equipe.php" class="btn-action">Gérer l'équipe →</a>
                </div>
            </div>

            <!-- Carte Avis -->
            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_avis ?></h3>
                <p>Avis en attente</p>
                <div style="margin-top: 20px;">
                    <a href="avis.php" class="btn-action">Modérer les avis →</a>
                </div>
            </div>

        </div>

        <div class="admin-footer-actions" style="margin-top: 60px; padding: 40px 0; border-top: 1px solid rgba(197, 166, 124, 0.1); display: flex; justify-content: center;">
            <a href="logout.php" class="btn-logout-elegant">
                Déconnexion
            </a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>