<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la protection
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // On déplace le message vers la corbeille au lieu de le supprimer définitivement
    $stmt = $pdo->prepare("UPDATE messages SET statut = 'corbeille' WHERE id = ?");
    
    // TENTATIVE D'EXÉCUTION ET NOTIFICATION POUR LE POP-UP
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Le message a été déplacé dans la corbeille.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la suppression du message.";
    }
} else {
    $_SESSION['error'] = "Identifiant de message invalide.";
}

// Redirection vers la liste des messages (message.php)
header('Location: message.php');
exit();