<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// 1. Récupération des filtres de statut
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'tous';

// 2. Requête SQL sur la table 'contacts'
if ($filter === 'non_lu') {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE statut = 'non_lu' ORDER BY date_envoi DESC");
} elseif ($filter === 'lu') {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE statut = 'lu' ORDER BY date_envoi DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY date_envoi DESC");
}

$stmt->execute();
$contacts = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        
        <!-- Header avec bouton Dashboard corrigé -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Demandes de Contact</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Questions générales et messages informatifs</p>
            </div>
            <!-- Bouton Dashboard version propre (largeur auto) -->
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>

        <!-- Navigation des filtres harmonisée (Or au lieu de Rouge) -->
        <div class="filter-nav" style="margin-bottom: 30px; display: flex; gap: 25px; border-bottom: 1px solid rgba(197, 166, 124, 0.1); padding-bottom: 15px; align-items: center;">
            
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
        </div>

        <?php if (empty($contacts)): ?>
            <div class="card-premium" style="text-align: center; padding: 50px;">
                <p style="opacity: 0.5;">Aucun message de contact pour le moment.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Réception</th>
                        <th>Expéditeur</th>
                        <th>Sujet</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                    <tr>
                        <td style="font-size: 0.85rem; opacity: 0.7;">
                            <?= date('d/m/Y H:i', strtotime($c['date_envoi'])) ?>
                        </td>
                        <td>
                            <strong style="display: block; color: var(--light-beige);"><?= htmlspecialchars($c['nom']) ?></strong>
                            <span style="font-size: 0.8rem; opacity: 0.5;"><?= htmlspecialchars($c['email']) ?></span>
                        </td>
                        <td>
                            <span style="font-style: italic; color: #ccc;"><?= htmlspecialchars($c['sujet']) ?></span>
                        </td>
                        <td>
                            <span class="badge <?= $c['statut'] === 'non_lu' ? 'badge-new' : 'badge-read' ?>">
                                <?= $c['statut'] === 'non_lu' ? 'Nouveau' : 'Lu' ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="view_contact.php?id=<?= $c['id'] ?>" class="btn-action">Lire</a>
                            <a href="delete_contact.php?id=<?= $c['id'] ?>" class="btn-action" style="color: #ff5f40;" onclick="return confirm('Supprimer ce message ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</main>

<?php include('../includes/footer.php'); ?>