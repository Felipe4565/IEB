<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/forms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// index.php affiche $_SESSION['success_contact'] au-dessus du formulaire
function contact_done(string $msg): void {
    $_SESSION['success_contact'] = $msg;
    header('Location: index.php#contact');
    exit();
}

// --- Sécurité ---
if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    contact_done("Votre session a expiré. Merci de renvoyer le message.");
}
if (!empty($_POST['hp_check_url'])) {          // robot
    header('Location: index.php');
    exit();
}
if (too_many_submissions($pdo, 'contact', 5, 60)) {
    contact_done("Trop de messages envoyés depuis votre connexion. Merci de réessayer plus tard.");
}

if (empty($_POST['rgpd_consent'])) {
    contact_done("Merci d'accepter la politique de confidentialité pour envoyer votre message.");
}

// --- Données ---
$nom     = trim($_POST['nom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$sujet   = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');

if (mb_strlen($nom) < 2 || mb_strlen($nom) > 100)               contact_done("Merci d'indiquer votre nom.");
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) contact_done("L'adresse email n'est pas valide.");
if (mb_strlen($sujet) < 2 || mb_strlen($sujet) > 150)           contact_done("Merci d'indiquer un sujet.");
if (mb_strlen($message) < 10 || mb_strlen($message) > 3000)     contact_done("Votre message doit faire entre 10 et 3000 caractères.");

// --- Enregistrement ---
try {
    $pdo->prepare("INSERT INTO contacts (nom, email, sujet, message, statut, date_envoi)
                   VALUES (:nom, :email, :sujet, :message, 'non_lu', NOW())")
        ->execute([':nom' => $nom, ':email' => $email, ':sujet' => $sujet, ':message' => $message]);
} catch (PDOException $e) {
    error_log('process_contact.php : ' . $e->getMessage());
    contact_done("Une erreur est survenue. Merci de réessayer ou de nous appeler.");
}

record_submission($pdo, 'contact');
record_consent($pdo, 'contact', $email);

contact_done("Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.");