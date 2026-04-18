<?php include('includes/header.php'); ?>

<?php
$sections_faq = [
    ["q" => "Le devis est-il gratuit ?", "r" => "Oui, tous nos devis sont gratuits et sans engagement. Nous étudions votre projet et vous proposons une solution adaptée."],
    ["q" => "Quels sont vos délais de réponse ?", "r" => "Nous répondons généralement à toutes les demandes sous 24 à 48 heures."],
    ["q" => "Quels types de projets réalisez-vous ?", "r" => "Nous réalisons des projets de menuiserie intérieure et extérieure : cuisines, terrasses, escaliers, dressings, pergolas, ainsi que des créations sur mesure."],
    ["q" => "Proposez-vous du sur-mesure ?", "r" => "Oui, chaque projet peut être entièrement personnalisé selon vos besoins, vos envies et votre espace."],
    ["q" => "Travaillez-vous avec des particuliers et des professionnels ?", "r" => "Oui, nous accompagnons aussi bien les particuliers que les professionnels (commerces, bureaux, etc.)."],
    ["q" => "Dans quelle zone intervenez-vous ?", "r" => "Nous intervenons principalement en Île-de-France et ses alentours."],
    ["q" => "Comment se déroule un projet ?", "r" => "Après votre demande, nous échangeons avec vous pour comprendre vos besoins, puis nous établissons un devis. Une fois validé, nous planifions et réalisons les travaux."],
    ["q" => "Puis-je modifier mon projet après validation du devis ?", "r" => "Oui, des modifications sont possibles. Elles peuvent entraîner un ajustement du devis et des délais."],
    ["q" => "Quelles sont les modalités de paiement ?", "r" => "Les modalités de paiement sont précisées dans le devis (acompte à la commande, solde à la fin des travaux)."],
    ["q" => "Proposez-vous des déplacements pour étudier le projet ?", "r" => "Oui, nous pouvons nous déplacer afin d’analyser votre projet directement sur place."],
    ["q" => "Que faire si j’ai une question supplémentaire ?", "r" => "Vous pouvez nous contacter via le formulaire de contact ou faire une demande de devis. Nous serons ravis de vous répondre rapidement."]
];
?>

<link rel="stylesheet" href="css/faq.css">

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

        <h1 class="legal-main-title">FOIRE AUX QUESTIONS</h1>
        
        <div class="legal-accordion" id="faqAccordion">
            <?php foreach ($sections_faq as $index => $item): ?>
                <div class="legal-item">
                    <button class="legal-header">
                        <span class="legal-label"><?php echo $item['q']; ?></span>
                        <span class="legal-plus">+</span>
                    </button>
                    <div class="legal-content">
                        <div class="legal-inner">
                            <p class="legal-text"><?php echo $item['r']; ?></p>
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

                // Fermeture des autres questions
                accordionItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.legal-content').style.maxHeight = null;
                });

                // Ouverture de la question cliquée
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