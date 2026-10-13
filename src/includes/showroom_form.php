<?php
// Bloc de préinscription au showroom. À inclure dans services.php :
//   <?php include('includes/showroom_form.php'); ?>
// (la session est déjà démarrée par includes/header.php)
$sr_ok  = $_SESSION['showroom_success'] ?? null;
$sr_err = $_SESSION['showroom_error'] ?? null;
unset($_SESSION['showroom_success'], $_SESSION['showroom_error']);
?>
<style>
    #showroom { padding: 90px 20px; text-align: center; }
    #showroom .showroom-box { max-width: 620px; margin: 0 auto; border: 1px solid rgba(197,166,124,0.35); padding: 50px 40px; }
    #showroom .showroom-eyebrow { font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase; color: var(--gold, #C5A059); margin-bottom: 15px; }
    #showroom h2 { font-family: 'Playfair Display', serif; color: var(--gold, #C5A059); font-size: 2rem; margin-bottom: 15px; }
    #showroom p.showroom-text { color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 30px; }
    #showroom input[type="email"], #showroom input[type="text"] {
        width: 100%; box-sizing: border-box; background: transparent; border: 0;
        border-bottom: 1px solid rgba(255,255,255,0.25); color: #fff; padding: 14px 4px;
        margin-bottom: 18px; font-size: 0.95rem; font-family: inherit; outline: none;
    }
    #showroom input:focus { border-bottom-color: var(--gold, #C5A059); }
    #showroom .showroom-consent { display: flex; gap: 12px; align-items: flex-start; text-align: left; margin: 10px 0 25px; cursor: pointer; }
    #showroom .showroom-consent span { color: rgba(255,255,255,0.6); font-size: 0.78rem; line-height: 1.5; }
    #showroom .showroom-consent a { color: #c5a67c; text-decoration: underline; }
    #showroom .showroom-btn { background: var(--gold, #C5A059); color: #000; border: 0; padding: 15px 38px; letter-spacing: 2px; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; cursor: pointer; }
    #showroom .showroom-btn:hover { opacity: 0.85; }
    #showroom .showroom-msg { padding: 14px 18px; margin-bottom: 25px; font-size: 0.9rem; border-left: 3px solid; text-align: left; }
    #showroom .showroom-msg.ok  { border-color: #5fbf8a; color: #bfe8d0; background: rgba(95,191,138,0.08); }
    #showroom .showroom-msg.err { border-color: #ff6b6b; color: #ffb3b3; background: rgba(255,107,107,0.08); }
</style>

<section id="showroom">
    <div class="showroom-box">
        <p class="showroom-eyebrow">Invitation exclusive</p>
        <h2>Ouverture du showroom</h2>
        <p class="showroom-text">
            Notre showroom ouvre bientôt. Inscrivez-vous pour faire partie des premiers invités :
            vous recevrez votre invitation en avant-première, avant toute annonce publique.
        </p>

        <?php if ($sr_ok): ?>
            <div class="showroom-msg ok"><?= htmlspecialchars($sr_ok) ?></div>
        <?php elseif ($sr_err): ?>
            <div class="showroom-msg err"><?= htmlspecialchars($sr_err) ?></div>
        <?php endif; ?>

        <form action="process_showroom.php" method="POST" novalidate>
            <?= csrf_field() ?>
            <div style="display:none;">
                <input type="text" name="hp_check_url" autocomplete="off" tabindex="-1">
            </div>

            <input type="text" name="prenom" placeholder="PRÉNOM (FACULTATIF)" maxlength="100" autocomplete="given-name">
            <input type="email" name="email" placeholder="VOTRE ADRESSE EMAIL" maxlength="190" required autocomplete="email">

            <label class="showroom-consent">
                <input type="checkbox" name="rgpd_consent" required style="margin-top:3px; accent-color:#c5a67c;">
                <span>
                    J'accepte que mon adresse email soit utilisée par IEB pour m'envoyer l'invitation à l'ouverture
                    du showroom. Je peux me désinscrire à tout moment en écrivant à IEB.
                    Consultez notre <a href="politique-confidentialite.php" target="_blank" rel="noopener">Politique de Confidentialité</a>.
                </span>
            </label>

            <button type="submit" class="showroom-btn">Je m'inscris</button>
        </form>
    </div>
</section>