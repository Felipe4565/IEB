<?php
// Enregistre une image validée (JPG, PNG, WebP, 5 Mo max). Retourne le nom du fichier, ou null si refusée.
function save_image(array $file, string $dir, string $prefix = ''): ?string {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > 5 * 1024 * 1024) return null;            // 5 Mo max
    if (!is_uploaded_file($file['tmp_name'])) return null;

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$mime])) return null;                     // vrai type, pas l'extension
    if (@getimagesize($file['tmp_name']) === false) return null;  // c'est bien une image

    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return null;

    $prefix = preg_replace('/[^a-z0-9-]/i', '', $prefix);         // pas de ../ possible
    $name = $prefix . bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    return move_uploaded_file($file['tmp_name'], rtrim($dir, '/') . '/' . $name) ? $name : null;
}

// Enregistre une pièce jointe de devis (JPG, PNG ou PDF, 10 Mo max).
function save_attachment(array $file, string $dir, string $prefix = ''): ?string {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > 10 * 1024 * 1024) return null;           // 10 Mo max
    if (!is_uploaded_file($file['tmp_name'])) return null;

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$mime])) return null;

    if ($mime === 'application/pdf') {
        if (file_get_contents($file['tmp_name'], false, null, 0, 5) !== '%PDF-') return null;
    } elseif (@getimagesize($file['tmp_name']) === false) {
        return null;
    }

    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return null;

    $prefix = preg_replace('/[^a-z0-9-]/i', '', $prefix);
    $name = $prefix . bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    return move_uploaded_file($file['tmp_name'], rtrim($dir, '/') . '/' . $name) ? $name : null;
}

// Extrait le fichier n°$i d'un champ multiple (galerie[])
function file_at(array $files, int $i): array {
    return [
        'name' => $files['name'][$i], 'tmp_name' => $files['tmp_name'][$i],
        'error' => $files['error'][$i], 'size' => $files['size'][$i],
    ];
}
