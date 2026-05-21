<?php 
require_once 'includes/db.php'; 
include 'includes/header.php'; 

$query_txt = $pdo->query("SELECT cle, valeur FROM contenus WHERE cle LIKE 'realisations_%'");
$textes = $query_txt->fetchAll(PDO::FETCH_KEY_PAIR);

$txt_hero_subtitle = $textes['realisations_hero_subtitle'] ?? "Un héritage de projets d'excellence";
$txt_hero_title    = $textes['realisations_hero_title']    ?? "NOS RÉALISATIONS";

$query = $pdo->query("SELECT * FROM projets WHERE statut = 'publie' ORDER BY date_creation DESC");
$projets = $query->fetchAll();
?>

<link rel="stylesheet" href="css/realisations.css">

<main class="portfolio-page">
    <section class="hero">
        <p class="subtitle"><?= htmlspecialchars($txt_hero_subtitle) ?></p>
        <h1><?= htmlspecialchars($txt_hero_title) ?></h1>
    </section>

    <section class="filters-container">
        <div class="filters">
            <button class="active" data-filter="all">Tous</button>
            <button data-filter="interieur">Intérieur</button>
            <button data-filter="exterieur">Extérieur</button>
            <button data-filter="sur-mesure">Sur-mesure</button>
            <button data-filter="renovation">Rénovation</button>
            <button data-filter="pro">Professionnel</button>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Chercher un projet...">
        </div>
    </section>
    
    <section class="grid-portfolio">
        <?php foreach ($projets as $projet): ?>
            <div class="card" data-cat="<?= htmlspecialchars($projet['type']) ?>">
                <img src="<?= htmlspecialchars($projet['image_principale']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>">
                <div class="card-overlay">
                    <span><?= ucfirst(htmlspecialchars($projet['type'])) ?></span>
                    <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                    <a href="projet_detail.php?slug=<?= $projet['slug'] ?>" class="btn-more" style="text-decoration:none; display:inline-block;">
                        En savoir plus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

        <div id="no-results" class="hide" style="grid-column: 1 / -1; text-align: center; padding: 50px 0;">
            <p style="color: var(--text-gold); font-family: 'Playfair Display', serif; font-size: 20px;">
                Aucune réalisation ne correspond à votre recherche.
            </p>
        </div>
    </section>

    <div class="load-more-container" style="text-align: center; margin-top: 40px;">
        <button id="load-more-btn" class="btn-more" style="padding: 15px 30px;">Voir plus de réalisations</button>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-bar input');
    const filterButtons = document.querySelectorAll('.filters button');
    const cards = document.querySelectorAll('.card');
    const noResults = document.getElementById('no-results');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadMoreContainer = document.querySelector('.load-more-container');

    let itemsToShow = 6; 

    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');

    if (filterParam) {
        const targetBtn = document.querySelector(`.filters button[data-filter="${filterParam}"]`);
        if (targetBtn) {
            filterButtons.forEach(b => b.classList.remove('active'));
            targetBtn.classList.add('active');
        }
    }

    function filterEverything() {
        const text = searchInput.value.toLowerCase().trim();
        const activeBtn = document.querySelector('.filters button.active');
        const filter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
        
        let visibleCount = 0;      
        let totalMatchCount = 0;   

        cards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            const cat = card.getAttribute('data-cat');
            
            const matchText = title.includes(text);
            const matchFilter = (filter === 'all' || cat === filter);

            if (matchText && matchFilter) {
                totalMatchCount++;
                
                if (totalMatchCount <= itemsToShow) {
                    card.classList.remove('hide', 'hidden-load');
                    visibleCount++;
                } else {
                    card.classList.add('hidden-load');
                    card.classList.remove('hide');
                }
            } else {
                card.classList.add('hide');
                card.classList.remove('hidden-load');
            }
        });

        if (totalMatchCount > itemsToShow) {
            loadMoreContainer.classList.remove('hide');
        } else {
            loadMoreContainer.classList.add('hide');
        }

        if (totalMatchCount === 0) {
            noResults.classList.remove('hide');
        } else {
            noResults.classList.add('hide');
        }
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            itemsToShow += 6;
            filterEverything();
        });
    }

    searchInput.addEventListener('input', () => {
        itemsToShow = 6;
        filterEverything();
    });

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            itemsToShow = 6; 
            filterEverything();
        });
    });

    filterEverything();
});
</script>

<?php 
include 'includes/footer.php'; 
?>