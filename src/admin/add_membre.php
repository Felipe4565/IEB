<?php
require_once('includes/auth_check.php'); // Assure la session et la protection
require_once('../includes/db.php');
require_once('../includes/upload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_post();
    $prenom      = trim($_POST['prenom'] ?? '');
    $nom         = trim($_POST['nom'] ?? '');
    $poste       = trim($_POST['poste'] ?? '');
    $description = $_POST['description'] ?? '';
    $statut      = in_array($_POST['statut'] ?? '', ['actif', 'brouillon'], true) ? $_POST['statut'] : 'brouillon';

    if ($prenom === '' || $nom === '' || $poste === '') {
        $_SESSION['error'] = "Prénom, nom et poste sont obligatoires.";
        header('Location: add_membre.php');
        exit();
    }

    // Photo (obligatoire, validée : nom de fichier aléatoire, plus de ../ possible)
    $saved = isset($_FILES['photo']) ? save_image($_FILES['photo'], __DIR__ . '/../assets/img/equipe/', 'membre-') : null;
    if ($saved === null) {
        $_SESSION['error'] = "Photo invalide (JPG, PNG ou WebP, 5 Mo max).";
        header('Location: add_membre.php');
        exit();
    }
    $photo_path = 'assets/img/equipe/' . $saved;

    // Préparation de l'insertion
    $sql = "INSERT INTO equipe (prenom, nom, poste, description, photo, statut, ordre)
            VALUES (?, ?, ?, ?, ?, ?, 99)";

    try {
        $pdo->prepare($sql)->execute([$prenom, $nom, $poste, $description, $photo_path, $statut]);
        $_SESSION['success'] = "L'artisan a été ajouté avec succès à l'équipe.";
    } catch (PDOException $e) {
        error_log('add_membre : ' . $e->getMessage());
        $_SESSION['error'] = "Une erreur technique est survenue lors de l'ajout.";
    }

    header('Location: equipe.php');
    exit();
}

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <?php include('includes/notifications.php'); ?>
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="equipe.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; text-decoration: none;">← Retour à l'équipe</a>
            <h1 class="serif-gold">Nouvel Artisan</h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); padding: 40px;">
                <?= csrf_field() ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Colonne Gauche -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Prénom</label>
                        <input type="text" name="prenom" required placeholder="Ex: Leonardo" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Poste / Spécialité</label>
                        <input type="text" name="poste" required placeholder="Ex: Ébéniste Designer" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Colonne Droite -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Nom</label>
                        <input type="text" name="nom" required placeholder="Ex: Alvariza" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Statut de publication</label>
                        <select name="statut" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; box-sizing: border-box;">
                            <option value="actif">En ligne</option>
                            <option value="brouillon">Brouillon</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description (Largeur totale) -->
            <div style="margin-top: 10px;">
                <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Parcours / Présentation</label>
                <textarea name="description" rows="5" placeholder="Décrivez l'expertise de cet artisan..." 
                          style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; margin-bottom: 20px; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <!-- Upload Photo -->
            <div style="margin-bottom: 30px; padding: 30px; border: 1px dashed rgba(197, 166, 124, 0.3); text-align: center; background: rgba(0,0,0,0.2);">
                <p style="font-size: 0.8rem; margin-bottom: 15px; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px;">Photo de profil de l'artisan</p>
                <input type="file" name="photo" accept="image/*" required style="font-size: 0.8rem; color: var(--gold-accent);">
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; cursor: pointer; padding: 18px; font-weight: 700; border: 1px solid var(--gold-accent);">
                INTÉGRER À L'ÉQUIPE
            </button>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>