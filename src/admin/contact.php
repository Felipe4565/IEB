<?php
require_once('includes/auth_check.php'); // Contient session_start()[cite: 2]
require_once('../includes/db.php');

// 1. Récupération des filtres de statut
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'tous';

// 2. Requête SQL sur la table 'contacts' filtrée pour exclure la corbeille
if ($filter === 'non_lu') {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE statut = 'non_lu' ORDER BY date_envoi DESC");
} elseif ($filter === 'lu') {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE statut = 'lu' ORDER BY date_envoi DESC");
} else {
    // Par défaut, on affiche tout SAUF ce qui est à la corbeille
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE statut != 'corbeille' ORDER BY date_envoi DESC");
}

$stmt->execute();
$contacts = $stmt->fetchAll();

include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Header avec bouton Dashboard -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Demandes de Contact</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Questions générales et messages informatifs</p>
            </div>
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>

        <!-- Navigation des filtres (Style harmonisé) -->
        <nav class="filter-nav" style="margin-bottom: 30px; display: flex; gap: 25px; border-bottom: 1px solid rgba(197, 166, 124, 0.1); padding-bottom: 15px; align-items: center;">
            <a href="contact.php?filter=tous" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'tous' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'tous' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Tous les messages
            </a>
            <a href="contact.php?filter=non_lu" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'non_lu' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'non_lu' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Nouveaux
            </a>
            <a href="contact.php?filter=lu" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'lu' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'lu' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Archives
            </a>
        </nav>

        <?php if (empty($contacts)): ?>
            <div class="card-premium" style="text-align: center; padding: 60px 20px;">
                <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                    Aucun message ne correspond à ce filtre.
                </p>
            </div>
        <?php else: ?>
            <div class="card-premium" style="padding: 10px 25px;">
                <table class="admin-table" style="width: 100%; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Réception</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Expéditeur</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Sujet</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Statut</th>
                            <th style="text-align:right; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td style="padding: 15px 0; font-size: 0.85rem; opacity: 0.7; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <?= date('d/m/Y H:i', strtotime($c['date_envoi'])) ?>
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <strong style="display: block; color: var(--light-beige);"><?= htmlspecialchars($c['nom']) ?></strong>
                                <span style="font-size: 0.8rem; opacity: 0.5;"><?= htmlspecialchars($c['email']) ?></span>
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <span style="font-style: italic; color: #ccc;"><?= htmlspecialchars($c['sujet']) ?></span>
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <span class="badge <?= $c['statut'] === 'non_lu' ? 'badge-new' : 'badge-read' ?>">
                                    <?= $c['statut'] === 'non_lu' ? 'Nouveau' : 'Lu' ?>
                                </span>
                            </td>
                            <td style="text-align: right; padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                    <a href="view_contact.php?id=<?= $c['id'] ?>" class="btn-mini-gold" style="text-decoration:none;">Lire</a>
                                    <!-- Le lien pointe vers ton script de mise en corbeille -->
                                    <a href="delete_contact.php?id=<?= $c['id'] ?>" class="btn-mini-flush" style="text-decoration:none;" onclick="return confirm('Envoyer ce message à la corbeille ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include('../includes/footer.php'); ?>