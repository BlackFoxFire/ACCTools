<?php

/**
 * Consumption.php
 * @Auteur : Christophe Dufour
 * 
 */

 namespace Blackfox\AccTools\Lib\Entities;

 use Blackfox\Mamba\Entity;
 use Blackfox\DigitalChainTest\DigitalChainTest;

 class Consumption extends Entity
 {

    /**
     * Constante
     */
    const BAD_IDCAR     = 1;
    const BAD_IDCIRCUIT = 2;
    const BAD_VALUE     = 3;
    
    /**
     * Attributs
     */
    protected int $id_car;              // Id d'une voiture
    protected int $id_circuit;          // id d'un circuit
    protected float $value;             // Valeur de la consommation
    protected \DateTime|null $update_time;   // Date de la dernière mise à jour

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
     * Retourne la valeur de l'attribut $update_time
     */
    public function update_time(): \DateTime|null
    {
        return $this->update_time == null ? null : $this->update_time->format("d-m-Y à H:i");
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
        if(DigitalChainTest::isInt($id_car) && DigitalChainTest::isPositive($id_car))
        {
            $this->id_car = $id_car;
        }
    }

    /**
     * Modifie la valeur de l'attribut $id_circuit
     */
    public function setId_circuit(int $id_circuit): void
    {
        if(DigitalChainTest::isInt($id_circuit) && DigitalChainTest::isPositive($id_circuit))
        {
            $this->id_circuit = $id_circuit;
        }
    }

    /**
     * Modifie la valeur de l'attribut $value
     */
    public function setValue(int|float $value): void
    {
        if(DigitalChainTest::isBetween($value, 1, 15))
        {
            $this->value = $value;
        }
    }

    /**
     * Retourne la valeur de l'attribut $update_time
     */
    public function setUpdate_time(string|null $update_time): void
    {
        if ($update_time == null) {
            $this->update_time = null;
        }
        else {
            $this->update_time = new \DateTime($update_time);
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
