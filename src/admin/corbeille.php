<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

// ==========================================
// 1. TRAITEMENT DES ACTIONS (POST/GET)
// ==========================================

// ACTION : VIDER TOUTE LA CORBEILLE
if (isset($_GET['action']) && $_GET['action'] === 'empty_all') {
    
    // --- 1. Nettoyage spécifique de la galerie des avis (images multiples) ---
    // On récupère les chemins de toutes les images liées aux avis en corbeille
    $stmt_galerie = $pdo->query("SELECT image_url FROM images_avis WHERE avis_id IN (SELECT id FROM avis WHERE statut = 'corbeille')");
    $galerie_items = $stmt_galerie->fetchAll();
    
    foreach ($galerie_items as $g_item) {
        $g_path = '../' . $g_item['image_url'];
        if (file_exists($g_path)) {
            unlink($g_path);
        }
    }
    // On vide la table de liaison images_avis pour les avis concernés
    $pdo->query("DELETE FROM images_avis WHERE avis_id IN (SELECT id FROM avis WHERE statut = 'corbeille')");

    // --- 2. Nettoyage des images principales (projets, équipe, avis) ---
    $files_to_clean = [
        'projets' => 'image_principale',
        'equipe' => 'photo',
        'avis' => 'image'
    ];

    foreach ($files_to_clean as $table => $column) {
        $stmt = $pdo->query("SELECT $column FROM $table WHERE statut = 'corbeille'");
        $items = $stmt->fetchAll();
        foreach ($items as $item) {
            if ($item[$column] && !strpos($item[$column], 'default.jpg')) {
                $file_path = '../' . $item[$column];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
    }

    // --- 3. Suppression SQL finale des entrées ---
    $tables = ['projets', 'messages', 'contacts', 'avis', 'equipe'];
    foreach ($tables as $t) {
        $pdo->query("DELETE FROM $t WHERE statut = 'corbeille'");
    }

    $_SESSION['success'] = "La corbeille a été entièrement vidée avec succès.";
    header('Location: corbeille.php');
    exit();
}

// ACTIONS INDIVIDUELLES : RESTAURER OU DÉTRUIRE
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['target'])) {
    $id = intval($_GET['id']);
    $table = $_GET['target']; 
    $filter_back = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
    
    if ($_GET['action'] === 'restore') {
        // Logique de restauration
        if ($table === 'projets' || $table === 'equipe') {
            $nouveau_statut = 'brouillon';
        } elseif ($table === 'avis') {
            $nouveau_statut = 'affiche'; 
        } elseif ($table === 'contacts') {
            $nouveau_statut = 'non_lu';
        } else {
            $nouveau_statut = 'lu';
        }
        $pdo->prepare("UPDATE $table SET statut = ? WHERE id = ?")->execute([$nouveau_statut, $id]);
        $_SESSION['success'] = "L'élément a été restauré avec succès.";

    } elseif ($_GET['action'] === 'flush') {
        
        // --- 1. Cas spécifique : Si on détruit un AVIS, on vide d'abord TOUTE sa galerie photo ---
        if ($table === 'avis') {
            $stmt_g = $pdo->prepare("SELECT image_url FROM images_avis WHERE avis_id = ?");
            $stmt_g->execute([$id]);
            $imgs_galerie = $stmt_g->fetchAll();
            
            foreach ($imgs_galerie as $img) {
                $path_g = '../' . $img['image_url'];
                if (file_exists($path_g)) {
                    unlink($path_g);
                }
            }
            // On supprime les entrées dans la table images_avis
            $pdo->prepare("DELETE FROM images_avis WHERE avis_id = ?")->execute([$id]);
        }

        // --- 2. Nettoyage de l'image principale ---
        $image_columns = ['projets' => 'image_principale', 'equipe' => 'photo', 'avis' => 'image'];
        if (array_key_exists($table, $image_columns)) {
            $col = $image_columns[$table];
            $stmt = $pdo->prepare("SELECT $col FROM $table WHERE id = ?");
            $stmt->execute([$id]);
            $res = $stmt->fetch();
            
            if ($res && $res[$col] && !strpos($res[$col], 'default.jpg')) {
                $file = '../' . $res[$col];
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        // --- 3. Suppression finale de l'élément en BD ---
        $pdo->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
        $_SESSION['success'] = "L'élément a été définitivement supprimé.";
    }
    
    header('Location: corbeille.php' . $filter_back);
    exit();
}

// ==========================================
// 2. FILTRAGE ET RÉCUPÉRATION DES DONNÉES
// ==========================================

$filter = isset($_GET['type']) ? $_GET['type'] : 'all';

$p_trash = ($filter === 'all' || $filter === 'projets') ? $pdo->query("SELECT id, titre as label, 'projets' as tab FROM projets WHERE statut='corbeille'")->fetchAll() : [];
$m_trash = ($filter === 'all' || $filter === 'messages') ? $pdo->query("SELECT id, CONCAT(nom, ' (Devis)') as label, 'messages' as tab FROM messages WHERE statut='corbeille'")->fetchAll() : [];
$c_trash = ($filter === 'all' || $filter === 'contacts') ? $pdo->query("SELECT id, CONCAT(nom, ' (Contact)') as label, 'contacts' as tab FROM contacts WHERE statut='corbeille'")->fetchAll() : [];
$a_trash = ($filter === 'all' || $filter === 'avis') ? $pdo->query("SELECT id, CONCAT(nom, ' (Avis)') as label, 'avis' as tab FROM avis WHERE statut='corbeille'")->fetchAll() : [];
$e_trash = ($filter === 'all' || $filter === 'equipe') ? $pdo->query("SELECT id, CONCAT(prenom, ' ', nom, ' (Équipe)') as label, 'equipe' as tab FROM equipe WHERE statut='corbeille'")->fetchAll() : [];

$full_trash = array_merge($p_trash, $m_trash, $c_trash, $a_trash, $e_trash);

$counts = [
    'projets'  => $pdo->query("SELECT COUNT(*) FROM projets WHERE statut='corbeille'")->fetchColumn(),
    'messages' => $pdo->query("SELECT COUNT(*) FROM messages WHERE statut='corbeille'")->fetchColumn(),
    'contacts' => $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut='corbeille'")->fetchColumn(),
    'avis'     => $pdo->query("SELECT COUNT(*) FROM avis WHERE statut='corbeille'")->fetchColumn(),
    'equipe'   => $pdo->query("SELECT COUNT(*) FROM equipe WHERE statut='corbeille'")->fetchColumn(),
];
$counts['all'] = array_sum($counts);

include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <!-- SYSTÈME DE NOTIFICATION GLOBAL -->
    <?php include('includes/notifications.php'); ?>

    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        <!-- HEADER -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h1 class="serif-gold" style="margin: 0;">Centre de Récupération</h1>
                <p style="opacity: 0.5; font-size: 0.9rem;">Gérez les éléments supprimés de l'atelier</p>
            </div>
            <a href="index.php" class="btn-gold" style="width: auto; min-width: 140px; padding: 12px 25px; font-size: 0.7rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">
                ← Dashboard
            </a>
        </div>

        <!-- BARRE DE FILTRAGE (ONGLETS) + BOUTON VIDER -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
            
            <!-- Filtres (Gauche) -->
            <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 5px;">
                <?php 
                $nav = ['all' => 'Tous', 'projets' => 'Projets', 'equipe' => 'Équipe', 'messages' => 'Devis', 'contacts' => 'Contacts', 'avis' => 'Avis'];
                foreach($nav as $key => $label): 
                    $active = ($filter === $key);
                ?>
                    <a href="?type=<?= $key ?>" style="
                        text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;
                        background: <?= $active ? 'var(--gold-accent)' : 'rgba(255,255,255,0.05)' ?>;
                        color: <?= $active ? '#000' : 'var(--gold-accent)' ?>;
                        border: 1px solid <?= $active ? 'var(--gold-accent)' : 'rgba(197,166,124,0.2)' ?>;
                        white-space: nowrap; transition: 0.3s;
                    ">
                        <?= $label ?> <span style="opacity: 0.5; margin-left: 5px;">(<?= $counts[$key] ?>)</span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Bouton Vider (Droite) -->
            <?php if ($counts['all'] > 0): ?>
                <a href="?action=empty_all" 
                   class="btn-empty-trash" 
                   onclick="return confirm('Vider TOUTE la corbeille définitivement ?')">
                    Vider la corbeille
                </a>
            <?php endif; ?>
        </div>

        <!-- TABLEAU DES ÉLÉMENTS -->
        <div class="card-premium" style="padding: 10px 25px;">
            <?php if (empty($full_trash)): ?>
                <div style="text-align:center; padding: 60px 20px;">
                    <p style="opacity: 0.4; font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.2rem;">
                        La corbeille est vide pour cette catégorie.
                    </p>
                </div>
            <?php else: ?>
                <table class="admin-table" style="width: 100%; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Élément</th>
                            <th style="text-align:right; padding-bottom: 20px; color: var(--gold-accent); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($full_trash as $item): ?>
                        <tr>
                            <td style="padding: 15px 0; color: var(--light-beige); opacity: 0.8; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <?= htmlspecialchars($item['label']) ?>
                            </td>
                            <td style="text-align:right; padding: 15px 0; border-bottom: 1px solid rgba(197, 166, 124, 0.1);">
                                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                    <a href="?action=restore&id=<?= $item['id'] ?>&target=<?= $item['tab'] ?>&type=<?= $filter ?>" class="btn-mini-gold" style="text-decoration:none;">Restaurer</a>
                                    <a href="?action=flush&id=<?= $item['id'] ?>&target=<?= $item['tab'] ?>&type=<?= $filter ?>" class="btn-mini-flush" style="text-decoration:none;" onclick="return confirm('Détruire définitivement ?')">Détruire</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>