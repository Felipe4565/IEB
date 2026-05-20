<?php
session_start();
require_once 'includes/db.php'; // Assurez-vous que le chemin est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }

    if (!empty($_POST['hp_check_comment'])) {
        exit("Spam détecté."); 
    }
    // 1. Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST['nom']));
    $note = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $type_projet = htmlspecialchars($_POST['projet']);
    $commentaire = htmlspecialchars(trim($_POST['message']));
    
    // 2. Génération du Slug unique
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nom), '-'));
    
    // Vérification des doublons de slug
    $checkSlug = $pdo->prepare("SELECT COUNT(*) FROM avis WHERE slug = ?");
    $checkSlug->execute([$slug]);
    if ($checkSlug->fetchColumn() > 0) {
        $slug = $slug . '-' . time();
    }

    try {
        // On commence une transaction pour être sûr que tout s'enregistre bien
        $pdo->beginTransaction();

        // 3. Insertion de l'avis dans la table 'avis'
        // On met l'image à NULL au début, on la mettra à jour avec la première photo uploadée
        $sqlAvis = "INSERT INTO avis (nom, commentaire, type_projet, note, statut, slug, date, est_detaille) 
                    VALUES (:nom, :commentaire, :type_projet, :note, 'attente', :slug, NOW(), 0)";
        
        $stmt = $pdo->prepare($sqlAvis);
        $stmt->execute([
            'nom'          => $nom,
            'commentaire'  => $commentaire,
            'type_projet'  => $type_projet,
            'note'         => $note,
            'slug'         => $slug
        ]);

        $avis_id = $pdo->lastInsertId(); // On récupère l'ID de l'avis qu'on vient de créer

        // 4. Gestion des Uploads Multiples
        $image_principale = null;
        $targetDir = "assets/img/avis/";

        // Créer le dossier s'il n'existe pas
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // On vérifie si des photos ont été envoyées
        if (!empty($_FILES['photos']['name'][0])) {
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
            
            foreach ($_FILES['photos']['name'] as $key => $val) {
                $fileName = time() . '_' . $key . '_' . basename($_FILES['photos']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                if (in_array(strtolower($fileType), $allowTypes)) {
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$key], $targetFilePath)) {
                        
                        // A. Insertion dans la table images_avis
                        $sqlImg = "INSERT INTO images_avis (avis_id, image_url) VALUES (?, ?)";
                        $pdo->prepare($sqlImg)->execute([$avis_id, $targetFilePath]);

                        // B. On garde la première image réussie pour la mettre en image principale de l'avis
                        if ($image_principale === null) {
                            $image_principale = $targetFilePath;
                        }
                    }
                }
            }
        }

        // 5. Mise à jour de l'image principale dans la table 'avis'
        if ($image_principale !== null) {
            $updateAvis = "UPDATE avis SET image = ? WHERE id = ?";
            $pdo->prepare($updateAvis)->execute([$image_principale, $avis_id]);
        }

        // On valide la transaction
        $pdo->commit();

        // Redirection vers la page des avis avec le message de succès
        header("Location: avis.php?success=1");
        exit();

    } catch (Exception $e) {
        // En cas d'erreur, on annule tout ce qui a été fait en base de données
        $pdo->rollBack();
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }

} else {
    // Si on tente d'accéder au fichier sans formulaire
    header("Location: laisser_avis.php");
    exit();
}