<?php

/**
 * CircuitsModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 * Gère les enregistrements de la base de données de la table circuits
 */

namespace Lib\Models;

use Lib\Entities\Circuit;

class CircuitsModelPDO extends CircuitsModel
{
    /**
     * Ajoute un enregistrement
     * 
     * @param Circuit $circuit
     * 
     * @return int
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
     * Modifie un enregistrement
     * 
     * @param Circuit $circuit
     * 
     * @return int
     */
    protected function update(Circuit $circuit): int
    {
        $sql = " update circuits set name=? where id=?";

        $request = $this->execute($sql, [$circuit, $circuit->id()]);
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
        $sql = "select * from circuits order by name";

        $request = $this->execute($sql);
        $request->setFetchMode(\PDO::FETCH_CLASS, '\Lib\Entities\Circuit');
        $datas = $request->fetchAll();
		$request->closeCursor();

        return $datas;
    }

    /**
     * Recherche un enregistrement en fonction d'un identifiant
     * 
     * @param int $id
     * 
     * @return Circuit|false
     */
    public function searchById(int $id): Circuit|false
    {
        $sql = "select * from circuits where id=?";

        $request = $this->execute($sql, [$id]);
        $request->setFetchMode(\PDO::FETCH_CLASS, 'Lib\Entities\Circuit');
        $datas = $request->fetch();
        $request->closeCursor();

        return $datas;
    }

    /**
     * Recherche un circuit par son nom
     * 
     * @param string $name
     * 
     * @return bool
     */
    public function searchName(string $name): bool
    {
        $sql = "select count(name) from circuits where name=?";

        $request = $this->execute($sql, [$name]);
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
        $sql = "delete from circuits where id=?";

        $request = $this->execute($sql, [$id]);
        $counter = $request->rowCount();
        $request->closeCursor();

        return $counter;
    }

}
