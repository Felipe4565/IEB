<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : ''; // 'projet', 'contact', ou 'message'
$action = isset($_GET['action']) ? $_GET['action'] : ''; // 'restore' ou 'delete'

if ($id > 0 && !empty($type)) {
    
    // Définition de la table cible
    $table = '';
    if ($type === 'projet') $table = 'projets';
    elseif ($type === 'contact') $table = 'contacts';
    elseif ($type === 'message') $table = 'messages';

    if ($table !== '') {
        if ($action === 'restore') {
            // ACTION : RESTAURER
            // On remet un statut par défaut pour qu'il réapparaisse dans les listes[cite: 4, 5]
            $nouveau_statut = ($table === 'projets') ? 'brouillon' : 'lu';
            $stmt = $pdo->prepare("UPDATE $table SET statut = ? WHERE id = ?");
            $stmt->execute([$nouveau_statut, $id]);
            
        } elseif ($action === 'delete') {
            // ACTION : DÉTRUIRE DÉFINITIVEMENT
            
            // Si c'est un projet, on doit AUSSI supprimer l'image physiquement
            if ($type === 'projet') {
                $stmt = $pdo->prepare("SELECT image_principale FROM projets WHERE id = ?");
                $stmt->execute([$id]);
                $p = $stmt->fetch();
                
                if ($p && $p['image_principale'] != 'assets/img/realisations/default.jpg') {
                    $file_to_delete = '../' . $p['image_principale'];
                    if (file_exists($file_to_delete)) {
                        unlink($file_to_delete); // Suppression du fichier sur le serveur[cite: 8]
                    }
                }
            }
            
            // Suppression de la ligne en base de données[cite: 5, 8]
            $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
}

// Retour à la corbeille après l'action
header('Location: corbeille.php');
exit();