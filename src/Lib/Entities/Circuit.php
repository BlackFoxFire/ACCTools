<?php

/**
 * Circuit.php
 * @Auteur : Christophe Dufour
 * 
 * Classe modélisant un circuit
 */

 namespace Lib\Entities;

 use Blackfox\Entities\Entity;

 class Circuit extends Entity
 {
    /**
     * Constante
     */
    const BAD_CIRCUIT = 1;
    
    /**
     * Attributs
     */

    // Nom d'un circuit
    protected string $name;

    /**
     * Getters
     */

    /**
     * Retourne la valeur de l'attribut $name
     * 
     * @return string
     * Retourne le mom du circuit
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Setters
     */

    /**
     * Modifie la valeur de l'attribut $name
     * 
     * @param string $name
     * Mom du circuit
     * @return void
     * Ne retourne aucune valeur
     */
    public function setName(string $name): void
    {
        if(!empty($name))
        {
            $this->name = $name;
        }
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
		return !$this->hasErrors() && !empty($this->name);
    }

    /**
     * Retourne l'objet sour forme de chaine de caratère
     * 
     * @return string
     * Retourne le nom du circuit
     */
	public function __toString(): string
	{
		return $this->name;
	}

}
