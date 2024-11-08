<?php

/**
 * CircuitsModel.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\Lib\Models;

use Blackfox\Database\Model;
use Blackfox\AccTools\Lib\Entities\Circuit;

abstract class CircuitsModel extends Model
{
    /**
     * Methodes
     */

    /**
     * Oriente vers l'ajout d'un enregistrement
     */
    public function save(Circuit $circuit): int
    {
        if($circuit->isValid())
        {
            return $this->add($circuit);
        }
        else
        {
            throw new \RuntimeException("L'objet doit être validé avant d'être enregistré");
        }
    }

    /**
     * Ajoute un enregistrement
     */
    abstract protected function add(Circuit $circuit): int;

    /**
     * Retourne tous les enregistrements
     */
    abstract public function readAll(): array;

    /**
     * Retourne true si la recherche d'un nom de circuit à été trouvé. Sinon false.
     */
    abstract public function searchName(string $name): bool;

}
