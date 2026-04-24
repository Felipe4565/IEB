<?php

$host = "db";
$dbname = "ieb_site";
$user = "root";
$password = "root_password";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}