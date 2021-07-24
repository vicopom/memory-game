<?php
// On instancie LESS pour l'utiliser dans le projet
$less = new lessc;
echo $less->compileFile(dirname(__FILE__)."/../css/style.less");
