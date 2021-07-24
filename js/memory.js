jQuery(document).ready(function($){
	//Déclaration de noms d'événement et des fonction associées à déclencher au moment voulu.
	$(document).bind("found_match", matchingCards);
	$(document).bind("no_match", resetOnCards);
    
    // Déclaration d'événement au clic sur des éléments.
    $("#start-button").on("click touch", initialiseGame);

    /* Les éléments ".playing-card" ou encore "#play-again-button" ne se trouvant 
    pas nécessairement dans le DOM au chargement du site, on attache l'événement
    sur un élément parent */
    $('#main-container').on('click touch', '.playing-card', toggleCard);
    $('body').on('click touch', '#play-again-button', playAgain);
	
});

/* initialiseGame() : Initialisation d'une nouvelle partie
    -> On fait disparaitre l'élément Welcome grâce à la fonction native de jQuery fadeOut()
    -> On initialise le compte à rebord avec la fonction countDown : Au terme du décompte de temps, on lance la fonction timesUp
*/
function initialiseGame(){
    $("#welcome").fadeOut(); 
    countDown( 3 * 60 * 1000, timesUp); 
}

/* timesUp() : Défini les actions à mener lorsque le compte à rebord est arrivé à 00:00
    -> Récupération des éléments à afficher dans la variavle $html
    -> On vide la div #result de son contenu par précaution
    -> On y ajoute le contenu de la variable $html
    -> On fait apparaître la div #result
*/
function timesUp(){
    $html = "<div class=\"container\"><p class=\"jumbotron\"><span>Temps écoulé</span> Perdu !</p><p>Ce n'est que partie remise</p><button id=\"play-again-button\" class=\"btn btn-primary\">Rejouer !</button></div>"
    $("#result").empty($html);
    $("#result").prepend($html);
    $("#result").fadeIn();
}

/* playAgain() : Réinitialise le jeu lorsque le joueur demande à rejouer 
    -> Initialisation d'une nouvelle board de jeu grâce à AJAX.
    -> Affichage du résultat de notre requête
*/
function playAgain(){
    /* Appel de la fonction $.get d'AJAX qui nous permet de faire communiquer jQuery (langage client) et PHP (langage serveur)
        -> Appel du fichier cible côté serveur : functions/new-game.php
        -> False indique que nous n'envoyons pas de données.
        -> Nom de la fonction de retour qui nous permettra d'afficher le contenu du résultat de notre requête
    */
    $.get(
        'functions/new-game.php',
        'false',
        initialiseNewGame,
        'text' // Format des données reçues.
    );
    
    /* Fonction de retour de l'appel AJAX.
        -> On vide le conteneur qui affichera notre résultat
        -> On place le retour de l'appel AJAX dnas notre conteneur
        -> On fait disparaitre la div#result qui affiche le dernier résultat obtenu
        -> On initialise une nouvelle partie avec initialiseGame()
    */
    function initialiseNewGame(response){
        $("#main-container").empty();
        $(response).appendTo("#main-container");
        $("#result").fadeOut();

        initialiseGame();
    }
    
}

