<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="css/realisations.css">

<main class="portfolio-page">
    <section class="hero">
        <p class="subtitle">Un héritage de projets d'excellence</p>
        <h1>NOS RÉALISATIONS</h1>
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
        
        <div class="card" data-cat="interieur">
            <img src="/assets/img/realisations/cuisine.jpg" alt="Cuisine sur mesure">
            <div class="card-overlay">
                <span>Menuiserie Intérieure</span>
                <h3>Cuisine moderne en chêne massif</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="interieur">
            <img src="/assets/img/realisations/escalier.jpg" alt="Escalier bois">
            <div class="card-overlay">
                <span>Menuiserie Intérieure</span>
                <h3>Escalier suspendu & Garde-corps design</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="exterieur">
            <img src="/assets/img/realisations/terasse.jpg" alt="Terrasse bois">
            <div class="card-overlay">
                <span>Menuiserie Extérieure</span>
                <h3>Terrasse en Ipé & Éclairage intégré</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="exterieur">
            <img src="/assets/img/realisations/pergola.jpg" alt="Pergola">
            <div class="card-overlay">
                <span>Menuiserie Extérieure</span>
                <h3>Pergola bioclimatique en Douglas</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="sur-mesure">
            <img src="/assets/img/realisations/dressing.jpg" alt="Dressing">
            <div class="card-overlay">
                <span>Sur-mesure</span>
                <h3>Dressing complet sous combles</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="sur-mesure">
            <img src="/assets/img/realisations/table_conf.jpg" alt="Mobilier unique">
            <div class="card-overlay">
                <span>Sur-mesure</span>
                <h3>Table de conférence en Noyau local</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="renovation">
            <img src="/assets/img/realisations/renovation.jpg" alt="Rénovation">
            <div class="card-overlay">
                <span>Rénovation</span>
                <h3>Rénovation d'un appartement Haussmannien</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="pro">
            <img src="/assets/img/realisations/technologie.jpg" alt="Agencement pro">
            <div class="card-overlay">
                <span>Projets Professionnels</span>
                <h3>Espace Coworking - Agencement bois & acoustique</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

        <div class="card" data-cat="pro">
            <img src="/assets/img/realisations/comptoir.jpg" alt="Comptoir accueil">
            <div class="card-overlay">
                <span>Projets Professionnels</span>
                <h3>Comptoir d'accueil - Boutique de luxe</h3>
                <button class="btn-more">En savoir plus</button>
            </div>
        </div>

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
    // Sélection des éléments
    const searchInput = document.querySelector('.search-bar input');
    const filterButtons = document.querySelectorAll('.filters button');
    const cards = document.querySelectorAll('.card');
    const noResults = document.getElementById('no-results');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadMoreContainer = document.querySelector('.load-more-container');

    // Configuration du nombre d'images
    let itemsToShow = 6; // Nombre de projets affichés par défaut

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
        
        let visibleCount = 0;      // Cartes réellement affichées (sous la limite)
        let totalMatchCount = 0;   // Cartes qui correspondent aux critères (indépendamment de la limite)

        cards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            const cat = card.getAttribute('data-cat');
            
            // 1. Vérification des critères (Texte + Filtre)
            const matchText = title.includes(text);
            const matchFilter = (filter === 'all' || cat === filter);

            if (matchText && matchFilter) {
                totalMatchCount++;
                
                // 2. Gestion de la limite "Charger plus"
                if (totalMatchCount <= itemsToShow) {
                    card.classList.remove('hide', 'hidden-load');
                    visibleCount++;
                } else {
                    // La carte correspond mais dépasse la limite actuelle
                    card.classList.add('hidden-load');
                    card.classList.remove('hide');
                }
            } else {
                // La carte ne correspond pas du tout
                card.classList.add('hide');
                card.classList.remove('hidden-load');
            }
        });

        // Affichage du bouton "Voir plus" si des cartes restent cachées
        if (totalMatchCount > itemsToShow) {
            loadMoreContainer.classList.remove('hide');
        } else {
            loadMoreContainer.classList.add('hide');
        }

        // Affichage du message "Aucun résultat" si visibleCount est à 0
        if (totalMatchCount === 0) {
            noResults.classList.remove('hide');
        } else {
            noResults.classList.add('hide');
        }
    }

    // --- Événements ---

    // Bouton Charger plus : on augmente la limite de 6
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            itemsToShow += 6;
            filterEverything();
        });
    }

    // Recherche : on remet la limite à 6 pour ne pas inonder l'écran
    searchInput.addEventListener('input', () => {
        itemsToShow = 6;
        filterEverything();
    });

    // Boutons de filtres : on remet la limite à 6
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            itemsToShow = 6; 
            filterEverything();
        });
    });

    // Lancement initial au chargement de la page
    filterEverything();
});
</script>

<?php 
include 'includes/footer.php'; 
?>