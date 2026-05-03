<?php
session_start();

// Si l'utilisateur n'a pas de session 'admin_id', il est renvoyé vers le login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>