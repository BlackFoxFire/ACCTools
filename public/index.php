<?php

/**
 * index.php
 * @Auteur: Christophe Dufour
 * 
 * Controleur frontal
 */

 // Dossier racine
$rootDir = dirname(__DIR__);

// Autoload de Composer
require $rootDir . str_replace('/', DIRECTORY_SEPARATOR, "/vendor/autoload.php");

// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if(!isset($_GET['app'])) {
    $_GET['app'] = "Frontend";
}

// Il ne nous suffit plus qu'à déduire le nom de la classe et de l'instancier
$appClass = "App\\" . $_GET['app'] . '\\' . $_GET['app'] . "Application";

$app = new $appClass;
$app->run();
