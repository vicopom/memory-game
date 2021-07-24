<?php
$cardsNumber = 9;

/*
Déclaration des espaces de noms dont on a besoin
En utilsant l'autoloader de composer, pas besoin de require pour les déclarations
*/
use App\Scores\Score;

/* fetchCards() : Fonction qui permet de retourner les fichiers des cartes
    Par défaut la fonction scandir renvoi les itérations ".." et "." que l'on supprime du tableau avec la fonction array_diff()
*/
function fetchCards(){
    return array_diff(scandir(__DIR__.'/../img/cartes'), array('..', '.'));
}

/* fetchScores() : Fonction qui permet de retourner les 3 meilleurs scores stockés en BDD
    On instancie la connexion à la BDD grâce à la fonction PDO de PHP
    -> Si on reçoie un score par la méthode $_POST on prépare une injection en BDD
        On choisi de préparer sa requête pour éviter les injections SQL
        -> On insère le score
    -> Sinon on retourne "Aucun score envoyé"

On gère ici les exceptions, si on rencontre une erreur à la connexion à la BDD on l'affiche
*/
function fetchScores(){

    $pdo = new PDO('sqlite:'.__DIR__.'/../data.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    $error = null;
    
    try{
        $query = $pdo->query('SELECT * FROM scores ORDER BY score DESC LIMIT 3');
        $scores = $query->fetchAll(PDO::FETCH_CLASS, Score::class);
    }catch(PDOException $e){
        $error = $e->getMessage();
        return $error;
    }

    return $scores;
}