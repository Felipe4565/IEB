<?php
require_once('includes/auth_check.php'); // Contient session_start()[cite: 1]
require_once('../includes/db.php');

// Récupération des projets : On exclut ceux envoyés à la corbeille
$stmt = $pdo->query("SELECT * FROM projets WHERE statut != 'corbeille' ORDER BY date_creation DESC");
$projets = $stmt->fetchAll();

include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- En-tête avec bouton Dashboard -->
        <header style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 30px;">
            <div>
                <h1 class="serif-gold" style="font-size: 2.5rem; margin: 0;">Le Portfolio</h1>
                <p style="color: var(--light-beige); opacity: 0.6; margin-top: 10px; font-weight: 300;">Gestion des ouvrages et des réalisations de l'atelier.</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="add_projet.php" class="btn-gold" style="width: auto; padding: 12px 25px; font-size: 0.7rem; text-decoration: none;">+ Nouveau Projet</a>
                <a href="index.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                    ← Dashboard
                </a>
            </div>
        </header>

        <?php if (empty($projets)): ?>
            <div class="card-premium" style="text-align: center; padding: 80px 20px;">
                <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                    Aucun projet actif n'est enregistré dans le portfolio.
                </p>
            </div>
        <?php else: ?>
            <!-- Grille de projets -->
            <div class="dashboard-grid">
                <?php foreach ($projets as $p): ?>
                <div class="card-premium" style="padding: 0; display: flex; flex-direction: column; overflow: hidden; position: relative;">
                    
                    <!-- Image du projet avec overlay au survol -->
                    <div class="project-image-container" style="width: 100%; height: 240px; overflow: hidden; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                        <img src="../<?= htmlspecialchars($p['image_principale']) ?>" alt="" 
                             style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                    </div>

                    <!-- Contenu de la carte -->
                    <div style="padding: 25px; flex-grow: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span class="gold-tag" style="font-size: 0.65rem; padding: 3px 10px; border: 1px solid rgba(197,166,124,0.3); color: var(--gold-accent); text-transform: uppercase; letter-spacing: 1px;">
                                <?= htmlspecialchars($p['type']) ?>
                            </span>
                            <span style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $p['statut'] === 'publie' ? 'var(--gold-accent)' : '#666' ?>;">
                                <?= $p['statut'] === 'publie' ? '● En ligne' : '● Brouillon' ?>
                            </span>
                        </div>

                        <h3 class="serif-gold" style="font-size: 1.4rem; margin-bottom: 20px; color: var(--light-beige) !important;">
                            <?= htmlspecialchars($p['titre']) ?>
                        </h3>
                        
                        <!-- Actions unifiées -->
                        <div style="display: flex; gap: 10px; margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(197, 166, 124, 0.1);">
                            <a href="edit_projet.php?id=<?= $p['id'] ?>" class="btn-mini-gold" style="flex: 1; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                MODIFIER
                            </a>
                            <!-- Redirection vers delete_projet.php pour mise en corbeille -->
                            <a href="delete_projet.php?id=<?= $p['id'] ?>" class="btn-mini-flush" 
                               onclick="return confirm('Envoyer cette réalisation à la corbeille ?')" 
                               style="width: 45px; height: 40px; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                ✕
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Animation spécifique au portfolio */
.card-premium:hover .project-image-container img {
    opacity: 1;
    transform: scale(1.08);
}
.card-premium {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-premium:hover {
    transform: translateY(-5px);
}
</style>

<?php include('../includes/footer.php'); ?>