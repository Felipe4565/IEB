<?php
/**
 * Démarrage de session sécurisé + aides CSRF.
 * À inclure à la place de session_start() dans toutes les pages.
 */
if (session_status() === PHP_SESSION_NONE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_set_cookie_params([
        'lifetime' => 0,          // cookie supprimé à la fermeture du navigateur
        'path'     => '/',
        'secure'   => $https,     // HTTPS uniquement quand le site est en HTTPS
        'httponly' => true,       // inaccessible au JavaScript
        'samesite' => 'Lax',      // pas envoyé sur les requêtes POST venant d'autres sites
    ]);
    ini_set('session.use_strict_mode', '1');   // refuse un identifiant de session inventé
    ini_set('session.use_only_cookies', '1');  // jamais d'identifiant dans l'URL
    session_start();
}

// ---------- CSRF ----------
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}

function csrf_valid($token): bool {
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function csrf_deny(): void {
    http_response_code(403);
    exit('<p style="font-family:sans-serif;padding:40px">Action refusée : jeton de sécurité invalide ou expiré.<br>'
       . '<a href="index.php">Retour au tableau de bord</a></p>');
}

// Formulaires POST : vérifie le champ caché csrf_token
function csrf_require_post(): void {
    if (!csrf_valid($_POST['csrf_token'] ?? null)) csrf_deny();
}

// Liens d'action (suppression, restauration...) : vérifie le paramètre &t=
function csrf_require_get(): void {
    if (!csrf_valid($_GET['t'] ?? null)) csrf_deny();
}
