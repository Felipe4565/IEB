<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Au lieu de supprimer la ligne (DELETE), on change le statut en 'corbeille'[cite: 5]
    // Cela permet de retrouver le message dans le Centre de Récupération[cite: 5]
    $stmt = $pdo->prepare("UPDATE contacts SET statut = 'corbeille' WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirection vers la liste des contacts actifs[cite: 6]
header('Location: contact.php');
exit();