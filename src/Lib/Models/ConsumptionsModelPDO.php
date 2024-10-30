<?php

/**
 * ConsumptionsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\Lib\Models;

use Blackfox\AccTools\Lib\Entities\Consumption;

class ConsumptionsModelPDO extends ConsumptionsModel
{
    /**
     * Ajoute un enregistrement
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
     */
    public function search(int $id_car, int $id_circuit): Consumption|FALSE
    {
        $sql = "select * from consumptions where id_car=? and id_circuit=?";

        $request = $this->execute($sql, [$id_car, $id_circuit]);
        $request->setFetchMode(\PDO::FETCH_ASSOC);
        $datas = $request->fetch();
		$request->closeCursor();

        if($datas) {
            $consumption = new Consumption($datas);
        }

        return $consumption;
    }

    /**
     * Recherche tous les enregistrements sous formes brute
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
     */
    public function readAll(): array
    {
        $sql  = "select cars.model, circuits.name, consumptions.value, consumptions.update_time ";
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
     * Retourne tous les enregistrements pour un modèle de voiture
     */
    public function readByCar(int $id_car): array
    {
        $sql  = "select cars.model, circuits.name, consumptions.value, consumptions.update_time ";
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
     */
    public function readByCarAndCircuit(int $id_car, int $id_circuit): array
    {
        $sql  = "select cars.model, circuits.name, consumptions.value, consumptions.update_time ";
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
     */
    public function readByCircuit(int $id_circuit): array
    {
        $sql  = "select cars.model, circuits.name, consumptions.value, consumptions.update_time ";
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
