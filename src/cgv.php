<?php
$page_title = "Conditions générales de vente | IEB";
$page_css = "css/mentions_legales.css";
include('includes/header.php');

$L = require __DIR__ . '/includes/legal.php';
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$mail = $e($L['email']);
$M = $L['mediateur'];
$A = $L['assurance'];

$assurances = '';
if (trim($A['decennale']) !== '') $assurances .= "<li>Assurance décennale : " . $e($A['decennale']) . "</li>";
if (trim($A['rc_pro']) !== '')    $assurances .= "<li>Responsabilité civile professionnelle : " . $e($A['rc_pro']) . "</li>";

$sections = [
    [
        "titre" => "OBJET ET CHAMP D'APPLICATION",
        "texte" => "<p>Les présentes conditions générales de vente (CGV) régissent les prestations de conception, fabrication et, le cas échéant, installation d'ouvrages en bois "
                 . "(menuiserie intérieure, extérieure, mobilier et aménagements sur mesure) proposées par " . $e($L['societe']) . " (« IEB »), "
                 . $e($L['adresse']) . ", " . $e($L['rcs']) . ".</p>"
                 . "<p>Elles s'appliquent aux clients consommateurs (particuliers) et aux clients professionnels. Elles sont communiquées avec le devis ; la signature du devis vaut acceptation.</p>",
    ],
    [
        "titre" => "DEVIS ET COMMANDE",
        "texte" => "<p>Les devis sont gratuits, établis sur demande et valables <strong>30 jours</strong> à compter de leur émission. "
                 . "Le contrat est formé à la signature du devis par le client, avec la mention « Bon pour accord ». "
                 . "Toute modification du projet doit être validée par écrit et peut entraîner un nouveau devis.</p>",
    ],
    [
        "titre" => "PRIX",
        "texte" => "<p>Les prix sont indiqués en euros, toutes taxes comprises (TTC) pour les consommateurs et hors taxes (HT) pour les professionnels, TVA au taux en vigueur. "
                 . "Ils sont fermes pour le projet décrit au devis ; toute modification demandée par le client peut les faire évoluer.</p>",
    ],
    [
        "titre" => "PAIEMENT",
        "texte" => "<p>Les modalités (acompte à la commande, solde à la réception des travaux) figurent sur le devis. "
                 . "Tout retard de paiement entraîne l'exigibilité de pénalités calculées au taux de trois fois le taux d'intérêt légal ; "
                 . "pour les clients professionnels s'ajoute une indemnité forfaitaire de 40 € pour frais de recouvrement.</p>"
                 . "<p>Les ouvrages restent la propriété d'IEB jusqu'au paiement complet du prix.</p>",
    ],
    [
        "titre" => "DÉLAIS",
        "texte" => "<p>Les délais sont indiqués à titre prévisionnel sur le devis. IEB informe le client de tout retard prévisible. "
                 . "Le consommateur dispose des recours prévus par le Code de la consommation (articles L. 216-2 et suivants) si l'ouvrage n'est pas livré ou exécuté à la date convenue.</p>",
    ],
    [
        "titre" => "DROIT DE RÉTRACTATION (CONSOMMATEURS)",
        "texte" => "<p>Lorsque le contrat est conclu à distance ou hors établissement (par exemple signé à votre domicile), le consommateur dispose de <strong>14 jours</strong> pour se rétracter, "
                 . "sans avoir à se justifier, en adressant une demande claire à <a href=\"mailto:$mail\">$mail</a> ou par courrier à l'adresse d'IEB.</p>"
                 . "<p>Ce droit ne s'applique pas aux biens confectionnés selon les spécifications du consommateur ou nettement personnalisés, ni aux prestations dont l'exécution a commencé "
                 . "à sa demande expresse avant la fin du délai, dans les conditions prévues par le Code de la consommation.</p>",
    ],
    [
        "titre" => "ANNULATION",
        "texte" => "<p>En cas d'annulation par le client après signature du devis, en dehors du droit de rétractation, IEB peut demander une indemnité correspondant aux frais réellement engagés "
                 . "(matières commandées, temps de conception, travaux déjà réalisés), dans la limite du préjudice subi.</p>",
    ],
    [
        "titre" => "RÉCEPTION DES TRAVAUX",
        "texte" => "<p>La réception donne lieu à un procès-verbal signé par les deux parties, avec ou sans réserves. Les réserves sont levées dans un délai convenu entre les parties.</p>",
    ],
    [
        "titre" => "GARANTIES ET ASSURANCES",
        "texte" => "<p>Les ouvrages bénéficient des garanties légales : garantie légale de conformité (consommateurs), garantie contre les vices cachés, "
                 . "et, lorsque les travaux en relèvent, garantie de parfait achèvement, garantie biennale et garantie décennale.</p>"
                 . ($assurances !== '' ? "<ul>$assurances</ul>" : ""),
    ],
    [
        "titre" => "RESPONSABILITÉ",
        "texte" => "<p>Sans préjudice des droits légaux du consommateur, IEB n'est pas responsable des dommages résultant d'une mauvaise utilisation de l'ouvrage ou d'un défaut d'entretien. "
                 . "Sauf faute lourde ou dol, la responsabilité d'IEB à l'égard des clients professionnels est limitée aux dommages directs et au montant de la prestation.</p>",
    ],
    [
        "titre" => "RÉCLAMATIONS ET MÉDIATION",
        "texte" => "<p>Pour toute réclamation, écrivez à <a href=\"mailto:$mail\">$mail</a>. À défaut de solution amiable, le consommateur peut recourir gratuitement au médiateur de la consommation :</p>"
                 . "<p>" . $e($M['nom']) . "<br>" . $e($M['adresse']) . "<br>" . $e($M['site']) . "</p>",
    ],
    [
        "titre" => "DONNÉES PERSONNELLES",
        "texte" => "<p>Les données collectées sont traitées conformément à notre <a href=\"politique-confidentialite.php\">Politique de confidentialité</a>.</p>",
    ],
    [
        "titre" => "DROIT APPLICABLE ET LITIGES",
        "texte" => "<p>Les présentes CGV sont soumises au droit français. En cas de litige, une solution amiable sera recherchée avant toute action. "
                 . "À défaut, les tribunaux compétents sont ceux désignés par les règles légales ; le consommateur peut notamment saisir la juridiction de son domicile ou celle du lieu d'exécution des travaux. "
                 . "Pour les clients professionnels, le tribunal de commerce de Melun est seul compétent.</p>",
    ],
];
$open_first = false;
?>

