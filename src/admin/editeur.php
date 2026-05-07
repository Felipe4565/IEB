<?php 
require_once('includes/auth_check.php'); // Assure la protection de la page[cite: 1]
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1000px; margin: 0 auto; text-align: center; padding-top: 50px;">
        
        <header style="margin-bottom: 60px;">
            <h1 class="serif-gold" style="font-size: 2.5rem; margin-bottom: 10px;">Éditeur de Contenu</h1>
            <p style="opacity: 0.5; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">
                Personnalisation de l'identité visuelle et textuelle
            </p>
        </header>

        <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
                    
            <a href="edit_textes.php" class="card-premium content-card" style="text-decoration: none; padding: 60px 20px; border: 1px solid rgba(197,166,124,0.1); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div class="icon-wrapper" style="margin-bottom: 25px; transition: transform 0.4s ease;">
                    <img src="../assets/img/admin/texte.png"
                        alt="Icone Texte" 
                        style="width: 60px; height: 60px; object-fit: contain; filter: brightness(0);"> </div>
                <h2 class="serif-gold" style="font-size: 1.8rem; margin-bottom: 15px;">Textes & Accroches</h2>
                <p style="font-size: 0.85rem; color: var(--light-beige); opacity: 0.6; line-height: 1.6; max-width: 250px;">
                    Mise à jour des titres, manifestes et slogans de l'Atelier.
                </p>
            </a>

            <a href="edit_photos.php" class="card-premium content-card" style="text-decoration: none; padding: 60px 20px; border: 1px solid rgba(197,166,124,0.1); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div class="icon-wrapper" style="margin-bottom: 25px; transition: transform 0.4s ease;">
                    <img src="../assets/img/admin/photo.png" 
                        alt="Icone Photos" 
                        style="width: 60px; height: 60px; object-fit: contain; filter: brightness(0);"> </div>
                <h2 class="serif-gold" style="font-size: 1.8rem; margin-bottom: 15px;">Photographies</h2>
                <p style="font-size: 0.85rem; color: var(--light-beige); opacity: 0.6; line-height: 1.6; max-width: 250px;">
                    Gestion des visuels d'ambiance et des bannières principales.
                </p>
            </a>

        </div>
        
        <div style="margin-top: 60px;">
            <a href="index.php" class="btn-gold" style="text-decoration:none; width: auto; padding: 15px 40px; font-size: 0.75rem;">
                ← RETOUR DASHBOARD
            </a>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>