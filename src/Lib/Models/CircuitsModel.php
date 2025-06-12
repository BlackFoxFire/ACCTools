<?php

/**
 * CircuitsModel.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les enregistrements de la base de données de la table circuits
 */

namespace Lib\Models;

use Blackfox\Database\Model;
use Lib\Entities\Circuit;

abstract class CircuitsModel extends Model
{
    /**
     * Oriente vers l'ajout ou la mise à jour d'un enregistrement
     * 
     * @param Circuit $circuit
     * 
     * @return int
     */
    public function save(Circuit $circuit): int
    {
        if($circuit->isValid())
        {
            return $circuit->isNew() ? $this->add($circuit) : $this->update($circuit);
        }
        else
        {
            throw new \RuntimeException("L'objet doit être validé avant d'être enregistré");
        }
    }

    /**
     * Ajoute un enregistrement
     * 
     * @param Circuit $circuit
     * 
     * @return int
     */
    abstract protected function add(Circuit $circuit): int;

    /**
     * Modifie un enregistrement
     * 
     * @param Circuit $circuit
     * 
     * @return int
     */
    abstract protected function update(Circuit $circuit): int;

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
     * @return Circuit|false
     */
    abstract public function searchById(int $id): Circuit|false;

    /**
     * Recherche un circuit par son nom
     * 
     * @param string $name
     * 
     * @return bool
     */
    abstract public function searchName(string $name): bool;

    /**
     * Supprime un enregistrement
     * 
     * @param int $id
     * 
     * @return int
     */
    abstract public function delete(int $id): int;

}
