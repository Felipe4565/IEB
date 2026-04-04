<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="css/laisser_avis.css">

<section class="section-form-avis">
    <div class="container">
        
        <div class="form-navigation">
            <a href="avis.php" class="btn-back">
                <span class="icon">←</span> Retour aux avis
            </a>
        </div>

        <div class="form-wrapper">
            <div class="form-header">
                <h1 class="serif-gold">Votre Témoignage</h1>
                <p class="form-subtitle">Partagez votre expérience avec l'Atelier IEB</p>
            </div>

            <form action="traitement-avis.php" method="POST" enctype="multipart/form-data" class="avis-form">
                
                <div class="rating-select">
                    <span class="label-gold">Votre Note</span>
                    <div class="rating-text" id="rating-desc">Sélectionnez votre note</div>
                    <div class="stars-input">
                        <input type="radio" name="rating" value="5" id="star5" required><label for="star5">★</label>
                        <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                        <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                        <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                        <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" name="nom" placeholder="Votre Nom Complet" required>
                </div>

                <div class="input-group" style="z-index: 10;">
                    <span class="label-gold" style="text-align: left; font-size: 0.75rem; margin-bottom: 10px;">Type de réalisation</span>
                    <div class="project-tags" id="project-tags">
                        <div class="tag" data-value="Terrasse">Terrasse</div>
                        <div class="tag" data-value="Cuisine">Cuisine</div>
                        <div class="tag" data-value="Escalier">Escalier</div>
                        <div class="tag" data-value="Meuble sur-mesure">Meuble</div>
                        <div class="tag" data-value="Plan de travail">Plan de travail</div>
                        <div class="tag" data-value="Intérieur">Intérieur</div>
                        <div class="tag" data-value="Extérieur">Extérieur</div>
                    </div>
                    <input type="hidden" name="projet" id="projet-selected" required>
                </div>

                <div class="input-group">
                    <textarea name="message" rows="6" placeholder="Racontez-nous votre projet..." required></textarea>
                </div>

                <div class="file-upload">
                    <label for="photo-chantier" class="file-label">
                        <span class="text" id="file-label-text">Ajouter une photo de la réalisation</span>
                    </label>
                    <input type="file" id="photo-chantier" name="photo" accept="image/*">
                    <div id="image-preview-container" style="display: none;">
                        <img id="image-preview" src="#" alt="Aperçu">
                        <span id="file-name-display"></span>
                    </div>
                </div>

                <button type="submit" class="btn-submit-gold">Publier mon avis</button>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // SÉLECTION DES TAGS
    const tags = document.querySelectorAll('.tag');
    const hiddenInput = document.getElementById('projet-selected');

    tags.forEach(tag => {
        tag.onclick = function() {
            // Nettoyage
            tags.forEach(t => t.classList.remove('active'));
            // Activation
            this.classList.add('active');
            // Valeur
            hiddenInput.value = this.getAttribute('data-value');
        };
    });

    // NOTE ÉTOILES
    const stars = document.querySelectorAll('.stars-input input');
    const ratingDesc = document.getElementById('rating-desc');
    const labels = {'5':'Excellent','4':'Très bien','3':'Bien','2':'Moyen','1':'Insatisfaisant'};

    stars.forEach(star => {
        star.addEventListener('change', (e) => {
            ratingDesc.innerText = labels[e.target.value];
            ratingDesc.style.color = "#C5A059";
        });
    });

    // PREVIEW IMAGE
    const fileInput = document.getElementById('photo-chantier');
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
                document.getElementById('file-name-display').innerText = this.files[0].name;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>

<?php include('includes/footer.php'); ?>