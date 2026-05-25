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
                
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div style="display:none;">
                    <label>Si vous êtes humain, ne remplissez pas ce champ</label>
                    <input type="text" name="hp_check_url" autocomplete="off">
                </div>

                <div class="form-step active" id="step-1">
                    <p class="label-gold">Étape 1 : Vos Coordonnées</p>
                    
                    <div class="input-group">
                        <input type="text" name="nom" placeholder="NOM COMPLET" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="ADRESSE EMAIL" required>
                    </div>
                    <div class="input-group">
                        <input type="text" 
                            name="tel" 
                            placeholder="NUMÉRO DE TÉLÉPHONE" 
                            inputmode="numeric" 
                            maxlength="10" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                            required>
                    </div>
                    <div class="input-group">
                        <input type="text" name="ville" placeholder="VILLE" required>
                    </div>

                    <div class="step-actions">
                        <button type="button" class="btn-submit-gold" onclick="validateAndNext(2)">CONTINUER</button>
                    </div>
                </div>

                <div class="form-step" id="step-2">
                    <p class="label-gold">Étape 2 : Votre Projet</p>
                    
                    <p class="rating-text">Nature des travaux</p>
                    <div class="project-tags">
                        <input type="hidden" name="type_travail" id="selected_type" value="Menuiserie Intérieure">
                        <div class="tag active" onclick="selectTag(this, 'Menuiserie Intérieure')">Menuiserie Intérieure</div>
                        <div class="tag" onclick="selectTag(this, 'Menuiserie Extérieure')">Menuiserie Extérieure</div>
                        <div class="tag" onclick="selectTag(this, 'Autres')">Autres</div>
                    </div>

                    <div class="input-group">
                        <textarea name="description" id="desc-projet" placeholder="DÉCRIVEZ VOTRE PROJET (DIMENSIONS, ESSENCES DE BOIS...)" rows="4" required></textarea>
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
                        <button type="button" class="btn-submit-gold" onclick="validateAndNext(3)">CONTINUER</button>
                    </div>
                </div>

            <div class="form-step" id="step-3">
                <p class="label-gold">Étape 3 : Vos Préférences</p>
                
                <div class="input-group">
                    <input type="text" name="echeance" placeholder="ÉCHÉANCE SOUHAITÉE (EX: SEPTEMBRE 2024)" required>
                </div>

                <div class="rgpd-container" style="text-align: left; margin: 30px 0;">
                    <label style="display: flex; align-items: flex-start; cursor: pointer; gap: 12px;">
                        <input type="checkbox" id="rgpd_consent_devis" name="rgpd_consent" required style="margin-top: 4px; accent-color: #c5a67c; width: 14px; height: 14px; transform: scale(0.9); cursor: pointer;">                        <span style="color: rgba(255,255,255,0.7); font-size: 0.85rem; line-height: 1.4;">
                            En soumettant ce formulaire, j'accepte que les informations saisies soient exploitées par IEB dans le cadre de ma demande de devis et de la relation commerciale qui peut en découler. 
                            Consultez notre <a href="politique-confidentialite.php" target="_blank" style="color: #c5a67c; text-decoration: underline;">Politique de Confidentialité</a>.
                        </span>
                    </label>
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
    /**
     * Valide les champs de l'étape actuelle avant de passer à la suivante
     */
    function validateAndNext(nextStep) {
        // On récupère le bloc de l'étape active
        const currentStepDiv = document.querySelector('.form-step.active');
        // On cible tous les champs requis (input et textarea)
        const inputs = currentStepDiv.querySelectorAll('input[required], textarea[required]');
        
        let isValid = true;
        let errorMessage = "";

        inputs.forEach(input => {
            // 1. Vérification générale : Champ vide
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderBottomColor = "#ff4d4d"; // Soulignement rouge
                errorMessage = "Veuillez remplir tous les champs obligatoires.";
            } else {
                input.style.borderBottomColor = "rgba(255, 255, 255, 0.1)"; // Retour au gris si OK
            }

            // 2. Vérification spécifique : EMAIL (doit avoir @ et .)
            if (input.type === "email" && input.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    input.style.borderBottomColor = "#ff4d4d";
                    errorMessage = "L'adresse email n'est pas valide (ex: contact@domaine.fr).";
                }
            }

            // 3. Vérification spécifique : TÉLÉPHONE (exactement 10 chiffres)
            if (input.name === "tel" && input.value.trim()) {
                if (input.value.length !== 10) {
                    isValid = false;
                    input.style.borderBottomColor = "#ff4d4d";
                    errorMessage = "Le numéro de téléphone doit comporter exactement 10 chiffres.";
                }
            }
        });

        // Si tout est bon, on change d'étape, sinon on alerte
        if (isValid) {
            changeStep(nextStep);
        } else {
            if (errorMessage) {
                alert(errorMessage);
            }
        }
    }

    /**
     * Gère l'affichage visuel des étapes (dots et barre de progression)
     */
    function changeStep(step) {
        // Masquer toutes les étapes et afficher la nouvelle
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        
        // Mise à jour visuelle des points (stepper)
        document.querySelectorAll('.dot').forEach((dot, index) => {
            if (index + 1 <= step) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });

        // Mise à jour de la barre dorée (0% -> 50% -> 100%)
        const progress = ((step - 1) / 2) * 100;
        document.getElementById('progress-fill').style.width = progress + "%";
        
        // Retour en haut du formulaire pour le confort
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Gère la sélection des tags (Etape 2)
     */
    function selectTag(el, val) {
        document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('selected_type').value = val;
    }

    /**
     * Gère la prévisualisation des fichiers (Etape 2)
     */
    function handleFiles(files) {
        const container = document.getElementById('thumbnails-container');
        container.innerHTML = ''; // On vide les anciennes vignettes
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const item = document.createElement('div');
                    item.className = 'thumbnail-item';
                    item.innerHTML = `<img src="${e.target.result}">`;
                    container.appendChild(item);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('multiStepForm');
        
        if(form) {
            form.addEventListener('submit', function(e) {
                // On récupère la checkbox RGPD par son ID (assure-toi qu'il correspond à ton HTML)
                const rgpdCheck = document.getElementById('rgpd_consent_devis');
                
                if (rgpdCheck && !rgpdCheck.checked) {
                    e.preventDefault(); // On bloque l'envoi
                    alert("Veuillez accepter la politique de confidentialité pour envoyer votre demande.");
                    return false;
                }
                
                // Si OK, le formulaire s'envoie normalement vers process.php
                console.log("Formulaire valide, envoi en cours...");
            });
        }
    });
</script>

<?php include('includes/footer.php'); ?>