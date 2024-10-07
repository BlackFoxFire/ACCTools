<?php

/**
 * AccController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\App\Backend\Modules\Acc;

use Mamba\BackController;
use Mamba\HTTPRequest;
use \Mamba\Link;
use Blackfox\AccTools\Lib\Entities\Car;
use Blackfox\AccTools\Lib\Entities\Circuit;
use Blackfox\AccTools\Lib\Entities\Consumption;

class AccController extends BackController
{

    /**
     *  
     */
    protected function executeIndex(HTTPRequest $request): void
    {
        $carMan = $this->managers->getManagerOf('Cars');
        $circuitMan = $this->managers->getManagerOf('Circuits');
        $consoMan = $this->managers->getManagerOf('Consumptions');

        $cars = $carMan->readAll();
        $circuits = $circuitMan->readAll();
        
        $datas = array(
            'user' => $this->app()->user(),
            'cars' => $cars,
            'circuits' => $circuits,
            'id_circuit' => 0
        );

        if(isset($cars[0])) {
            $datas['id_car'] = $cars[0]->id();
        }

        if($request->formIsSubmit())
        {
            $id_car = $request->getFromPost('carConsumption') ? $request->getFromPost('carConsumption') : 0;
            $id_circuit = $request->getFromPost('circuitConsumption');

            if($id_car != 0 && $id_circuit == 0) {
                $datas['id_car'] = $id_car;
                $consumptions = $consoMan->readByCar($id_car);
            }
            elseif($id_car != 0 && $id_circuit != 0) {
                $datas['id_car'] = $id_car;
                $datas['id_circuit'] = $id_circuit;
                $consumptions = $consoMan->readByCarAndCircuit($id_car, $id_circuit);
            }
            elseif($id_car == 0 && $id_circuit != 0) {
                $datas['id_car'] = 0;
                $datas['id_circuit'] = $id_circuit;
                $consumptions = $consoMan->readByCircuit($id_circuit);
            }
            else {
                $datas['id_car'] = 0;
                $consumptions = $consoMan->readAll();  
            }
        }
        else
        {
            //$consumptions = $consoMan->readAll();
            if(isset($cars[0])) {
                $consumptions = $consoMan->readByCar($cars[0]->id());
            }
        }

        $datas['consumptions'] = $consumptions;
        $this->view->setData($datas);
    }

    /**
     * 
     */
    protected function executeAddCar(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $carMan = $this->managers->getManagerOf('Cars');
            $datas['model'] = $request->getFromPost('car');

            if(!$carMan->searchModel($datas['model']))
            {
                $car = new Car($datas);

                if($car->isValid())
                {
                    if($carMan->save($car))
                    {
                        $this->app()->user()->setMessage("Modèle de voiture ajouté avec success.");
                    }
                }
                else
                {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.");
                }
            }
            else
            {
                $this->app()->user()->setMessage("Modèle déjà présent dans la base de données. Aucune modification effectuée.");
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

    /**
     * 
     */
    protected function executeAddCircuit(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $circuitMan = $this->managers->getManagerOf('Circuits');
            $datas['name'] = $request->getFromPost('circuit');
            
            if(!$circuitMan->searchName($datas['name']))
            {
                $circuit = new Circuit($datas);

                if($circuit->isValid())
                {
                    if($circuitMan->save($circuit))
                    {
                        $this->app()->user()->setMessage("Circuit ajouté avec success.");
                    }
                }
                else
                {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.");
                }
            }
            else
            {
                $this->app()->user()->setMessage("Circuit déjà présent dans la base de données. Aucune modification effectuée.");
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

    /**
     * 
     */
    protected function executeAddConsumption(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $consoMan = $this->managers->getManagerOf('Consumptions');

            $datas = array(
                'id_car' => $request->getFromPost('car2') ? $request->getFromPost('car2') : 0,
                'id_circuit' => $request->getFromPost('circuit2') ? $request->getFromPost('circuit2') : 0,
                'value' => $request->getFromPost('consumption') ? $request->getFromPost('consumption') : 0
            );

            if($consumption = $consoMan->search($datas['id_car'], $datas['id_circuit']))
            {
                $consumption->setValue($datas['value']);
            }
            else
            {
                $consumption = new Consumption($datas);
            }

            if($consumption->isValid())
            {
                if($consoMan->save($consumption))
                {
                    $this->app()->user()->setMessage("Consommation ajoutée avec success.");
                }
            }
            else
            {
                $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.");
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

    /**
     * 
     */
    protected function executeInsert()
    {
        $consoMan = $this->managers->getManagerOf('Consumptions');

        $car = 1;
        $circuit = 0;
        $values = [2.9, 2.9, 3.5, 2.5, 2.9, 3.5, 2.6, 2.9, 2.5, 2.9, 3.6, 3.8, 3.3, 14, 2.5, 3.3, 2.7, 3.3, 2.7, 4.1, 3.6, 2.6, 3.4, 2.9, 2.7];
        //$values = [2.6, 2.6, 3.4, 2.3, 2.5, 2.9, 2.5, 2.6, 2.1, 2.4, 3.0, 3.5, 2.8, 13, 2.2, 2.9, 2.3, 2.9, 2.5, 3.6, 3.2, 2.5, 3.3, 2.5, 2.3];

        foreach($values as $value)
        {
            $circuit ++;

            $datas = array(
                'id_car' => $car,
                'id_circuit' => $circuit,
                'value' => $value
            );

            $consumption = new Consumption($datas);
            //$consoMan->save($consumption);
            
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

 }
