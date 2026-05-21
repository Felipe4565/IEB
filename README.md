#  IEB – Intérieur Extérieur Bois  
### Site vitrine sur mesure – Menuiserie artisanale

---

##  Présentation du projet

IEB – Intérieur Extérieur Bois est un site web vitrine développé sur mesure pour une entreprise spécialisée dans la menuiserie intérieure et extérieure, la fabrication de mobilier bois et les aménagements personnalisés.

L’objectif du site est de :

- présenter les services de l’entreprise
- mettre en valeur les réalisations
- améliorer la visibilité locale en Île-de-France
- faciliter la prise de contact et les demandes de devis
- renforcer l’image de marque en ligne

---

##  Stack technique

### Front-end
- HTML5
- CSS3
- JavaScript (vanilla)

### Back-end
- PHP (procédural)
- MySQL / MariaDB
- PDO (connexion sécurisée)

### Déploiement
- Docker (développement local)
- Hébergement mutualisé (InfinityFree / production)

---

##  Fonctionnalités principales

###  Site public
- Galerie de réalisations avec filtrage
- Pages services (intérieur / extérieur / sur-mesure)
- Système avant / après projets
- Formulaire de contact et demande de devis
- Page avis clients
- FAQ et pages informatives
- Carte et informations de contact
- Site responsive (mobile / tablette / desktop)
- Optimisation SEO de base

###  Back-office (admin)
- Gestion des projets (CRUD complet)
- Gestion des avis clients
- Gestion des messages et contacts
- Gestion de l’équipe
- Système de corbeille (soft delete)
- Upload d’images (galeries projets)
- Éditeur de contenus dynamiques
- Authentification sécurisée

---

##  Arborescence du projet

```bash
src/
│
├── admin/
│   ├── includes/
│   │   ├── auth_check.php
│   │   ├── header.php
│   │   └── notifications.php
│   ├── add_projet.php
│   ├── edit_projet.php
│   ├── projets.php
│   ├── avis.php
│   ├── equipe.php
│   ├── contact.php
│   ├── message.php
│   ├── corbeille.php
│   ├── soft_delete.php
│   ├── login.php
│   ├── logout.php
│   └── index.php
│
├── assets/
│   └── img/
│       ├── accueil/
│       ├── admin/
│       ├── atelier/
│       ├── avis/
│       ├── equipe/
│       ├── realisations/
│       └── services/
│
├── css/
│   ├── admin.css
│   ├── atelier.css
│   ├── avis.css
│   ├── contact.css
│   ├── footer.css
│   ├── header.css
│   ├── realisations.css
│   ├── services.css
│   ├── responsive.css
│   └── style.css
│
├── includes/
│   ├── db.php
│   ├── header.php
│   ├── footer.php
│   └── element_flottant.php
│
├── index.php
├── services.php
├── realisations.php
├── entreprise.php
├── contact.php
├── avis.php
├── faq.php
├── mentions_legales.php
└── .htaccess

##  Architecture du projet

###  Includes

Les fichiers `header.php`, `footer.php` et `db.php` sont centralisés afin de :

- éviter la duplication de code  
- faciliter la maintenance du site  
- uniformiser l’ensemble des pages  

---

###  Admin

Le back-office est totalement séparé du site public :

- authentification obligatoire pour accéder à l’administration  
- gestion complète des contenus (projets, avis, messages, équipe)  
- système de corbeille (soft delete avant suppression définitive)  

---

###  Assets

Les ressources images sont organisées de manière structurée :

- réalisations  
- équipe  
- services  
- accueil  

---

##  Sécurité

- authentification administrateur obligatoire  
- requêtes SQL sécurisées via PDO  
- système de corbeille avant suppression définitive  
- protection des pages admin  
- séparation stricte front-end / back-end  

---

##  SEO & performance

- URLs optimisées via slugs  
- balises meta structurées  
- site responsive (mobile-first)  
- optimisation des images  
- structure HTML sémantique propre  

---

## Objectifs du projet

- digitaliser une entreprise artisanale locale  
- améliorer la visibilité sur Google  
- générer des demandes de devis  
- professionnaliser l’image de marque  
- centraliser la gestion du contenu  

---

## Auteur

**Felipe Alvariza**  
Développeur web – Projet IEB  
PHP / MySQL / Front-end sur mesure