<?php

/**
 * Car.php
 * @Auteur : Christophe Dufour
 * 
 */

 namespace Blackfox\AccTools\Lib\Entities;

 use Blackfox\Mamba\Entity;

 class Car extends Entity
 {
    /**
     * Constante
     */
    const BAD_CAR = 1;
    
    /**
     * Attributs
     */

    // Modèle d'une voiture
    protected string $model;

    /**
     * Getters
     * *******
     */

    /**
     * Retourne la valeur de l'attribut $model
     */
    public function model(): string
    {
        return $this->model;
    }

    /**
     * Setters
     * *******
     */

    /**
     * Modifie la valeur de l'attribut $model
     */
    public function setModel(string $model): void
    {
        if(!empty($model))
        {
            $this->model = $model;
        }
    }

    /**
     * Methodes
     * ********
     */

    /**
     * Retourne true si l'objet est valide
     */
	public function isValid(): bool
	{
		return !$this->hasErrors() && !empty($this->model);
    }

    /**
     * Retourne l'objet sour forme de chaine de caratère
     */
	public function __toString(): string
	{
		return $this->model;
	}

}
