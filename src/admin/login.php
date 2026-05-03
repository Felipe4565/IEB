<?php
session_start();
require_once('../includes/db.php');

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // trim() retire les espaces invisibles avant/après l'email
    $user_input = trim($_POST['admin_user']); 
    $pass_input = $_POST['admin_pass'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$user_input]);
    $admin = $stmt->fetch();

    // On vérifie si l'admin existe ET si le mot de passe est valide
    if ($admin && password_verify($pass_input, $admin['mot_de_passe'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header('Location: index.php');
        exit();
    } else {
        $error = "IDENTIFIANTS INCORRECTS";
    }
}

// Définition du chemin pour le header intelligent
$base_path = '../'; 
include('../includes/header.php'); 
?>

<!-- Lien vers ton CSS spécifique -->
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
                    <p style="color: #d4af37; text-align: center; font-weight: bold; margin-bottom: 20px;">
                        <?= $error ?>
                    </p>
                <?php endif; ?>
                
                <div class="input-group">
                    <!-- Utilisation du type email pour une meilleure validation -->
                    <input type="email" name="admin_user" placeholder="EMAIL" required>
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