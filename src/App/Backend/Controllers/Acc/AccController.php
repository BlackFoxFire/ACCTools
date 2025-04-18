<?php

/**
 * AccController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace App\Backend\Controllers\Acc;

use Blackfox\BackController;
use Blackfox\HTTPRequest;
use Lib\Entities\Car;
use Lib\Entities\Circuit;
use Lib\Entities\Consumption;

class AccController extends BackController
{

    /**
     * Affiche la page principale d'administration
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeIndex(HTTPRequest $request): void
    {
        $carMan = $this->modelFactory->create('Cars');
        $circuitMan = $this->modelFactory->create('Circuits');
        $consoMan = $this->modelFactory->create('Consumptions');

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

        foreach($consumptions as $consumption) {
            if(!is_null($consumption['update_time'])) {
                $update_time = new \DateTime($consumption['update_time']);
                $consumption['update_time'] = $update_time->format("d-m-Y à H:i");
            }
        }

        $datas['consumptions'] = $consumptions;
        $this->view->setData($datas);
    }

    /**
     * Ajoute une voiture
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeAddCar(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $carMan = $this->modelFactory->create('Cars');
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

        $this->app->httpResponse()->redirect($this->app->link()->get('url_admin'));
    }

    /**
     * Ajoute un circuit
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeAddCircuit(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $circuitMan = $this->modelFactory->create('Circuits');
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

        $this->app->httpResponse()->redirect($this->app->link()->get('url_admin'));
    }

    /**
     * Ajoute une consommation
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeAddConsumption(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $consoMan = $this->modelFactory->create('Consumptions');

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

        $this->app->httpResponse()->redirect($this->app->link()->get('url_admin'));
    }

    /**
     * Ajoute des valeurs prédéfinies pour une marque de voiture
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeInsert()
    {
        $consoMan = $this->modelFactory->create('Consumptions');

        $car = 5; // BMW M4 GT3
        //$car = 7; // Ferrari 296 GT3
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

        $this->app->httpResponse()->redirect($this->app->link()->get('url_admin'));
    }

    /**
     * Permet la déconnexion de la zone d'administration
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    public function executeDeconnection(HTTPRequest $request): void
    {
        $this->app->user()->setAuthenticated(false);
        $this->app->httpResponse()->redirect($this->app->link()->get('url_index'));
    }

 }
