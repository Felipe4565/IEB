<?php
require_once('includes/auth_check.php'); // Gère session_start() et la protection
require_once('../includes/db.php');

// Fonction pour générer le slug automatiquement
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = slugify($titre);
    $type = $_POST['type'];
    $description = $_POST['description'];
    $localisation = $_POST['localisation'];
    $surface = $_POST['surface'];
    $materiaux = $_POST['materiaux'];
    $duree = $_POST['duree'];
    $statut = $_POST['statut'];

    $upload_dir = '../assets/img/realisations/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    // --- 1. GESTION DE L'IMAGE PRINCIPALE ---
    $image_path = 'assets/img/realisations/default.jpg'; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'main-' . $slug . '-' . uniqid() . '.' . $extension;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_path = 'assets/img/realisations/' . $filename;
        }
    }

    // --- 2. INSERTION DU PROJET DANS LA TABLE 'projets' ---
    $sql = "INSERT INTO projets (titre, slug, description, type, localisation, surface, materiaux, duree, image_principale, statut, date_creation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$titre, $slug, $description, $type, $localisation, $surface, $materiaux, $duree, $image_path, $statut])) {
        $projet_id = $pdo->lastInsertId(); // On récupère l'ID du projet tout juste créé

        // --- 3. GESTION DE LA GALERIE (PHOTOS MULTIPLES) ---
        if (isset($_FILES['galerie']) && !empty($_FILES['galerie']['name'][0])) {
            foreach ($_FILES['galerie']['name'] as $key => $name) {
                if ($_FILES['galerie']['error'][$key] === 0) {
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $gal_filename = 'gal-' . $projet_id . '-' . uniqid() . '.' . $ext;
                    
                    if (move_uploaded_file($_FILES['galerie']['tmp_name'][$key], $upload_dir . $gal_filename)) {
                        $gal_path = 'assets/img/realisations/' . $gal_filename;
                        // Insertion dans la table des images secondaires
                        $stmt_gal = $pdo->prepare("INSERT INTO images_projets (projet_id, image_url) VALUES (?, ?)");
                        $stmt_gal->execute([$projet_id, $gal_path]);
                    }
                }
            }
        }

        $_SESSION['success'] = "Le projet et sa galerie ont été créés avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la création du projet.";
    }

    header('Location: projets.php');
    exit();
}
?>

<?php include('../includes/header.php'); ?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
        
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="projets.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; color: #c5a67c; text-decoration: none;">← Retour au portfolio</a>
            <h1 class="serif-gold" style="color: #c5a67c; font-family: 'Playfair Display', serif; font-size: 2.5rem;">Nouvelle Réalisation</h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); padding: 30px; border: 1px solid rgba(197, 166, 124, 0.1);">
            
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