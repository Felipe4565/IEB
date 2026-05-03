<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// 1. Récupération des filtres
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'tous';

// 2. Requête SQL filtrée pour exclure la corbeille par défaut[cite: 3, 10]
if ($filter === 'non_lu') {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE statut = 'non_lu' ORDER BY date_envoi DESC");
} elseif ($filter === 'lu') {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE statut = 'lu' ORDER BY date_envoi DESC");
} else {
    // On affiche tout SAUF les devis envoyés à la corbeille
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE statut != 'corbeille' ORDER BY date_envoi DESC");
}

$stmt->execute();
$messages = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        
        <!-- Header avec bouton Dashboard -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Gestion des Devis</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Demandes de projets et réalisations sur-mesure</p>
            </div>
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>

        <!-- Navigation des filtres -->
        <div class="filter-nav" style="margin-bottom: 30px; display: flex; gap: 25px; border-bottom: 1px solid rgba(197, 166, 124, 0.1); padding-bottom: 15px; align-items: center;">
            
            <a href="message.php?filter=tous" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'tous' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'tous' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Tous les devis
            </a>
            
            <a href="message.php?filter=non_lu" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'non_lu' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'non_lu' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Nouveaux
            </a>
            
            <a href="message.php?filter=lu" 
               style="text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $filter === 'lu' ? 'var(--gold-accent)' : '#666' ?>; border-bottom: 2px solid <?= $filter === 'lu' ? 'var(--gold-accent)' : 'transparent' ?>; padding-bottom: 13px; transition: 0.3s;">
                Archives (Lus)
            </a>
        </div>

        <?php if (empty($messages)): ?>
            <div class="card-premium" style="text-align: center; padding: 50px;">
                <p style="opacity: 0.5;">Aucun devis trouvé dans cette catégorie.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Réception</th>
                        <th>Client</th>
                        <th>Type de projet</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td style="font-size: 0.85rem; opacity: 0.7;">
                            <?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?>
                        </td>
                        <td>
                            <strong style="display: block; color: var(--light-beige);"><?= htmlspecialchars($msg['nom']) ?></strong>
                            <span style="font-size: 0.8rem; opacity: 0.5;"><?= htmlspecialchars($msg['email']) ?></span>
                        </td>
                        <td>
                            <span class="gold-tag" style="font-size: 0.75rem; padding: 3px 10px; border: 1px solid var(--gold-accent); color: var(--gold-accent); text-transform: uppercase;">
                                <?= htmlspecialchars($msg['type']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $msg['statut'] === 'non_lu' ? 'badge-new' : 'badge-read' ?>">
                                <?= $msg['statut'] === 'non_lu' ? 'Nouveau' : 'Lu' ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="view_message.php?id=<?= $msg['id'] ?>" class="btn-action">Ouvrir</a>
                            <a href="delete_message.php?id=<?= $msg['id'] ?>" class="btn-action" style="color: #ff5f40;" onclick="return confirm('Envoyer ce devis à la corbeille ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</main>

<?php include('../includes/footer.php'); ?>