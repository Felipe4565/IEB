<?php
$page_title = "Profil - IEB";
$page_css = "css/personne_page.css?v=" . time();
include('includes/header.php');

// Récupère l'ID depuis l'URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Définit les infos selon l'ID
$team_members = [
    'leonardo' => [
        'name' => 'Leonardo Freddy Alvariza',
        'role' => 'Gérant et Menuisier intérieur/extérieur bois',
        'image' => 'assets/img/Alvariza.jpg',
        'bio' => 'Leonardo est né en Uruguay et a voyagé à travers l’Europe. Il a d’abord travaillé en France puis en Italie avant de fonder IEB en 2001. Seul au départ, il a développé son activité avec passion, et au fil des années, l’entreprise a grandi et ses clients se sont diversifiés, expliquant une croissance exponentielle.',
        'cards' => [
            ['title' => 'Expérience', 'text' => '+20 ans'],
            ['title' => 'Parcours', 'text' => 'Europe & Italie'],
            ['title' => 'Passion', 'text' => 'Création artisanale']
        ]
    ],
    'julian' => [
        'name' => 'Julian Alvariza',
        'role' => 'Menuisier spécialisé sur mesure',
        'image' => 'assets/img/employé_type.jpg',
        'bio' => 'Julian est spécialisé dans la fabrication sur mesure et le travail de précision. Il apporte sa créativité et son expertise au service de chaque projet.',
        'cards' => [
            ['title' => 'Expertise', 'text' => 'Sur mesure'],
            ['title' => 'Précision', 'text' => 'Travail artisanal'],
            ['title' => 'Témoignage', 'text' => '“J’apprends beaucoup aux côtés de Leonardo et chaque projet est un défi passionnant.”']
        ]
    ]
];

// Si ID invalide, redirige vers l’atelier
if (!array_key_exists($id, $team_members)) {
    header('Location: atelier.php');
    exit;
}

$person = $team_members[$id];
?>

<main class="team-member-page <?= $id ?>">
    <section class="section-padding">
        <a class="back-button" href="entreprise.php">← Retour à l'équipe</a>

        <div class="member-container">
            <div class="member-image">
                <img src="<?= $person['image'] ?>" alt="<?= $person['name'] ?>">
            </div>

            <div class="member-info">
                <h1><?= $person['name'] ?></h1>
                <h2><?= $person['role'] ?></h2>
                <p class="member-bio"><?= $person['bio'] ?></p>

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