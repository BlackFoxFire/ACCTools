<?php

/**
 * Routes.php
 * @Auteur: Christophe Dufour
 * 
 * Gére les différentes route de l'application
 */

namespace App\Backend\Routes;

use Blackfox\Router\Router;

Router::set("/admin/", "Acc", "consumptions");

Router::set("/admin/cars", "Acc", "cars");
Router::set("/admin/addCar", "Acc", "addCar");
Router::set("/admin/favoriteCar-([0-9a-f]{64})-([0-9]+)", "Acc", "favoriteCar", "security,idCar");
Router::set("/admin/deleteCar-([0-9a-f]{64})-([0-9]+)", "Acc", "deleteCar", "security,idCar");

Router::set("/admin/circuits", "Acc", "circuits");
Router::set("/admin/deleteCircuit-([0-9a-f]{64})-([0-9]+)", "Acc", "deleteCircuit", "security,idCircuit");

Router::set("/admin/consumptions", "Acc", "consumptions");
Router::set("/admin/addConsumption", "Acc", "addConsumption");
Router::set("/admin/deleteConsumption-([0-9a-f]{64})-([0-9]+)", "Acc", "deleteConsumption", "security,idConsumption");

Router::set("/admin/insert", "Acc", "insert");
Router::set("/admin/deconnection", "Acc", "deconnection");
