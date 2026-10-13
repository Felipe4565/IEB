<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');
require_once('../includes/showroom.php');

showroom_ensure_table($pdo);

// --- Suppression d'une inscription (POST + jeton CSRF) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf_token'] ?? null)) {
        $_SESSION['error'] = "Session expirée, merci de réessayer.";
    } elseif (isset($_POST['delete_id'])) {
        $pdo->prepare("DELETE FROM showroom_preinscriptions WHERE id = ?")->execute([(int)$_POST['delete_id']]);
        $_SESSION['success'] = "Inscription supprimée.";
    }
    header('Location: showroom_liste.php');
    exit();
}

$rows = $pdo->query("SELECT id, email, prenom, created_at FROM showroom_preinscriptions ORDER BY created_at DESC")->fetchAll();

// --- Export CSV (ouvrable dans Excel) ---
if (isset($_GET['export'])) {
    $safe = function ($v) {                       // empêche l'injection de formules Excel
        $v = (string)$v;
        return ($v !== '' && strpbrk($v[0], "=+-@\t\r") !== false) ? "'" . $v : $v;
    };
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="showroom-preinscriptions-' . date('Y-m-d') . '.csv"');
    header('Cache-Control: private, no-store');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");                 // BOM UTF-8 pour Excel
    fputcsv($out, ['Email', 'Prénom', 'Inscrit le'], ';');
    foreach ($rows as $r) {
        fputcsv($out, [$safe($r['email']), $safe($r['prenom']), $r['created_at']], ';');
    }
    fclose($out);
    exit();
}

$base_path = '../';
include('../includes/header.php');
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" class="btn-action" style="margin-left: 0;">← Tableau de bord</a>
        </div>

        <?php foreach (['success' => '#5fbf8a', 'error' => '#ff5f40'] as $k => $c): if (!empty($_SESSION[$k])): ?>
            <p style="max-width: 900px; margin: 0 auto 20px; padding: 12px 16px; border-left: 3px solid <?= $c ?>;"><?= htmlspecialchars($_SESSION[$k]) ?></p>
        <?php unset($_SESSION[$k]); endif; endforeach; ?>

        <article class="card-premium" style="max-width: 900px; margin: 0 auto;">
            <header style="border-bottom: 1px solid rgba(197,166,124,0.2); padding-bottom: 20px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span class="serif-gold" style="font-size: 0.8rem; display: block; margin-bottom: 8px;">Showroom</span>
                    <h1 class="serif-gold" style="font-size: 1.8rem;">Liste de préinscription (<?= count($rows) ?>)</h1>
                </div>
                <?php if ($rows): ?>
                <div style="display: flex; gap: 12px; align-items: center;">
                    <a href="showroom_liste.php?export=1" class="btn-gold">Exporter en CSV</a>
                    <button type="button" class="btn-action" id="copy-all" style="background:none; cursor:pointer; font-family:inherit;">Copier tous les emails</button>
                </div>
                <?php endif; ?>
            </header>

            <?php if (!$rows): ?>
                <p style="opacity: 0.6;">Aucune inscription pour le moment.</p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase; opacity: 0.6;">
                            <th style="padding: 10px 8px;">Email</th>
                            <th style="padding: 10px 8px;">Prénom</th>
                            <th style="padding: 10px 8px;">Inscrit le</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr style="border-top: 1px solid rgba(197,166,124,0.12);">
                            <td style="padding: 12px 8px;"><?= htmlspecialchars($r['email']) ?></td>
                            <td style="padding: 12px 8px;"><?= htmlspecialchars((string)$r['prenom']) ?></td>
                            <td style="padding: 12px 8px; opacity: 0.7;"><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                            <td style="padding: 12px 8px; text-align: right;">
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette inscription ?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="delete_id" value="<?= (int)$r['id'] ?>">
                                    <button type="submit" class="btn-action" style="color:#ff5f40; background:none; cursor:pointer; font-family:inherit;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </article>
    </div>
</main>

<?php if ($rows): ?>
<script>
document.getElementById('copy-all').addEventListener('click', function () {
    const emails = <?= json_encode(array_column($rows, 'email')) ?>.join('; ');
    const btn = this, old = btn.textContent;
    const done = () => { btn.textContent = 'Copié ✓'; setTimeout(() => btn.textContent = old, 1500); };
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(emails).then(done);
    } else {
        const t = document.createElement('textarea');
        t.value = emails; document.body.appendChild(t); t.select();
        document.execCommand('copy'); t.remove(); done();
    }
});
</script>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>