<?php
require_once('includes/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$queryMembre = $pdo->prepare("SELECT * FROM equipe WHERE id = ?");
$queryMembre->execute([$id]);
$person = $queryMembre->fetch();

if (!$person) {
    header('Location: atelier.php');
    exit;
}

$queryCards = $pdo->prepare("SELECT * FROM equipe_cards WHERE equipe_id = ? ORDER BY ordre ASC");
$queryCards->execute([$id]);
$cards = $queryCards->fetchAll();

$page_title = "Profil de " . htmlspecialchars($person['prenom']) . " - IEB";
$page_css = "css/personne_page.css?v=" . time();
include('includes/header.php');
?>

<main class="team-member-page">
    <section class="section-padding">
        <a class="back-button" href="entreprise.php">← Retour à l'équipe</a>

        <div class="member-container">
            <div class="member-image">
                <img src="<?= htmlspecialchars($person['photo']) ?>" alt="<?= htmlspecialchars($person['nom']) ?>">
            </div>

            <div class="member-info">
                <h1><?= htmlspecialchars($person['prenom'] . ' ' . $person['nom']) ?></h1>
                
                <h2><?= htmlspecialchars($person['poste']) ?></h2>
                
                <p class="member-bio"><?= nl2br(htmlspecialchars($person['description'])) ?></p>

                <?php if (!empty($cards)): ?>
                    <div class="member-cards">
                        <?php foreach ($cards as $card): ?>
                            <div class="member-card">
                                <h3><?= htmlspecialchars($card['titre']) ?></h3>
                                <p><?= htmlspecialchars($card['contenu']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>