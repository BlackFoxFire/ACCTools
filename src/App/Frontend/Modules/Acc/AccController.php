<?php

/**
 * AccController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace AccTools\App\Frontend\Modules\Acc;

use Mamba\BackController;
use Mamba\HTTPRequest;

class AccController extends BackController
{

    /**
     * Affiche la page d'index du site
     */
    protected function executeIndex(HTTPRequest $request): void
    {
        $carMan = $this->managers->getManagerOf('Cars');
        $circuitMan = $this->managers->getManagerOf('Circuits');
        $cars = $carMan->readAll();
        $circuits = $circuitMan->readAll();

        $datas = array(
            'user' => $this->app()->user(),
            'cars' => $cars,
            'circuits' => $circuits
        );

        $this->view->setData($datas);
    }

    /**
     * Recherche une consommation et la retourne pour Ajax
     */
    protected function executeEstimate(HTTPRequest $request): void
    {
        if($request->getKeyExists('car'))
        {
            $car = $request->getFromGet("car");
            $circuit = $request->getFromGet("circuit");

            $consoMan = $this->managers->getManagerOf('Consumptions');
            $consumption = $consoMan->search($car, $circuit);

            $this->view->setData('estimate', $consumption->value());
        }
    }

}
