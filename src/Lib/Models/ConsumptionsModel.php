<?php

/**
 * ConsumptionsModel.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\Lib\Models;

use Blackfox\Database\Model;
use Blackfox\AccTools\Lib\Entities\Consumption;

abstract class ConsumptionsModel extends Model
{
    /**
     * Methodes
     */

    /**
     * Oriente vers l'ajout ou la mise à jour d'un enregistrement
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
     */
    abstract protected function add(Consumption $consumption): int;

    /**
     * Modifie un enregistrement
     */
    abstract protected function update(Consumption $consumption): int;

    /**
     * Retourne un enregistrement précis
     */
    abstract public function search(int $id_car, int $id_circuit): Consumption|FALSE;

    /**
     * Recherche tous les enregistrements sous formes brute
     */
    abstract public function rawData(): array;

    /**
     * Retourne tous les enregistrements
     */
    abstract public function readAll(): array;

    /**
     * Retourne tous les enregistrements pour un modelle de voiture
     */
    abstract public function readByCar(int $id_car): array;

    /**
     * Retourne tous les enregistrements pour un modèle de voiture et un circuit donné
     */
    abstract public function readByCarAndCircuit(int $id_car, int $id_circuit): array;

    /**
     * Retourne tous les enregistrements pour un circuit donné
     */
    abstract public function readByCircuit(int $id_circuit): array;
}
