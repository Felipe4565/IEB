<?php
/**
 * Aides pour les formulaires publics :
 *  - limite d'envois par adresse IP (anti-spam)
 *  - journal de consentement (preuve RGPD)
 * Les tables se créent automatiquement. En cas de problème de base, les
 * fonctions ne bloquent jamais le visiteur (elles écrivent dans les logs).
 */
const POLICY_VERSION = '2026-10';   // à changer quand la politique de confidentialité change

function forms_ensure_tables(PDO $pdo): void {
    static $done = false;
    if ($done) return;
    $pdo->exec("CREATE TABLE IF NOT EXISTS form_submissions (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        form VARCHAR(30) NOT NULL,
        ip VARCHAR(45) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_form_ip (form, ip, created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS consents (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        source VARCHAR(30) NOT NULL,
        ref VARCHAR(190) NOT NULL DEFAULT '',
        policy_version VARCHAR(20) NOT NULL,
        accepted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ref (ref)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $done = true;
}

function client_ip(): string {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// true si cette IP a déjà envoyé trop de formulaires "$form" récemment
function too_many_submissions(PDO $pdo, string $form, int $max = 5, int $minutes = 60): bool {
    try {
        forms_ensure_tables($pdo);
        $q = $pdo->prepare("SELECT COUNT(*) FROM form_submissions
                            WHERE form = ? AND ip = ?
                              AND created_at > (NOW() - INTERVAL " . (int)$minutes . " MINUTE)");
        $q->execute([$form, client_ip()]);
        return (int)$q->fetchColumn() >= $max;
    } catch (PDOException $e) {
        error_log('too_many_submissions : ' . $e->getMessage());
        return false;
    }
}

// Enregistre un envoi réussi (les anciennes lignes sont purgées après 2 jours)
function record_submission(PDO $pdo, string $form): void {
    try {
        forms_ensure_tables($pdo);
        $pdo->prepare("INSERT INTO form_submissions (form, ip) VALUES (?, ?)")->execute([$form, client_ip()]);
        if (random_int(1, 50) === 1) {
            $pdo->exec("DELETE FROM form_submissions WHERE created_at < (NOW() - INTERVAL 2 DAY)");
        }
    } catch (PDOException $e) {
        error_log('record_submission : ' . $e->getMessage());
    }
}

// Garde la preuve que la personne a accepté la politique de confidentialité
function record_consent(PDO $pdo, string $source, string $ref): void {
    try {
        forms_ensure_tables($pdo);
        $pdo->prepare("INSERT INTO consents (source, ref, policy_version) VALUES (?, ?, ?)")
            ->execute([$source, mb_substr($ref, 0, 190), POLICY_VERSION]);
    } catch (PDOException $e) {
        error_log('record_consent : ' . $e->getMessage());
    }
}
