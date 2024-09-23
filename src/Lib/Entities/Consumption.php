<?php

/**
 * Consumption.php
 * @Auteur : Christophe Dufour
 * 
 */

 namespace AccTools\Lib\Entities;

 use Mamba\Entity;
 use Mamba\Traits\DigitTester;

 class Consumption extends Entity
 {
    
    use DigitTester;

    /**
     * Constante
     */
    const BAD_IDCAR     = 1;
    const BAD_IDCIRCUIT = 2;
    const BAD_VALUE     = 3;
    
    /**
     * Attributs
     */
    protected int $id_car;          // Id d'une voiture
    protected int $id_circuit;      // id d'un circuit
    protected float $value;         // Valeur de la consommation

    /**
     * Getters
     * *******
     */

    /**
     * Retourne la valeur de l'attribut $id_car
     */
    public function id_car(): string
    {
        return $this->id_car;
    }

    /**
     * Retourne la valeur de l'attribut $id_circuit
     */
    public function id_circuit(): string
    {
        return $this->id_circuit;
    }

    /**
     * Retourne la valeur de l'attribut $value
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Setters
     * *******
     */

    /**
     * Modifie la valeur de l'attribut $id_car
     */
    public function setId_car(int $id_car): void
    {
        if($this->isInt($id_car) && $this->isPositive($id_car))
        {
            $this->id_car = $id_car;
        }
    }

    /**
     * Modifie la valeur de l'attribut $id_circuit
     */
    public function setId_circuit(int $id_circuit): void
    {
        if($this->isInt($id_circuit) && $this->isPositive($id_circuit))
        {
            $this->id_circuit = $id_circuit;
        }
    }

    /**
     * Modifie la valeur de l'attribut $value
     */
    public function setValue(int|float $value): void
    {
        if($this->isBetween($value, 1, 15))
        {
            $this->value = $value;
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
		return !$this->hasErrors() && !empty($this->id_car) && !empty($this->id_circuit) && !empty($this->value);
    }

    /**
     * Retourne l'objet sour forme de chaine de caratère
     */
	public function __toString(): string
	{
		return $this->value;
	}

}
