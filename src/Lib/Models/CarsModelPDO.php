<?php

/**
 * CarsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les enregistrements de la base de données de la table cars
 */

namespace Lib\Models;

use Lib\Entities\Car;

class CarsModelPDO extends CarsModel
{
    /**
     * Ajoute un enregistrement
     * 
     * @param Car $car
     * 
     * @return int
     */
    protected function add(Car $car): int
    {
        $sql = "insert into cars(model) value(?)";

        $request = $this->execute($sql, [$car]);
        $counter = $request->rowCount();
        $request->closeCursor();

        return $counter;
    }

    /**
     * Modifie un enregistrement
     * 
     * @param Car $car
     * 
     * @return int
     */
    protected function update(Car $car): int
    {
        $sql = " update cars set model=?, favorite=? where id=?";

        $request = $this->execute($sql, [$car, (int)$car->favorite(), $car->id()]);
        $counter = $request->rowCount();
        $request->closeCursor();

        return $counter;
    }

    /**
     * Retourne tous les enregistrements
     * 
     * @return array
     */
    public function readAll(): array
    {
        $sql = "select * from cars order by favorite desc, model asc";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_CLASS, '\Lib\Entities\Car');
        $datas = $request->fetchAll();
        $request->closeCursor();

        return $datas;
    }

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * 
     * @return Car|false
     */
    public function searchById(int $id): Car|false
    {
        $sql = "select * from cars where id=?";

        $request = $this->execute($sql, [$id]);
        $request->setFetchMode(\PDO::FETCH_CLASS, 'Lib\Entities\Car');
        $datas = $request->fetch();
        $request->closeCursor();

        return $datas;
    }

    /**
     * Recherche un modèle de voiture
     * 
     * @param string $model
     * 
     * @return bool
     */
    public function searchModel(string $model): bool
    {
        $sql = "select count(model) from cars where model=?";

        $request = $this->execute($sql, [$model]);
        $counter = $request->fetch()[0];
        $request->closeCursor();

        return $counter;
    }

    /**
     * Supprime un enregistrement
     * 
     * @param int $id
     * 
     * @return int
     */
    public function delete(int $id): int
    {
        $sql = "delete from cars where id=?";

        $request = $this->execute($sql, [$id]);
        $counter = $request->rowCount();
        $request->closeCursor();

        return $counter;
    }

}
