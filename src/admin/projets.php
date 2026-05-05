<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// Modification de la requête : On exclut les projets envoyés à la corbeille
$stmt = $pdo->query("SELECT * FROM projets WHERE statut != 'corbeille' ORDER BY date_creation DESC");
$projets = $stmt->fetchAll();

$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Utilisation de tes variables et polices -->
<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- En-tête avec bouton Dashboard -->
        <header style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 30px;">
            <div>
                <h1 class="serif-gold" style="font-size: 2.5rem; margin: 0;">Le Portfolio</h1>
                <p style="color: var(--light-beige); opacity: 0.6; margin-top: 10px; font-weight: 300;">Gestion des ouvrages et des réalisations de l'atelier.</p>
            </div>
            <div style="display: flex; gap: 20px;">
                <a href="add_projet.php" class="btn-gold">+ Nouveau Projet</a>
                <a href="index.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                    ← Dashboard
                </a>
            </div>
        </header>

        <?php if (empty($projets)): ?>
            <div class="card-premium" style="text-align: center; border-style: dashed; padding: 50px;">
                <p style="opacity: 0.5; font-family: 'Playfair Display', serif; font-style: italic;">Aucun projet actif n'est enregistré.</p>
            </div>
        <?php else: ?>
            <!-- Grille utilisant ta dashboard-grid -->
            <div class="dashboard-grid">
                <?php foreach ($projets as $p): ?>
                <div class="card-premium" style="padding: 0; display: flex; flex-direction: column; overflow: hidden;">
                    
                    <!-- Image du projet -->
                    <div style="width: 100%; height: 250px; overflow: hidden; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                        <img src="../<?= htmlspecialchars($p['image_principale']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: var(--transition-luxe);">
                    </div>

                    <!-- Contenu de la carte -->
                    <div style="padding: 25px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span class="badge" style="color: var(--gold-accent); border-color: rgba(197, 166, 124, 0.3); font-size: 0.7rem; padding: 2px 8px;">
                                <?= htmlspecialchars($p['type']) ?>
                            </span>
                            <span style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; color: <?= $p['statut'] === 'publie' ? 'var(--gold-accent)' : '#666' ?>;">
                                <?= $p['statut'] === 'publie' ? '● En ligne' : '● Brouillon' ?>
                            </span>
                        </div>

                        <h3 style="font-size: 1.5rem; margin-bottom: 20px; color: var(--light-beige);"><?= htmlspecialchars($p['titre']) ?></h3>
                        
                        <!-- Actions -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(197, 166, 124, 0.1);">
                            <a href="edit_projet.php?id=<?= $p['id'] ?>" class="btn-action" style="margin: 0;">Modifier</a>
                            <!-- Le lien pointe vers delete_projet.php qui met à jour le statut en 'corbeille'[cite: 5, 7] -->
                            <a href="delete_projet.php?id=<?= $p['id'] ?>" class="btn-action" style="color: #ff5f40; margin: 0;" onclick="return confirm('Envoyer cette réalisation à la corbeille ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<style>
.card-premium:hover img {
    opacity: 1;
    transform: scale(1.05);
}
.btn-action { text-decoration: none; }
</style>

<?php include('../includes/footer.php'); ?>