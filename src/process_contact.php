<?php
session_start();
require_once('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }

    if (!empty($_POST['hp_check_url'])) {
        exit("Spam détecté."); 
    }
    // 1. Nettoyage des données
    $nom     = htmlspecialchars(trim($_POST['nom']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $sujet   = htmlspecialchars(trim($_POST['sujet']));
    $message = htmlspecialchars(trim($_POST['message']));

    // 2. Vérification rapide
    if (empty($nom) || empty($email) || empty($message)) {
        header('Location: index.php#contact');
        exit();
    }

    try {
        // 3. Insertion dans la table 'contacts'
        $sql = "INSERT INTO contacts (nom, email, sujet, message, statut, date_envoi) 
                VALUES (:nom, :email, :sujet, :message, 'non_lu', NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom'     => $nom,
            ':email'   => $email,
            ':sujet'   => $sujet,
            ':message' => $message
        ]);

        // 4. Message de succès et redirection
        $_SESSION['success_contact'] = "Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.";
        header('Location: index.php#contact');
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur
        $_SESSION['success_contact'] = "Erreur technique : " . $e->getMessage();
        header('Location: index.php#contact');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}