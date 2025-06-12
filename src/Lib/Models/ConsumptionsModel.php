<?php

/**
 * ConsumptionsModel.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les consommations en base de données
 */

namespace Lib\Models;

use Blackfox\Database\Model;
use Lib\Entities\Consumption;

abstract class ConsumptionsModel extends Model
{
    /**
     * Oriente vers l'ajout ou la mise à jour d'un enregistrement
     * 
     * @param Consumption $consumption
     * 
     * @return int
     */
    public function save(Consumption $consumption): int
    {
        if($consumption->isValid())
        {
            return $consumption->isNew() ? $this->add($consumption) : $this->update($consumption);
        }
        else
        {
            throw new \RuntimeException("L'objet doit être validé avant d'être enregistré");
        }
    }

    /**
     * Ajoute un enregistrement
     * 
     * @param Consumption $consumption
     * 
     * @return int
     */
    abstract protected function add(Consumption $consumption): int;

    /**
     * Modifie un enregistrement
     * 
     * @param Consumption $consumption
     * 
     * @return int
     */
    abstract protected function update(Consumption $consumption): int;

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * 
     * @return Consumption|FALSE
     */
    abstract public function searchById(int $id): Consumption|false;

    /**
     * Retourne un enregistrement précis
     * 
     * @param int $id_car
     * 
     * @param int $id_circuit
     * 
     * @return Consumption|FALSE
     */
    abstract public function search(int $id_car, int $id_circuit): Consumption|FALSE;

    /**
     * Recherche tous les enregistrements sous formes brute
     * 
     * @return array
     */
    abstract public function rawData(): array;

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     */
    abstract public function readAll(): array;

    /**
     * Retourne tous les enregistrements pour un modele de voiture
     * 
     * @param int $id_car
     * 
     * @return array
     */
    abstract public function readByCar(int $id_car): array;

    /**
     * Retourne tous les enregistrements pour un modèle de voiture et un circuit donné
     * 
     * @param int $id_car
     * 
     * @param int $id_circuit
     * 
     * @return array
     */
    abstract public function readByCarAndCircuit(int $id_car, int $id_circuit): array;

    /**
     * Retourne tous les enregistrements pour un circuit donné
     * 
     * @param int $id_circuit
     * 
     * @return array
     */
    abstract public function readByCircuit(int $id_circuit): array;

    /**
     * Supprime un enregistrement
     * 
     * @param int $id
     * 
     * @return int
     */
    abstract public function delete(int $id): int;
    
}