/* gameWon() : Défini les actions à mener lorsque la partie est gagnée (le joueur à terminer avant le temps imparti)
    -> Appel de la fonction $.post d'AJAX pour l'enregistrement de notre score en base de données
    -> Appel de la fonction $.get d'AJAX pour récupérer le tableau des meilleurs scores
    -> Affichage des 
*/
function gameWon(remainingTime){
    /* Appel de la fonction $.post d'AJAX qui nous permet de faire communiquer jQuery (langage client) et PHP (langage serveur)
        -> Appel du fichier cible côté serveur : functions/register-score.php
        -> Envoi du paramètre "score" contenant la valeur du temps restant à la fin de jeu
        -> Fonction de retour qui nous permettra d'afficher une
    */
    $.post(
        'functions/register-score.php', // Le fichier cible côté serveur.
        {
            score : remainingTime,
        },
        function(response){ console.log(response) },
        'text'
    );

    // On s'assure que l'ajout en base donnée ait été effectuée avant de récupérer le tableau des scores en attendant 500ms.
    setTimeout(
        /* Appel de la fonction $.get d'AJAX qui nous permet de faire communiquer jQuery (langage client) et PHP (langage serveur)
            -> Appel du fichier cible côté serveur : functions/fetch-score.php
            -> False indique que nous n'envoyons pas de données.
            -> Nom de la fonction de retour qui nous permettra d'afficher le contenu du résultat de notre requête
        */
        $.get(
            'functions/fetch-score.php', 
            false,
            boardWon, 
            'text' 
        )
    , 500);
    
    /* Fonction de retour de l'appel AJAX $.get.
        -> On assigne le contenu à afficher dans la variable $html
        -> On vide le conteneur qui affichera notre résultat
        -> On place le retour de l'appel AJAX dans notre conteneur
        -> On fait apparaître la div#result qui affiche alors le dernier résultat obtenu
    */

    function boardWon(response){
        $html = "<div class=\"container\"><p class=\"jumbotron\"> Bien joué ! <span>Partie gagnée avec un temps restant de : <br/>" + getRemainingTime() + " </span></p>";
        $html += response; // += Permet de concaténer les chaines de caractères
        $html += "<p>Vous voulez remettre ça ?</p><button id=\"play-again-button\" class=\"btn btn-primary\">Rejouer !</button></div>"
        
        $("#result").empty($html);
        $("#result").prepend($html);
        $("#result").fadeIn();
    }

}

/* restOnCards() : Gestion du cas : cartes retournées NE SONT PAS les mêmes
    -> On récupère toutes les cartes actives dans la variable $cards
    -> On enlève la classe ".active" aux cartes concernées 
*/
function resetOnCards(event){
	$cards = $(".playing-card.active");
	$.each($cards, function(index, card){
		$card = $(card);
		$card.removeClass('active');
	});
	$cards = null;
};

/* matchingCards() : Gestion du cas : cartes retournées SONT les mêmes
    -> On récupère toutes les cartes actives dans la variable $cards
    -> On ajoute la classe ".resolved" aux cartes concernées 
    -> On enlève la classe ".active" aux cartes concernées 
*/
function matchingCards(event){
	$cards = $(".playing-card.active");
	$.each($cards, function(index, card){
		var $card = $(card);
		$card.addClass('resolved');
        $card.removeClass('active');
	});

	$cards = null;
};

/* cardsLeft(): Vérification qu'il reste des cartes à retourner
    -> On récupère toutes les cartes qui ne sont pas résolues
    -> Si la longueur de la variable = 0 > On retourne NON
    -> Si la longueur de la variable = 0 > On retourne OUI
*/
function cardsLeft(){
    $cards_left = $("#playing-board>.playing-card:not(.resolved)");

	if ( $cards_left.length == 0 ){
		return false;
	}

    return true;
}

/* toggleCard() : Défini les actions à mener lorsque l'on retourne une carte
    -> On récupère la carte cliquée
    -> On vérifie qu'elle ne soit pas active auquel cas on ne fait rien
    -> On stocke le nombre de carte retournée sur le plateau
    -> On ajoute la classe ".active" a la carte cliquée
    -> Si le nombre de carte retournée est égal à 1 (avant d'y ajouter celle sur laquelle on vient de cliquer)
    -> On lance la vérification d'une éventuelle concordance entre les cartes avec la fonction checkCards
    -> On désactive le clic sur l'ensemble des cartes le temps de la vérification
*/
function toggleCard(event){

	var $card = $(this);

	if(!$card.hasClass("active")){
		var num_already_opened = $card.parent("#playing-board").find(".playing-card.active").length;
        $card.addClass('active');
		
		if ( num_already_opened == 1 ){
            chk_cards_timeout = setTimeout(checkCards, 1000);

            //Désactivation du clic pendant la vérification
            $(".playing-card").css("pointer-events", "none");
		}
	}
	$card = null;
};

