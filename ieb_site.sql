-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 18 mai 2026 à 16:15
-- Version du serveur : 11.5.2-MariaDB
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ieb_site`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `email`, `mot_de_passe`, `date_creation`) VALUES
(1, 'admin@ieb.fr', '$2y$10$UCSEZuSG5zFWQJ2wEJ..yOZyp8utQIE7hHYUNoQh/4wls1TQVm3SK', '2026-05-01 02:51:50');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `commentaire` mediumtext DEFAULT NULL,
  `type_projet` varchar(100) DEFAULT NULL,
  `note` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'affiche',
  `date` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `est_detaille` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `nom`, `commentaire`, `type_projet`, `note`, `statut`, `date`, `image`, `slug`, `est_detaille`) VALUES
(1, 'Marc-Antoine P.', 'Une équipe à l\'écoute et un savoir-faire artisanal qu\'on ne trouve plus ailleurs. Ma terrasse est superbe.', NULL, 5, 'affiche', '2026-04-27 03:03:13', 'assets/img/avis/terrasse.jpg', 'marc-antoine', 1),
(2, 'Sophie L.', 'Précision millimétrée pour mon dressing sur-mesure. Chantier très propre, je recommande vivement.', NULL, 5, 'affiche', '2026-04-27 03:03:13', NULL, NULL, 0),
(3, 'Julien R.', 'Intervention rapide pour nos fenêtres. Le bois est de qualité supérieure, l\'isolation est parfaite.', NULL, 5, 'affiche', '2026-04-27 03:03:13', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `statut` enum('non_lu','lu','corbeille') DEFAULT 'non_lu',
  `date_envoi` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `nom`, `email`, `telephone`, `sujet`, `message`, `statut`, `date_envoi`) VALUES
(1, 'Alice Morel', 'alice.m@gmail.com', '0612345678', 'Question sur les bois', 'Bonjour, utilisez-vous des vernis éco-responsables pour vos meubles ? Merci.', 'non_lu', '2026-05-03 15:20:00'),
(2, 'Pierre Durand', 'p.durand@bureau.fr', '0140506070', 'Partenariat', 'Bonjour, je suis architecte d\'intérieur et j\'aimerais discuter d\'une collaboration éventuelle.', 'non_lu', '2026-05-03 10:45:00'),
(3, 'Service Urbanisme', 'mairie-contact@ville.fr', NULL, 'Dossier technique', 'Concernant votre intervention rue de la Paix, merci de nous transmettre l\'attestation d\'assurance.', 'lu', '2026-05-02 11:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `contenus`
--

DROP TABLE IF EXISTS `contenus`;
CREATE TABLE IF NOT EXISTS `contenus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cle` varchar(191) DEFAULT NULL,
  `valeur` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contenus`
--

