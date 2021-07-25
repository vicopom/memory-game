<?php
/*
    FONCTION APPELEE EN AJAX POUR ENREGISTRER LE TEMPS RESTANT LORSQUE LE JOUEUR A GAGNE
*/

/* Instancie la connexion à la BDD grâce à la fonction PDO de PHP
    -> Si on reçoie un score par la méthode $_POST on prépare une injection en BDD
        On choisi de préparer sa requête pour éviter les injections SQL
        -> On insère le score
    -> Sinon on retourne "Aucun score envoyé"

On gère ici les exceptions, si on rencontre une erreur à la connexion à la BDD on l'affiche
*/
$pdo = new PDO('sqlite:'.__DIR__.'/../../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_TIMEOUT => 2, // in seconds
]);
$error = null;

try{
    if(isset($_POST['score'])){
        $query = $pdo->prepare('INSERT INTO scores (score) VALUES (:score)');
        $query->execute([
            'score' => $_POST['score']
        ]);
    }else{
        echo "Aucun score renvoyé";
    }
}catch(PDOException $e){
    $error = $e->getMessage();
}

if($error){

    echo $error;

} 

