<?php

/**
 * Routes.php
 * @Auteur: Christophe Dufour
 * 
 * Gére les différentes route de l'application
 */

namespace App\Backend\Routes;

use Blackfox\Router\Router;

Router::set("/admin/", "Acc", "index");
Router::set("/admin/addCar", "Acc", "addCar");
Router::set("/admin/addCircuit", "Acc", "addCircuit");
Router::set("/admin/addConsumption", "Acc", "addConsumption");
Router::set("/admin/insert", "Acc", "insert");
Router::set("/admin/deconnection", "Acc", "deconnection");
