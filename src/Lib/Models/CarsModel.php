<?php

/**
 * CarsModel.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Lib\Models;

use Blackfox\Database\Model;
use Lib\Entities\Car;

abstract class CarsModel extends Model
{
    /**
     * Methodes
     */

    /**
     * Oriente vers l'ajout d'un enregistrement
     */
    public function save(Car $car): int
    {
        if($car->isValid())
        {
            return $this->add($car);
        }
        else
        {
            throw new \RuntimeException("L'objet doit être validé avant d'être enregistré");
        }
    }

    /**
     * Ajoute un enregistrement
     */
    abstract protected function add(Car $car): int;

    /**
     * Retourne tous les enregistrements
     */
    abstract public function readAll(): array;

    /**
     * Retourne true si la recherche d'un modèle de voiture à été trouvé. Sinon false.
     */
    abstract public function searchModel(string $model): bool;

}
