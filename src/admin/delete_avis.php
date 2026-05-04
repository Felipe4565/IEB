<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // On met à jour le statut pour le Centre de Récupération[cite: 5, 12]
    $stmt = $pdo->prepare("UPDATE avis SET statut = 'corbeille' WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: avis.php');
exit();