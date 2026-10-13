<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/upload.php';
require_once __DIR__ . '/includes/forms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: laisser_avis.php');
    exit();
}

function avis_fail(string $msg): void {
    $_SESSION['form_error'] = $msg;
    header('Location: laisser_avis.php');
    exit();
}

// Identifiant d'URL à partir du nom (accents retirés, jamais vide)
function avis_slug(string $nom): string {
    $t = preg_replace('~[^\pL\d]+~u', '-', $nom);
    $t = @iconv('utf-8', 'us-ascii//TRANSLIT', $t) ?: $t;
    $t = strtolower(trim(preg_replace('~[^-\w]+~', '', $t), '-'));
    return $t !== '' ? $t : 'avis';
}

// --- Sécurité ---
if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    avis_fail("Votre session a expiré. Merci de renvoyer le formulaire.");
}
if (!empty($_POST['hp_check_comment'])) {      // robot
    header('Location: avis.php');
    exit();
}
if (too_many_submissions($pdo, 'avis', 3, 1440)) {
    avis_fail("Vous avez déjà envoyé plusieurs avis aujourd'hui. Merci de réessayer demain.");
}
if (empty($_POST['rgpd_consent'])) {
    avis_fail("Merci d'autoriser la publication de votre témoignage pour continuer.");
}

// --- Données ---
$nom         = trim($_POST['nom'] ?? '');
$note        = filter_var($_POST['rating'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 5]]);
$type_projet = $_POST['projet'] ?? '';
$commentaire = trim($_POST['message'] ?? '');

$types_ok = ['Terrasse', 'Cuisine', 'Escalier', 'Meuble sur-mesure', 'Plan de travail', 'Intérieur', 'Extérieur'];

if (mb_strlen($nom) < 2 || mb_strlen($nom) > 80)        avis_fail("Merci d'indiquer le nom avec lequel signer votre témoignage.");
if ($note === false || $note === null)                   avis_fail("Merci de choisir une note.");
if (!in_array($type_projet, $types_ok, true))            avis_fail("Merci de choisir le type de réalisation.");
if (mb_strlen($commentaire) < 10 || mb_strlen($commentaire) > 750) avis_fail("Votre témoignage doit faire entre 10 et 750 caractères.");

// --- Photos (JPG, PNG ou WebP ; 10 max, 5 Mo chacune) ---
$saved = [];
$dir = __DIR__ . '/assets/img/avis/';
$cleanup = function () use (&$saved, $dir) {
    foreach ($saved as $f) { @unlink($dir . $f); }
};

if (isset($_FILES['photos']) && is_array($_FILES['photos']['name'])) {
    $real = 0;
    foreach ($_FILES['photos']['error'] as $err) {
        if ($err !== UPLOAD_ERR_NO_FILE) $real++;
    }
    if ($real > 10) avis_fail("10 photos maximum.");

    foreach ($_FILES['photos']['name'] as $i => $_) {
        if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
        $name = save_image(file_at($_FILES['photos'], $i), $dir, 'avis-');
        if ($name === null) {
            $cleanup();
            avis_fail("Une photo a été refusée (JPG, PNG ou WebP, 5 Mo maximum).");
        }
        $saved[] = $name;
    }
}

// --- Enregistrement (avis + photos en une seule transaction) ---
try {
    $pdo->beginTransaction();

    $slug = avis_slug($nom);
    $chk = $pdo->prepare("SELECT COUNT(*) FROM avis WHERE slug = ?");
    $chk->execute([$slug]);
    if ($chk->fetchColumn() > 0) {
        $slug .= '-' . bin2hex(random_bytes(3));
    }

    $pdo->prepare("INSERT INTO avis (nom, commentaire, type_projet, note, statut, slug, date, est_detaille)
                   VALUES (?, ?, ?, ?, 'attente', ?, NOW(), 0)")
        ->execute([$nom, $commentaire, $type_projet, $note, $slug]);
    $avis_id = (int)$pdo->lastInsertId();

    foreach ($saved as $f) {
        $pdo->prepare("INSERT INTO images_avis (avis_id, image_url) VALUES (?, ?)")
            ->execute([$avis_id, 'assets/img/avis/' . $f]);
    }
    if ($saved) {
        $pdo->prepare("UPDATE avis SET image = ? WHERE id = ?")
            ->execute(['assets/img/avis/' . $saved[0], $avis_id]);
    }

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $cleanup();
    error_log('traitement_avis.php : ' . $e->getMessage());
    avis_fail("Une erreur est survenue lors de l'enregistrement de votre avis. Merci de réessayer.");
}

record_submission($pdo, 'avis');
record_consent($pdo, 'avis', 'avis:' . $slug);

header('Location: avis.php?success=1');
exit();
