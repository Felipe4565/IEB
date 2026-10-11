<?php
require_once __DIR__ . '/../../includes/session.php';

$idle_limit = 2 * 60 * 60; // déconnexion après 2 h d'inactivité

// Pas connecté : retour au login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Session trop ancienne : on la détruit
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $idle_limit) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php?expired=1');
    exit();
}
$_SESSION['last_activity'] = time();