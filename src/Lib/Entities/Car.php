<?php

/**
 * Car.php
 * @Auteur : Christophe Dufour
 * 
 * Classe modélisant une voiture
 */

 namespace Lib\Entities;

 use Blackfox\Entities\Entity;

 class Car extends Entity
 {
    const BAD_CAR = 1;

    // Modèle d'une voiture
    protected string $model;
    // Est-ce une voiture favorite
    protected bool $favorite = false;

    /**
     * Retourne la valeur de model
     * 
     * @return string
     */
    public function model(): string
    {
        return $this->model;
    }

    /**
     * Retourne la valeur de favorite
     * 
     * @return bool
     */
    public function favorite(): bool
    {
        return $this->favorite;
    }

    /**
     * Modifie la valeur de model
     * 
     * @param string $model
     * 
     * @return void
     */
    public function setModel(string $model): void
    {
        if(!empty($model))
        {
            $this->model = $model;
        }
    }

    /**
     * Modifie la valeur de favorite
     * 
     * @param bool $favorite
     * 
     * @return void
     */
    public function setFavorite(bool $favorite): void
    {
        $this->favorite = $favorite;
    }

    /**
     * Vérifie si un object est valide
     * 
     * @return bool
     * Retourne true en cas de succès, sinon false
     */
	public function isValid(): bool
	{
		return !$this->hasErrors() && !empty($this->model) && is_bool($this->favorite);
    }

    /**
     * Retourne l'objet sous forme de chaine de caratère
     * 
     * @return string
     */
	public function __toString(): string
	{
		return $this->model;
	}

}
