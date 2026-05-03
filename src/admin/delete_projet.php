<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE projets SET statut = 'corbeille' WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirection vers la liste des projets
header('Location: projets.php');
exit();