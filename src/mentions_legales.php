<?php
$page_title = "Mentions légales | IEB";
$page_css = "css/mentions_legales.css";
include('includes/header.php');

$L = require __DIR__ . '/includes/legal.php';
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$H = $L['hebergeur'];
$mail = $e($L['email']);

$sections = [
    [
        "titre" => "INFORMATIONS GÉNÉRALES",
        "sous_titre" => "Éditeur du site",
        "texte" => "<p><strong>" . $e($L['societe']) . "</strong><br>nom commercial : " . $e($L['marque']) . "</p>"
                 . "<p>" . $e($L['forme']) . " au capital de " . $e($L['capital']) . "<br>"
                 . "Siège social : " . $e($L['adresse']) . "<br>"
                 . $e($L['rcs']) . "<br>"
                 . "SIREN : " . $e($L['siren']) . " – SIRET : " . $e($L['siret']) . "<br>"
                 . "N° de TVA intracommunautaire : " . $e($L['tva']) . "</p>"
                 . "<p>Email : <a href=\"mailto:$mail\">$mail</a><br>Téléphone : " . $e($L['telephone']) . "</p>",
    ],
    [
        "titre" => "RESPONSABLE DE LA PUBLICATION",
        "sous_titre" => $e($L['gerant']) . ", gérant de " . $e($L['societe']),
        "texte" => "<p>Pour toute question relative au site : <a href=\"mailto:$mail\">$mail</a> – " . $e($L['telephone']) . ".</p>",
    ],
    [
        "titre" => "HÉBERGEMENT",
        "sous_titre" => "Le site est hébergé par",
        "texte" => "<p>" . $e($H['nom']) . "<br>" . $e($H['adresse']) . "<br>Téléphone : " . $e($H['telephone']) . "<br>" . $e($H['site']) . "</p>",
    ],
    [
        "titre" => "PROPRIÉTÉ INTELLECTUELLE",
        "sous_titre" => "Droits d'auteur et marques",
        "texte" => "<p>L'ensemble des éléments du site (textes, photographies, logos, graphismes, structure) est la propriété de "
                 . $e($L['societe']) . " ou de ses partenaires et protégé par le droit d'auteur et le droit des marques. "
                 . "Toute reproduction, représentation ou adaptation, même partielle, est interdite sans accord écrit préalable.</p>"
                 . "<p>Les témoignages et photographies de clients sont publiés avec leur autorisation.</p>",
    ],
    [
        "titre" => "DONNÉES PERSONNELLES (RGPD)",
        "sous_titre" => "Responsable du traitement : " . $e($L['societe']),
        "texte" => "<p>Les données saisies dans nos formulaires (devis, contact, avis, liste d'invitation) sont utilisées uniquement pour répondre à vos demandes et gérer notre relation commerciale. "
                 . "Vous disposez d'un droit d'accès, de rectification, d'effacement, d'opposition, de limitation et de portabilité, ainsi que du droit de retirer votre consentement à tout moment.</p>"
                 . "<p>Le détail des traitements, des durées de conservation et la manière d'exercer vos droits figurent dans notre "
                 . "<a href=\"politique-confidentialite.php\">Politique de confidentialité</a>. Contact : <a href=\"mailto:$mail\">$mail</a>.</p>",
    ],
    [
        "titre" => "COOKIES ET TRACEURS",
        "sous_titre" => "Aucun traceur publicitaire ni outil de mesure d'audience",
        "texte" => "<p>Ce site n'utilise ni cookie publicitaire, ni outil de statistiques, ni réseau social intégré. "
                 . "Il dépose uniquement un <strong>cookie technique de session</strong>, indispensable au fonctionnement et à la sécurité des formulaires : "
                 . "il ne nécessite pas votre consentement et disparaît à la fermeture de votre navigateur.</p>"
                 . "<p>Les polices de caractères et les icônes sont hébergées sur le site : aucune donnée n'est transmise à un tiers à ce titre.</p>"
                 . (trim($L['calendly_url']) !== ''
                    ? "<p>Le calendrier de prise de rendez-vous est fourni par Calendly (États-Unis). Il n'est chargé que si vous cliquez sur « Afficher le calendrier » ; "
                      . "Calendly peut alors déposer ses propres cookies.</p>"
                    : "")
                 . "<p>Les liens vers Google Maps ou Instagram ne sont activés que si vous cliquez dessus.</p>",
    ],
    [
        "titre" => "DROIT APPLICABLE",
        "sous_titre" => "Litiges et juridiction",
        "texte" => "<p>Le site est soumis au droit français. Pour tout litige, une solution amiable sera recherchée en priorité. "
                 . "À défaut, et sous réserve des règles protectrices des consommateurs, les tribunaux de Melun sont compétents.</p>",
    ],
];
$open_first = true;
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

        <h1 class="legal-main-title">MENTIONS LÉGALES</h1>
        

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