<style>
    .legal-text p { margin: 0 0 12px; }
    .legal-text ul { margin: 6px 0 14px 22px; list-style: disc; }
    .legal-text li { margin-bottom: 6px; }
    .legal-text a { color: #c5a67c; text-decoration: underline; }
    .legal-meta { text-align: center; color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 1px; margin: -40px 0 50px; }
</style>

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
        <p class="legal-meta">Dernière mise à jour : <?= $e($L['cgv_date']) ?></p>

        <div class="legal-accordion" id="legalAccordion">
            <?php foreach ($sections as $index => $section): ?>
                <div class="legal-item <?php echo ($index === 0 && $open_first) ? 'active' : ''; ?>">
                    <button class="legal-header">
                        <span class="legal-label"><?php echo $section['titre']; ?></span>
                        <span class="legal-plus">+</span>
                    </button>
                    <div class="legal-content">
                        <div class="legal-inner">
                            <?php if (!empty($section['sous_titre'])): ?>
                                <span class="legal-subtitle"><?php echo $section['sous_titre']; ?></span>
                            <?php endif; ?>
                            <div class="legal-text"><?php echo $section['texte']; ?></div>
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

                accordionItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.legal-content').style.maxHeight = null;
                });

                if (!isActive) {
                    item.classList.add('active');
                    const content = item.querySelector('.legal-content');
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });

        const firstActive = document.querySelector('.legal-item.active .legal-content');
        if (firstActive) firstActive.style.maxHeight = firstActive.scrollHeight + "px";
    });
</script>

<?php include('includes/footer.php'); ?>
