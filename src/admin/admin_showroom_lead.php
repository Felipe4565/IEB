<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');
include('../includes/header.php');



// --- LOGIQUE D'EXPORTATION CSV ---
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=leads_showroom_ieb_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    // Bom pour compatibilité Excel Windows
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    fputcsv($output, ['ID', 'Email', 'Date d\'inscription']);
    
    $stmt = $pdo->query("SELECT * FROM showroom_leads ORDER BY date_inscription DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [$row['id'], $row['email'], $row['date_inscription']]);
    }
    fclose($output);
    exit;
}

// --- RÉCUPÉRATION DES DONNÉES ---
try {
    $query = $pdo->query("SELECT * FROM showroom_leads ORDER BY date_inscription DESC");
    $leads = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_leads = count($leads);
} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Liste Privée Showroom | IEB</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@700&激display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin_showroom_lead.css">
</head>
<body>

<div class="admin-container">
    <header>
        <div>
            <span style="color: var(--gold); font-size: 0.8rem; letter-spacing: 3px;">ADMINISTRATION</span>
            <h1>Liste Privée Showroom</h1>
            <a href="index.php" class="btn-action" style="margin-bottom: 20px; display: inline-block; color: #c5a67c; text-decoration: none;">← Retour</a>

        </div>
        <div class="stats-badge">
            <i class="fas fa-users"></i> <?= $total_leads ?> INSCRITS
        </div>
    </header>

    <div class="actions-bar">
        <a href="?export=csv" class="btn-export">
            <i class="fas fa-file-excel"></i> Exporter en CSV
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Adresse Email</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($total_leads > 0): ?>
                    <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td style="color: var(--gold); width: 50px;">#<?= $lead['id'] ?></td>
                        <td class="email-col"><?= htmlspecialchars($lead['email']) ?></td>
                        <td class="date-col">
                            <i class="far fa-calendar-alt" style="margin-right: 8px;"></i>
                            <?= date('d/m/Y à H:i', strtotime($lead['date_inscription'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-envelope-open-text"></i>
                            Aucun inscrit pour le moment.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php include('../includes/footer.php'); ?>