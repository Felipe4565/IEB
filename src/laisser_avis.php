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

            <form action="traitement_avis.php" method="POST" enctype="multipart/form-data" class="avis-form" id="avisForm" novalidate>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div style="display:none;">
                    <input type="text" name="hp_check_comment" autocomplete="off">
                </div>

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
                    <textarea name="message" id="message-input" rows="5" placeholder="Racontez-nous l'essence de votre projet..." maxlength="750" spellcheck="false"></textarea>
                    <div id="char-count" style="text-align: right; font-size: 0.6rem; color: rgba(255,255,255,0.4); margin-top: 5px;">
                        0 / 750 caractères
                    </div>
                </div>

                <div class="file-upload" id="drop-zone">
                <div class="file-upload" id="drop-zone">
                    <label for="photo-chantier" class="file-label">
                        <div class="upload-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#C5A059" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        </div>
                        <span class="text" id="file-label-text">Ajoutez une ou plusieurs photos de votre projet</span>
                    </label>
                    <input type="file" id="photo-chantier" name="photos[]" accept="image/*" multiple style="display:none;">
                    <div id="thumbnails-container" style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; justify-content: center;"></div>
                </div>

                <div class="rgpd-container" style="text-align: left; margin: 25px 0;">
                    <label style="display: flex; align-items: flex-start; cursor: pointer; gap: 12px;">
                        <input type="checkbox" name="rgpd_consent" id="rgpd_avis" required class="custom-rgpd-checkbox">
                        <span style="color: rgba(255,255,255,0.6); font-size: 0.8rem; line-height: 1.4;">
                            J'autorise IEB à publier mon témoignage et les photos associées sur son site internet. 
                            Consultez notre <a href="politique-confidentialite.php" target="_blank" style="color: #C5A67C; text-decoration: underline;">Politique de Confidentialité</a>.
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-submit-gold" id="submit-btn">Publier mon avis</button>

                <button type="submit" class="btn-submit-gold" id="submit-btn">Publier mon avis</button>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. DÉCLARATION DES VARIABLES (UNE SEULE FOIS)
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
    const thumbnailsContainer = document.getElementById('thumbnails-container');
    const charCount = document.getElementById('char-count');
    
    const MAX_CHARS = 750;
    const labels = {'5':'Excellent','4':'Très bien','3':'Bien','2':'Moyen','1':'Insatisfaisant'};
    
    // Conteneur pour le cumul des fichiers
    let allFiles = new DataTransfer();

    // 2. EFFET PARALLAXE SOURIS
    document.addEventListener('mousemove', (e) => {
        let xAxis = (window.innerWidth / 2 - e.pageX) / 100;
        let yAxis = (window.innerHeight / 2 - e.pageY) / 100;
        wrapper.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
    });

    // 3. GESTION DES TAGS
    tags.forEach(tag => {
        tag.addEventListener('click', function() {
            tags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            hiddenInput.value = this.getAttribute('data-value');
            tagsContainer.style.boxShadow = "none"; 
        });
    });

    // 4. GESTION DES ÉTOILES
    stars.forEach(star => {
        star.addEventListener('change', (e) => {
            ratingDesc.innerText = labels[e.target.value];
            ratingDesc.style.color = "#C5A059";
            starsContainer.style.filter = "none";
        });
    });

    // 5. COMPTEUR DE CARACTÈRES
    messageInput.addEventListener('input', function() {
        const length = this.value.length;
        charCount.innerText = `${length} / ${MAX_CHARS} caractères`;
        charCount.style.color = (length >= MAX_CHARS * 0.9) ? "var(--gold)" : "rgba(255,255,255,0.4)";
    });

    // 6. GESTION DES PHOTOS (CUMUL ET APERÇU)
    fileInput.addEventListener('change', function() {
        const selectedFiles = Array.from(this.files);
        
        selectedFiles.forEach((file) => {
            if (allFiles.items.length >= 10) return; // Limite 10 photos

            // On ajoute au panier global
            allFiles.items.add(file);

            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'thumbnail-item';
                div.setAttribute('data-name', file.name);
                
                div.innerHTML = `
                    <div class="remove-thumbnail">×</div>
                    <img src="${e.target.result}" alt="Aperçu">
                `;

                // Suppression
                div.querySelector('.remove-thumbnail').addEventListener('click', () => {
                    removeFileFromFileList(file.name);
                    div.remove();
                    updateLabel();
                });

                thumbnailsContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        // On synchronise l'input avec le panier global
        this.files = allFiles.files;
        updateLabel();
    });

    function removeFileFromFileList(name) {
        const updatedFiles = new DataTransfer();
        for (let i = 0; i < allFiles.files.length; i++) {
            if (allFiles.files[i].name !== name) {
                updatedFiles.items.add(allFiles.files[i]);
            }
        }
        allFiles = updatedFiles;
        fileInput.files = allFiles.files;
    }

    function updateLabel() {
        const count = allFiles.items.length;
        const labelText = document.getElementById('file-label-text');
        labelText.innerText = count > 0 ? `${count} photo(s) prête(s) (Ajouter +)` : "Ajoutez une ou plusieurs photos";
    }

    // 7. VALIDATION FINALE (Mise à jour avec RGPD)
    form.addEventListener('submit', function(e) {
        let errors = [];
        const rgpdCheck = document.getElementById('rgpd_avis');

        // Vérifications classiques
        if (!document.querySelector('input[name="rating"]:checked')) errors.push("Note");
        if (nomInput.value.trim() === "") errors.push("Nom");
        if (!hiddenInput.value) errors.push("Réalisation");
        if (messageInput.value.trim() === "") errors.push("Message");
        
        // Vérification RGPD
        if (rgpdCheck && !rgpdCheck.checked) {
            errors.push("Acceptation des conditions (RGPD)");
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert("Veuillez compléter les points suivants : \n- " + errors.join("\n- "));
            return false;
        }

        submitBtn.classList.add('sending');
        submitBtn.innerText = "Publication en cours...";
    });
</script>

<?php include('includes/footer.php'); ?>