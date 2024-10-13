<?php

/**
 * Circuit.php
 * @Auteur : Christophe Dufour
 * 
 */

 namespace Blackfox\AccTools\Lib\Entities;

 use Blackfox\Mamba\Entity;

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
     * *******
     */

    /**
     * Retourne la valeur de l'attribut $name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Setters
     * *******
     */

    /**
     * Modifie la valeur de l'attribut $name
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
     * ********
     */

    /**
     * Retourne true si l'objet est valide
     */
	public function isValid(): bool
	{
		return !$this->hasErrors() && !empty($this->name);
    }

    /**
     * Retourne l'objet sour forme de chaine de caratère
     */
	public function __toString(): string
	{
		return $this->name;
	}

}
