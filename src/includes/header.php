<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$current_page = basename($_SERVER['PHP_SELF']);
$base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'IEB - Intérieur Extérieur Bois'; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/header.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/element_flottant.css?v=<?php echo time(); ?>">
    
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="<?php echo $base_path . $page_css; ?>">
    <?php endif; ?>
</head>
<body>

    <div class="menu-overlay" id="menu-overlay"></div>

    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $base_path; ?>index.php">
                    <img src="<?php echo $base_path; ?>assets/img/logo_ieb.jpg" alt="IEB - Intérieur Extérieur Bois">
                </a>
            </div>

            <nav class="nav-menu" id="nav-menu">
                <ul>
                    <li style="--i:1"><a href="<?php echo $base_path; ?>index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a></li>
                    <li style="--i:2"><a href="<?php echo $base_path; ?>services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Nos Services</a></li>
                    <li style="--i:3"><a href="<?php echo $base_path; ?>realisations.php" class="<?php echo ($current_page == 'realisations.php') ? 'active' : ''; ?>">Réalisations</a></li>
                    <li style="--i:4"><a href="<?php echo $base_path; ?>entreprise.php" class="<?php echo ($current_page == 'entreprise.php') ? 'active' : ''; ?>">L'Atelier</a></li>
                    <li style="--i:5"><a href="<?php echo $base_path; ?>avis.php" class="<?php echo ($current_page == 'avis.php') ? 'active' : ''; ?>">Avis</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="<?php echo $base_path; ?>contact.php" class="btn-contact-pill">Devis</a>
                
                <button class="menu-toggle" id="menu-toggle" aria-label="Menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <script>
        const header = document.querySelector('.main-header');
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        const menuOverlay = document.getElementById('menu-overlay');
        const body = document.body;
        const html = document.documentElement;

        // Gestion du Scroll (Header réduit)
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });

        // Fonction Toggle Menu
        function toggleMenu() {
            const isOpen = navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', isOpen);

            // Bloque le scroll sur PC et Mobile
            if (isOpen) {
                body.style.overflow = 'hidden';
                html.style.overflow = 'hidden';
            } else {
                body.style.overflow = 'auto';
                html.style.overflow = 'auto';
            }
        }

        menuToggle.addEventListener('click', toggleMenu);
        menuOverlay.addEventListener('click', toggleMenu);

        // Fermeture automatique sur clic lien
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
                menuOverlay.classList.remove('active');
                body.style.overflow = 'auto';
                html.style.overflow = 'auto';
            });
        });
    </script>