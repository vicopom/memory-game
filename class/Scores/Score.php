<?php

// Nomage du namespace
namespace App\Scores;

class Score {
    // Déclaration des attributs de la class
    private $score;

    // Fonction publique permettant de retourner le temps au format MM:SS à partir des secondes
    public function get_score()
    {
        $seconds = $this->score;
        $getHours = floor($seconds / 3600);
        $getMins = floor(($seconds - ($getHours*3600)) / 60);
        $getSecs = floor($seconds % 60);

        if(intval($getMins) < 10){$getMins = "0".strval($getMins); }
        if(intval($getSecs) < 10){$getSecs = "0".strval($getSecs); }

        return $getMins.':'.$getSecs;
    }

} 