<?php

/**
 * CreateDBModel.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\Lib\Models;

use Blackfox\Database\Model;

abstract class CreateDBModel extends Model
{
    /**
     * Methodes
     */

    /**
     * Appelle les différentes functions pour créer la base de données
     * 
     * @return void
     */
    abstract public function createDB():  void;

    /**
     * Efface les anciennes tables
     * 
     * @return void
     */
    abstract protected function dropTable(): void;

    /**
     * Crée la table des voitures
     * 
     * @return void
     */
    abstract protected function createTableCars(): void;

    /**
     * Crée la table des circuits
     * 
     * @return void
     */
    abstract protected function createTableCircuits(): void;

    /**
     * Crée la table des consommations
     * 
     * @return void
     */
    abstract protected function createTableConsumptions(): void;

     /**
     * Ajoutes des voitures
     * 
     * @return void
     */
    abstract protected function insertCars(): void;

     /**
     * Ajoute des circuits
     * 
     * @return void
     */
    abstract protected function insertCircuits(): void;

    /**
     * Ajoute des consommations
     * 
     * @return void
     */
    abstract protected function insertConsumptions(): void;
    
}
