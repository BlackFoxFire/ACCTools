<?php

/**
 * AccController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace App\Backend\Controllers\Acc;

use Blackfox\BackController;
use Blackfox\HTTPRequest;
use Blackfox\Config\Link;

class AccController extends BackController
{
    /**
     * Gestion des voitures
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeCars(HTTPRequest $request): void
    {
        $carMan = $this->modelFactory->create('Cars');
        $datas['carQuantity'] = $carMan->count('cars');

        if ($datas['carQuantity'] > 0) {
            $datas['cars'] = $carMan->readAll();
        }

        $this->view->setData($datas);
    }

    /**
     * Ajoute une voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeAddCar(HTTPRequest $request): void
    {
        if ($request->formIsSubmit()) {
            $carMan = $this->modelFactory->create('Cars');
            $datas['model'] = $request->getFromPost('car');

            if (!$carMan->searchModel($datas['model'])) {
                $car = $this->entityFactory->create("Car", $datas);

                if ($car->isValid()) {
                    if (!$carMan->save($car)) {
                        throw new \Exception("Erreur de communication avec la base de données.");
                    }

                    $this->app()->user()->setMessage("Modèle de voiture ajouté avec success.");
                }
                else {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.", true);
                }
            }
            else {
                $this->app()->user()->setMessage("Modèle déjà présent dans la base de données.", true);
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_cars'));
    }

    /**
     * Edite une voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeEditCar(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCar = $request->getFromGet('idCar');

        if(strcmp($security, $this->app->user()->get('security')) != 0) {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
            $this->app->httpResponse()->redirect(Link::get('url_cars'));
        }

        $carMan = $this->modelFactory->create('Cars');

        if(!$datas['car'] = $carMan->searchById($idCar)) {
            $this->app->user()->setMessage("Erreur: Voiture introuvable en base de données.", true);
            $this->app->httpResponse()->redirect(Link::get('url_cars'));
        }

        $this->view->setData($datas);
    }

    /**
     * Modifie une voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeModifyCar(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCar = $request->getFromGet('idCar');

        if(strcmp($security, $this->app->user()->get('security')) != 0) {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
            $this->app->httpResponse()->redirect(Link::get('url_cars'));
        }

        if ($request->formIsSubmit()) {
            $carMan = $this->modelFactory->create('Cars');
            $datas['model'] = $request->getFromPost('car');
            
            if ($carMan->searchModel($datas['model'])) {
                $this->app()->user()->setMessage("Modèle déjà présent dans la base de données.", true);
                $this->app->httpResponse()->redirect(Link::get('url_editCar') . $security . "-" . $idCar);
            }

            if($car = $carMan->searchById($idCar)) {
                $car->setModel($datas['model']);

                if ($car->isValid()) {
                    if (!$carMan->save($car)) {
                        throw new \Exception("Erreur de communication avec la base de données.");
                    }

                    $this->app()->user()->setMessage("Voiture modifiée avec success.");
                }
                else {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.", true);
                }
            }
            else {
                $this->app->user()->setMessage("Erreur: Voiture introuvable en base de données.", true);
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_cars'));
    }

    /**
     * Modifie le statut favoris d'une voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeFavoriteCar(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCar = $request->getFromGet('idCar');

        if (strcmp($security, $this->app->user()->get('security')) == 0) {
            $carMan = $this->modelFactory->create('Cars');

            if ($car = $carMan->searchById($idCar)) {
                $car->setFavorite(!$car->favorite());

                if (!$carMan->save($car)) {
                    throw new \Exception("Erreur de communication avec la base de données.");
                }

                if ($car->favorite()) {
                    $this->app->user()->setMessage("Voiture ajoutée aux favorites.");
                }
                else {
                    $this->app->user()->setMessage("Voiture retirée des favorites.");
                }
            }
            else {
                $this->app->user()->setMessage("Erreur: Voiture introuvable en base de données.", true);
            }
        }
        else {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
        }

        $this->app->httpResponse()->redirect(Link::get('url_cars'));
    }

    /**
     * Supprime une voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeDeleteCar(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCar = $request->getFromGet('idCar');

        if (strcmp($security, $this->app->user()->get('security')) == 0) {
            $carMan = $this->modelFactory->create('Cars');

            if ($car = $carMan->searchById($idCar)) {
                if (!$carMan->delete($idCar)) {
                    throw new \Exception("Erreur de communication avec la base de données.");
                }

                $this->app->user()->setMessage("Enregistrement supprimé avec succès.");
            }
            else {
                $this->app->user()->setMessage("Erreur: Voiture introuvable en base de données.", true);
            }
        }
        else {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
        }

        $this->app->httpResponse()->redirect(Link::get('url_cars'));
    }

    /**
     * Gestion des circuits
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeCircuits(HTTPRequest $request): void
    {
        $circuitMan = $this->modelFactory->create('Circuits');
        $datas['circuitQuantity'] = $circuitMan->count('circuits');

        if ($datas['circuitQuantity'] > 0) {
            $datas['circuits'] = $circuitMan->readAll();
        }

        $this->view->setData($datas);
    }

    /**
     * Ajoute un circuit
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeAddCircuit(HTTPRequest $request): void
    {
        if ($request->formIsSubmit()) {
            $circuitMan = $this->modelFactory->create('Circuits');
            $datas['name'] = $request->getFromPost('circuit');

            if (!$circuitMan->searchName($datas['name'])) {
                $circuit = $this->entityFactory->create("Circuit", $datas);

                if ($circuit->isValid()) {
                    if (!$circuitMan->save($circuit)) {
                        throw new \Exception("Erreur de communication avec la base de données.");
                    }

                    $this->app()->user()->setMessage("Circuit ajouté avec success.");
                }
                else {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.", true);
                }
            }
            else {
                $this->app()->user()->setMessage("Circuit déjà présent dans la base de données.", true);
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_circuits'));
    }

    /**
     * Edite un circuit
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeEditCircuit(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCircuit = $request->getFromGet('idCircuit');

        if(strcmp($security, $this->app->user()->get('security')) != 0) {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
            $this->app->httpResponse()->redirect(Link::get('url_circuit'));
        }

        $circuitMan = $this->modelFactory->create('Circuits');

        if(!$datas['circuit'] = $circuitMan->searchById($idCircuit)) {
            $this->app->user()->setMessage("Erreur: Circuit introuvable en base de données.", true);
            $this->app->httpResponse()->redirect(Link::get('url_circuit'));
        }

        $this->view->setData($datas);
    }

    /**
     * Modifie un circuit
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeModifyCircuit(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCircuit = $request->getFromGet('idCircuit');

        if(strcmp($security, $this->app->user()->get('security')) != 0) {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
            $this->app->httpResponse()->redirect(Link::get('url_circuit'));
        }

        if ($request->formIsSubmit()) {
            $circuitMan = $this->modelFactory->create('Circuits');
            $datas['name'] = $request->getFromPost('circuit');

            if ($circuitMan->searchName($datas['name'])) {
                $this->app()->user()->setMessage("Circuit déjà présent dans la base de données.", true);
                $this->app->httpResponse()->redirect(Link::get('url_editCircuit') . $security . "-" . $idCircuit);
            }
            
            if($circuit = $circuitMan->searchById($idCircuit)) {
                $circuit->setName($datas['name']);

                if ($circuit->isValid()) {
                    if (!$circuitMan->save($circuit)) {
                        throw new \Exception("Erreur de communication avec la base de données.");
                    }

                    $this->app()->user()->setMessage("Circuit modifié avec success.");
                }
                else {
                    $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.");
                }
            }
            else {
                $this->app->user()->setMessage("Erreur: Circuit introuvable en base de données.", true);
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_circuits'));
    }

    /**
     * Supprime un circuit
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeDeleteCircuit(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idCircuit = $request->getFromGet('idCircuit');

        if (strcmp($security, $this->app->user()->get('security')) == 0) {
            $circuitMan = $this->modelFactory->create('Circuits');

            if ($circuit = $circuitMan->searchById($idCircuit)) {
                if (!$circuitMan->delete($idCircuit)) {
                    throw new \Exception("Erreur de communication avec la base de données.");
                }

                $this->app->user()->setMessage("Enregistrement supprimé avec succès.");
            }
            else {
                $this->app->user()->setMessage("Erreur: Voiture introuvable en base de données.", true);
            }
        }
        else {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
        }

        $this->app->httpResponse()->redirect(Link::get('url_circuits'));
    }

    /**
     * Gestion des consommations
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeConsumptions(HTTPRequest $request): void
    {
        $carMan = $this->modelFactory->create('Cars');
        $circuitMan = $this->modelFactory->create('Circuits');
        $consoMan = $this->modelFactory->create('Consumptions');

        $cars = $carMan->readAll();
        $circuits = $circuitMan->readAll();

        $datas = array(
            'cars' => $cars,
            'circuits' => $circuits,
            'id_circuit' => 0
        );

        if (isset($cars[0])) {
            $datas['id_car'] = $cars[0]->id();
        }

        if ($request->formIsSubmit()) {
            $id_car = $request->getFromPost('carConsumption') ? $request->getFromPost('carConsumption') : 0;
            $id_circuit = $request->getFromPost('circuitConsumption');

            if ($id_car != 0 && $id_circuit == 0) {
                $datas['id_car'] = $id_car;
                $consumptions = $consoMan->readByCar($id_car);
            }
            elseif ($id_car != 0 && $id_circuit != 0) {
                $datas['id_car'] = $id_car;
                $datas['id_circuit'] = $id_circuit;
                $consumptions = $consoMan->readByCarAndCircuit($id_car, $id_circuit);
            }
            elseif ($id_car == 0 && $id_circuit != 0) {
                $datas['id_car'] = 0;
                $datas['id_circuit'] = $id_circuit;
                $consumptions = $consoMan->readByCircuit($id_circuit);
            }
            else {
                $datas['id_car'] = 0;
                $consumptions = $consoMan->readAll();
            }
        }
        else {
            //$consumptions = $consoMan->readAll();
            if (isset($cars[0])) {
                $consumptions = $consoMan->readByCar($cars[0]->id());
            }
        }

        if(isset($consumptions)) {
            $i=0;
            foreach ($consumptions as $consumption) {
                if (!is_null($consumption['update_time'])) {
                    $update_time = new \DateTime($consumption['update_time']);
                    $consumptions[$i]['update_time'] = $update_time->format("d-m-y");
                }
                $i ++;
            }

            $datas['consumptions'] = $consumptions;
        }
        
        $this->view->setData($datas);
    }

    /**
     * Ajoute une consommation
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeAddConsumption(HTTPRequest $request): void
    {
        if ($request->formIsSubmit()) {
            $consoMan = $this->modelFactory->create('Consumptions');

            $datas = array(
                'id_car' => $request->getFromPost('car2') ? $request->getFromPost('car2') : 0,
                'id_circuit' => $request->getFromPost('circuit2') ? $request->getFromPost('circuit2') : 0,
                'value' => $request->getFromPost('consumption') ? $request->getFromPost('consumption') : 0
            );

            if ($consumption = $consoMan->search($datas['id_car'], $datas['id_circuit'])) {
                $consumption->setValue($datas['value']);
            }
            else {
                $consumption = $this->entityFactory->create("Consumption", $datas);
            }

            if ($consumption->isValid()) {
                if ($consoMan->save($consumption)) {
                    $this->app()->user()->setMessage("Consommation ajoutée avec success.");
                }
            }
            else {
                $this->app()->user()->setMessage("Erreur! Aucune modification effectuée.");
            }
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

    /**
     * Supprime une consommation
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeDeleteConsumption(HTTPRequest $request): void
    {
        $security = $request->getFromGet('security');
        $idConsumption = $request->getFromGet('idConsumption');

        if (strcmp($security, $this->app->user()->get('security')) == 0) {
            $consoMan = $this->modelFactory->create('Consumptions');

            if ($consumption = $consoMan->searchById($idConsumption)) {
                if (!$consoMan->delete($idConsumption)) {
                    throw new \Exception("Erreur de communication avec la base de données.");
                }

                $this->app->user()->setMessage("Enregistrement supprimé avec succès.");
            }
            else {
                $this->app->user()->setMessage("Erreur: Consommation introuvable en base de données.", true);
            }
        }
        else {
            $this->app->user()->setMessage("Erreur: Jeton de sécurité invalide.", true);
        }

        $this->app->httpResponse()->redirect(Link::get('url_admin'));
    }

    /**
     * Ajoute des valeurs prédéfinies pour une marque de voiture
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    protected function executeInsert(HTTPRequest $request): void
    {
        $cars[0]['id'] = 5;
        $cars[0]['car'] = "BMW M4 GT3";
        $cars[1]['id'] = 7;
        $cars[1]['car'] = "Ferrari 296 GT3";

        $datas['cars'] = $cars;

        $values[5] = [2.9, 2.9, 3.5, 2.5, 2.9, 3.5, 2.6, 2.9, 2.5, 2.9, 3.6, 3.8, 3.3, 14, 2.5, 3.3, 2.7, 3.3, 2.7, 4.1, 3.6, 2.6, 3.4, 2.9, 2.7];
        $values[7] = [2.6, 2.6, 3.4, 2.3, 2.5, 2.9, 2.5, 2.6, 2.1, 2.4, 3.0, 3.5, 2.8, 13, 2.2, 2.9, 2.3, 2.9, 2.5, 3.6, 3.2, 2.5, 3.3, 2.5, 2.3];

        if($request->formIsSubmit()) {
            $consoMan = $this->modelFactory->create('Consumptions');
            $car = $request->getFromPost('car');
            $circuit = 0;

            foreach ($values[$car] as $value) {
                $circuit++;

                $datas = array(
                    'id_car' => $car,
                    'id_circuit' => $circuit,
                    'value' => $value
                );

                $consumption = $this->entityFactory->create("Consumption", $datas);
                $consoMan->save($consumption);
            }

            $this->app->httpResponse()->redirect(Link::get('url_insert'));
        }

        $this->view->setData($datas);
    }

    /**
     * Permet la déconnexion de la zone d'administration
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    public function executeDeconnection(HTTPRequest $request): void
    {
        $this->app->user()->setAuthenticated(false);
        $this->app->httpResponse()->redirect(Link::get('url_index'));
    }

}
