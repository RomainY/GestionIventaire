-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 12 mars 2020 à 14:28
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todolist`
--

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `idEtape` int(11) NOT NULL AUTO_INCREMENT,
  `nomEtape` varchar(255) NOT NULL,
  PRIMARY KEY (`idEtape`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etape`
--

INSERT INTO `etape` (`idEtape`, `nomEtape`) VALUES
(1, 'Pas fait'),
(2, 'En cours'),
(3, 'Fait');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `idEtat` int(11) NOT NULL AUTO_INCREMENT,
  `nomEtat` varchar(255) NOT NULL,
  PRIMARY KEY (`idEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`idEtat`, `nomEtat`) VALUES
(1, 'R.A.S'),
(2, 'A verifier');

-- --------------------------------------------------------

--
-- Structure de la table `importance`
--

DROP TABLE IF EXISTS `importance`;
CREATE TABLE IF NOT EXISTS `importance` (
  `idImportance` int(11) NOT NULL AUTO_INCREMENT,
  `nomImportance` varchar(255) NOT NULL,
  PRIMARY KEY (`idImportance`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `importance`
--

INSERT INTO `importance` (`idImportance`, `nomImportance`) VALUES
(1, 'Faible'),
(2, 'Moyen'),
(3, 'Important'),
(4, 'Urgent');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `liste_objet`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `liste_objet`;
CREATE TABLE IF NOT EXISTS `liste_objet` (
`nomObjet` varchar(255)
,`nomPiece` varchar(255)
,`nomEtat` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

DROP TABLE IF EXISTS `objet`;
CREATE TABLE IF NOT EXISTS `objet` (
  `idObjet` int(11) NOT NULL AUTO_INCREMENT,
  `nomObjet` varchar(255) NOT NULL,
  `idPiece` int(11) NOT NULL,
  `idEtat` int(11) NOT NULL,
  PRIMARY KEY (`idObjet`),
  KEY `idPiece` (`idPiece`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `nomObjet`, `idPiece`, `idEtat`) VALUES
(1, 'Four', 1, 1),
(2, 'Lit', 2, 2),
(3, 'Plafonds', 1, 2),
(4, 'Evier', 4, 2),
(6, 'Robinet', 5, 1),
(7, 'Lampe', 3, 1),
(8, 'Tapis', 3, 1),
(10, 'Lits', 2, 1),
(11, 'Chambre°2', 1, 1),
(12, 'Machin à bibules', 1, 1),
(13, 'Papier', 5, 1),
(14, 'SUPPRIMER', 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

DROP TABLE IF EXISTS `piece`;
CREATE TABLE IF NOT EXISTS `piece` (
  `idPiece` int(11) NOT NULL AUTO_INCREMENT,
  `nomPiece` varchar(255) NOT NULL,
  PRIMARY KEY (`idPiece`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `piece`
--

INSERT INTO `piece` (`idPiece`, `nomPiece`) VALUES
(1, 'Cuisine'),
(2, 'Chambre'),
(3, 'Couloirs'),
(4, 'Salle de bains'),
(5, 'WC'),
(7, 'Salons');

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

DROP TABLE IF EXISTS `tache`;
CREATE TABLE IF NOT EXISTS `tache` (
  `idTache` int(11) NOT NULL AUTO_INCREMENT,
  `nomTache` varchar(255) NOT NULL,
  `descriptifTache` varchar(255) NOT NULL,
  `typesTache` varchar(255) NOT NULL,
  `idEtape` int(11) NOT NULL,
  `idImportance` int(11) NOT NULL,
  `idObjet` int(11) NOT NULL,
  PRIMARY KEY (`idTache`),
  KEY `idEtape` (`idEtape`),
  KEY `idImportance` (`idImportance`),
  KEY `idObjet` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`idTache`, `nomTache`, `descriptifTache`, `typesTache`, `idEtape`, `idImportance`, `idObjet`) VALUES
(1, 'Nettoyer plafond', '...', 'Nettoyer', 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la vue `liste_objet`
--
DROP TABLE IF EXISTS `liste_objet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `liste_objet`  AS  select `objet`.`nomObjet` AS `nomObjet`,`piece`.`nomPiece` AS `nomPiece`,`etat`.`nomEtat` AS `nomEtat` from ((`objet` join `piece` on((`objet`.`idPiece` = `piece`.`idPiece`))) join `etat` on((`objet`.`idEtat` = `etat`.`idEtat`))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `objet`
--
ALTER TABLE `objet`
  ADD CONSTRAINT `objet_ibfk_1` FOREIGN KEY (`idPiece`) REFERENCES `piece` (`idPiece`) ON DELETE CASCADE,
  ADD CONSTRAINT `objet_ibfk_2` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`idEtat`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`idEtape`) REFERENCES `etape` (`idEtape`),
  ADD CONSTRAINT `tache_ibfk_2` FOREIGN KEY (`idImportance`) REFERENCES `importance` (`idImportance`),
  ADD CONSTRAINT `tache_ibfk_3` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
