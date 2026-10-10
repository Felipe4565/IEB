<?php
$env = getenv('APP_ENV') ?: 'production';
ini_set('display_errors', $env === 'local' ? '1' : '0');
ini_set('log_errors', '1');

// Config pour l'hébergement mutualisé (fichier NON versionné)
$local = __DIR__ . '/config.local.php';
$cfg = file_exists($local) ? require $local : [];

$host     = getenv('DB_HOST')     ?: ($cfg['host'] ?? 'localhost');
$dbname   = getenv('DB_NAME')     ?: ($cfg['name'] ?? '');
$user     = getenv('DB_USER')     ?: ($cfg['user'] ?? '');
$password = getenv('DB_PASSWORD') ?: ($cfg['pass'] ?? '');

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log("Erreur de connexion DB : " . $e->getMessage());
    http_response_code(500);
    die("Une erreur technique est survenue. Veuillez réessayer plus tard.");
}