<?php
// On détecte si on est dans le dossier admin
$prefix = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IEB - Intérieur Extérieur Bois</title>
    
    <link rel="stylesheet" href="<?= $prefix ?>css/style.css">
    <link rel="stylesheet" href="<?= $prefix ?>css/header.css">
    
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="<?= $prefix . $page_css ?>">
    <?php endif; ?>
</head>