<?php
require_once('includes/auth_check.php');
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

    // Gestion de l'image
    $image_path = 'assets/img/realisations/default.jpg'; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/img/realisations/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = $slug . '-' . uniqid() . '.' . $extension;
        $target = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = 'assets/img/realisations/' . $filename;
        }
    }

    // Insertion conforme à la structure de ta base de données
    $sql = "INSERT INTO projets (titre, slug, description, type, localisation, surface, materiaux, duree, image_principale, statut, date_creation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $slug, $description, $type, $localisation, $surface, $materiaux, $duree, $image_path, $statut]);

    header('Location: projets.php');
    exit();
}

$base_path = '../';
include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="projets.php" class="btn-action" style="margin-bottom: 20px; display: inline-block;">← Retour au portfolio</a>
            <h1 class="serif-gold">Nouvelle Réalisation</h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px);">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Colonne Gauche -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Titre de l'ouvrage</label>
                        <input type="text" name="titre" required placeholder="Ex: Bibliothèque en Noyer" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Catégorie</label>
                        <select name="type" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            <option value="interieur">Intérieur</option>
                            <option value="exterieur">Extérieur</option>
                            <option value="sur-mesure">Sur-Mesure</option>
                            <option value="pro">Professionnel</option>
                            <option value="renovation">Rénovation</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Localisation</label>
                        <input type="text" name="localisation" placeholder="Ex: Paris VII" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                    </div>
                </div>

                <!-- Colonne Droite -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Matériaux utilisés</label>
                        <input type="text" name="materiaux" placeholder="Ex: Chêne massif, Acier" 
                               style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Surface</label>
                            <input type="text" name="surface" placeholder="Ex: 20m2" 
                                   style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>
                        <div>
                            <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Durée</label>
                            <input type="text" name="duree" placeholder="Ex: 3 semaines" 
                                   style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Statut de publication</label>
                        <select name="statut" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff;">
                            <option value="brouillon">Brouillon</option>
                            <option value="publie">Publié</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description & Image (Largeur totale) -->
            <div style="margin-top: 10px;">
                <label class="serif-gold" style="font-size: 0.7rem; display: block; margin-bottom: 10px;">Description détaillée</label>
                <textarea name="description" rows="4" style="width: 100%; background: #161811; border: 1px solid rgba(197, 166, 124, 0.2); padding: 12px; color: #fff; margin-bottom: 20px;"></textarea>
            </div>

            <div style="margin-bottom: 30px; padding: 20px; border: 1px dashed rgba(197, 166, 124, 0.3); text-align: center;">
                <p style="font-size: 0.8rem; margin-bottom: 15px; opacity: 0.7;">Photo principale du projet</p>
                <input type="file" name="image" accept="image/*" required style="font-size: 0.8rem; color: var(--gold-accent);">
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; cursor: pointer; padding: 15px;">Enregistrer le projet en base de données</button>
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>