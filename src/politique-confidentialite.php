<?php include('includes/header.php'); ?>

<?php
$sections_privacy = [
    [
        "titre" => "PRÉAMBULE", 
        "texte" => "La protection de vos données personnelles est au cœur de nos engagements. Chez IEB (Intérieur Extérieur Bois), nous traitons vos informations avec la même précision que nos ouvrages en bois. Cette politique vous informe sur la manière dont nous collectons et protégeons vos données conformément au RGPD."
    ],
    [
        "titre" => "DONNÉES COLLECTÉES", 
        "texte" => "Nous collectons uniquement les informations nécessaires à la réalisation de vos projets : identité (nom, prénom), coordonnées (adresse email, numéro de téléphone), adresse de réalisation des travaux et détails techniques relatifs à votre projet de menuiserie."
    ],
    [
        "titre" => "FINALITÉS DU TRAITEMENT", 
        "texte" => "Vos données sont traitées pour des objectifs précis : établissement de devis personnalisés, gestion et suivi de vos chantiers, facturation et, avec votre accord, publication de témoignages ou photos de vos réalisations sur notre site."
    ],
    [
        "titre" => "DURÉE DE CONSERVATION", 
        "texte" => "Nous ne conservons pas vos données plus longtemps que nécessaire : 3 ans pour les demandes de devis n'ayant pas abouti à une commande, et 10 ans pour les dossiers clients (durée légale de conservation des documents comptables et contractuels)."
    ],
    [
        "titre" => "ACCÈS AUX DONNÉES", 
        "texte" => "Vos informations sont strictement réservées à l'usage interne de IEB. Elles ne sont jamais vendues, louées ou transmises à des tiers à des fins commerciales. Seuls nos prestataires techniques (hébergement du site) peuvent y avoir accès dans le cadre strict de leur mission de maintenance."
    ],
    [
        "titre" => "VOS DROITS & SUPPRESSION", 
        "texte" => "Conformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression de vos données. Vous pouvez retirer votre consentement à tout moment pour l'utilisation de vos photos ou de votre témoignage sur simple demande."
    ],
    [
        "titre" => "CONTACT RESPONSABLE", 
        "texte" => "Pour toute question concernant vos données ou pour exercer vos droits, vous pouvez nous contacter directement par email à : [TON_EMAIL] ou par courrier postal à l'adresse de notre atelier."
    ]
];
?>

<link rel="stylesheet" href="css/cgv.css">

<main class="legal-page">
    <div class="legal-container">
        
        <div class="back-nav">
            <a href="index.php" class="minimal-back">
                <div class="arrow-wrapper">
                    <span class="arrow-head"></span>
                    <span class="line"></span>
                </div>
                <span class="text">RETOUR À L'ACCUEIL</span>
            </a>
        </div>

        <h1 class="legal-main-title">POLITIQUE DE CONFIDENTIALITÉ</h1>
        
        <div class="legal-accordion" id="privacyAccordion">
            <?php foreach ($sections_privacy as $index => $section): ?>
                <div class="legal-item">
                    <button class="legal-header">
                        <span class="legal-label"><?php echo $section['titre']; ?></span>
                        <span class="legal-plus">+</span>
                    </button>
                    <div class="legal-content">
                        <div class="legal-inner">
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

                // Ferme toutes les autres sections
                accordionItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.legal-content').style.maxHeight = null;
                });

                // Ouvre la section actuelle
                if (!isActive) {
                    item.classList.add('active');
                    const content = item.querySelector('.legal-content');
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });
    });
</script>

<?php include('includes/footer.php'); ?>