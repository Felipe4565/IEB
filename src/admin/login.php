<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/db.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

const LOGIN_MAX_FAILS_IP    = 5;   // échecs max par adresse IP
const LOGIN_MAX_FAILS_EMAIL = 20;  // échecs max par email (toutes IP confondues)
const LOGIN_WINDOW_MIN      = 15;  // durée du blocage (minutes)

// Table des tentatives (créée automatiquement la première fois)
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS login_attempts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(45) NOT NULL,
        email VARCHAR(190) NOT NULL DEFAULT '',
        attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ip (ip, attempted_at),
        INDEX idx_email (email, attempted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Nettoyage occasionnel des vieilles tentatives
    if (random_int(1, 50) === 1) {
        $pdo->exec("DELETE FROM login_attempts WHERE attempted_at < (NOW() - INTERVAL 1 DAY)");
    }
} catch (PDOException $e) {
    error_log('login_attempts : ' . $e->getMessage());
}

$ip     = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$error  = '';
$notice = isset($_GET['expired']) ? 'Session expirée, merci de vous reconnecter.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['admin_user'] ?? ''));
    $pass  = $_POST['admin_pass'] ?? '';

    if (!csrf_valid($_POST['csrf_token'] ?? null)) {
        $error = 'SESSION INVALIDE, RECHARGEZ LA PAGE';
    } else {
        // 1. Trop d'échecs récents ?
        $q = $pdo->prepare("SELECT SUM(ip = ?) AS by_ip, SUM(email = ?) AS by_email
                            FROM login_attempts
                            WHERE attempted_at > (NOW() - INTERVAL " . LOGIN_WINDOW_MIN . " MINUTE)");
        $q->execute([$ip, $email]);
        $row = $q->fetch();
        $blocked = ((int)$row['by_ip'] >= LOGIN_MAX_FAILS_IP)
                || ((int)$row['by_email'] >= LOGIN_MAX_FAILS_EMAIL);

        if ($blocked) {
            $error = 'TROP DE TENTATIVES, RÉESSAYEZ DANS ' . LOGIN_WINDOW_MIN . ' MINUTES';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            // password_verify est toujours exécuté (même durée si l'email n'existe pas)
            $hash = $admin['mot_de_passe'] ?? password_hash('x-' . bin2hex(random_bytes(4)), PASSWORD_DEFAULT);
            $ok   = password_verify($pass, $hash) && $admin;

            if ($ok) {
                session_regenerate_id(true);            // nouvel identifiant après connexion
                unset($_SESSION['csrf_token']);         // nouveau jeton CSRF
                $_SESSION['admin_id']      = $admin['id'];
                $_SESSION['admin_email']   = $admin['email'];
                $_SESSION['last_activity'] = time();

                if (password_needs_rehash($admin['mot_de_passe'], PASSWORD_DEFAULT)) {
                    $pdo->prepare("UPDATE admins SET mot_de_passe = ? WHERE id = ?")
                        ->execute([password_hash($pass, PASSWORD_DEFAULT), $admin['id']]);
                }

                $pdo->prepare("DELETE FROM login_attempts WHERE ip = ? AND email = ?")->execute([$ip, $email]);

                header('Location: index.php');
                exit();
            }

            // Échec : on l'enregistre
            $pdo->prepare("INSERT INTO login_attempts (ip, email) VALUES (?, ?)")
                ->execute([$ip, mb_substr($email, 0, 190)]);
            $error = 'IDENTIFIANTS INCORRECTS';
        }
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
                <?= csrf_field() ?>

                <?php if ($notice): ?>
                    <p style="color: #c5a67c; text-align: center; margin-bottom: 20px;">
                        <?= htmlspecialchars($notice) ?>
                    </p>
                <?php endif; ?>

                <?php if ($error): ?>
                    <p style="color: #d4af37; text-align: center; font-weight: bold; margin-bottom: 20px;">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endif; ?>

                <div class="input-group">
                    <input type="email" name="admin_user" placeholder="EMAIL" autocomplete="username" required>
                </div>

                <div class="input-group">
                    <input type="password" name="admin_pass" placeholder="MOT DE PASSE" autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn-submit-gold-full">ACCÉDER AU PANEL</button>
            </form>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>