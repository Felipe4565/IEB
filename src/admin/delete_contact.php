<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la protection
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // On déplace le contact vers la corbeille au lieu de le supprimer définitivement
    $stmt = $pdo->prepare("UPDATE contacts SET statut = 'corbeille' WHERE id = ?");
    
    // TENTATIVE D'EXÉCUTION ET GÉNÉRATION DU MESSAGE POUR LE POP-UP
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Le message de contact a été déplacé dans la corbeille.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors du déplacement vers la corbeille.";
    }
} else {
    $_SESSION['error'] = "Identifiant de contact invalide.";
}

// Redirection vers la liste des contacts qui contient notifications.php
header('Location: contact.php');
exit();