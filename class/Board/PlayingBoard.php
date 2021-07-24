<?php

// Nomage du namespace
namespace App\Board;

// Déclaration des namespace dont on a besoin
use App\Cards\PlayingCard;

class PlayingBoard
{
    // Déclaration des attributs de la class
    private $cards = array();
    private $cards_names = array();

    // Fonction de construction de la classe (appelée à l'instanciation d'une classe)
    function __construct($cardFiles, $cardsNumber = 18) {

        // On mélange le tableau de cartes que l'on a récupéré
        shuffle($cardFiles);

        // On créé un tableau contenant les cartes récupéré
        // Par défaut le tableau contient 18 cartes, si l'utililisateur indique une autre quantité sur $cardsNumber, le plateau est adapté
        $cards = array();

        for ( $i = 0; $i < $cardsNumber; ++$i ){
            $cards[$i] = new PlayingCard($cardFiles[$i]);
        }
        // On double le tableau pour avoir des paires et on les affecte à notre plateau de jeu
        $this->cards = array_merge($cards, $cards);
        
        // On mélange les cartes pour ne pas qu'elles soient les unes à côté des autres
        shuffle($this->cards);
    }
    
    // Fonction interne à la class qui permet de récupéré le tableau d'objets PlayingCard
    private function get_cards(){
        return $this->cards;
    }
    
    // Fonction interne à la class qui retourne la taille du tableau
    private function get_size(){
        return count($this->cards);
    }
    
    // Fonction interne à la class qui retourne une carte précise du plateau de jeu
    private function get_card($index){
        return $this->cards[$index];
    }

    // Fonction publique qui permet de retourner le plateau de jeu au format HTML
    public function get_html(){
        print "<div id=\"playing-board\" class=\"row\">";

        for ( $i = 0 ; $i < $this->get_size() ; ++$i ){
            print $this->get_card($i)->get_html_block();
        }

        print "</div>";
    }
}