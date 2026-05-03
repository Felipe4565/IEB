<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($id > 0) {
    $table = ($type === 'contact') ? 'contacts' : 'messages';
    $redirect = ($type === 'contact') ? 'contact.php' : 'message.php';

    $stmt = $pdo->prepare("UPDATE $table SET statut = 'non_lu' WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: $redirect");
exit();