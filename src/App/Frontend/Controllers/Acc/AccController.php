<?php

/**
 * AccController.php
 * @Auteur : Christophe Dufour
 * 
 * Application utilisateur pour le calcul des temps de course, consommation, etc ...
 */

namespace App\Frontend\Controllers\Acc;

use Blackfox\BackController;
use Blackfox\HTTPRequest;

class AccController extends BackController
{
    /**
     * Affiche la page d'index du site
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeIndex(HTTPRequest $request): void
    {
        $carMan = $this->modelFactory->create('Cars');
        $circuitMan = $this->modelFactory->create('Circuits');
        $cars = $carMan->readAll();
        $circuits = $circuitMan->readAll();

        $datas = array(
            'includeJS' => true,
            'user' => $this->app()->user(),
            'cars' => $cars,
            'circuits' => $circuits
        );

        $this->view->setData($datas);
    }

    /**
     * Recherche une consommation et la retourne pour Ajax
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeEstimate(HTTPRequest $request): void
    {
        if($request->getKeyExists('car'))
        {
            $car = $request->getFromGet("car");
            $circuit = $request->getFromGet("circuit");

            $consoMan = $this->modelFactory->create('Consumptions');
            $consumption = $consoMan->search($car, $circuit);

            if($consumption !== false) {
                $this->view->setData('estimate', $consumption->value());
            }
            else {
                $this->view->setData('estimate', 0);
            }
        }
    }

}
