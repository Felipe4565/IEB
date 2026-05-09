<button id="scrollTop" class="control-btn" onclick="scrollToTop()" title="Retour en haut">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<a href="<?php echo $base_path; ?>index.php#contact" class="control-btn contact-bubble" title="Nous contacter">
    <i class="fa-solid fa-envelope"></i>
    <span class="bubble-text">Contact</span>
</a>

<script>
// Gestion de l'apparition du bouton retour en haut au scroll
window.addEventListener('scroll', function() {
    const scrollBtn = document.getElementById("scrollTop");
    // Le bouton apparaît après 400px de défilement
    if (window.scrollY > 400) {
        scrollBtn.classList.add("visible");
    } else {
        scrollBtn.classList.remove("visible");
    }
});

// Fonction pour un retour en haut fluide
function scrollToTop() {
    window.scrollTo({ 
        top: 0, 
        behavior: 'smooth' 
    });
}
</script>