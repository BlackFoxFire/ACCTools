<?php

/**
 * ConsumptionsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les consommations en base de données
 */

namespace Lib\Models;

use Lib\Entities\Consumption;

class ConsumptionsModelPDO extends ConsumptionsModel
{
    /**
     * Ajoute un enregistrement
     * 
     * @param Consumption $consumption
     * Un objet de type Consumption
     * @return int
     * Retourne le nombre d'enregistrement ecrit
     */
    protected function add(Consumption $consumption): int
    {
        $sql = "insert into consumptions(id_car, id_circuit, value) value(?, ?, ?)";

        $datas = array(
            $consumption->id_car(),
            $consumption->id_circuit(),
            $consumption->value()
        );

        $request = $this->execute($sql, $datas);
        $counter = $request->rowCount();
		$request->closeCursor();

        return $counter;
    }

    /**
     * Modifie un enregistrement
     * 
     * @param Consumption $consumption
     * Un objet de type Consumption
     * @return int
     * Retourne le nombre d'enregistrement ecrit
     */
    protected function update(Consumption $consumption): int
    {
        $sql = "update consumptions set value=?,  update_time=now() where id=?";

        $datas = array(
            $consumption->value(),
            $consumption->id()
        );

        $request = $this->execute($sql, $datas);
        $counter = $request->rowCount();
		$request->closeCursor();

        return $counter;
    }

    /**
     * Retourne un enregistrement précis
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @param int $id_circuit
     * Identifiant du circuit
     * @return Consumption|FALSE
     * Retourne un objet Consumption en cas de succès, sinon false
     */
    public function search(int $id_car, int $id_circuit): Consumption|FALSE
    {
        $sql = "select * from consumptions where id_car=? and id_circuit=?";

        $request = $this->execute($sql, [$id_car, $id_circuit]);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetch();
		$request->closeCursor();

        $consumption = false;

        if($datas) {
            $consumption = new Consumption($datas);
        }

        return $consumption;
    }

    /**
     * Recherche tous les enregistrements sous formes brute
     * 
     * @return array
     * Retourne un tableau associatif
     */
    public function rawData(): array
    {
        $sql = "select * from consumptions order by id_car, id_circuit";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     * Retourne un tableau associatif
     */
    public function readAll(): array
    {
        $sql  = "select consumptions.id, cars.model, circuits.name, consumptions.value, consumptions.update_time ";
        $sql .= "from consumptions ";
        $sql .= "join cars on cars.id = consumptions.id_car ";
        $sql .= "join circuits on circuits.id = consumptions.id_circuit ";
        $sql .= "order by cars.model, circuits.name";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Retourne tous les enregistrements pour un modele de voiture
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @return array
     * Retourne un tableau associatif
     */
    public function readByCar(int $id_car): array
    {
        $sql  = "select consumptions.id, cars.model, circuits.name, consumptions.value, consumptions.update_time ";
        $sql .= "from consumptions ";
        $sql .= "join cars on cars.id = consumptions.id_car ";
        $sql .= "join circuits on circuits.id = consumptions.id_circuit ";
        $sql .= "where id_car=? ";
        $sql .= "order by circuits.name";

        $request = $this->execute($sql, [$id_car]);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Retourne tous les enregistrements pour un modèle de voiture et un circuit donné
     * 
     * @param int $id_car
     * Identifiant de la voiture
     * @param int $id_circuit
     * Identifiant du circuit
     * @return array
     * Retourne un tableau associatif
     */
    public function readByCarAndCircuit(int $id_car, int $id_circuit): array
    {
        $sql  = "select consumptions.id, cars.model, circuits.name, consumptions.value, consumptions.update_time ";
        $sql .= "from consumptions ";
        $sql .= "join cars on cars.id = consumptions.id_car ";
        $sql .= "join circuits on circuits.id = consumptions.id_circuit ";
        $sql .= "where id_car=? and id_circuit=?";
        $sql .= "order by circuits.name";

        $request = $this->execute($sql, [$id_car, $id_circuit]);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

     /**
     * Retourne tous les enregistrements pour un circuit donné
     * 
     * @param int $id_circuit
     * Identifiant du circuit
     * @return array
     * Retourne un tableau associatif
     */
    public function readByCircuit(int $id_circuit): array
    {
        $sql  = "select consumptions.id, cars.model, circuits.name, consumptions.value, consumptions.update_time ";
        $sql .= "from consumptions ";
        $sql .= "join cars on cars.id = consumptions.id_car ";
        $sql .= "join circuits on circuits.id = consumptions.id_circuit ";
        $sql .= "where id_circuit=? ";
        $sql .= "order by cars.model";

        $request = $this->execute($sql, [$id_circuit]);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }
}
