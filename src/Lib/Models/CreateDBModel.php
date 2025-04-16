<?php

/**
 * CreateDBModel.php
 * @Auteur : Christophe Dufour
 * 
 * Gère la créationn de la base de données
 */

namespace Lib\Models;

use Blackfox\Database\Model;

abstract class CreateDBModel extends Model
{

    /**
     * Appelle les différentes functions pour créer la base de données
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract public function createDB():  void;

    /**
     * Efface les anciennes tables
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function dropTable(): void;

    /**
     * Crée la table des voitures
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function createTableCars(): void;

    /**
     * Crée la table des circuits
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function createTableCircuits(): void;

    /**
     * Crée la table des consommations
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function createTableConsumptions(): void;

     /**
     * Ajoutes des voitures
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function insertCars(): void;

     /**
     * Ajoute des circuits
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function insertCircuits(): void;

    /**
     * Ajoute des consommations
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    abstract protected function insertConsumptions(): void;
    
}
