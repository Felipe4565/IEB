<?php include('includes/header.php'); ?>

<?php
// Utilisation de guillemets doubles pour éviter les erreurs d'apostrophes (d'accès, l'atelier, etc.)
$sections_legales = [
    [
        "titre" => "INFORMATIONS GÉNÉRALES",
        "sous_titre" => "Nom de l'entreprise : IEB Intérieur Bois",
        "texte" => "Adresse de l'Intérieur Bois<br>77340 PONTAULT-COMBAULT<br>Capital : 2 200 000,09€<br>SIRET : XXX XXX XXX XXXXX",
    ],
    [
        "titre" => "RESPONSABLE DE LA PUBLICATION",
        "sous_titre" => "Marc-Antoine - Gérant",
        "texte" => "Pour toute question relative au site : contact@ieb-interieurbois.fr<br>Téléphone : 06 31 09 66 22",
    ],
    [
        "titre" => "HÉBERGEMENT",
        "sous_titre" => "Le site est hébergé par",
        "texte" => "O2Switch<br>Chemin des Pardiaux, 63000 Clermont-Ferrand<br>France",
    ],
    [
        "titre" => "PROPRIÉTÉ INTELLECTUELLE",
        "sous_titre" => "Droits d'auteur et marques",
        "texte" => "Tous les éléments du site (textes, images, logos, designs) sont la propriété exclusive de IEB. Toute reproduction, même partielle, est interdite sans accord écrit préalable.",
    ],
    [
        "titre" => "DONNÉES PERSONNELLES (RGPD)",
        "sous_titre" => "Collecte et finalité",
        "texte" => "Conformément au RGPD, nous collectons des données via le formulaire de contact pour la gestion de vos devis. Vous disposez d'un droit d'accès, de rectification et de suppression de vos données.",
    ],
    [
        "titre" => "COOKIES",
        "sous_titre" => "Utilisation des traceurs",
        "texte" => "Ce site utilise des cookies techniques et de statistiques pour améliorer votre navigation. Vous pouvez configurer vos préférences via votre navigateur.",
    ],
    [
        "titre" => "DROIT APPLICABLE",
        "sous_titre" => "Litiges et juridiction",
        "texte" => "Tout litige relatif à l'utilisation du site est soumis au droit français. Le tribunal compétent est celui de Melun.",
    ]
];
?>

<link rel="stylesheet" href="css/mentions_legales.css">

<main class="legal-page">
    <div class="legal-container">
        <a href="index.php" class="btn-back">
            <span class="arrow-back">←</span> RETOUR À L'ACCUEIL
        </a>
        <h1 class="legal-main-title">MENTIONS LÉGALES</h1>
        
        <div class="legal-accordion" id="legalAccordion">
            <?php foreach ($sections_legales as $index => $section): ?>
                <div class="legal-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                    <button class="legal-header">
                        <span class="legal-label"><?php echo $section['titre']; ?></span>
                        <span class="legal-plus">+</span>
                    </button>
                    <div class="legal-content">
                        <div class="legal-inner">
                            <span class="legal-subtitle"><?php echo $section['sous_titre']; ?></span>
                            <p class="legal-text"><?php echo $section['texte']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionItems = document.querySelectorAll('.legal-item');

        accordionItems.forEach(item => {
            const header = item.querySelector('.legal-header');
            
            header.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // On ferme tout le monde
                accordionItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.legal-content').style.maxHeight = null;
                });

                // Si l'élément cliqué n'était pas déjà ouvert, on l'ouvre
                if (!isActive) {
                    item.classList.add('active');
                    const content = item.querySelector('.legal-content');
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });

        // Initialiser la première section ouverte au chargement
        const firstActive = document.querySelector('.legal-item.active .legal-content');
        if(firstActive) firstActive.style.maxHeight = firstActive.scrollHeight + "px";
    });
</script>

<?php include('includes/footer.php'); ?>