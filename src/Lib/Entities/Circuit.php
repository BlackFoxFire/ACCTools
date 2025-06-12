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
    const BAD_CIRCUIT = 1;

    // Nom d'un circuit
    protected string $name;

    /**
     * Retourne la valeur de name
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Modifie la valeur de name
     * 
     * @param string $name
     * 
     * @return void
     */
    public function setName(string $name): void
    {
        if(!empty($name))
        {
            $this->name = $name;
        }
    }

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
     */
	public function __toString(): string
	{
		return $this->name;
	}

}
