<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/upload.php';
require_once __DIR__ . '/includes/forms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit();
}

function devis_fail(string $msg): void {
    $_SESSION['form_error'] = $msg;
    header('Location: contact.php');
    exit();
}

// --- Sécurité ---
if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    devis_fail("Votre session a expiré. Merci de renvoyer le formulaire.");
}
if (!empty($_POST['hp_check_url'])) {          // robot : on fait comme si de rien n'était
    header('Location: index.php');
    exit();
}
if (too_many_submissions($pdo, 'devis', 5, 60)) {
    devis_fail("Trop de demandes envoyées depuis votre connexion. Merci de réessayer plus tard ou de nous appeler.");
}
if (empty($_POST['rgpd_consent'])) {
    devis_fail("Merci d'accepter la politique de confidentialité pour envoyer votre demande.");
}

// --- Données (on n'échappe pas ici : l'échappement se fait à l'affichage) ---
$nom          = trim($_POST['nom'] ?? '');
$email        = trim($_POST['email'] ?? '');
$tel          = preg_replace('/\D/', '', $_POST['tel'] ?? '');
$ville        = trim($_POST['ville'] ?? '');
$type_travail = $_POST['type_travail'] ?? '';
$description  = trim($_POST['description'] ?? '');
$echeance     = trim($_POST['echeance'] ?? '');

$types_ok = ['Menuiserie Intérieure', 'Menuiserie Extérieure', 'Autres'];

if (mb_strlen($nom) < 2 || mb_strlen($nom) > 100)               devis_fail("Merci d'indiquer votre nom.");
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) devis_fail("L'adresse email n'est pas valide.");
if (!preg_match('/^\d{10}$/', $tel))                            devis_fail("Le numéro de téléphone doit comporter 10 chiffres.");
if (mb_strlen($ville) < 2 || mb_strlen($ville) > 100)           devis_fail("Merci d'indiquer votre ville.");
if (!in_array($type_travail, $types_ok, true))                  devis_fail("Merci de choisir la nature des travaux.");
if (mb_strlen($description) < 10 || mb_strlen($description) > 3000) devis_fail("Merci de décrire votre projet (10 à 3000 caractères).");
if (mb_strlen($echeance) < 2 || mb_strlen($echeance) > 100)     devis_fail("Merci d'indiquer l'échéance souhaitée.");

// --- Pièces jointes (PDF, JPG, PNG ; 5 fichiers max, 10 Mo chacun) ---
$saved = [];
$upload_dir = __DIR__ . '/assets/uploads/devis/';
$cleanup = function () use (&$saved) {
    foreach ($saved as $p) { @unlink(__DIR__ . '/' . $p); }
};

if (isset($_FILES['files']) && is_array($_FILES['files']['name'])) {
    $real = 0;
    foreach ($_FILES['files']['error'] as $err) {
        if ($err !== UPLOAD_ERR_NO_FILE) $real++;
    }
    if ($real > 5) devis_fail("5 fichiers maximum par demande.");

    foreach ($_FILES['files']['name'] as $i => $_) {
        if ($_FILES['files']['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
        $name = save_attachment(file_at($_FILES['files'], $i), $upload_dir, 'devis-');
        if ($name === null) {
            $cleanup();
            devis_fail("Un fichier a été refusé (PDF, JPG ou PNG, 10 Mo maximum).");
        }
        $saved[] = 'assets/uploads/devis/' . $name;
    }
}

// --- Enregistrement ---
try {
    $sql = "INSERT INTO messages (nom, email, telephone, ville, type, message, fichiers, echeance, statut, date_envoi)
            VALUES (:nom, :email, :tel, :ville, :type, :message, :fichiers, :echeance, 'non_lu', NOW())";
    $pdo->prepare($sql)->execute([
        ':nom'      => $nom,
        ':email'    => $email,
        ':tel'      => $tel,
        ':ville'    => $ville,
        ':type'     => $type_travail,
        ':message'  => $description,
        ':fichiers' => implode(',', $saved),
        ':echeance' => $echeance,
    ]);
} catch (PDOException $e) {
    error_log('process.php : ' . $e->getMessage());
    $cleanup();
    devis_fail("Une erreur est survenue lors de l'enregistrement de votre demande. Merci de réessayer ou de nous appeler.");
}

record_submission($pdo, 'devis');
record_consent($pdo, 'devis', $email);

$_SESSION['success_devis'] = "Votre demande de devis a été transmise avec succès. Nous vous répondrons sous 48h.";
header('Location: index.php?success_devis=1');
exit();
