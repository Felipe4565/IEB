<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="css/laisser_avis.css">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

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
                <p class="form-subtitle">L'excellence au service de votre projet</p>
            </div>

            <form action="traitement-avis.php" method="POST" enctype="multipart/form-data" class="avis-form" id="avisForm" novalidate>
                
                <div class="rating-select">
                    <span class="label-gold">Notez votre expérience</span>
                    <div class="rating-text" id="rating-desc">Sélectionnez vos étoiles</div>
                    <div class="stars-input" id="stars-container">
                        <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                        <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                        <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                        <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                        <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" name="nom" id="nom-input" placeholder="Sous quel nom signer ce témoignage ?" autocomplete="off">
                </div>

                <div class="input-group">
                    <span class="label-gold" style="text-align: left; font-size: 0.75rem; margin-bottom: 15px;">Type de réalisation</span>
                    <div class="project-tags" id="project-tags">
                        <div class="tag" data-value="Terrasse">Terrasse</div>
                        <div class="tag" data-value="Cuisine">Cuisine</div>
                        <div class="tag" data-value="Escalier">Escalier</div>
                        <div class="tag" data-value="Meuble sur-mesure">Meuble</div>
                        <div class="tag" data-value="Plan de travail">Plan de travail</div>
                        <div class="tag" data-value="Intérieur">Intérieur</div>
                        <div class="tag" data-value="Extérieur">Extérieur</div>
                    </div>
                    <input type="hidden" name="projet" id="projet-selected">
                </div>

                <div class="input-group">
                    <textarea name="message" id="message-input" rows="5" placeholder="Racontez-nous l'essence de votre projet..." spellcheck="false"></textarea>
                </div>

                <div class="file-upload" id="drop-zone">
                    <label for="photo-chantier" class="file-label">
                        <div class="upload-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#C5A059" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        </div>
                        <span class="text" id="file-label-text">Cliquez ou glissez une photo du projet terminé</span>
                    </label>
                    <input type="file" id="photo-chantier" name="photo" accept="image/*">
                    
                    <div id="image-preview-container" style="display: none; margin-top: 20px;">
                        <img id="image-preview" src="#" alt="Aperçu" style="max-width: 150px; border: 1px solid var(--gold); padding: 5px;">
                        <p id="file-name-display" style="font-size: 10px; color: var(--gold); margin-top: 5px;"></p>
                    </div>
                </div>

                <button type="submit" class="btn-submit-gold" id="submit-btn">Publier mon avis</button>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('avisForm');
    const wrapper = document.querySelector('.form-wrapper');
    const submitBtn = document.getElementById('submit-btn');
    
    const tags = document.querySelectorAll('.tag');
    const tagsContainer = document.getElementById('project-tags');
    const hiddenInput = document.getElementById('projet-selected');
    
    const starsContainer = document.getElementById('stars-container');
    const stars = document.querySelectorAll('.stars-input input');
    const ratingDesc = document.getElementById('rating-desc');
    
    const nomInput = document.getElementById('nom-input');
    const messageInput = document.getElementById('message-input');
    
    const fileInput = document.getElementById('photo-chantier');
    const dropZone = document.getElementById('drop-zone');

    const labels = {'5':'Excellent','4':'Très bien','3':'Bien','2':'Moyen','1':'Insatisfaisant'};

    // 1. EFFET PARALLAXE SOURIS
    document.addEventListener('mousemove', (e) => {
        let xAxis = (window.innerWidth / 2 - e.pageX) / 100;
        let yAxis = (window.innerHeight / 2 - e.pageY) / 100;
        wrapper.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
    });

    // 2. GESTION DES TAGS
    tags.forEach(tag => {
        tag.addEventListener('click', function() {
            tags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            hiddenInput.value = this.getAttribute('data-value');
            tagsContainer.style.boxShadow = "none"; 
        });
    });

    // 3. GESTION DES ÉTOILES
    stars.forEach(star => {
        star.addEventListener('change', (e) => {
            ratingDesc.innerText = labels[e.target.value];
            ratingDesc.style.color = "#C5A059";
            starsContainer.style.filter = "none";
        });
    });

    // 4. APERÇU IMAGE
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

    // 5. VALIDATION FINALE AU SUBMIT
    form.addEventListener('submit', function(e) {
        let errors = [];

        // Check Étoiles
        const starChecked = document.querySelector('input[name="rating"]:checked');
        if (!starChecked) {
            errors.push("Note (étoiles)");
            starsContainer.style.filter = "drop-shadow(0 0 8px #ff4d4d)";
            ratingDesc.innerText = "⚠️ Note obligatoire";
            ratingDesc.style.color = "#ff4d4d";
        }

        // Check Nom
        if (nomInput.value.trim() === "") {
            errors.push("Votre nom");
            nomInput.style.borderBottomColor = "#ff4d4d";
        } else {
            nomInput.style.borderBottomColor = "";
        }

        // Check Tags
        if (!hiddenInput.value) {
            errors.push("Type de réalisation");
            tagsContainer.style.boxShadow = "0 0 10px rgba(255, 77, 77, 0.5)";
        }

        // Check Message
        if (messageInput.value.trim() === "") {
            errors.push("Votre message");
            messageInput.style.borderBottomColor = "#ff4d4d";
        } else {
            messageInput.style.borderBottomColor = "";
        }

        if (errors.length > 0) {
            e.preventDefault(); 
            
            alert("Veuillez remplir les champs suivants : \n- " + errors.join("\n- "));

            // Vibration du formulaire
            wrapper.animate([
                { transform: 'translateX(-5px) rotateX(0) rotateY(0)' },
                { transform: 'translateX(5px) rotateX(0) rotateY(0)' },
                { transform: 'translateX(-5px) rotateX(0) rotateY(0)' },
                { transform: 'translateX(0) rotateX(0) rotateY(0)' }
            ], { duration: 300 });

            return false;
        }

        // Si tout est valide
        submitBtn.classList.add('sending');
        submitBtn.innerText = "Envoi en cours...";
    });

    // 6. DRAG & DROP VISUEL
    ['dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, e => {
            e.preventDefault();
            if (eventName === 'dragover') {
                dropZone.style.background = "rgba(197, 160, 89, 0.1)";
            } else {
                dropZone.style.background = "transparent";
            }
        });
    });
});
</script>

<?php include('includes/footer.php'); ?>