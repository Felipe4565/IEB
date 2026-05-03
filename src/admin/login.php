<?php
session_start();
require_once('../includes/db.php'); // On remonte pour la BDD

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = $_POST['admin_user'];
    $pass_input = $_POST['admin_pass'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$user_input]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($pass_input, $admin['mot_de_passe'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header('Location: index.php'); // Redirection vers le dashboard
        exit();
    } else {
        $error = "IDENTIFIANTS INCORRECTS";
    }
}

// On inclut le header de base qui est maintenant "intelligent"
include('../includes/header.php'); 
?>

<!-- On force le CSS du formulaire qui est aussi à la racine -->
<link rel="stylesheet" href="../css/identification.css">

<main class="admin-login-page">
    <div class="admin-container">
        <div class="auth-card">
            <div class="auth-header">
                <span class="label-gold">Accès Restreint</span>
                <h1 class="serif-gold">ADMINISTRATION</h1>
            </div>

            <form action="login.php" method="POST" class="auth-form">
                <?php if($error): ?>
                    <p style="color: #d4af37; text-align: center; font-weight: bold;"><?= $error ?></p>
                <?php endif; ?>
                
                <div class="input-group">
                    <input type="text" name="admin_user" placeholder="EMAIL" required>
                </div>
                <div class="input-group">
                    <input type="password" name="admin_pass" placeholder="MOT DE PASSE" required>
                </div>
                <button type="submit" class="btn-submit-gold-full">ACCÉDER AU PANEL</button>
            </form>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>