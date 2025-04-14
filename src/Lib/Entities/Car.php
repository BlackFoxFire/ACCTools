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
    /**
     * Constante
     */
    const BAD_CAR = 1;
    
    /**
     * Attributs
     */

    // Modèle d'une voiture
    protected string $model;
    // Est-ce une voiture favorite
    protected bool $favorite = false;

    /**
     * Getters
     */

    /**
     * Retourne la valeur de l'attribut $model
     * 
     * @return string
     * Retourne le model de voiture
     */
    public function model(): string
    {
        return $this->model;
    }

    /**
     * Retourne la valeur de l'attribut $favorite
     * 
     * @return bool
     * Retourne true si la voiture est dans les favorites, sinon false
     */
    public function favorite(): bool
    {
        return $this->favorite;
    }

    /**
     * Setters
     */

    /**
     * Modifie la valeur de l'attribut $model
     * 
     * @param string $model
     * Modèle d'une voiture
     * @return void
     * Ne retourne aucune valeur
     */
    public function setModel(string $model): void
    {
        if(!empty($model))
        {
            $this->model = $model;
        }
    }

    /**
     * Modifie la valeur de l'attribut $favorite
     * 
     * @param bool $favorite
     * Un booléen, true si la voiture dans la liste des favorites, sinon false
     * @return void
     * Ne retourne aucune valeur
     */
    public function setFavorite(bool $favorite): void
    {
        $this->favorite = $favorite;
    }

    /**
     * Methodes
     */

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
     * Retourne l'objet sour forme de chaine de caratère
     * 
     * @return string
     * Retourne le model de voiture
     */
	public function __toString(): string
	{
		return $this->model;
	}

}
