<?php
// 1. On place la logique de détection tout en haut
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'IEB - Intérieur Extérieur Bois'; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    
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
                    <li>
                        <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a>
                    </li>
                    <li>
                        <a href="services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Nos Services</a>
                    </li>
                    <li>
                        <a href="realisations.php" class="<?php echo ($current_page == 'realisations.php') ? 'active' : ''; ?>">Réalisations</a>
                    </li>
                    <li>
                        <a href="entreprise.php" class="<?php echo ($current_page == 'entreprise.php') ? 'active' : ''; ?>">L'Atelier</a>
                    </li>
                    <li>
                        <a href="avis.php" class="<?php echo ($current_page == 'avis.php') ? 'active' : ''; ?>">Avis</a>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="contact.php" class="btn-contact-pill">Contact & Devis</a>
            </div>
        </div>
    </header>

    
    <script>
        const header = document.querySelector('.main-header');
        let isScrolled = false;

        window.addEventListener('scroll', () => {
            const scrollValue = window.scrollY;

            // On active à 100px
            if (scrollValue > 100 && !isScrolled) {
                header.classList.add('scrolled');
                isScrolled = true;
            } 
            // On ne désactive QUE si on remonte vraiment haut (sous 20px)
            else if (scrollValue < 20 && isScrolled) {
                header.classList.remove('scrolled');
                isScrolled = false;
            }
        }, { passive: true });
    </script>