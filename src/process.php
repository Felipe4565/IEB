<?php
session_start();
require_once('includes/db.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $tel = htmlspecialchars(trim($_POST['tel']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $type_travail = htmlspecialchars($_POST['type_travail']);
    $description = htmlspecialchars(trim($_POST['description']));
    $echeance = htmlspecialchars(trim($_POST['echeance']));

    // 2. Gestion des Uploads (Fichiers)
    $uploadedFiles = [];
    $uploadDir = 'assets/uploads/devis/';
    
    // Créer le dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            // On ajoute un timestamp pour éviter les doublons de noms de fichiers
            $fileName = time() . '_' . basename($_FILES['files']['name'][$key]);
            $targetPath = $uploadDir . $fileName;
            
            // Vérification de l'extension
            $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

            if (in_array($fileType, $allowed)) {
                if (move_uploaded_file($tmp_name, $targetPath)) {
                    $uploadedFiles[] = $targetPath;
                }
            }
        }
    }

    // On transforme le tableau de chemins de fichiers en chaîne de caractères pour la BD
    $fichiersString = implode(',', $uploadedFiles);

    // 3. Insertion en Base de Données
    try {
        $sql = "INSERT INTO messages (nom, email, telephone, ville, type, message, fichiers, echeance, statut, date_envoi) 
                VALUES (:nom, :email, :tel, :ville, :type, :message, :fichiers, :echeance, 'non_lu', NOW())";
        
        $stmt = $pdo->prepare($sql);
        $params = [
            ':nom' => $nom,
            ':email' => $email,
            ':tel' => $tel,
            ':ville' => $ville,
            ':type' => $type_travail,
            ':message' => $description,
            ':fichiers' => $fichiersString,
            ':echeance' => $echeance
        ];

        if ($stmt->execute($params)) {
            // --- SUCCÈS : Préparation du message et redirection ---
            $_SESSION['success_devis'] = "Votre demande de devis a été transmise avec succès. Nous vous répondrons sous 48h.";
            header('Location: index.php?success_devis=1'); 
            exit();
        }
    } catch (PDOException $e) {
        // En cas d'erreur technique
        $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement de votre demande.";
        header('Location: contact.php');
        exit();
    }
} else {
    // Si on tente d'accéder au fichier sans passer par le formulaire
    header('Location: contact.php');
    exit();
}