<?php
require_once('includes/auth_check.php'); 
require_once('../includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. Récupérer le message dans la table CONTACTS
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch();

if (!$contact) {
    header('Location: contact.php');
    exit();
}

// 2. Marquer comme LU automatiquement
if ($contact['statut'] === 'non_lu') {
    $update = $pdo->prepare("UPDATE contacts SET statut = 'lu' WHERE id = ?");
    $update->execute([$id]);
}

$base_path = '../'; 
include('../includes/header.php'); 
?>

<link rel="stylesheet" href="../css/admin.css">

<main class="admin-main">
    <div class="container">
        <div style="margin-bottom: 30px;">
            <a href="contact.php" class="btn-gold" style="font-size: 0.8rem;">← Retour aux messages</a>
        </div>

        <div class="card-premium" style="max-width: 800px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(197, 166, 124, 0.2); padding-bottom: 20px; margin-bottom: 20px;">
                <div>
                    <h2 class="serif-gold" style="margin: 0;"><?= htmlspecialchars($contact['nom']) ?></h2>
                    <p style="opacity: 0.6; margin: 5px 0;"><?= htmlspecialchars($contact['email']) ?></p>
                    <?php if($contact['telephone']): ?>
                        <p style="font-size: 0.9rem; color: var(--gold-accent);"><?= htmlspecialchars($contact['telephone']) ?></p>
                    <?php endif; ?>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 0.8rem; opacity: 0.5;"><?= date('d/m/Y à H:i', strtotime($contact['date_envoi'])) ?></span>
                    <p><strong>Sujet :</strong> <?= htmlspecialchars($contact['sujet']) ?></p>
                </div>
            </div>

            <div style="line-height: 1.8; color: #eee; white-space: pre-wrap;">
                <?= nl2br(htmlspecialchars($contact['message'])) ?>
            </div>

            <div style="margin-top: 40px; border-top: 1px solid rgba(197, 166, 124, 0.1); padding-top: 20px; display: flex; gap: 15px;">
                <a href="mailto:<?= $contact['email'] ?>" class="btn-gold">Répondre par email</a>
                <a href="delete_contact.php?id=<?= $contact['id'] ?>" 
                   style="color: #ff5f40; text-decoration: none; font-size: 0.8rem; align-self: center;"
                   onclick="return confirm('Supprimer ce message ?')">Supprimer ce message</a>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>