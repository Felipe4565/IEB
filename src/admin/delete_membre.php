<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// On vérifie qu'un ID est bien passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // On ne supprime pas, on change le statut en 'corbeille'
    // Cela correspond à la logique de ta requête dans equipe.php (statut != 'corbeille')
    $sql = "UPDATE equipe SET statut = 'corbeille' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        // Redirection avec un petit message de succès (optionnel)
        header('Location: equipe.php?msg=supprime');
        exit();
    } else {
        die("Erreur lors de la mise à la corbeille.");
    }
} else {
    // Si pas d'ID, on repart direct à la liste
    header('Location: equipe.php');
    exit();
}