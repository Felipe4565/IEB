<?php
// 1. Détection de la page actuelle
$current_page = basename($_SERVER['PHP_SELF']);

// 2. Détection automatique du dossier admin pour corriger les chemins
// Si l'URL contient "/admin/", on remonte d'un dossier avec "../"
$base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'IEB - Intérieur Extérieur Bois'; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Utilisation du $base_path pour que le CSS soit trouvé partout -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/header.css">
    
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="<?php echo $base_path . $page_css; ?>">
    <?php endif; ?>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $base_path; ?>index.php">
                    <!-- Chemin de l'image corrigé avec $base_path -->
                    <img src="<?php echo $base_path; ?>assets/img/logo_ieb.jpg" alt="IEB - Intérieur Extérieur Bois">
                </a>
            </div>

            <nav class="nav-menu">
                <ul>
                    <li>
                        <a href="<?php echo $base_path; ?>index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_path; ?>services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Nos Services</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_path; ?>realisations.php" class="<?php echo ($current_page == 'realisations.php') ? 'active' : ''; ?>">Réalisations</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_path; ?>entreprise.php" class="<?php echo ($current_page == 'entreprise.php') ? 'active' : ''; ?>">L'Atelier</a>
                    </li>
                    <li>
                        <a href="<?php echo $base_path; ?>avis.php" class="<?php echo ($current_page == 'avis.php') ? 'active' : ''; ?>">Avis</a>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="<?php echo $base_path; ?>contact.php" class="btn-contact-pill">Besoin d'un devis ?</a>
            </div>
        </div>
    </header>

    <script>
        const header = document.querySelector('.main-header');
        let isScrolled = false;

        window.addEventListener('scroll', () => {
            const scrollValue = window.scrollY;

            if (scrollValue > 100 && !isScrolled) {
                header.classList.add('scrolled');
                isScrolled = true;
            } 
            else if (scrollValue < 20 && isScrolled) {
                header.classList.remove('scrolled');
                isScrolled = false;
            }
        }, { passive: true });
    </script>