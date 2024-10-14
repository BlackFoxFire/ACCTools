-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 oct. 2024 à 10:26
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `acctools`
--

-- --------------------------------------------------------

--
-- Structure de la table `cars`
--

CREATE TABLE `cars` (
  `id` tinyint(2) NOT NULL,
  `model` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cars`
--

INSERT INTO `cars` (`id`, `model`) VALUES
(1, 'BMW M4 GT3'),
(2, 'Ferrari 296 GT3');

-- --------------------------------------------------------

--
-- Structure de la table `circuits`
--

CREATE TABLE `circuits` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `circuits`
--

INSERT INTO `circuits` (`id`, `name`) VALUES
(1, 'Barcelona-Catalunya'),
(2, 'Brands Hatch'),
(3, 'Cota'),
(4, 'Donington'),
(5, 'Hungaroring'),
(6, 'Imola'),
(7, 'Indianapolis'),
(8, 'Kyalami'),
(9, 'Laguna Seca'),
(10, 'Misano'),
(11, 'Monza'),
(12, 'Mount Panorama'),
(13, 'Nürburgring'),
(14, 'Nürburgring 24H'),
(15, 'Oulton Park'),
(16, 'Paul Ricard'),
(17, 'Red Bull Ring'),
(18, 'Silverstone'),
(19, 'Snetterton'),
(20, 'Spa-Francorchamps'),
(21, 'Suzuka'),
(22, 'Valencia'),
(23, 'Watkins Glen'),
(24, 'Zandvoort'),
(25, 'Zolder');

-- --------------------------------------------------------

--
-- Structure de la table `consumptions`
--

CREATE TABLE `consumptions` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `id_car` tinyint(2) NOT NULL,
  `id_circuit` tinyint(2) NOT NULL,
  `value` decimal(3,1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consumptions`
--

INSERT INTO `consumptions` (`id`, `id_car`, `id_circuit`, `value`) VALUES
(1, 1, 1, 2.9),
(2, 1, 2, 2.9),
(3, 1, 3, 3.5),
(4, 1, 4, 2.5),
(5, 1, 5, 2.9),
(6, 1, 6, 3.5),
(7, 1, 7, 2.6),
(8, 1, 8, 2.9),
(9, 1, 9, 2.5),
(10, 1, 10, 2.9),
(11, 1, 11, 3.6),
(12, 1, 12, 3.8),
(13, 1, 13, 3.3),
(14, 1, 14, 14.0),
(15, 1, 15, 2.5),
(16, 1, 16, 3.3),
(17, 1, 17, 2.7),
(18, 1, 18, 3.3),
(19, 1, 19, 2.7),
(20, 1, 20, 4.1),
(21, 1, 21, 3.6),
(22, 1, 22, 2.6),
(23, 1, 23, 3.4),
(24, 1, 24, 2.9),
(25, 1, 25, 2.7),
(26, 2, 1, 2.6),
(27, 2, 2, 2.6),
(28, 2, 3, 3.4),
(29, 2, 4, 2.3),
(30, 2, 5, 2.5),
(31, 2, 6, 2.9),
(32, 2, 7, 2.5),
(33, 2, 8, 2.6),
(34, 2, 9, 2.1),
(35, 2, 10, 2.4),
(36, 2, 11, 3.1),
(37, 2, 12, 3.5),
(38, 2, 13, 2.8),
(39, 2, 14, 13.0),
(40, 2, 15, 2.2),
(41, 2, 16, 2.9),
(42, 2, 17, 2.3),
(43, 2, 18, 2.9),
(44, 2, 19, 2.5),
(45, 2, 20, 3.6),
(46, 2, 21, 3.2),
(47, 2, 22, 2.5),
(48, 2, 23, 3.3),
(49, 2, 24, 2.5),
(50, 2, 25, 2.3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`);

--
-- Index pour la table `circuits`
--
ALTER TABLE `circuits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `consumptions`
--
ALTER TABLE `consumptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCar` (`id_car`),
  ADD KEY `idCircuit` (`id_circuit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `circuits`
--
ALTER TABLE `circuits`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `consumptions`
--
ALTER TABLE `consumptions`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consumptions`
--
ALTER TABLE `consumptions`
  ADD CONSTRAINT `consumptions_ibfk_1` FOREIGN KEY (`id_car`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consumptions_ibfk_2` FOREIGN KEY (`id_circuit`) REFERENCES `circuits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
