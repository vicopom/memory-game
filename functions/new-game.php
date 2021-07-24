<?php

// Déclaration des dépendances
require '../functions/functions.php';
require '../vendor/autoload.php';

/*
Déclaration des espaces de noms dont on a besoin
En utilsant l'autoloader de composer, pas besoin de require pour les déclarations
*/
use App\Cards\PlayingCard;
use App\Board\PlayingBoard;

// Initialisation de notre table de jeu
$files = fetchCards();  //Fonction d'import des cartes déclarée dans /functions.php
$board = new PlayingBoard($files, $GLOBALS['cardsNumber']);

//On retourne le plateau de jeu en HTML
echo $board->get_html();

?>