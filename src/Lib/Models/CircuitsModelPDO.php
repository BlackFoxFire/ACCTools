<?php

/**
 * CircuitsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Lib\Models;

use Lib\Entities\Circuit;

class CircuitsModelPDO extends CircuitsModel
{
    /**
     * Ajoute un enregistrement
     */
    protected function add(Circuit $circuit): int
    {
        $sql = "insert into circuits(name) value(?)";

        $request = $this->execute($sql, [$circuit]);
        $counter = $request->rowCount();
		$request->closeCursor();

        return $counter;
    }

    /**
     * Retourne tous les enregistrements
     */
    public function readAll(): array
    {
        $sql = "select * from circuits order by name";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entities\Circuit');
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Retourne true si la recherche d'un nom de circuit à été trouvé. Sinon false.
     */
    public function searchName(string $name): bool
    {
        $sql = "select count(name) from circuits where name=?";

        $request = $this->execute($sql, [$name]);
        $counter = $request->fetch()[0];
		$request->closeCursor();

        return $counter;
    }

}
