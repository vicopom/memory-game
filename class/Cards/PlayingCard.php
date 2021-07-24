<?php

// Nomage du namespace
namespace App\Cards;

class PlayingCard {
    // Déclaration des attributs de la class
    private $name;
    private $class;
    private $imageUrl;

    // Fonction de construction de la classe (appelée à l'instanciation d'une classe)
    public function __construct(string $url) 
    {
        $this->class = $this->extract_name($url);
        $this->name = ucwords(str_replace('-', ' ', $this->class));
        $this->imageUrl =  'img/cartes/'. $url;
    }

    // Retourne le nom de la carte
    public function get_name()
    {
        return $this->name;
    }

    // Retourne la classe de la carte (nom du fichier moins l'extension de fichier)
    public function get_class()
    {
        return $this->class;
    }

    // Retourne l'URL de l'image
    public function get_url()
    {
        return $this->imageUrl;
    }
    
    // Retourne le bloc HTML a afficher pour une carte à jouer
    public function get_html_block(){
        return "\r<div class=\"playing-card\">
                    \r<div class=\"inner-playing-card\" data-name=\"".$this->class."\">
                        \r<div class=\"front\"></div>
                        \r<div class=\"back\" style=\"background-image: url('".$this->imageUrl."')\"></div>
                    \r</div>
                </div>";
    }

    // Extrait le nom du fichier à partir de son URL
    private function extract_name(string $url)
    {
        $tmp = pathinfo($url);
        return $tmp['filename'];
    }
} 