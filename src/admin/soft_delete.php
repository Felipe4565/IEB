<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = $_GET['type'] ?? ''; // 'projet', 'message', ou 'contact'

if ($id > 0 && in_array($type, ['projet', 'message', 'contact'])) {
    $table = ($type === 'projet') ? 'projets' : (($type === 'message') ? 'messages' : 'contacts');
    
    // On passe simplement le statut à corbeille
    $stmt = $pdo->prepare("UPDATE $table SET statut = 'corbeille' WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: " . $_SERVER['HTTP_REFERER']); // Redirige là d'où on vient
exit();