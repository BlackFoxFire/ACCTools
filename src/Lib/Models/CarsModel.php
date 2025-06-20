<?php

/**
 * CarsModel.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les enregistrements de la base de données de la table cars
 */

namespace Lib\Models;

use Blackfox\Database\Model;
use Lib\Entities\Car;

abstract class CarsModel extends Model
{
    /**
     * Oriente vers l'ajout ou la mise à jour d'un enregistrement
     * 
     * @param Car $car
     * 
     * @return int
     */
    public function save(Car $car): int
    {
        if ($car->isValid()) {
            return $car->isNew() ? $this->add($car) : $this->update($car);
        } else {
            throw new \RuntimeException("L'objet doit être validé avant d'être enregistré");
        }
    }

    /**
     * Ajoute un enregistrement
     * 
     * @param Car $car
     * 
     * @return int
     */
    abstract protected function add(Car $car): int;

    /**
     * Modifie un enregistrement
     * 
     * @param Car $car
     * 
     * @return int
     */
    abstract protected function update(Car $car): int;

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     */
    abstract public function readAll(): array;

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * 
     * @return Car|false
     */
    abstract public function searchById(int $id): Car|false;

    /**
     * Recherche un modèle de voiture
     * 
     * @param string $model
     * 
     * @return bool
     */
    abstract public function searchModel(string $model): bool;

    /**
     * Supprime un enregistrement
     * 
     * @param int $id
     * 
     * @return int
     */
    abstract public function delete(int $id): int;

}
