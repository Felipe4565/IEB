<?php 
require_once('includes/auth_check.php');
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 1000px; margin: 0 auto; text-align: center; padding-top: 50px;">
        <h1 class="serif-gold">Éditeur de Contenu</h1>
        <p style="opacity: 0.6; margin-bottom: 50px;">Sélectionnez l'aspect du site que vous souhaitez modifier</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            <!-- Bloc Textes -->
            <a href="edit_textes.php" class="card-premium" style="text-decoration: none; padding: 60px 20px; transition: var(--transition-luxe); border: 1px solid rgba(197,166,124,0.1);">
                <div style="margin-bottom: 20px;">
                    <img src="../assets/img/admin/texte.png"
                        alt="Icone Texte" 
                        style="width: 50px; height: 50px; object-fit: contain; filter: brightness(0);">
                </div>
                <h2 class="serif-gold">Textes & Accroches</h2>
                <p style="font-size: 0.8rem; color: var(--light-beige); opacity: 0.7;">Modifier les titres, descriptions et slogans du site.</p>
            </a>

            <!-- Bloc Photos -->
            <a href="edit_photos.php" class="card-premium" style="text-decoration: none; padding: 60px 20px; transition: var(--transition-luxe); border: 1px solid rgba(197,166,124,0.1);">
                <div style="margin-bottom: 20px;">
                    <img src="../assets/img/admin/photo.png" 
                        alt="Icone Photos" 
                        style="width: 50px; height: 50px; object-fit: contain; filter: brightness(0);">
                </div>
                <h2 class="serif-gold">Photographies</h2>
                <p style="font-size: 0.8rem; color: var(--light-beige); opacity: 0.7;">Changer les images d'ambiance et de galeries.</p>
            </a>

        </div>
        
        <div style="margin-top: 50px;">
            <a href="index.php" class="btn-gold" style="text-decoration:none;">← Retour Dashboard</a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>