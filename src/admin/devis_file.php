<?php
// Télécharge une pièce jointe de devis (réservé à l'admin connecté).
require_once('includes/auth_check.php');
require_once('../includes/db.php');

function not_found(): void {
    http_response_code(404);
    exit('Fichier introuvable.');
}

$id = (int)($_GET['id'] ?? 0);
$n  = (int)($_GET['n'] ?? -1);

$stmt = $pdo->prepare("SELECT fichiers FROM messages WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) not_found();

$list = array_values(array_filter(array_map('trim', explode(',', (string)$row['fichiers']))));
if (!isset($list[$n])) not_found();

// Le fichier doit se trouver dans assets/uploads/devis/
$base = realpath(__DIR__ . '/../assets/uploads/devis');
$full = realpath(__DIR__ . '/../' . ltrim($list[$n], '/'));
if (!$base || !$full || strpos($full, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($full)) not_found();

$ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
$types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'pdf' => 'application/pdf'];
if (!isset($types[$ext])) {
    http_response_code(403);
    exit('Type de fichier non autorisé.');
}

header('Content-Type: ' . $types[$ext]);
header('X-Content-Type-Options: nosniff');
header('Content-Disposition: attachment; filename="devis-' . $id . '-piece-' . ($n + 1) . '.' . $ext . '"');
header('Content-Length: ' . filesize($full));
header('Cache-Control: private, no-store');
readfile($full);
exit();
