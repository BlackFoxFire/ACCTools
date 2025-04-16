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
     * Un objet de type Circuit
     * @return int
     * Retourne le nombre d'enregistrement ecrit
     */
    public function save(Circuit $circuit): int
    {
        if($circuit->isValid())
        {
            //return $circuit->isNew() ? $this->add($circuit) : $this->update($circuit);
            return $this->add($circuit);
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
     * Un objet de type Circuit
     * @return int
     * Retourne le nombre d'enregistrement écrit
     */
    abstract protected function add(Circuit $circuit): int;

    /**
     * Modifie un enregistrement
     * 
     * @param Circuit $circuit
     * Un objet de type Circuit
     * @return int
     * Retourne le nombre d'enregistrement écrit
     */
    abstract protected function update(Circuit $circuit): int;

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     * Retourne un tableau d'objet Circuit
     */
    abstract public function readAll(): array;

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * Identifiant à rechercher
     * @return Circuit|false
     * Retourne un objet Circuit en cas de succès, sinon false
     */
    abstract public function searchById(int $id): Circuit|false;

    /**
     * Recherche un circuit par son nom
     * 
     * @param string $name
     * La chaine à rechercher
     * @return bool
     * Retourne true en cas de succès, sinon false
     */
    abstract public function searchName(string $name): bool;

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
