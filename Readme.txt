/*---------------------------------------
------------- JEU DE MEMORY -------------
---------------------------------------*/

Ce jeu de Mémory instancie des paires de cartes (class PlayingCard) sur un plateau de jeu (class PlayingBoard)
Le but du jeu est de résoudre le plateau avant la fin du compte à rebourd

Si toutes les paires de cartes sont retrouvées avant la fin du temps imparti, le score (class Score) effectué par le joueur est enregistré en BDD
Si toutes les paires de cartes ne sont pas retrouvées avant la fin du temps imparti, le joueur est invité à recommencer une partie
Le tableau des meilleurs scores est affiché (class gameScore) au lancement du jeu et en cas de réussite

/*--- GESTION DU JEU ---*/
Les éléments du jeu (plateau de jeu, cartes, score, tableau des scores) sont des Objets PHP (Cf. Dossier class/)
Les variables globales du jeu (Nombres de cartes et Temps de jeu) sont définies dans le fichier params.php
Les actions utilisateurs sont toutes gérées en jQuery (Cf. Dossier js/memory.js)
Le traitement de la réussite ou l'échec de la partie est effectuée en AJAX entre des fonctions PHP (Cf. Dossier functions/) et des actions en jQuery (Cf. Dossier js/memory.js)

/*--- GESTION EN BASE DE DONNEES ---*/
Pour le bien du projet, nous utilisons une BDD SQLite (version allégée de SQL)
Les scores sont stockés dans une table "scores" qui comprend un ID (clée primaire auto indentée) et le score enregistré en secondes (INT)

/*--- AIDE PHP ---*/

//DOC PDO
https://www.php.net/manual/fr/book.pdo.php

//FONCTIONS SPECIFIQUES
array_dif()     => https://www.php.net/manual/fr/function.array-diff
array_merge()   => https://www.php.net/manual/fr/function.array-merge.php
count()         => https://www.php.net/manual/fr/function.count 
pathinfo()      => https://www.php.net/manual/fr/function.pathinfo.php
scandir()       => https://www.php.net/manual/fr/function.scandir
shuffle()       => https://www.php.net/manual/fr/function.shuffle
str_replace     => https://www.php.net/manual/fr/function.str-replace
ucwords()       => https://www.php.net/manual/fr/function.ucwords


/*--- AIDE JQUERY ---*/

addClass()      => https://api.jquery.com/addClass/#addClass-className
append()        => https://api.jquery.com/append/#append-content-content
appendTo()      => https://api.jquery.com/appendTo/#appendTo-target 
attr()          => https://api.jquery.com/attr/#attr-attributeName
bind()          => https://api.jquery.com/bind/#bind-eventType-eventData-handler
children()      => https://api.jquery.com/children/#children-selector
css()           => https://api.jquery.com/css/#css-propertyName
empty()         => https://api.jquery.com/empty/#empty
fadeIn()        => https://api.jquery.com/fadeIn/#fadeIn-duration-easing-complete
fadeOut()       => https://api.jquery.com/fadeOut/#fadeOut-duration-complete
find()          => https://api.jquery.com/find/#find-selector
html()          => https://api.jquery.com/html/#html
on()            => https://api.jquery.com/on/#on-events-selector-data-handler
parent()        => https://api.jquery.com/parent/#parent-selector
prepend()       => https://api.jquery.com/prepend/#prepend-content-content
removeClass()   => https://api.jquery.com/removeClass/#removeClass-className
trigger()       => https://api.jquery.com/trigger/#trigger-eventType-extraParameters