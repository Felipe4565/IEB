<?php
if ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
} else {
    ini_set('display_errors', 1);
}

$host = "db";
$dbname = "ieb_site";
$user = "root";
$password = "root_password";

try {
    // Connexion avec charset sécurisé
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {

    error_log("Erreur de connexion DB : " . $e->getMessage());
    
    // 2. On affiche un message propre et pro au client
    die("Une erreur technique est survenue. Veuillez réessayer plus tard.");
}