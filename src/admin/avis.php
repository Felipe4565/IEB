<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// Récupération des avis (on exclut ceux marqués comme 'corbeille')[cite: 3, 12]
$stmt = $pdo->query("SELECT * FROM avis WHERE statut != 'corbeille' ORDER BY date DESC");
$avis = $stmt->fetchAll();

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Témoignages Clients</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Modération des avis publiés sur le site</p>
            </div>
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>

        <?php if (empty($avis)): ?>
            <div class="card-premium" style="text-align: center; padding: 50px;">
                <p style="opacity: 0.5;">Aucun témoignage trouvé.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Note</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($avis as $a): ?>
                    <tr>
                        <td style="font-size: 0.85rem; opacity: 0.7;">
                            <?= date('d/m/Y', strtotime($a['date'])) ?>
                        </td>
                        <td>
                            <strong style="display: block; color: var(--light-beige);"><?= htmlspecialchars($a['nom']) ?></strong>
                            <span style="font-size: 0.8rem; opacity: 0.5; font-style: italic;">
                                "<?= mb_strimwidth(htmlspecialchars($a['commentaire']), 0, 60, "...") ?>"
                            </span>
                        </td>
                        <td style="color: var(--gold-accent); letter-spacing: 2px;">
                            <?php 
                                for($i=1; $i<=5; $i++) {
                                    echo ($i <= $a['note']) ? '★' : '<span style="opacity:0.2;">★</span>';
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Dans ta BD, le statut actif est 'affiche'[cite: 12] -->
                            <span class="badge" style="color: <?= $a['statut'] === 'affiche' ? 'var(--gold-accent)' : '#666' ?>; border-color: currentColor;">
                                <?= $a['statut'] === 'affiche' ? 'En ligne' : 'Masqué' ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                <a href="edit_avis.php?id=<?= $a['id'] ?>" class="btn-action">Modifier</a>
                                <a href="delete_avis.php?id=<?= $a['id'] ?>" class="btn-action" style="color: #ff5f40;" onclick="return confirm('Envoyer cet avis à la corbeille ?')">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</main>

<?php include('../includes/footer.php'); ?>