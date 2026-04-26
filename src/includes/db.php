<?php

$host = "db";
$dbname = "ieb_site";
$user = "root";
$password = "root_password";

try {
    // AJOUT DE charset=utf8mb4 DANS LA CHAÎNE DE CONNEXION
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}