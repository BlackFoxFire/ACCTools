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
     * Un objet de type Circuit
     * @return int
     * Retourne le nombre d'enregistrement écrit
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
     * 
     * @return array
     * Retourne un tableau d'objet Circuit
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
     * Identifiant à rechercher
     * @return Circuit|false
     * Retourne un objet Circuit en cas de succès, sinon false
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
     * La chaine à rechercher
     * @return bool
     * Retourne true en cas de succès, sinon false
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
     * Identifiant de l'enregistrement à supprimer
     * @return int
     * Retourne le nombre d'enregistrement supprimé
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
