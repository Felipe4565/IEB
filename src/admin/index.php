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

            <div class="card-premium">
                <h3 style="color: var(--gold-accent);"><?= $nb_avis_alerte ?></h3>
                <p>Avis en attente</p>
                <div style="margin-top: 20px;">
                    <a href="avis.php" class="btn-action">Modérer les avis →</a>
                </div>
            </div>

            <div class="card-premium">
                <div class="card-icon" style="margin-top: 10px; margin-bottom: 20px;">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="var(--gold-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </div>
                
                <h3 style="color: var(--gold-accent); font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px;">
                    Éditeur de Site
                </h3>

                <div style="margin-top: 25px;">
                    <a href="editeur.php" class="btn-action">Ouvrir l'éditeur →</a>
                </div>
            </div>

            <div class="card-premium">
                <div class="card-icon" style="margin-top: 10px; margin-bottom: 20px;">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="var(--gold-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M12 4h9"></path>
                        <path d="M4 9h16"></path>
                        <path d="M4 15h16"></path>
                    </svg>
                </div>
                
                <h3 style="color: var(--gold-accent); font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px;">
                    Liste privée Showroom
                </h3>

                <div style="margin-top: 25px;">
                    <a href="admin_showroom_lead.php" class="btn-action">Voir la liste →</a>
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