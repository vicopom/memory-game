<?php
/*
    FONCTION APPELEE EN AJAX POUR RECUPERER LE TABLEAU DES MEILLEURS SCORES
*/


// Déclaration des dépendances
require '../../vendor/autoload.php';
require '../../functions/functions.php';

/*
Déclaration des espaces de noms dont on a besoin
En utilsant l'autoloader de composer, pas besoin de require pour les déclarations
*/
use App\Scores\GameScore;

// On récupère le tableau des scores (Array d'objets "Score")
$scores = fetchScores();

// On instancie une nouvelle valeur de tableau avec le résultat de la requête lancée
$gameScore = new GameScore($scores);

// On retourne le tableau des scores HTML généré
print $gameScore->get_html(); 