<?php
$page_title = "Politique de confidentialité | IEB";
$page_css = "css/mentions_legales.css";
include('includes/header.php');

require_once __DIR__ . '/includes/forms.php';   // constante POLICY_VERSION
$L = require __DIR__ . '/includes/legal.php';
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$mail = $e($L['email']);
$H = $L['hebergeur'];
$calendly_on = trim($L['calendly_url']) !== '';

$sections = [
    [
        "titre" => "QUI EST RESPONSABLE DE VOS DONNÉES ?",
        "texte" => "<p><strong>" . $e($L['societe']) . "</strong> (" . $e($L['marque']) . "), " . $e($L['adresse']) . ", " . $e($L['rcs']) . ".</p>"
                 . "<p>Pour toute question sur vos données : <a href=\"mailto:$mail\">$mail</a>.</p>"
                 . "<p>Nous collectons uniquement les informations nécessaires à vos demandes. Nous ne vendons ni ne louons vos données.</p>",
    ],
    [
        "titre" => "DONNÉES COLLECTÉES ET POURQUOI",
        "texte" => "<ul>"
                 . "<li><strong>Demande de devis</strong> : nom, email, téléphone, ville, nature et description du projet, échéance, et les plans ou photos que vous joignez (PDF, JPG, PNG). "
                 .     "Finalité : étudier votre projet, vous répondre et établir un devis. Base légale : mesures précontractuelles à votre demande, et votre consentement.</li>"
                 . "<li><strong>Message de contact</strong> : nom, email, sujet, message. Finalité : vous répondre. Base légale : votre consentement.</li>"
                 . "<li><strong>Témoignage client</strong> : nom de signature, note, type de réalisation, commentaire et photos. Finalité : publication sur le site après validation de notre part. "
                 .     "Base légale : votre consentement. Merci de ne pas joindre de photos où figurent des personnes identifiables.</li>"
                 . "<li><strong>Liste d'invitation au showroom</strong> : email et prénom (facultatif). Finalité : vous envoyer l'invitation à l'ouverture. Base légale : votre consentement.</li>"
                 . ($calendly_on ? "<li><strong>Prise de rendez-vous</strong> : les informations saisies dans le calendrier Calendly (nom, email, créneau). Finalité : organiser le rendez-vous.</li>" : "")
                 . "<li><strong>Sécurité et lutte contre le spam</strong> : adresse IP lors de l'envoi d'un formulaire, conservée 2 jours pour limiter les envois abusifs. Base légale : intérêt légitime (sécurité du site).</li>"
                 . "<li><strong>Preuve de consentement</strong> : lorsque vous cochez une case, nous conservons la date, la version de cette politique ("
                 .     $e(POLICY_VERSION) . ") et votre email ou une référence. Base légale : obligation de pouvoir démontrer votre consentement.</li>"
                 . "</ul>",
    ],
    [
        "titre" => "À QUI SONT TRANSMISES VOS DONNÉES ?",
        "texte" => "<p>Elles sont accessibles uniquement aux personnes habilitées de " . $e($L['societe']) . ".</p>"
                 . "<p>Notre hébergeur, " . $e($H['nom']) . " (" . $e($H['adresse']) . "), les stocke en tant que sous-traitant technique, dans le cadre strict de sa mission.</p>"
                 . ($calendly_on ? "<p>Si vous utilisez le calendrier, Calendly (société américaine) reçoit les informations que vous y saisissez, selon sa propre politique de confidentialité.</p>" : "")
                 . "<p>Aucune autre transmission n'est effectuée, et aucune donnée n'est vendue.</p>",
    ],
    [
        "titre" => "COMBIEN DE TEMPS LES CONSERVONS-NOUS ?",
        "texte" => "<ul>"
                 . "<li>Demandes de devis et messages sans suite : <strong>3 ans</strong> après le dernier échange.</li>"
                 . "<li>Clients : pendant la relation contractuelle, puis <strong>5 ans</strong> (prescription), et <strong>10 ans</strong> pour les documents comptables.</li>"
                 . "<li>Pièces jointes à un devis non conclu : supprimées en même temps que la demande.</li>"
                 . "<li>Témoignages : tant qu'ils sont publiés ; vous pouvez demander leur retrait à tout moment.</li>"
                 . "<li>Liste d'invitation au showroom : jusqu'à l'ouverture et à l'envoi de l'invitation, puis suppression sous 3 mois, ou jusqu'à votre désinscription.</li>"
                 . "<li>Adresses IP anti-spam : <strong>2 jours</strong>.</li>"
                 . "<li>Preuves de consentement : durée du traitement concerné, puis <strong>5 ans</strong>.</li>"
                 . "</ul>",
    ],
    [
        "titre" => "VOS DROITS",
        "texte" => "<p>Vous pouvez à tout moment : accéder à vos données, les faire rectifier ou effacer, limiter leur traitement, vous y opposer, les récupérer dans un format courant (portabilité), "
                 . "retirer votre consentement (par exemple pour la publication d'un témoignage ou votre inscription à la liste showroom) et définir des directives sur le sort de vos données après votre décès.</p>"
                 . "<p>Écrivez-nous à <a href=\"mailto:$mail\">$mail</a> en précisant votre demande ; nous répondons dans un délai d'un mois. "
                 . "Nous pouvons vous demander un justificatif d'identité en cas de doute.</p>"
                 . "<p>Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une réclamation auprès de la CNIL : "
                 . "<a href=\"https://www.cnil.fr\" target=\"_blank\" rel=\"noopener\">www.cnil.fr</a> – 3 place de Fontenoy, TSA 80715, 75334 Paris Cedex 07.</p>",
    ],
    [
        "titre" => "SÉCURITÉ",
        "texte" => "<p>Nous protégeons vos données par des mesures adaptées : connexion chiffrée (HTTPS), accès à l'administration protégé par mot de passe et limitation des tentatives, "
                 . "contrôle des fichiers envoyés, dossiers de pièces jointes non accessibles publiquement, sauvegardes régulières.</p>",
    ],
    [
        "titre" => "COOKIES",
        "texte" => "<p>Le site n'utilise qu'un cookie technique de session, exempté de consentement, et aucun traceur publicitaire ou de mesure d'audience. "
                 . "Détails dans les <a href=\"mentions_legales.php\">mentions légales</a>.</p>",
    ],
    [
        "titre" => "MISES À JOUR",
        "texte" => "<p>Version " . $e(POLICY_VERSION) . " – dernière mise à jour : " . $e($L['cgv_date']) . ". "
                 . "En cas de changement important, la version sera modifiée et vous en serez informé sur cette page.</p>",
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

        <h1 class="legal-main-title">POLITIQUE DE CONFIDENTIALITÉ</h1>
        

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
