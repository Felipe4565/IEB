<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');
require_once('../includes/upload.php');

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_post();

    // =========================
    // DONNÉES FORM (validées)
    // =========================
    $categories = ['interieur', 'exterieur', 'sur-mesure', 'pro', 'renovation'];

    $titre        = trim($_POST['titre'] ?? '');
    $type         = in_array($_POST['type'] ?? '', $categories, true) ? $_POST['type'] : 'interieur';
    $description  = $_POST['description'] ?? '';
    $localisation = $_POST['localisation'] ?? '';
    $surface      = $_POST['surface'] ?? '';
    $materiaux    = $_POST['materiaux'] ?? '';
    $duree        = $_POST['duree'] ?? '';
    $statut       = in_array($_POST['statut'] ?? '', ['publie', 'brouillon'], true) ? $_POST['statut'] : 'brouillon';

    if ($titre === '') {
        $_SESSION['error'] = "Le titre est obligatoire.";
        header('Location: add_projet.php');
        exit();
    }

    // Slug unique (projet_detail.php s'appuie dessus)
    $slug = slugify($titre);
    $check = $pdo->prepare("SELECT COUNT(*) FROM projets WHERE slug = ?");
    $check->execute([$slug]);
    if ($check->fetchColumn() > 0) {
        $slug .= '-' . bin2hex(random_bytes(3));
    }

    // =========================
    // UPLOAD
    // =========================
    $upload_dir  = __DIR__ . '/../assets/img/realisations/';
    $public_path = 'assets/img/realisations/';

    // IMAGE PRINCIPALE (obligatoire, validée)
    $saved = isset($_FILES['image']) ? save_image($_FILES['image'], $upload_dir, 'main-') : null;
    if ($saved === null) {
        $_SESSION['error'] = "Image principale invalide (JPG, PNG ou WebP, 5 Mo max).";
        header('Location: add_projet.php');
        exit();
    }
    $image_path = $public_path . $saved;

    // =========================
    // INSERT PROJET
    // =========================
    try {
        $sql = "INSERT INTO projets
            (titre, slug, description, type, localisation, surface, materiaux, duree, image_principale, statut, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $pdo->prepare($sql)->execute([
            $titre, $slug, $description, $type,
            $localisation, $surface, $materiaux,
            $duree, $image_path, $statut
        ]);
    } catch (PDOException $e) {
        error_log('add_projet : ' . $e->getMessage());
        $_SESSION['error'] = "Erreur lors de l'enregistrement du projet.";
        header('Location: add_projet.php');
        exit();
    }

    $projet_id = (int)$pdo->lastInsertId();

    // =========================
    // GALERIE (chaque photo validée)
    // =========================
    $refused = 0;
    if (isset($_FILES['galerie']) && is_array($_FILES['galerie']['name'])) {
        foreach ($_FILES['galerie']['name'] as $i => $_) {
            if ($_FILES['galerie']['error'][$i] === UPLOAD_ERR_NO_FILE) continue;

            $saved = save_image(file_at($_FILES['galerie'], $i), $upload_dir, 'gal-' . $projet_id . '-');
            if ($saved === null) { $refused++; continue; }

            $pdo->prepare("INSERT INTO images_projets (projet_id, image_url) VALUES (?, ?)")
                ->execute([$projet_id, $public_path . $saved]);
        }
    }

    $_SESSION['success'] = "Projet créé avec succès";
    if ($refused > 0) {
        $_SESSION['error'] = $refused . " photo(s) de galerie refusée(s) (JPG, PNG ou WebP, 5 Mo max).";
    }
    header('Location: projets.php');
    exit();
}
include('../includes/header.php');
?>

    <link rel="stylesheet" href="../css/admin.css">

    <main class="admin-main">
    <?php include('includes/notifications.php'); ?>
        <div class="container" style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
            
            <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
                <a href="projets.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; color: #c5a67c; text-decoration: none;">← Retour au portfolio</a>
                <h1 class="serif-gold" style="color: #c5a67c; font-family: 'Playfair Display', serif; font-size: 2.5rem;">Nouvelle Réalisation</h1>
            </header>

            <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); padding: 30px; border: 1px solid rgba(197, 166, 124, 0.1);">
                <?= csrf_field() ?>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase; letter-spacing: 1px;">Titre de l'ouvrage</label>
                            <input type="text" name="titre" required placeholder="Ex: Bibliothèque en Noyer" 
                                style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Catégorie</label>
                            <select name="type" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                                <option value="interieur">Intérieur</option>
                                <option value="exterieur">Extérieur</option>
                                <option value="sur-mesure">Sur-Mesure</option>
                                <option value="pro">Professionnel</option>
                                <option value="renovation">Rénovation</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Localisation (Optionnel)</label>
                            <input type="text" name="localisation" placeholder="Ex: Paris VII" 
                                style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>
                    </div>

                    <div>
                        <div style="margin-bottom: 20px;">
                            <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Matériaux (Optionnel)</label>
                            <input type="text" name="materiaux" placeholder="Ex: Chêne massif, Acier" 
                                style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Surface</label>
                                <input type="text" name="surface" placeholder="Ex: 20m2" 
                                    style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            </div>
                            <div>
                                <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Durée</label>
                                <input type="text" name="duree" placeholder="Ex: 3 semaines" 
                                    style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Statut</label>
                            <select name="statut" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                                <option value="publie">Publié (Visible sur le site)</option>
                                <option value="brouillon">Brouillon (Masqué)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <label class="serif-gold" style="font-size: 0.75rem; display: block; margin-bottom: 10px; color: #c5a67c; text-transform: uppercase;">Description détaillée</label>
                    <textarea name="description" rows="4" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; margin-bottom: 20px; font-family: sans-serif;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    <div style="padding: 20px; border: 1px dashed rgba(197, 166, 124, 0.3); text-align: center;">
                        <p style="font-size: 0.8rem; margin-bottom: 15px; color: #fff; opacity: 0.7;">Photo principale (Couverture)</p>
                        <input type="file" name="image" accept="image/*" required style="font-size: 0.8rem; color: #c5a67c;">
                    </div>

                    <div style="padding: 20px; border: 1px dashed rgba(197, 166, 124, 0.3); text-align: center;">
                        <p style="font-size: 0.8rem; margin-bottom: 15px; color: #fff; opacity: 0.7;">Galerie : Photos de détails (Multiples)</p>
                        <input type="file" name="galerie[]" accept="image/*" multiple style="font-size: 0.8rem; color: #c5a67c;">
                        <p style="font-size: 0.65rem; color: #c5a67c; margin-top: 10px;">Maintenez CTRL pour en choisir plusieurs.</p>
                    </div>
                </div>

                <button type="submit" class="btn-gold" style="width: 100%; cursor: pointer; padding: 18px; background: #c5a67c; color: #0d0e0a; border: none; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s;">
                    Enregistrer l'ouvrage et les photos
                </button>
            </form>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>