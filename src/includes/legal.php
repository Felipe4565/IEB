<?php
/**
 * Informations légales de l'entreprise : à modifier ICI uniquement.
 * Les pages (mentions légales, CGV, politique de confidentialité, pied de page,
 * rendez-vous) lisent toutes ce fichier.
 *
 * Source : registre public (SIREN 437 635 154). À CONFIRMER sur le Kbis :
 *   - 'rcs'    : greffe d'immatriculation
 *   - 'gerant' : orthographe exacte du nom
 * Les valeurs "À COMPLÉTER" s'affichent sur le site : il faut les remplacer
 * (ou les laisser vides lorsqu'une ligne est facultative) avant la mise en ligne.
 */
return [
    'marque'         => 'IEB – Intérieur Extérieur Bois',
    'societe'        => 'SARL INTERIEUR EXTERIEUR BOIS',
    'forme'          => 'Société à responsabilité limitée (SARL)',
    'capital'        => '8 000 €',
    'siren'          => '437 635 154',
    'siret'          => '437 635 154 00028',
    'rcs'            => 'R.C.S. Melun 437 635 154',
    'tva'            => 'FR95 437635154',
    'adresse'        => '4 rue Saint Claude, 77340 Pontault-Combault',
    'gerant'         => 'Freddy Alvariza Billar',

    // Contact public (mêmes valeurs que le pied de page)
    'email'          => 'interieurexterieurbois@orange.fr',
    'telephone'      => '06 21 08 06 22',
    'telephone_href' => '0621080622',
    'horaires'       => 'Lundi - Vendredi : 8h à 20h',

    // Hébergeur : à vérifier avec ton contrat
    'hebergeur' => [
        'nom'       => 'o2switch',
        'adresse'   => 'Chemin des Pardiaux, 63000 Clermont-Ferrand, France',
        'telephone' => '04 44 44 60 40',
        'site'      => 'www.o2switch.fr',
    ],

    // Médiateur de la consommation : obligatoire pour les ventes aux particuliers.
    // À COMPLÉTER (nom, adresse postale, site web du médiateur auquel l'entreprise adhère).
    'mediateur' => [
        'nom'     => '[À COMPLÉTER : nom du médiateur de la consommation]',
        'adresse' => '[À COMPLÉTER : adresse postale]',
        'site'    => '[À COMPLÉTER : site web]',
    ],

    // Assurances (affichées dans les CGV seulement si renseignées).
    // Ex. 'decennale' => 'Nom de l\'assureur, n° de contrat, couverture géographique'
    'assurance' => [
        'decennale' => '',
        'rc_pro'    => '',
    ],

    // Lien de ta page Calendly (https://calendly.com/...). Vide = page rendez-vous sans calendrier.
    'calendly_url'   => '',

    'cgv_date'       => 'octobre 2026',
];
