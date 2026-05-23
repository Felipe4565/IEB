<?php
header('Content-Type: application/json');
require_once('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Veuillez entrer une adresse email valide.']);
        exit;
    }

    try {
        // Vérifier si l'email existe déjà
        $check = $pdo->prepare("SELECT id FROM showroom_leads WHERE email = ?");
        $check->execute([$email]);
        
        if ($check->fetch()) {
            echo json_encode(['success' => true, 'message' => 'Vous êtes déjà inscrit sur notre liste privée. À très vite !']);
            exit;
        }

        // Insertion du nouveau lead VIP
        $insert = $pdo->prepare("INSERT INTO showroom_leads (email) VALUES (?)");
        $insert->execute([$email]);

        echo json_encode(['success' => true, 'message' => 'Votre invitation privilège a bien été réservée.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Une erreur technique est survenue. Veuillez réessayer.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête non autorisée.']);
}