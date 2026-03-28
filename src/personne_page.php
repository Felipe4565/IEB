<?php
$page_title = "Profil - IEB";
$page_css = "css/personne_page.css?v=" . time();
include('includes/header.php');

// Récupère l'ID depuis l'URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Définition des membres de l'équipe
$team_members = [
    'leonardo' => [
        'name' => 'Leonardo Freddy Alvariza',
        'role' => 'Gérant et Menuisier intérieur/extérieur bois',
        'image' => 'assets/img/Alvariza.jpg',
        'bio' => 'Leonardo dirige l’atelier depuis plus de 20 ans. Il combine savoir-faire traditionnel et innovation pour créer des pièces uniques et raffinées. Passionné par le bois, il supervise chaque projet avec précision.',
        'cards' => [
            ['title' => 'Expérience', 'text' => '+20 ans'],
            ['title' => 'Spécialité', 'text' => 'Menuiserie intérieure/extérieure'],
            ['title' => 'Passion', 'text' => 'Création artisanale']
        ]
    ],
    'julian' => [
        'name' => 'Julian Alvariza',
        'role' => 'Menuisier spécialisé sur mesure',
        'image' => 'assets/img/employé_type.jpg',
        'bio' => 'Julian est spécialisé dans la fabrication sur mesure et le travail de précision. Il met sa créativité et son expertise au service de chaque projet pour garantir qualité et finition parfaite.',
        'cards' => [
            ['title' => 'Expertise', 'text' => 'Sur mesure'],
            ['title' => 'Précision', 'text' => 'Travail artisanal'],
            ['title' => 'Créativité', 'text' => 'Finitions personnalisées']
        ]
    ]
];

// Si ID invalide, redirige vers l’atelier
if (!array_key_exists($id, $team_members)) {
    header('Location: entreprise.php');
    exit;
}

$person = $team_members[$id];
?>

<main class="team-member-page">
    <section class="section-padding">
        <a class="back-button" href="entreprise.php">← Retour à l'équipe</a>
        <div class="member-container">
            <div class="member-image">
                <img src="<?= $person['image'] ?>" alt="<?= $person['name'] ?>">
            </div>
            <div class="member-info">
                <h1><?= $person['name'] ?></h1>
                <h2><?= $person['role'] ?></h2>
                <p><?= $person['bio'] ?></p>

                <?php if (!empty($person['cards'])): ?>
                    <div class="member-cards">
                        <?php foreach ($person['cards'] as $card): ?>
                            <div class="member-card">
                                <h3><?= $card['title'] ?></h3>
                                <p><?= $card['text'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>