<?php
require_once('includes/auth_check.php'); // Gère le session_start() et la sécurité
require_once('../includes/db.php');

// On vérifie qu'un ID est bien passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // On ne supprime pas, on change le statut en 'corbeille'
    $sql = "UPDATE equipe SET statut = 'corbeille' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        // ON DEFINIT LE MESSAGE DE SUCCÈS POUR LE POP-UP
        $_SESSION['success'] = "L'artisan a été déplacé dans la corbeille avec succès.";
        header('Location: equipe.php');
        exit();
    } else {
        // ON DEFINIT UN MESSAGE D'ERREUR SI BESOIN
        $_SESSION['error'] = "Impossible de supprimer ce membre pour le moment.";
        header('Location: equipe.php');
        exit();
    }
} else {
    // Si pas d'ID, on repart direct à la liste
    header('Location: equipe.php');
    exit();
}