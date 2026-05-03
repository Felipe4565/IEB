<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// On récupère les projets
$stmt = $pdo->query("SELECT * FROM projets ORDER BY date_creation DESC");
$projets = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Lien vers le CSS harmonisé -->
<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main" style="padding: 100px 20px; min-height: 80vh;">
    <div class="container">
        
        <!-- Header avec titre et bouton retour Dashboard -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin-bottom: 5px;">Gestion des Projets</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Gérez vos réalisations et votre portfolio</p>
            </div>
            <!-- Bouton Dashboard version propre -->
            <a href="index.php" class="btn-gold" style="font-size: 0.7rem; padding: 10px 20px; width: auto; min-width: unset; text-transform: uppercase; letter-spacing: 2px; text-decoration: none;">
                ← Dashboard
            </a>
        </div>

        <!-- Barre d'action pour l'ajout -->
        <div style="margin-bottom: 30px; display: flex; justify-content: flex-end;">
            <a href="add_projet.php" class="btn-gold" style="background: var(--gold-accent); color: #000; padding: 12px 25px; text-decoration: none; font-weight: bold; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                + Nouveau Projet
            </a>
        </div>

        <?php if (empty($projets)): ?>
            <div class="card-premium" style="text-align: center; padding: 50px;">
                <p style="opacity: 0.5;">Aucun projet dans le portfolio pour le moment.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projets as $p): ?>
                    <tr>
                        <td>
                            <div style="width: 60px; height: 60px; border: 1px solid rgba(197, 166, 124, 0.3); padding: 2px;">
                                <img src="../<?= $p['image_principale'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td>
                            <strong style="color: var(--light-beige);"><?= htmlspecialchars($p['titre']) ?></strong>
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; opacity: 0.7;"><?= htmlspecialchars($p['type']) ?></span>
                        </td>
                        <td>
                            <span class="badge <?= $p['statut'] === 'publie' ? 'badge-read' : 'badge-new' ?>" style="text-transform: uppercase; font-size: 0.7rem;">
                                <?= $p['statut'] ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="edit_projet.php?id=<?= $p['id'] ?>" class="btn-action">Modifier</a>
                            <a href="delete_projet.php?id=<?= $p['id'] ?>" class="btn-action" style="color: #ff5f40; margin-left: 10px;" onclick="return confirm('Supprimer ce projet ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include('../includes/footer.php'); ?>