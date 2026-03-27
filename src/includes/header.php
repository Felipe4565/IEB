<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'IEB - Intérieur Extérieur Bois'; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
    
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="<?php echo $page_css; ?>">
    <?php endif; ?>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/img/logo_ieb.jpg" alt="IEB - Intérieur Extérieur Bois">
                </a>
            </div>

            <nav class="nav-menu">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="services.php">Nos Services</a></li>
                    <li><a href="realisations.php">Réalisations</a></li>
                    <li><a href="entreprise.php">L'Atelier</a></li>
                    <li><a href="avis.php">Avis</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="contact.php" class="btn-contact-pill">Contact & Devis</a>
            </div>
        </div>
    </header>