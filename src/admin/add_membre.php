<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $poste = $_POST['poste'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];

    // Gestion de l'image
    $photo_path = 'assets/img/equipe/default.jpg'; 
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $upload_dir = '../assets/img/equipe/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = strtolower($prenom . '-' . $nom) . '-' . uniqid() . '.' . $extension;
        $target = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $photo_path = 'assets/img/equipe/' . $filename;
        }
    }

    // Insertion conforme à la structure de ta table 'equipe'
    $sql = "INSERT INTO equipe (prenom, nom, poste, description, photo, statut, ordre) 
            VALUES (?, ?, ?, ?, ?, ?, 99)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$prenom, $nom, $poste, $description, $photo_path, $statut]);

    header('Location: equipe.php');
    exit();
}

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        
        <header style="margin-bottom: 40px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px;">
            <a href="equipe.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; text-decoration: none;">← Retour à l'équipe</a>
            <h1 class="serif-gold">Nouvel Artisan</h1>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="card-premium" style="background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); padding: 40px;">
            
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