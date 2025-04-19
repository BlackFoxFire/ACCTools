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
     * Un objet de type Consumption
     * @return int
     * Retourne le nombre d'enregistrement ecrit
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
     * Un objet de type Consumption
     * @return int
     * Retourne le nombre d'enregistrement ecrit
     */
    abstract protected function add(Consumption $consumption): int;

    /**
     * Modifie un enregistrement
     * 
     * @param Consumption $consumption
     * Un objet de type Consumption
     * @return int
     * Retourne le nombre d'enregistrement ecrit
     */
    abstract protected function update(Consumption $consumption): int;

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * Identifiant à rechercher
     * @return Consumption|FALSE
     * Retourne un objet Consumption en cas de succès, sinon false
     */
    abstract public function searchById(int $id): Consumption|false;

    /**
     * Retourne un enregistrement précis
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @param int $id_circuit
     * Identifiant du circuit
     * @return Consumption|FALSE
     * Retourne un objet Consumption en cas de succès, sinon false
     */
    abstract public function search(int $id_car, int $id_circuit): Consumption|FALSE;

    /**
     * Recherche tous les enregistrements sous formes brute
     * 
     * @return array
     * Retourne un tableau associatif
     */
    abstract public function rawData(): array;

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     * Retourne un tableau associatif
     */
    abstract public function readAll(): array;

    /**
     * Retourne tous les enregistrements pour un modele de voiture
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @return array
     * Retourne un tableau associatif
     */
    abstract public function readByCar(int $id_car): array;

    /**
     * Retourne tous les enregistrements pour un modèle de voiture et un circuit donné
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @param int $id_circuit
     * Identifiant du circuit
     * @return array
     * Retourne un tableau associatif
     */
    abstract public function readByCarAndCircuit(int $id_car, int $id_circuit): array;

    /**
     * Retourne tous les enregistrements pour un circuit donné
     * 
     * @param int $id_circuit
     * Identifiant du circuit
     * @return array
     * Retourne un tableau associatif
     */
    abstract public function readByCircuit(int $id_circuit): array;

    /**
     * Supprime un enregistrement
     * 
     * @param int $id
     * Identifiant de l'enregistrement à supprimer
     * @return int
     * Retourne le nombre d'enregistrement supprimé
     */
    abstract public function delete(int $id): int;
}
