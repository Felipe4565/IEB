<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="css/identification.css">

<main class="admin-login-page">
    <div class="admin-container">
        
        <div class="back-nav">
            <a href="index.php" class="minimal-back">
                <div class="arrow-wrapper">
                    <span class="arrow-head"></span>
                    <span class="line"></span>
                </div>
                <span class="text">RETOUR AU SITE</span>
            </a>
        </div>

        <div class="auth-card">
            <div class="auth-header">
                <span class="label-gold">Accès Restreint</span>
                <h1 class="serif-gold">ADMINISTRATION</h1>
                <div class="separator-line"></div>
            </div>

            <form action="traitement_admin.php" method="POST" class="auth-form">
                <div class="input-group">
                    <input type="text" name="admin_user" id="admin_user" placeholder="IDENTIFIANT" required>
                </div>

                <div class="input-group">
                    <input type="password" name="admin_pass" id="admin_pass" placeholder="MOT DE PASSE" required>
                </div>

                <button type="submit" class="btn-submit-gold-full">
                    ACCÉDER AU PANEL
                </button>
            </form>
            
            <p class="security-note">Espace sécurisé IEB - Connexion surveillée</p>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>