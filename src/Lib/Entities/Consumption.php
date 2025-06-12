<?php

/**
 * Consumption.php
 * @Auteur : Christophe Dufour
 * 
 * Classe modélisant une consommation
 */

 namespace Lib\Entities;

 use Blackfox\Entities\Entity;
 use Blackfox\DigitalChainTest\DigitalChainTest;

 class Consumption extends Entity
 {
    const BAD_IDCAR     = 1;
    const BAD_IDCIRCUIT = 2;
    const BAD_VALUE     = 3;
    
    // Id d'une voiture
    protected int $id_car;
    // id d'un circuit
    protected int $id_circuit;
    // Valeur de la consommation
    protected float $value;
    // Date de la dernière mise à jour
    protected \DateTime|null $update_time;

    /**
     * Retourne la valeur de id_car
     * 
     * @return int
     */
    public function id_car(): int
    {
        return $this->id_car;
    }

    /**
     * Retourne la valeur de id_circuit
     * 
     * @return int
     */
    public function id_circuit(): int
    {
        return $this->id_circuit;
    }

    /**
     * Retourne la valeur de value
     * 
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * Retourne la valeur de update_time
     * 
     * @return DateTime|null
     */
    public function update_time(): \DateTime|null
    {
        return $this->update_time;
    }

    /**
     * Modifie la valeur de id_car
     * 
     * @param int $id_car
     * 
     * @return void
     */
    public function setId_car(int $id_car): void
    {
        if(DigitalChainTest::isInt($id_car) && DigitalChainTest::isPositive($id_car))
        {
            $this->id_car = $id_car;
        }
    }

    /**
     * Modifie la valeur de id_circuit
     * 
     * @param int $id_circuit
     * 
     * @return void
     */
    public function setId_circuit(int $id_circuit): void
    {
        if(DigitalChainTest::isInt($id_circuit) && DigitalChainTest::isPositive($id_circuit))
        {
            $this->id_circuit = $id_circuit;
        }
    }

    /**
     * Modifie la valeur de value
     * 
     * @param int|float $value
     * 
     * @return void
     */
    public function setValue(int|float $value): void
    {
        if(DigitalChainTest::isBetween($value, 1, 15))
        {
            $this->value = $value;
        }
    }

    /**
     * Retourne la valeur de $update_time
     * 
     * @param string|null $update_time
     * 
     * @return void
     */
    public function setUpdate_time(string|null $update_time): void
    {
        if(!is_null($update_time)) {
            $update_time = new \DateTime($update_time);
        }

        $this->update_time = $update_time;
    }

    /**
     * Vérifie si un object est valide
     * 
     * @return bool
     * Retourne true en cas de succès, sinon false
     */
	public function isValid(): bool
	{
		return !$this->hasErrors() && !empty($this->id_car) && !empty($this->id_circuit) && !empty($this->value);
    }

    /**
     * Retourne la date de mise à jour
     * 
     * @return string
     * Retourne une date sous forme de chaine de caractère en cas de succès, sinon une chaine vide
     */
    public function update_timeAsString(): string
    {
        if(is_null($this->update_time)) {
            return '';
        }

        return $this->update_time->format("d-m-y");
    }

    /**
     * Retourne l'objet sour forme de chaine de caratère
     * 
     * @return string
     */
	public function __toString(): string
	{
		return $this->value;
	}

}
