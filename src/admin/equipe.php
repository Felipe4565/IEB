<?php
require_once('includes/auth_check.php'); // Gère session_start()[cite: 1]
require_once('../includes/db.php');

// Récupération des membres (exclusion de la corbeille)
$equipe = $pdo->query("SELECT * FROM equipe WHERE statut != 'corbeille' ORDER BY ordre ASC")->fetchAll();

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Header ajusté pour alignement parfait -->
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 60px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 class="serif-gold" style="margin: 0;">L'Équipe</h1>
                <p style="opacity: 0.5; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; margin-top: 5px;">
                    Maîtres Artisans de l'Atelier IEB
                </p>
            </div>
            
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="add_membre.php" class="btn-gold" style="width: auto; min-width: 180px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                    + Ajouter un membre
                </a>
                <a href="index.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                    ← Dashboard
                </a>
            </div>
        </header>

        <?php if (empty($equipe)): ?>
            <div class="card-premium" style="text-align: center; padding: 60px 20px;">
                <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                    Aucun membre n'est actuellement enregistré dans l'équipe.
                </p>
            </div>
        <?php else: ?>
            <div class="dashboard-grid">
                <?php foreach ($equipe as $membre): ?>
                <div class="card-premium" style="text-align: center; position: relative;">
                    
                    <!-- Badge de statut dynamique -->
                    <div style="position: absolute; top: 15px; right: 15px;">
                        <span class="badge <?= $membre['statut'] == 'actif' ? 'badge-read' : 'badge-new' ?>" style="font-size: 0.6rem;">
                            <?= $membre['statut'] == 'actif' ? 'En ligne' : 'Brouillon' ?>
                        </span>
                    </div>

                    <div style="margin-bottom: 25px; position: relative; display: inline-block;">
                        <div style="padding: 6px; border: 1px solid var(--gold-accent); border-radius: 50%; display: inline-block;">
                            <img src="../<?= $membre['photo'] ?>" alt="<?= htmlspecialchars($membre['prenom']) ?>" 
                                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                        </div>
                    </div>
                    
                    <h3 style="font-size: 1.5rem; margin-bottom: 5px; color: var(--gold-accent) !important;">
                        <?= htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']) ?>
                    </h3>
                    
                    <p style="color: var(--light-beige); opacity: 0.6; font-size: 0.85rem; margin-bottom: 25px;">
                        <?= htmlspecialchars($membre['poste']) ?>
                    </p>

                    <div style="border-top: 1px solid rgba(197, 166, 124, 0.1); padding-top: 20px; display: flex; gap: 8px; align-items: center;">
                        <a href="edit_membre.php?id=<?= $membre['id'] ?>" class="btn-mini-gold" 
                           style="flex: 1; height: 40px; text-decoration: none; display: flex; align-items: center; justify-content: center; margin: 0;">
                            ÉDITER
                        </a>

                        <a href="delete_membre.php?id=<?= $membre['id'] ?>" class="btn-mini-flush" 
                           onclick="return confirm('Envoyer ce membre à la corbeille ?')" 
                           style="width: 40px; height: 40px; padding: 0; text-decoration: none; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; margin: 0; flex-shrink: 0;">
                            ✕
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('../includes/footer.php'); ?>