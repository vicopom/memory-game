<?php

// Déclaration des dépendances
require 'vendor/autoload.php';
require 'vendor/leafo/lessphp/lessc.inc.php';
require 'functions/functions.php';

/*
Déclaration des espaces de noms
En utilsant l'autoloader de composer, pas besoin de require pour les déclarations
*/
use App\Cards\PlayingCard;
use App\Board\PlayingBoard;
use App\Scores\{
    GameScore,
    Score
};
use App\Less;


// Initialisation de notre table de jeu
$files = fetchCards(); //Fonction d'import des cartes déclarée dans /functions.php
$board = new PlayingBoard($files, $GLOBALS['cardsNumber']); 

//Initialisation de la table des scores
$scores = fetchScores(); //Fonction d'import des cartes déclarée dans /functions.php
$gameScore = new GameScore($scores);

//Importation du header de notre page
require 'header.php';

?>

<section id="welcome">
    <div class="container">
        <div class="row flex-column justify-content-center text-center">
            <div id="resume">
                <p class="jumbotron"><span>Jeu de memory</span> Prêts à vous amuser ?</p>

                <div class="scores">
                    <?php 
                        //Affichage du tableau des score
                        print $gameScore->get_html(); 
                    ?>
                </div>

                <button id="start-button" class="btn btn-primary">Commencer !</button>
            </div>
            
        </div>
    </div>
</section>

<header>
	<div class="container">
        <div class="row justify-content-between align-items-center">
            <h1>Jeu de memory</h1> 

            <div id="timer"></div>
        </div>
    </div>
</header>
<main role="main">
    <div id="main-container" class="container">

        <?php 
            //Affichage des cartes à jouer
            $board->get_html(); 
        ?>

    </div>  
</main>

<div id="result"></div>

<?php

//Importation du footer de notre page
require 'footer.php';

?>
