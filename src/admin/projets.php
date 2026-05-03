<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// On récupère les projets
$stmt = $pdo->query("SELECT * FROM projets ORDER BY date_creation DESC");
$projets = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main" style="padding: 100px 20px; min-height: 80vh;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="serif-gold">Gestion des Projets</h1>
            <a href="add_projet.php" style="background: #d4af37; color: black; padding: 10px 15px; text-decoration: none; font-weight: bold;">+ Nouveau Projet</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $p): ?>
                <tr>
                    <td><img src="../<?= $p['image_principale'] ?>" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #d4af37;"></td>
                    <td><?= htmlspecialchars($p['titre']) ?></td>
                    <td><?= htmlspecialchars($p['type']) ?></td>
                    <td><?= $p['statut'] ?></td>
                    <td>
                        <a href="edit_projet.php?id=<?= $p['id'] ?>" class="btn-action">Modifier</a>
                        <a href="delete_projet.php?id=<?= $p['id'] ?>" class="btn-action" style="color: #ff4b2b;" onclick="return confirm('Supprimer ce projet ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('../includes/footer.php'); ?>