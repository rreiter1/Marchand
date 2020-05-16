-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 16 mai 2020 à 15:56
-- Version du serveur :  10.3.12-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `musiqueworld`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `idA` int(11) NOT NULL AUTO_INCREMENT,
  `nomA` varchar(500) NOT NULL,
  `prixA` double NOT NULL,
  `stockA` int(11) NOT NULL,
  `nomImg` varchar(500) NOT NULL,
  `idG` int(11) NOT NULL,
  `idCompo` int(11) NOT NULL,
  PRIMARY KEY (`idA`),
  KEY `Article_Compositeur0_FK` (`idCompo`),
  KEY `Article_Genre_AK` (`idG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`idA`, `nomA`, `prixA`, `stockA`, `nomImg`, `idG`, `idCompo`) VALUES
(5, 'L\'Everest', 13.99, 0, 'L Everest.jfif', 1, 1),
(6, 'La Vie de reve', 9.99, 87, 'La Vie de reve.jpg', 1, 2),
(7, 'La Vraie Vie', 17.99, 89, 'La Vraie Vie.jpg', 1, 2),
(8, 'Phoenix', 19.99, 87, 'Phoenix.jpg', 1, 1),
(48, 'koala', 2999.99, 78, 'Koala.jpg', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compositeur`
--

DROP TABLE IF EXISTS `compositeur`;
CREATE TABLE IF NOT EXISTS `compositeur` (
  `idCompo` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`idCompo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compositeur`
--

INSERT INTO `compositeur` (`idCompo`, `nom`) VALUES
(1, 'Soprano'),
(2, 'Bigflo et Oli'),
(3, 'Theo'),
(6, 'LPM');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `idC` int(11) NOT NULL AUTO_INCREMENT,
  `nomC` varchar(500) NOT NULL,
  `prenomC` varchar(500) NOT NULL,
  `identifiantC` varchar(500) NOT NULL,
  `mdpC` varchar(500) NOT NULL,
  `villeC` varchar(500) NOT NULL,
  `adresseC` varchar(500) NOT NULL,
  `payC` varchar(500) NOT NULL,
  `cpC` varchar(10) NOT NULL,
  `numtelC` varchar(10) NOT NULL,
  `idP` int(11) NOT NULL DEFAULT 3,
  PRIMARY KEY (`idC`),
  KEY `Compte_Permission_FK` (`idP`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`idC`, `nomC`, `prenomC`, `identifiantC`, `mdpC`, `villeC`, `adresseC`, `payC`, `cpC`, `numtelC`, `idP`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$.1OZv5VABz8g5J5Qd/oSsudc9X6JLp5XZyvVdTEgIiNiKSX7pqOCW', 'admin', 'admin', 'admin', '00000', '0664408228', 1),
(2, 'user', 'user', 'user', '$2y$10$fM47795Bz70CgKacrtpNtOpUqpWY80X2CmnWhA4XbwW2t9MEQdRzC', 'user', 'user', 'user', '98765', '0123456789', 3),
(8, 'Ozkok', 'Ozan', 'oozkok', '$2y$10$A.kLL5ox5DDRkIkogz973eaMSh1IVgv4eqRyJZR8FwpMJuOX.bvqu', 'Saint-Avold', '54 rue du faucon', 'France', '57500', '0619333186', 3),
(11, 'chi', 'chiyu', 'chiyu', '$2y$10$RmMhy987jhVc58SOBgj0Vex00ANHwcqDTb3LRH88kOZRdLo2KnK5G', 'ms', '1 adb', 'Japon', '666', '666', 3),
(12, 'testpanier', 'testpanier', 'test', '$2y$10$ZkVKLNXSm2dBHs/G7VHCW.N0tk59ILnP8uizS/Eqk70tUK0IndNN.', 'NeverLand', 'Je sais aos pk jai mais sa', 'banane', '775', '854722335', 3),
(13, 'alan', 'anal', 'ui', '$2y$10$aSAByGYVvmQGFIx4K7z.IuN5f3.IGfwt0L1tJlr5Q1.l1nJmyNyEO', 'Saint-Avold', '54 rue du faucon', 'France', '57500', '0619333186', 3),
(14, 'a', 'a', 'a', '$2y$10$uEsQUe6lTjYBTVAsfcGhjOlh5NJzVZ88Eyv68URf86M3dYFuOUdGi', 'a', 'a', 'a', '5', '5', 3);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idA` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `Quandtiter` int(11) NOT NULL,
  PRIMARY KEY (`idA`,`id`),
  KEY `Contenir_Panier0_FK` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`idA`, `id`, `Quandtiter`) VALUES
(6, 10, 3),
(7, 10, 9),
(8, 10, 1),
(48, 10, 5),
(48, 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `idG` int(11) NOT NULL AUTO_INCREMENT,
  `nomG` varchar(100) NOT NULL,
  PRIMARY KEY (`idG`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`idG`, `nomG`) VALUES
(1, 'Rap'),
(3, 'Rock');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idC` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Panier_Compte_FK` (`idC`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `idC`) VALUES
(1, NULL),
(10, 1),
(11, 2),
(12, 8),
(13, 11),
(14, 12),
(15, 13),
(16, 14);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `idP` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(500) NOT NULL,
  PRIMARY KEY (`idP`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idP`, `Nom`) VALUES
(1, 'ADMIN'),
(2, 'Visiteur'),
(3, 'Utilisateur');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `Article_Compositeur0_FK` FOREIGN KEY (`idCompo`) REFERENCES `compositeur` (`idCompo`),
  ADD CONSTRAINT `Article_Genre_FK` FOREIGN KEY (`idG`) REFERENCES `genre` (`idG`);

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `Contenir_Article_FK` FOREIGN KEY (`idA`) REFERENCES `article` (`idA`),
  ADD CONSTRAINT `Contenir_Panier0_FK` FOREIGN KEY (`id`) REFERENCES `panier` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `Panier_Compte_FK` FOREIGN KEY (`idC`) REFERENCES `compte` (`idC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
