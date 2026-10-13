<?php
// Préinscription showroom (fenêtre "Liste Privée" de services.php) : répond en JSON.
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/forms.php';
require_once __DIR__ . '/includes/showroom.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function reponse(bool $ok, string $message, int $code = 200): void {
    http_response_code($code);
    echo json_encode(['success' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit();
}

$merci = "Merci ! Vous êtes sur la liste : vous recevrez votre invitation en avant-première.";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    reponse(false, "Requête invalide.", 405);
}
if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    reponse(false, "Votre session a expiré. Rechargez la page et réessayez.", 403);
}
if (!empty($_POST['hp_check_url'])) {            // robot : on fait comme si c'était réussi
    reponse(true, $merci);
}
if (too_many_submissions($pdo, 'showroom', 5, 60)) {
    reponse(false, "Trop d'inscriptions depuis votre connexion. Merci de réessayer plus tard.", 429);
}
if (empty($_POST['rgpd_consent'])) {
    reponse(false, "Merci d'accepter la politique de confidentialité pour vous inscrire.", 400);
}

$email = mb_strtolower(trim($_POST['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
    reponse(false, "L'adresse email n'est pas valide.", 400);
}

// Une adresse déjà inscrite reçoit le même message : on ne révèle pas qui est inscrit.
try {
    showroom_ensure_table($pdo);
    $pdo->prepare("INSERT IGNORE INTO showroom_preinscriptions (email) VALUES (?)")->execute([$email]);
} catch (PDOException $e) {
    error_log('ajax_showroom_lead.php : ' . $e->getMessage());
    reponse(false, "Une erreur est survenue. Merci de réessayer dans un instant.", 500);
}

record_submission($pdo, 'showroom');
record_consent($pdo, 'showroom', $email);

reponse(true, $merci);