<?php
require_once('includes/auth_check.php');
require_once('../includes/db.php');

// 1. Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: messages.php');
    exit;
}

$id = $_GET['id'];

// 2. Marquer comme LU et récupérer les infos
// On fait les deux en suivant : d'abord l'UPDATE, puis le SELECT
$pdo->prepare("UPDATE messages SET statut = 'lu' WHERE id = ?")->execute([$id]);

$stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
$stmt->execute([$id]);
$msg = $stmt->fetch();

// Si le message n'existe pas
if (!$msg) {
    header('Location: messages.php');
    exit;
}

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <div style="margin-bottom: 40px;">
            <a href="message.php" class="btn-action" style="margin-left: 0;">← Retour à la liste</a>
        </div>

        <article class="card-premium" style="max-width: 800px; margin: 0 auto;">
            <header style="border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px; margin-bottom: 30px;">
                <span class="serif-gold" style="font-size: 0.8rem; display: block; margin-bottom: 10px;">Demande concernant : <?= htmlspecialchars($msg['type']) ?></span>
                <h1 class="serif-gold" style="font-size: 2rem;"><?= htmlspecialchars($msg['nom']) ?></h1>
                <p style="opacity: 0.6; font-size: 0.9rem;">
                    Reçu le <?= date('d/m/Y à H:i', strtotime($msg['date_envoi'])) ?> | 
                    Email : <a href="mailto:<?= $msg['email'] ?>" style="color: var(--gold-accent);"><?= htmlspecialchars($msg['email']) ?></a>
                </p>
            </header>

            <div class="message-content" style="white-space: pre-wrap; line-height: 1.8; color: var(--light-beige);">
                <?= nl2br(htmlspecialchars($msg['message'])) ?>
            </div>

            <footer style="margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(197, 166, 124, 0.1);">
                <a href="mailto:<?= $msg['email'] ?>?subject=Réponse IEB : <?= $msg['type'] ?>" class="btn-gold">Répondre par email</a>
                <a href="delete_message.php?id=<?= $msg['id'] ?>" class="btn-action" style="color: #ff5f40; float: right;" onclick="return confirm('Supprimer ce message ?')">Supprimer</a>
            </footer>
        </article>
    </div>
</main>

<?php include('../includes/footer.php'); ?>