<?php

// Nomage du namespace
namespace App\Scores;

// Déclaration des namespace dont on a besoin
use App\Score\Score;

class GameScore {
    // Déclaration des attributs de la class
    private $scores = array();

    // Fonction de construction de la classe (appelée à l'instanciation d'une classe)
    public function __construct(array $scoresBuild) 
    {
        $this->scores = $scoresBuild;
    }

    // Fonction publique qui permet de retourner le tableau des meilleur scores au format HTML
    public function get_html()
    {
        $rang = 1;

        $wrapper= "<section id=\"scores\">";
        $header = "<h3>Tableau des meilleurs scores</h3>";

        if(!empty($this->scores)){
            $table="<table><thead><tr><td>Rang</td><td>Temps restant</td></tr></thead>";
            $table.="<tbody>"; // .= permet d'ajouter du contenu à une variable par concaténation
    
            foreach($this->scores as $score){
                $table.="<tr><td>".$rang."</td><td>".$score->get_score()."</td></tr>";
                $rang++;
            }
    
            $table.="</tbody></table>";
        }else{
            $table="<p>Aucun score enregistré<br/> Soyez le premier à inscrire votre score !</p>";
        }
        
        $wrapperEnd="</section>";

        $html = $wrapper.$header.$table.$wrapperEnd; // Les . permettent les concaténation de chaines.

        return $html;
    }

} 