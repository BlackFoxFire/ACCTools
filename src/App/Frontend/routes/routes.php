<?php

/**
 * Routes.php
 * @Auteur: Christophe Dufour
 * 
 * Gére les différentes route de l'application
 */

namespace App\Frontend\Routes;

use Blackfox\Router\Router;

Router::set("/", "Acc", "index");
Router::set("/estimate-([0-9]+)-([0-9]+)", "Acc", "estimate", "car,circuit");
