<?php

/**
 * CarsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Lib\Models;

use Lib\Entities\Car;

class CarsModelPDO extends CarsModel
{
    /**
     * Ajoute un enregistrement
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
     * Retourne tous les enregistrements
     */
    public function readAll(): array
    {
        $sql = "select * from cars order by model";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entities\Car');
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Retourne true si la recherche d'un modèle de voiture à été trouvé. Sinon false.
     */
    public function searchModel(string $model): bool
    {
        $sql = "select count(model) from cars where model=?";

        $request = $this->execute($sql, [$model]);
        $counter = $request->fetch()[0];
		$request->closeCursor();

        return $counter;
    }
}
