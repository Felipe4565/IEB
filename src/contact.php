<?php 
$pageTitle = "Demander un devis | IEB"; 
include('includes/header.php'); 
?>

<link rel="stylesheet" href="css/contact.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

<main class="section-form-devant">
    <div class="container">
        
        <div class="form-navigation">
            <a href="index.php" class="btn-back">
                <span class="icon">←</span> RETOUR À L'ACCUEIL
            </a>
        </div>

        <div class="form-wrapper">
            <div class="form-header">
                <p class="form-subtitle">Un projet d'excellence sur-mesure</p>
                <h1 class="serif-gold">DEMANDER UN DEVIS</h1>
                
                <div class="stepper-ieb">
                    <div class="progress-line">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <div class="step-dots">
                        <div class="dot active" data-step="1"><span>1</span></div>
                        <div class="dot" data-step="2"><span>2</span></div>
                        <div class="dot" data-step="3"><span>3</span></div>
                    </div>
                </div>
            </div>

            <form id="multiStepForm" action="process.php" method="POST" enctype="multipart/form-data" class="avis-form">
                
                <div class="form-step active" id="step-1">
                    <p class="label-gold">Étape 1 : Vos Coordonnées</p>
                    
                    <div class="input-group">
                        <input type="text" name="nom" placeholder="VOTRE NOM COMPLET" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="VOTRE ADRESSE EMAIL" required>
                    </div>
                    <div class="input-group">
                        <input type="text" name="tel" placeholder="NUMÉRO DE TÉLÉPHONE">
                    </div>

                    <div class="step-actions">
                        <button type="button" class="btn-submit-gold" onclick="changeStep(2)">CONTINUER</button>
                    </div>
                </div>

                <div class="form-step" id="step-2">
                    <p class="label-gold">Étape 2 : Votre Projet</p>
                    
                    <p class="rating-text">Nature des travaux</p>
                    <div class="project-tags">
                        <input type="hidden" name="type_travail" id="selected_type" value="Menuiserie Intérieure">
                        <div class="tag active" onclick="selectTag(this, 'Menuiserie Intérieure')">Menuiserie Intérieure</div>
                        <div class="tag" onclick="selectTag(this, 'Menuiserie Extérieure')">Menuiserie Extérieure</div>
                        <div class="tag" onclick="selectTag(this, 'Mobilier')">Mobilier Signature</div>
                    </div>

                    <div class="input-group">
                        <textarea name="description" placeholder="DÉCRIVEZ VOTRE PROJET (DIMENSIONS, ESSENCES DE BOIS...)" rows="4"></textarea>
                    </div>

                    <div class="file-upload">
                        <label for="file" class="file-label">
                            <span class="label-gold">+ AJOUTER DES PLANS OU INSPIRATIONS</span>
                            <p style="font-size: 0.6rem; color: rgba(255,255,255,0.4); margin-top: 10px;">PDF, JPG, PNG (MAX 10MO)</p>
                        </label>
                        <input type="file" id="file" name="files[]" multiple style="display:none;" onchange="handleFiles(this.files)">
                        <div id="thumbnails-container"></div>
                    </div>

                    <div class="step-actions dual">
                        <button type="button" class="btn-back" onclick="changeStep(1)">RETOUR</button>
                        <button type="button" class="btn-submit-gold" onclick="changeStep(3)">CONTINUER</button>
                    </div>
                </div>

                <div class="form-step" id="step-3">
                    <p class="label-gold">Étape 3 : Vos Préférences</p>
                    
                    <div class="input-group">
                        <input type="text" name="echeance" placeholder="ÉCHÉANCE SOUHAITÉE (EX: SEPTEMBRE 2024)">
                    </div>

                    <div class="info-note">
                        <p>Une réponse détaillée vous sera adressée sous 48h par l'un de nos artisans experts.</p>
                    </div>

                    <div class="step-actions dual">
                        <button type="button" class="btn-back" onclick="changeStep(2)">RETOUR</button>
                        <button type="submit" class="btn-submit-gold">ENVOYER LA DEMANDE</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</main>

<script>
    function changeStep(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        
        // Update Dots
        document.querySelectorAll('.dot').forEach((dot, index) => {
            if (index + 1 <= step) dot.classList.add('active');
            else dot.classList.remove('active');
        });

        // Update Line
        const progress = ((step - 1) / 2) * 100;
        document.getElementById('progress-fill').style.width = progress + "%";
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function selectTag(el, val) {
        document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('selected_type').value = val;
    }

    function handleFiles(files) {
        const container = document.getElementById('thumbnails-container');
        container.innerHTML = '';
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const item = document.createElement('div');
                item.className = 'thumbnail-item';
                item.innerHTML = `<img src="${e.target.result}">`;
                container.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

<?php include('includes/footer.php'); ?>