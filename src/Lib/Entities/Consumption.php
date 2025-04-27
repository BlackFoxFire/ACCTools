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

    /**
     * Constante
     */
    const BAD_IDCAR     = 1;
    const BAD_IDCIRCUIT = 2;
    const BAD_VALUE     = 3;
    
    /**
     * Attributs
     */
    protected int $id_car;                  // Id d'une voiture
    protected int $id_circuit;              // id d'un circuit
    protected float $value;                 // Valeur de la consommation
    protected \DateTime|null $update_time;  // Date de la dernière mise à jour

    /**
     * Getters
     */

    /**
     * Retourne la valeur de l'attribut $id_car
     * 
     * @return int
     * Retourne l'identifiant de la voiture
     */
    public function id_car(): int
    {
        return $this->id_car;
    }

    /**
     * Retourne la valeur de l'attribut $id_circuit
     * 
     * @return int
     * Retourne l'identifiant du circuit
     */
    public function id_circuit(): int
    {
        return $this->id_circuit;
    }

    /**
     * Retourne la valeur de l'attribut $value
     * 
     * @return float
     * Retourne la valeur de la consommation
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * Retourne la valeur de l'attribut $update_time
     * 
     * @return DateTime|null
     * Retourne un format DateTime si la consommation a été mise à jour, sinon null
     */
    public function update_time(): \DateTime|null
    {
        return $this->update_time;
    }

    /**
     * Setters
     */

    /**
     * Modifie la valeur de l'attribut $id_car
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @return void
     * Ne retourne aucune valeur
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
     * 
     * @param int $id_circuit
     * Identifiant du circuit
     * @return void
     * Ne retourne aucune valeur
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
     * 
     * @param int|float $value
     * Valeur de la consommation
     * @return void
     * Ne retourne aucune valeur
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
     * 
     * @param string|null $update_time
     * Date de la mise à jour
     * @return void
     * Ne retourne aucune valeur
     */
    public function setUpdate_time(string|null $update_time): void
    {
        if(!is_null($update_time)) {
            $update_time = new \DateTime($update_time);
        }

        $this->update_time = $update_time;
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
     * Retourne la valeur de la consommation
     */
	public function __toString(): string
	{
		return $this->value;
	}

}