/* checkCards() : Compare deux cartes et lance l'événement associé adéquat : 'found_match' ou 'no_match'
    -> On récupère les cartes actives sur le plateau
    -> S'il y en a deux, on récupère l'attribut "data-name" de chacunes pour les comparer dans le tableau $classes
    -> On instancie de base l'événement 'no_match'
    -> Si les attributs récupérés sont identique, alors on instancie l'événement 'found_match'
    -> On permet alors de nouveau à l'utilisateur de cliquer sur les cartes du plateau
On en profite pour vérifier s'il n'y a pas eu un bug et que plus de 2 cartes sont retournées, auquel cas on instancie l'événemnet 'no_match'
*/
function checkCards(){
	$visible_cards = $("#playing-board .playing-card.active");

    // Cas où deux cartes sont actives
	if ( $visible_cards.length == 2 ){
        var $classes = [];

        $visible_cards.each(function(){
            $classes.push($(this).children(".inner-playing-card").attr("data-name"));
        });

		var event_name = "no_match";
		if ( $classes[0] == $classes[1] ){
			event_name = "found_match";
		} 
		$(document).trigger(event_name);

        //Réactivation du clic après vérification
        $(".playing-card").css("pointer-events", "auto"); 
        
	}else if( $visible_cards.length > 2 ){
        //Gérer le cas où plus de 2 cartes sont actives
        $(document).trigger("no_match");
    }

	$visible_cards = null;
};

/* countDown() : Initialise le compte à rebourd
    -> On converti le timing choisi en millisecondes > Par défaut : 5 minutes * 60 secondes * 1000
    -> On récupère la date au lancement et on y ajoute notre timing pour obtenir l'heure de fin du compte à rebourd
    -> On lance le compte à rebourd avec la fonction tick()
*/
function countDown(milliseconds, callback) {
    var buffer = 200;
    var end, timer;
    milliseconds = milliseconds || 5 * 60 * 1000; // 5 minutes
    end = new Date(Date.now() + milliseconds + buffer);
    
    // Lancement du compte à rebourd
    tick();
    
    /* formatTime() : Permet de renvoyer les minutes et secondes qu'il reste pour les afficher dans le compte à rebourd
        -> On récupère le temps restant (sous format Date) : Les minutes puis les secondes
        -> Pour un affichage optimal et une meilleure expérience utilisateur on ajoute un "0" devant les chiffres (0 - 9)
        -> On retourne le résultat sous la forme MM:SS
    */
    function formatTime(time){
        minutes = time.getMinutes();
        seconds = time.getSeconds();

        if(minutes < 10){minutes = "0"+minutes;}
        if(seconds < 10){seconds = "0"+seconds;}

        return minutes + " : " + seconds;
    }
    
    /* tick() : Fait avancer le compte à rebourd ou l'arrête lorsque toutes les cartes sont retournées
        -> On récupère le temps restant (sous format Date) : Les minutes puis les secondes en récupérant le moment actuel et en le soustrayant à la date de fin souhaitée
        -> Si le temps restant est > à 0, 
            -> On affiche le nouveau temps dans "#timer"
            -> On vérifie s'il reste des cartes en jeu avec la fonction cardsLeft()
                -> Si c'est le cas, on relance tick() pour faire avancer le temps
                -> Sinon, on récupère le temps final et on lance la fonction gameWon() avec la valeur du temps restant
        -> Si le temps restant est <= 0
            -> On stoppe timer
            -> On lance la fonction de callback (ici, )
    */
    function tick() {
        var remaining = new Date(end - Date.now());
        
        if (remaining > 0) {
            $("#timer").html(formatTime(remaining));

            if(cardsLeft()){
                timer = setTimeout(tick, 1000);
            }else{
                finalTime = formatRemainingTime(remaining);
                gameWon(finalTime);
            }
        } else {
            clearInterval(timer);
            if (callback) callback.apply();
        }
    };
};

/* formatRemainingTime() : Permet de transformer l'objet Date en un entier en secondes pour le stocker en BDD
*/
function formatRemainingTime(time){
    minutes = time.getMinutes();
    seconds = time.getSeconds();
    return minutes * 60 + seconds;
}

/* getRemainingTime() : Permet de récupérer la valeur affichée du timer
*/
function getRemainingTime(){
    return $("#timer").text();
} 

