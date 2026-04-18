<?php include('includes/header.php'); ?>

<?php
$sections_cgv = [
    ["titre" => "OBJET", "texte" => "Les présentes Conditions Générales de Vente (CGV) définissent les modalités de réalisation des prestations proposées par IEB – Intérieur Extérieur Bois, spécialisée dans les travaux de menuiserie intérieure et extérieure. Toute commande implique l’acceptation sans réserve des présentes CGV."],
    ["titre" => "PRESTATIONS", "texte" => "IEB propose des prestations de conception, fabrication et installation de réalisations en bois (menuiserie intérieure, extérieure et sur mesure). Les caractéristiques de chaque prestation sont détaillées dans le devis remis au client."],
    ["titre" => "DEVIS", "texte" => "Les devis sont gratuits et établis sur demande. Ils sont valables pendant une durée de 30 jours à compter de leur date d’émission. La commande est considérée comme validée après signature du devis par le client avec la mention « Bon pour accord »."],
    ["titre" => "PRIX", "texte" => "Les prix sont indiqués en euros (€) et peuvent être exprimés hors taxes (HT) ou toutes taxes comprises (TTC) selon le statut de l’entreprise. Les prix mentionnés sur le devis sont fermes, sauf modification du projet demandée par le client."],
    ["titre" => "MODALITÉS DE PAIEMENT", "texte" => "Les modalités de paiement sont précisées sur le devis. En général : un acompte peut être demandé à la signature du devis et le solde est à régler à la fin des travaux. Tout retard de paiement pourra entraîner des pénalités conformément à la législation en vigueur."],
    ["titre" => "DÉLAIS", "texte" => "Les délais de réalisation sont donnés à titre indicatif. IEB s’engage à informer le client en cas de retard éventuel, sans que cela puisse donner lieu à des dommages et intérêts."],
    ["titre" => "MODIFICATION ET ANNULATION", "texte" => "Toute demande de modification du projet doit être validée par écrit et peut entraîner une modification du devis. En cas d’annulation de la commande par le client après validation, l’acompte versé pourra être conservé à titre d’indemnisation."],
    ["titre" => "RESPONSABILITÉ", "texte" => "IEB ne pourra être tenue responsable des dommages résultant d’une mauvaise utilisation des installations ou d’un défaut d’entretien. La responsabilité de l’entreprise est limitée au montant de la prestation réalisée."],
    ["titre" => "GARANTIE", "texte" => "Les prestations réalisées bénéficient des garanties légales en vigueur."],
    ["titre" => "DONNÉES PERSONNELLES", "texte" => "Les informations collectées dans le cadre des devis et prestations sont utilisées uniquement pour le traitement des demandes clients. Elles ne sont ni vendues ni transmises à des tiers."],
    ["titre" => "DROIT APPLICABLE", "texte" => "Les présentes CGV sont soumises au droit français. En cas de litige, une solution amiable sera recherchée avant toute action judiciaire. À défaut, les tribunaux compétents seront ceux du ressort du siège social de l’entreprise."]
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

        <h1 class="legal-main-title">CONDITIONS GÉNÉRALES DE VENTE</h1>
        
        <div class="legal-accordion" id="cgvAccordion">
            <?php foreach ($sections_cgv as $index => $section): ?>
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

                // Ouvre la section actuelle si elle n'était pas déjà active
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