INSERT INTO `contenus` (`id`, `cle`, `valeur`) VALUES
(1, 'home_top_announcement', 'Artisan Menuisier en Île-de-France depuis 2001'),
(2, 'home_hero_subtitle', 'Conception & Fabrication'),
(3, 'home_hero_title_main', 'L\'art du bois,'),
(4, 'home_hero_title_gold', 'le sens du détail.'),
(5, 'home_hero_description', 'Conception unique de cuisines, escaliers et mobilier sur-mesure'),
(6, 'home_btn_projets', 'Voir nos projets'),
(7, 'home_btn_devis', 'Demander un devis'),
(8, 'home_gallery_title', 'Bienvenue chez Intérieur Extérieur Bois'),
(9, 'home_gallery_subtitle', 'Découvrez l\'art du bois sur-mesure'),
(10, 'home_gallery_card1_title', 'Intérieur'),
(11, 'home_gallery_card1_desc', 'Des travaux d\'intérieur sur mesure'),
(12, 'home_gallery_card2_title', 'Extérieur'),
(13, 'home_gallery_card2_desc', 'Des créations en bois pour votre jardin et terrasse'),
(14, 'home_gallery_card3_title', 'Mobilier'),
(15, 'home_gallery_card3_desc', 'Des créations signées pour votre intérieur'),
(16, 'home_fact_default', 'Interagissez avec le meuble pour révéler nos secrets de fabrication.'),
(17, 'home_fact1_title', '25 Ans d\'Expertise'),
(18, 'home_fact1_desc', 'Depuis 2001, nous transformons le bois noble en pièces uniques.'),
(19, 'home_fact2_title', 'Matériaux Durables'),
(20, 'home_fact2_desc', 'Bois issus de forêts gérées durablement.'),
(21, 'home_fact3_title', 'Sur-Mesure Total'),
(22, 'home_fact3_desc', 'Chaque millimètre est pensé pour votre espace.'),
(23, 'services_showroom_subtitle', 'ÉVÉNEMENT'),
(24, 'services_showroom_title', 'Bientôt : L\'expérience IEB prend vie'),
(25, 'services_showroom_text', 'Nous avons hâte de vous accueillir dans notre futur Showroom. Un espace dédié à l\'inspiration et à la visualisation de vos projets les plus ambitieux.'),
(26, 'services_showroom_btn', 'Restez informé'),
(27, 'services_adn_subtitle', 'NOTRE SAVOIR-FAIRE'),
(28, 'services_adn_title', 'L\'ADN IEB : La Haute Mesure'),
(29, 'services_adn_transformation_title', 'TRANSFORMATION'),
(30, 'services_adn_transformation_text', 'Nous adaptons l\'existant et concevons des structures sans limites, du traçage préliminaire à la concrétisation du projet.'),
(31, 'services_adn_fabrication_title', 'FABRICATION SUR MESURE'),
(32, 'services_adn_fabrication_text', 'Fabrication sur mesure à partir de vos projets et de vos matières, avec un souci du détail artisanal et technologique.'),
(33, 'services_expertise_subtitle', 'NOS DOMAINES D\'EXCELLENCE'),
(34, 'services_expertise_title', 'Une Expertise Complète'),
(35, 'services_ext_title', 'MENUISERIE EXTÉRIEURE'),
(36, 'services_ext_btn', 'Voir les réalisations'),
(37, 'services_ext_list1_title', 'OUVERTURES'),
(38, 'services_ext_list1_item1', 'Portes d\'entrée'),
(39, 'services_ext_list1_item2', 'Châssis'),
(40, 'services_ext_list1_item3', 'Fenêtres Performantes'),
(41, 'services_ext_list2_title', 'AMÉNAGEMENTS'),
(42, 'services_ext_list2_item1', 'Terrasses'),
(43, 'services_ext_list2_item2', 'Bardages'),
(44, 'services_ext_list2_item3', 'Portails & Garde-corps'),
(45, 'services_int_title', 'MENUISERIE INTÉRIEURE'),
(46, 'services_int_list1_title', 'AMÉNAGEMENTS'),
(47, 'services_int_list1_item1', 'Escaliers'),
(48, 'services_int_list1_item2', 'Cloisons & Portes'),
(49, 'services_int_list1_item3', 'Rangements'),
(50, 'services_int_list2_title', 'MOBILIER SIGNATURE'),
(51, 'services_int_list2_item1', 'Tables & Consoles'),
(52, 'services_int_list2_item2', 'Plans de travail'),
(53, 'services_int_list2_item3', 'Bibliothèques'),
(54, 'services_process_subtitle', 'Processus IEB'),
(55, 'services_process_title', 'Un Accompagnement Complet'),
(56, 'services_process1_title', 'Conseil & Étude'),
(57, 'services_process1_text', 'Analyse personnalisée et choix des essences pour un projet qui vous ressemble.'),
(58, 'services_process2_title', 'Installation Expertise'),
(59, 'services_process2_text', 'Pose millimétrée par nos équipes qualifiées, dans le respect des règles de l\'art.'),
(60, 'services_process3_title', 'Entretien & Suivi'),
(61, 'services_process3_text', 'Suivi durable pour garantir la longévité et l\'éclat de vos ouvrages en bois.'),
(62, 'realisations_hero_subtitle', 'Un héritage de projets d\'excellence'),
(63, 'realisations_hero_title', 'NOS RÉALISATIONS'),
(64, 'atelier_hero_subtitle', 'Depuis 2001'),
(65, 'atelier_hero_title', 'L\'Atelier IEB'),
(66, 'atelier_hero_description', 'L’excellence au service de vos projets'),
(67, 'atelier_intro_title', 'Notre Héritage'),
(68, 'atelier_intro_lead', 'Chaque pièce est une rencontre entre une essence noble et un geste précis.'),
(69, 'atelier_intro_text', 'Installés en Île-de-France, nous combinons les techniques traditionnelles et l\'innovation pour réaliser des créations uniques et raffinées.'),
(70, 'avis_transformation_title', 'Étude de cas : La métamorphose'),
(71, 'avis_case_title', 'Rénovation Salon & Bibliothèque'),
(72, 'avis_case_client', 'Maison Haussmannienne'),
(73, 'avis_case_location', 'Paris VII'),
(74, 'avis_case_quote', 'Nous avions un espace sombre et mal optimisé. L\'équipe IEB a su redonner vie à notre pièce avec un travail du bois d\'une finesse rare. Le résultat dépasse nos espérances.'),
(75, 'avis_case_signature', '— Famille de V.');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `poste` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'actif',
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom`, `prenom`, `poste`, `description`, `photo`, `ordre`, `slug`, `statut`, `date_creation`) VALUES
(1, 'Alvariza', 'Leonardo Freddy', 'Menuisier et gérant d\'intérieur extérieur bois', 'Expert en menuiserie intérieure et extérieure avec une grande expérience dans le bois sur mesure.', 'assets/img/atelier/Alvariza.jpg', 1, NULL, 'actif', '2026-04-27 02:13:42'),
(2, 'Alvariza', 'Julian', 'Menuisier et salarié de l\'entreprise intérieur extérieur bois', 'Spécialisé dans la fabrication et l’installation de structures bois en intérieur et extérieur.', 'assets/img/atelier/employé_type.jpg', 2, NULL, 'actif', '2026-04-27 02:13:42');

-- --------------------------------------------------------

--
-- Structure de la table `equipe_cards`
--

DROP TABLE IF EXISTS `equipe_cards`;
CREATE TABLE IF NOT EXISTS `equipe_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipe_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` mediumtext DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipe_id` (`equipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe_cards`
--

INSERT INTO `equipe_cards` (`id`, `equipe_id`, `titre`, `contenu`, `ordre`) VALUES
(1, 1, 'Expérience', '+20 ans', 1),
(2, 1, 'Parcours', 'Europe & Italie', 2),
(3, 1, 'Passion', 'Création artisanale', 3),
(4, 2, 'Expertise', 'Sur mesure', 1),
(5, 2, 'Précision', 'Travail artisanal', 2),
(6, 2, 'Témoignage', 'J’apprends beaucoup aux côtés de Leonardo...', 3);

-- --------------------------------------------------------

--
-- Structure de la table `images_avis`
--

DROP TABLE IF EXISTS `images_avis`;
CREATE TABLE IF NOT EXISTS `images_avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avis_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `ordre` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `avis_id` (`avis_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `images_projets`
--

DROP TABLE IF EXISTS `images_projets`;
CREATE TABLE IF NOT EXISTS `images_projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projet_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projet_id` (`projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `images_projets`
--

INSERT INTO `images_projets` (`id`, `projet_id`, `image_url`, `type`, `ordre`) VALUES
(1, NULL, 'assets/img/accueil/Intérieur.jpg', 'home_interieur', 1),
(2, NULL, 'assets/img/accueil/extérieur.jpg', 'home_exterieur', 2),
(3, NULL, 'assets/img/accueil/mobilier.jpg', 'home_mobilier', 3),
(4, NULL, 'assets/img/accueil/meuble_close.png', 'home_meuble', 4),
(5, NULL, 'assets/img/accueil/meuble_close.png', 'home_meuble_close', 1),
(6, NULL, 'assets/img/accueil/meuble_open1.png', 'home_meuble_open1', 2),
(7, NULL, 'assets/img/accueil/meuble_open2.png', 'home_meuble_open2', 3),
(8, NULL, 'assets/img/accueil/meuble_open3.png', 'home_meuble_open3', 4),
(9, NULL, 'assets/img/services/precision.jpg', 'home_precision', 1),
(10, NULL, 'assets/img/services/geste.jpg', 'home_geste', 2),
(11, NULL, 'assets/img/services/technologie.jpg', 'home_technologie', 3),
(12, NULL, 'assets/img/services/matiere.jpg', 'home_matiere', 4),
(13, NULL, 'assets/img/services/exterieur.jpg', 'home_expertise_exterieur', 1),
(14, NULL, 'assets/img/services/interieur.jpg', 'home_expertise_interieur', 2),
(15, NULL, 'assets/img/atelier/heritage_meuble.jpg', 'atelier_heritage', 1),
(16, NULL, 'assets/img/avis/avant.png', 'avis_avant', 1),
(17, NULL, 'assets/img/avis/apres.png', 'avis_apres', 2);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `fichiers` mediumtext DEFAULT NULL,
  `echeance` varchar(255) DEFAULT NULL,
  `statut` enum('non_lu','lu','corbeille') DEFAULT 'non_lu',
  `date_envoi` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `telephone`, `ville`, `type`, `message`, `fichiers`, `echeance`, `statut`, `date_envoi`) VALUES
(1, 'Jean Dupont', 'j.dupont@email.com', '0601020304', NULL, 'Terrasse', 'Bonjour, je souhaiterais un devis pour une terrasse en bois de 20m2 environ. Merci.', NULL, NULL, 'non_lu', '2026-05-02 14:30:00'),
(2, 'Marie Lefebvre', 'marie.le@provider.net', '0145223344', NULL, 'Cuisine', 'Projet de rénovation de cuisine avec plan de travail en chêne massif. Êtes-vous disponibles en juin ?', NULL, NULL, 'non_lu', '2026-05-03 09:15:00'),
(3, 'Cabinet Architecture XL', 'contact@xl-archi.fr', '0788554411', NULL, 'Escalier', 'Demande professionnelle : Nous avons un client pour un escalier suspendu sur mesure à Paris VII.', NULL, NULL, 'lu', '2026-04-30 11:00:00'),
(4, 'Lucas Martin', 'lucas.m@gmail.com', '0611223344', NULL, 'Mobilier', 'Bonjour, je cherche un artisan pour fabriquer une bibliothèque sur mesure sous une pente.', NULL, NULL, 'non_lu', '2026-05-03 10:00:00'),
(5, 'Sophie Morel', 's.morel@outlook.fr', '0699887766', NULL, 'Entretien', 'Bonjour, j\'aimerais faire traiter ma terrasse que vous avez installée il y a 2 ans.', NULL, NULL, 'lu', '2026-04-25 16:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `surface` varchar(50) DEFAULT NULL,
  `materiaux` mediumtext DEFAULT NULL,
  `duree` varchar(100) DEFAULT NULL,
  `image_principale` varchar(255) DEFAULT NULL,
  `statut` enum('brouillon','publie','corbeille') DEFAULT 'brouillon',
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `titre`, `slug`, `description`, `type`, `localisation`, `surface`, `materiaux`, `duree`, `image_principale`, `statut`, `date_creation`) VALUES
(1, 'Cuisine moderne en chêne massif', 'cuisine-moderne-chene', 'Cuisine sur mesure en bois massif avec finitions haut de gamme', 'interieur', NULL, NULL, NULL, NULL, 'assets/img/realisations/cuisine.jpg', 'brouillon', '2026-04-24 23:43:40'),
(2, 'Escalier suspendu & Garde-corps design', 'escalier-suspendu-design', 'Escalier contemporain avec structure invisible et garde-corps design', 'interieur', NULL, NULL, NULL, NULL, 'assets/img/realisations/escalier.jpg', 'brouillon', '2026-04-24 23:43:40'),
(3, 'Terrasse en Ipé & Éclairage intégré', 'terrasse-ipe-eclairage', 'Terrasse extérieure en bois exotique avec système lumineux intégré', 'exterieur', NULL, NULL, NULL, NULL, 'assets/img/realisations/terasse.jpg', 'brouillon', '2026-04-24 23:43:40'),
(4, 'Pergola bioclimatique en Douglas', 'pergola-bioclimatique', 'Pergola moderne en bois Douglas avec gestion de la lumière naturelle', 'exterieur', NULL, NULL, NULL, NULL, 'assets/img/realisations/pergola.jpg', 'brouillon', '2026-04-24 23:43:40'),
(5, 'Dressing complet sous combles', 'dressing-sous-combles', 'Aménagement sur mesure optimisé pour espace sous pente', 'sur-mesure', NULL, NULL, NULL, NULL, 'assets/img/realisations/dressing.jpg', 'brouillon', '2026-04-24 23:43:40'),
(6, 'Table de conférence en Noyau local', 'table-conference-bois', 'Mobilier professionnel unique en bois noble local', 'sur-mesure', NULL, NULL, NULL, NULL, 'assets/img/realisations/table_conf.jpg', 'brouillon', '2026-04-24 23:43:40'),
(7, 'Rénovation d\'un appartement Haussmannien', 'renovation-haussmannien', 'Restauration complète avec conservation du cachet ancien', 'renovation', NULL, NULL, NULL, NULL, 'assets/img/realisations/renovation.jpg', 'brouillon', '2026-04-24 23:43:40'),
(8, 'Espace Coworking - Agencement bois & acoustique', 'coworking-agencement', 'Création d\'un espace pro avec traitement acoustique et bois', 'pro', NULL, NULL, NULL, NULL, 'assets/img/realisations/technologie.jpg', 'brouillon', '2026-04-24 23:43:40'),
(9, 'Comptoir d\'accueil - Boutique de luxe', 'comptoir-luxe', 'Comptoir sur mesure pour environnement haut de gamme', 'pro', NULL, NULL, NULL, NULL, 'assets/img/realisations/comptoir.jpg', 'brouillon', '2026-04-24 23:43:40');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
