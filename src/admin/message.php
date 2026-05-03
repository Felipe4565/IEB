<?php
require_once('includes/auth_check.php'); // Toujours en premier ![cite: 5]
require_once('../includes/db.php');

// Récupérer tous les messages, les plus récents en premier
$stmt = $pdo->query("SELECT * FROM messages ORDER BY date_envoi DESC");
$messages = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main" style="padding: 100px 20px; min-height: 80vh;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="serif-gold">Messages Reçus</h1>
            <a href="index.php" style="color: #bbb;">← Retour Dashboard</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?></td>
                    <td><?= htmlspecialchars($msg['nom']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= htmlspecialchars($msg['type']) ?></td>
                    <td>
                        <span class="badge <?= $msg['statut'] === 'non_lu' ? 'badge-new' : 'badge-read' ?>">
                            <?= strtoupper($msg['statut']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="view_message.php?id=<?= $msg['id'] ?>" class="btn-action">Lire</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('../includes/footer.php'); ?>