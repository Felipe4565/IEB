<?php
require_once('includes/auth_check.php'); // Gère la session et l'accès[cite: 1]
require_once('../includes/db.php');

// Récupération des avis (on exclut ceux marqués comme 'corbeille')
$stmt = $pdo->query("SELECT * FROM avis WHERE statut != 'corbeille' ORDER BY date DESC");
$avis = $stmt->fetchAll();

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Header avec bouton Dashboard -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Témoignages Clients</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Modération des avis publiés sur le site</p>
            </div>
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 12px 25px; width: auto; min-width: 140px; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                ← Dashboard
            </a>
        </div>

        <?php if (empty($avis)): ?>
            <div class="card-premium" style="text-align: center; padding: 60px 20px;">
                <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                    Aucun témoignage n'est enregistré pour le moment.
                </p>
            </div>
        <?php else: ?>
            <div class="card-premium" style="padding: 10px 25px;">
                <table class="admin-table" style="width: 100%; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Date</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Client & Commentaire</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Note</th>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Statut</th>
                            <th style="text-align:right; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avis as $a): ?>
                        <tr>
                            <td style="padding: 15px 0; font-size: 0.85rem; opacity: 0.7; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <?= date('d/m/Y', strtotime($a['date'])) ?>
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <strong style="display: block; color: var(--light-beige); margin-bottom: 4px;"><?= htmlspecialchars($a['nom']) ?></strong>
                                <span style="font-size: 0.8rem; opacity: 0.5; font-style: italic; display: block; max-width: 400px; line-height: 1.4;">
                                    "<?= mb_strimwidth(htmlspecialchars($a['commentaire']), 0, 80, "...") ?>"
                                </span>
                            </td>
                            <td style="padding: 15px 0; color: var(--gold-accent); letter-spacing: 2px; font-size: 0.9rem; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <?php 
                                    for($i=1; $i<=5; $i++) {
                                        echo ($i <= $a['note']) ? '★' : '<span style="opacity:0.2;">★</span>';
                                    }
                                ?>
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <!-- Statut : 'affiche' = En ligne -->
                                <span class="badge <?= $a['statut'] === 'affiche' ? 'badge-read' : 'badge-new' ?>" style="font-size: 0.65rem;">
                                    <?= $a['statut'] === 'affiche' ? 'En ligne' : 'Masqué' ?>
                                </span>
                            </td>
                            <td style="text-align: right; padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                    <a href="edit_avis.php?id=<?= $a['id'] ?>" class="btn-mini-gold" style="text-decoration:none;">Modifier</a>
                                    <a href="delete_avis.php?id=<?= $a['id'] ?>" class="btn-mini-flush" style="text-decoration:none;" onclick="return confirm('Envoyer cet avis à la corbeille ?')">
                                        ✕
                                    </a>
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