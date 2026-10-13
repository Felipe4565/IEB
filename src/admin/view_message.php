<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// 1. Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: message.php');
    exit;
}

$id = (int)$_GET['id'];

// 2. Marquer comme LU et récupérer les infos
$pdo->prepare("UPDATE messages SET statut = 'lu' WHERE id = ?")->execute([$id]);

$stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
$stmt->execute([$id]);
$msg = $stmt->fetch();

// Si le message n'existe pas
if (!$msg) {
    header('Location: message.php');
    exit;
}

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <!-- Barre de retour -->
        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
            <a href="message.php" class="btn-action" style="margin-left: 0;">← Retour à la liste</a>
            
            <!-- Lien rapide vers le dashboard si besoin -->
            <a href="index.php" style="text-decoration: none; font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 1px;">Dashboard</a>
        </div>

        <article class="card-premium" style="max-width: 800px; margin: 0 auto;">
            <header style="border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px; margin-bottom: 30px;">
                <span class="serif-gold" style="font-size: 0.8rem; display: block; margin-bottom: 10px;">Demande concernant : <?= htmlspecialchars($msg['type']) ?></span>
                <h1 class="serif-gold" style="font-size: 2rem;"><?= htmlspecialchars($msg['nom']) ?></h1>
                <p style="opacity: 0.6; font-size: 0.9rem;">
                    Reçu le <?= date('d/m/Y à H:i', strtotime($msg['date_envoi'])) ?> | 
                    Email : <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" style="color: var(--gold-accent);"><?= htmlspecialchars($msg['email']) ?></a>
                </p>
            </header>

            <div class="message-content" style="white-space: pre-wrap; line-height: 1.8; color: var(--light-beige); min-height: 150px;">
                <?= nl2br(htmlspecialchars($msg['message'])) ?>
            </div>

            <?php
            $fichiers = array_values(array_filter(array_map('trim', explode(',', (string)($msg['fichiers'] ?? '')))));
            if ($fichiers): ?>
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(197, 166, 124, 0.1);">
                <p class="serif-gold" style="font-size: 0.75rem; margin-bottom: 12px;">Pièces jointes (<?= count($fichiers) ?>)</p>
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <?php foreach ($fichiers as $i => $f): ?>
                        <a href="devis_file.php?id=<?= (int)$msg['id'] ?>&n=<?= $i ?>" class="btn-action">
                            📎 Pièce jointe <?= $i + 1 ?> (<?= htmlspecialchars(strtoupper(pathinfo($f, PATHINFO_EXTENSION))) ?>)
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <footer style="margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(197, 166, 124, 0.1); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=<?= htmlspecialchars(rawurlencode('Réponse IEB : ' . $msg['type'])) ?>" class="btn-gold">Répondre par email</a>
                    <a href="<?= htmlspecialchars('https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($msg['email']) . '&su=' . rawurlencode('Réponse IEB : ' . $msg['type'])) ?>" target="_blank" rel="noopener noreferrer" class="btn-action" style="font-size: 0.75rem;">Ouvrir dans Gmail</a>
                    <button type="button" class="btn-action" data-email="<?= htmlspecialchars($msg['email']) ?>" onclick="copyEmail(this)" style="font-size: 0.75rem; background: none; border: none; cursor: pointer; padding: 0; font-family: inherit;">Copier l'adresse</button>
                    
                    <a href="non_lu.php?id=<?= (int)$msg['id'] ?>&type=devis&t=<?= csrf_token() ?>" class="btn-action" style="font-size: 0.75rem;">
                        Marquer comme non lu
                    </a>
                </div>

                <a href="delete_message.php?id=<?= (int)$msg['id'] ?>&t=<?= csrf_token() ?>" class="btn-action" style="color: #ff5f40;" onclick="return confirm('Envoyer ce devis à la corbeille ?')">Supprimer</a>
            </footer>
        </article>
    </div>
</main>

<script>
function copyEmail(btn) {
    const email = btn.dataset.email;
    const done = () => {
        const old = btn.textContent;
        btn.textContent = 'Copié ✓';
        setTimeout(() => { btn.textContent = old; }, 1500);
    };
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(email).then(done);
    } else {
        const i = document.createElement('input');
        i.value = email;
        document.body.appendChild(i);
        i.select();
        document.execCommand('copy');
        i.remove();
        done();
    }
}
</script>

<?php include('../includes/footer.php'); ?>