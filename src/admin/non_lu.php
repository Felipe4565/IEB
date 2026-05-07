<?php
require_once('includes/auth_check.php'); // Assure le démarrage de la session et la protection
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Initialisation par défaut pour éviter les erreurs de redirection
$redirect = 'index.php';

if ($id > 0) {
    $table = ($type === 'contact') ? 'contacts' : 'messages';
    $redirect = ($type === 'contact') ? 'contact.php' : 'message.php';

    $stmt = $pdo->prepare("UPDATE $table SET statut = 'non_lu' WHERE id = ?");
    
    // TENTATIVE D'EXÉCUTION ET GÉNÉRATION DU MESSAGE POUR LE POP-UP
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Le message a été marqué comme non lu.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour du statut.";
    }
}

// Redirection vers la page correspondante (contact.php ou message.php)
header("Location: $redirect");
exit();