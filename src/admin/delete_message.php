<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header('Location: message.php');
exit;