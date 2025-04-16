<?php

/**
 * CreateDBModelPDO.php
 * @Auteur : Christophe Dufour
 * 
 * Gère la créationn de la base de données
 */

namespace Lib\Models;

class CreateDBModelPDO extends CreateDBModel
{

    /**
     * Appelle les différentes functions pour créer la base de données
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    public function createDB(): void
    {
        $this->dropTable();
        $this->createTableCars();
        $this->createTableCircuits();
        $this->createTableConsumptions();
        $this->insertCars();
        $this->insertCircuits();
        $this->insertConsumptions();
    }

    /**
     * Efface les anciennes tables
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function dropTable(): void
    {
        $sql = "DROP TABLE IF EXISTS consumptions, cars, circuits";

        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Crée la table des voitures
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function createTableCars(): void
    {
        $sql = "CREATE TABLE cars(
            id tinyint(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            model varchar(30) UNIQUE KEY NOT NULL)";

        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Crée la table des circuits
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function createTableCircuits(): void
    {
        $sql = "CREATE TABLE circuits(
            id tinyint(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            name varchar(30) UNIQUE KEY NOT NULL)";

        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Crée la table des consommations
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function createTableConsumptions(): void
    {
        $sql = "CREATE TABLE consumptions(
            id smallint(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            id_car tinyint(2) UNSIGNED NOT NULL,
            id_circuit tinyint(2) UNSIGNED NOT NULL,
            value decimal(4,2) UNSIGNED NOT NULL),
            update_time datetime DEFAULT NULL";

        $request = $this->execute($sql);
        $request->closeCursor();

        $sql = "ALTER TABLE consumptions 
            ADD KEY idcar(id_car), 
            ADD KEY idCircuit(id_circuit)";

        $request = $this->execute($sql);
        $request->closeCursor();

        $sql = "ALTER TABLE consumptions 
            ADD CONSTRAINT consumptions_ibfk_1 FOREIGN KEY (id_car) REFERENCES cars(id) ON DELETE CASCADE ON UPDATE CASCADE, 
            ADD CONSTRAINT consumptions_ibfk_2 FOREIGN KEY (id_circuit) REFERENCES circuits(id) ON DELETE CASCADE ON UPDATE CASCADE";

        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Ajoutes des voitures
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function insertCars(): void
    {
        $sql = "INSERT INTO `cars` (`model`) VALUES
        ('AMR V8 Vantage GT3'),
        ('Audi R8 LMS Evo'),
        ('Audi R8 LMS Evo II'),
        ('Bentley Continental GT3'),
        ('BMW M4 GT3'),
        ('BMW M6 GT3'),
        ('Ferrari 296 GT3'),
        ('Ferrari 488 GT3'),
        ('Ferrari 488 GT3 Evo'),
        ('Ford Mustang GT3'),
        ('Honda NSX GT3 Evo'),
        ('Lamborghini Huracan GT3 Evo'),
        ('Lamborghini Huracan GT3 Evo2'),
        ('Lexus RC F GT3'),
        ('McLaren 720S GT3'),
        ('McLaren 720S GT3 Evo'),
        ('Mercedes-AMG GT3'),
        ('Mercedes-AMG GT3 2020'),
        ('Porsche 991 GT3 R'),
        ('Porsche 991II GT3 R'),
        ('Porsche 992 GT3 R')";
        
        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Ajoute des circuits
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function insertCircuits(): void
    {
        $sql = "INSERT INTO `circuits` (`name`) VALUES 
        ('Barcelona-Catalunya'), ('Brands Hatch'), ('Cota'),
        ('Donington'), ('Hungaroring'), ('Imola'),
        ('Indianapolis'), ('Kyalami'), ('Laguna Seca'),
        ('Misano'), ('Monza'), ('Mount Panorama'),
        ('Nürburgring'), ('Nürburgring 24H'), ('Oulton Park'),
        ('Paul Ricard'), ('Red Bull Ring'), ('Silverstone'),
        ('Snetterton'), ('Spa-Francorchamps'), ('Suzuka'),
        ('Valencia'), ('Watkins Glen'), ('Zandvoort'),
        ('Zolder')";
    
        $request = $this->execute($sql);
        $request->closeCursor();
    }

    /**
     * Ajoute des consommations
     * 
     * @return void
     * Ne retourne aucune valeur
     */
    protected function insertConsumptions(): void
    {
        $sql = "INSERT INTO `consumptions` (`id_car`, `id_circuit`, `value`) VALUES 
        (5, 1, 2.9), (5, 2, 2.9), (5, 3, 3.5),
        (5, 4, 2.5), (5, 5, 2.9), (5, 6, 3.5),
        (5, 7, 2.6), (5, 8, 2.9), (5, 9, 2.5),
        (5, 10,2.9), (5, 11, 3.6), (5, 12, 3.8),
        (5, 13, 3.3), (5, 14, 14), (5, 15, 2.5),
        (5, 16, 3.3), (5, 17, 2.7), (5, 18, 3.3),
        (5, 19, 2.7), (5, 20, 4.1), (5, 21, 3.6),
        (5, 22, 2.6), (5, 23, 3.4), (5, 24, 2.9),
        (5, 25, 2.7),
        (7, 1, 2.6), (7, 2, 2.6), (7, 3, 3.4),
        (7, 4, 2.3), (7, 5, 2.5), (7, 6, 2.9),
        (7, 7, 2.5), (7, 8, 2.6), (7, 9, 2.1),
        (7, 10, 2.4), (7, 11, 3.0), (7, 12, 3.5),
        (7, 13, 2.8), (7, 14, 13), (7, 15, 2.2),
        (7, 16, 2.9), (7, 17, 2.3), (7, 18, 2.9),
        (7, 19, 2.5), (7, 20, 3.6), (7, 21, 3.2),
        (7, 22, 2.5), (7, 23, 3.3), (7, 24, 2.5),
        (7, 25, 2.3)";

        $request = $this->execute($sql);
        $request->closeCursor();
    }
}
