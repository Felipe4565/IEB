<?php
require_once('includes/auth_check.php'); // Initialise la session et vérifie l'accès
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE projets SET statut = 'corbeille' WHERE id = ?");
    
    // TENTATIVE D'EXÉCUTION ET NOTIFICATION POUR LE POP-UP
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Le projet a été déplacé dans la corbeille.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la suppression du projet.";
    }
} else {
    $_SESSION['error'] = "Identifiant de projet invalide.";
}

// Redirection vers la liste des projets qui contient le fichier notifications.php
header('Location: projets.php');
exit();