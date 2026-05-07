<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la protection
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // On met à jour le statut pour le Centre de Récupération
    $stmt = $pdo->prepare("UPDATE avis SET statut = 'corbeille' WHERE id = ?");
    
    // TENTATIVE D'EXÉCUTION ET NOTIFICATION POUR LE POP-UP
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Le témoignage a été déplacé dans la corbeille.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la suppression du témoignage.";
    }
} else {
    $_SESSION['error'] = "Identifiant de témoignage manquant.";
}

// Redirection vers la liste des avis (avis.php) qui contient le fichier notifications.php
header('Location: avis.php');
exit();