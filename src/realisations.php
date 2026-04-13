<?php 
include 'includes/header.php'; 
?>

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

    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-bar input');
    const filterButtons = document.querySelectorAll('.filters button');
    const cards = document.querySelectorAll('.card');

    function filterEverything() {
        const text = searchInput.value.toLowerCase().trim();
        const activeBtn = document.querySelector('.filters button.active');
        const filter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';

        cards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            const cat = card.getAttribute('data-cat');
            
            const matchText = title.includes(text);
            const matchFilter = (filter === 'all' || cat === filter);

            if (matchText && matchFilter) {
                card.classList.remove('hide');
            } else {
                card.classList.add('hide');
            }
        });
    }

    // On utilise 'input' pour une réaction immédiate
    searchInput.addEventListener('input', filterEverything);

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterEverything();
        });
    });
});
</script>

<?php 
include 'includes/footer.php'; 
?>