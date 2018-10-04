-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 04, 2018 at 11:08 AM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ib`
--
DROP DATABASE IF EXISTS `ib`;
CREATE DATABASE IF NOT EXISTS `ib` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ib`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `V_Emprunt`
-- (See below for the actual view)
--
CREATE TABLE `V_Emprunt` (
`ID` int(11)
,`IDLivre` int(11)
,`IDUtilisateur` int(11)
,`duree` int(11)
,`dateEmprunt` datetime
,`dateRetour` datetime
,`titre` varchar(100)
,`editeur` varchar(50)
,`nom` varchar(50)
,`prenom` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `V_Livre`
-- (See below for the actual view)
--
CREATE TABLE `V_Livre` (
`ID` int(11)
,`titre` varchar(100)
,`resume` text
,`courtResume` varchar(255)
,`nomSite` varchar(50)
,`adresseSite` text
,`type` varchar(20)
,`editeur` varchar(50)
,`auteur` text
,`genre` text
);

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `ID` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`ID`, `nom`, `prenom`) VALUES
(1, 'GEOFFROY', 'Jean'),
(2, 'Adrienne', 'LeLandais'),
(3, 'Blanche', 'LeTemplier');

-- --------------------------------------------------------

--
-- Table structure for table `editeur`
--

CREATE TABLE `editeur` (
  `ID` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `editeur`
--

INSERT INTO `editeur` (`ID`, `libelle`) VALUES
(1, 'Nouvelles Éditions Bordessoules'),
(2, 'TheBook Edition');

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `IDUtilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `motDePasse` text NOT NULL,
  `IDSite` int(11) NOT NULL,
  `IDResponsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`IDUtilisateur`, `nom`, `motDePasse`, `IDSite`, `IDResponsable`) VALUES
(1, 'dumbo', 'dumbo', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emprunt`
--

CREATE TABLE `emprunt` (
  `ID` int(11) NOT NULL,
  `IDLivre` int(11) NOT NULL,
  `IDUtilisateur` int(11) NOT NULL,
  `dateEmprunt` datetime NOT NULL,
  `duree` int(11) NOT NULL,
  `dateRetour` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emprunt`
--

INSERT INTO `emprunt` (`ID`, `IDLivre`, `IDUtilisateur`, `dateEmprunt`, `duree`, `dateRetour`) VALUES
(2, 1, 1, '2017-10-26 00:00:00', 25, '2017-10-26 13:30:25'),
(3, 1, 1, '2017-10-26 00:00:00', 30, '2017-11-05 20:17:43'),
(4, 2, 1, '2017-11-09 00:00:00', 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `ID` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`ID`, `libelle`) VALUES
(1, 'Roman'),
(2, 'Biographie'),
(3, 'Science-fiction'),
(4, 'Fantasy'),
(5, 'Nouvelle'),
(6, 'Conte');

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

CREATE TABLE `livre` (
  `ID` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `resume` text NOT NULL,
  `courtResume` varchar(255) NOT NULL,
  `IDSite` int(11) NOT NULL,
  `IDType` int(11) NOT NULL,
  `IDEditeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `livre`
--

INSERT INTO `livre` (`ID`, `titre`, `resume`, `courtResume`, `IDSite`, `IDType`, `IDEditeur`) VALUES
(1, 'À 75 ans, j\'en ai plein le cul d\'être hypocrite', 'Pendant des années, écouter les politiques promettre, mentir, berner, cacher, échouer, raconter des contes à dormir debout, débiter des discours tellement vieille langue de bois qu\'ils en sont vermoulus, prendre le citoyen pour un couillon (c\'est dans le dictionnaire), il y\'en a plein le fondement !\r\n\r\nJean Geoffroy, de la classe des \"vrais gens\" comme ils disent, tend l\'oreille dans la rue, au bistrot, dans les fêtes pour écouter ses concitoyens. Ce livre est un résumé des ressentis.\r\n\r\nJean Geoffroy ose dire ce qu\'il a dans les oreillettes, les ventricules et même les tripes !\r\n\r\nSi, à la fin de l\'ouvrage, le lecteur découvre ce qu\'il pensait parfois sans jamais oser le dire, il en retirera une grande bouffée de plaisir.', 'Si, à la fin de l\'ouvrage, le lecteur découvre ce qu\'il pensait parfois sans jamais oser le dire, il en retirera une grande bouffée de plaisir.', 1, 1, 1),
(2, 'Deux auteurs pour un livre', 'Deux auteurs publient chacune deux nouvelles, et s\'allient pour en écrire une en quatre parties et à quatre mains.', 'Deux auteurs publient chacune deux nouvelles, et s\'allient pour en écrire une en quatre parties et à quatre mains.', 1, 1, 2),
(5, 'À 75 ans, j\'en ai plein le cul d\'être hypocrite', 'Pendant des années, écouter les politiques promettre, mentir, berner, cacher, échouer, raconter des contes à dormir debout, débiter des discours tellement vieille langue de bois qu\'ils en sont vermoulus, prendre le citoyen pour un couillon (c\'est dans le dictionnaire), il y\'en a plein le fondement !\r\n\r\nJean Geoffroy, de la classe des \"vrais gens\" comme ils disent, tend l\'oreille dans la rue, au bistrot, dans les fêtes pour écouter ses concitoyens. Ce livre est un résumé des ressentis.\r\n\r\nJean Geoffroy ose dire ce qu\'il a dans les oreillettes, les ventricules et même les tripes !\r\n\r\nSi, à la fin de l\'ouvrage, le lecteur découvre ce qu\'il pensait parfois sans jamais oser le dire, il en retirera une grande bouffée de plaisir.', 'Si, à la fin de l\'ouvrage, le lecteur découvre ce qu\'il pensait parfois sans jamais oser le dire, il en retirera une grande bouffée de plaisir.', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `livre_auteur`
--

CREATE TABLE `livre_auteur` (
  `IDLivre` int(11) NOT NULL,
  `IDAuteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `livre_auteur`
--

INSERT INTO `livre_auteur` (`IDLivre`, `IDAuteur`) VALUES
(1, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `livre_genre`
--

CREATE TABLE `livre_genre` (
  `IDLivre` int(11) NOT NULL,
  `IDGenre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `livre_genre`
--

INSERT INTO `livre_genre` (`IDLivre`, `IDGenre`) VALUES
(1, 2),
(2, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE `site` (
  `ID` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `adresse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`ID`, `nom`, `adresse`) VALUES
(1, 'Site 1', 'Blabla');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `ID` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`ID`, `libelle`) VALUES
(1, 'Beau livre'),
(2, 'Bande dessinée'),
(3, 'Revue'),
(4, 'Album'),
(5, 'Livre de poche');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` text NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `civilite` tinyint(1) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `nom`, `prenom`, `adresse`, `telephone`, `mail`, `civilite`, `statut`) VALUES
(1, 'Dupond', 'Jerome', '105 avenue du stade', '0123456789', 'jerome.durand@gmail.com', 0, 0),
(3, 'PIERRE', 'Jonathan', 'sfdghjrcv', '0160689318', 'ml@klm.k', 0, 0),
(4, 'AULAIS', 'Aurélie', 'AZERTYUJIK', '0102030409', 'al.a@gmail.com', 1, 0),
(5, 'BRICI', 'Clem', 'ezrty', '1345678080', 'bric@gm.com', 0, 0);

-- --------------------------------------------------------

--
-- Structure for view `V_Emprunt`
--
DROP TABLE IF EXISTS `V_Emprunt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ib`@`localhost` SQL SECURITY DEFINER VIEW `V_Emprunt`  AS  select `E`.`ID` AS `ID`,`E`.`IDLivre` AS `IDLivre`,`E`.`IDUtilisateur` AS `IDUtilisateur`,`E`.`duree` AS `duree`,`E`.`dateEmprunt` AS `dateEmprunt`,`E`.`dateRetour` AS `dateRetour`,`L`.`titre` AS `titre`,`ED`.`libelle` AS `editeur`,`U`.`nom` AS `nom`,`U`.`prenom` AS `prenom` from (((`emprunt` `E` left join `livre` `L` on((`E`.`IDLivre` = `L`.`ID`))) left join `utilisateur` `U` on((`E`.`IDUtilisateur` = `U`.`ID`))) join `editeur` `ED` on((`L`.`IDEditeur` = `ED`.`ID`))) ;

-- --------------------------------------------------------

--
-- Structure for view `V_Livre`
--
DROP TABLE IF EXISTS `V_Livre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ib`@`localhost` SQL SECURITY DEFINER VIEW `V_Livre`  AS  select `L`.`ID` AS `ID`,`L`.`titre` AS `titre`,`L`.`resume` AS `resume`,`L`.`courtResume` AS `courtResume`,`S`.`nom` AS `nomSite`,`S`.`adresse` AS `adresseSite`,`T`.`libelle` AS `type`,`E`.`libelle` AS `editeur`,group_concat(distinct concat(`A`.`nom`,' ',`A`.`prenom`) separator ', ') AS `auteur`,group_concat(distinct `G`.`libelle` separator ', ') AS `genre` from (((((((`livre` `L` left join `editeur` `E` on((`L`.`IDEditeur` = `E`.`ID`))) left join `type` `T` on((`L`.`IDType` = `T`.`ID`))) left join `site` `S` on((`L`.`IDSite` = `S`.`ID`))) left join `livre_auteur` `LA` on((`L`.`ID` = `LA`.`IDLivre`))) join `auteur` `A` on((`LA`.`IDAuteur` = `A`.`ID`))) left join `livre_genre` `LG` on((`L`.`ID` = `LG`.`IDLivre`))) join `genre` `G` on((`LG`.`IDGenre` = `G`.`ID`))) group by `L`.`ID` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `editeur`
--
ALTER TABLE `editeur`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`IDUtilisateur`),
  ADD KEY `IDSite` (`IDSite`),
  ADD KEY `IDResponsable` (`IDResponsable`);

--
-- Indexes for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDLivre` (`IDLivre`),
  ADD KEY `IDUtilisateur` (`IDUtilisateur`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDSite` (`IDSite`),
  ADD KEY `IDType` (`IDType`),
  ADD KEY `IDEditeur` (`IDEditeur`);

--
-- Indexes for table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD PRIMARY KEY (`IDLivre`,`IDAuteur`),
  ADD KEY `IDAuteur` (`IDAuteur`);

--
-- Indexes for table `livre_genre`
--
ALTER TABLE `livre_genre`
  ADD PRIMARY KEY (`IDLivre`,`IDGenre`),
  ADD KEY `IDGenre` (`IDGenre`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `editeur`
--
ALTER TABLE `editeur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `livre`
--
ALTER TABLE `livre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`IDSite`) REFERENCES `site` (`ID`),
  ADD CONSTRAINT `employe_ibfk_2` FOREIGN KEY (`IDResponsable`) REFERENCES `employe` (`IDUtilisateur`),
  ADD CONSTRAINT `employe_ibfk_3` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`ID`);

--
-- Constraints for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`IDLivre`) REFERENCES `livre` (`ID`),
  ADD CONSTRAINT `emprunt_ibfk_2` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`ID`);

--
-- Constraints for table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`IDSite`) REFERENCES `site` (`ID`),
  ADD CONSTRAINT `livre_ibfk_2` FOREIGN KEY (`IDType`) REFERENCES `type` (`ID`),
  ADD CONSTRAINT `livre_ibfk_3` FOREIGN KEY (`IDEditeur`) REFERENCES `editeur` (`ID`);

--
-- Constraints for table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD CONSTRAINT `livre_auteur_ibfk_1` FOREIGN KEY (`IDLivre`) REFERENCES `livre` (`ID`),
  ADD CONSTRAINT `livre_auteur_ibfk_2` FOREIGN KEY (`IDAuteur`) REFERENCES `auteur` (`ID`);

--
-- Constraints for table `livre_genre`
--
ALTER TABLE `livre_genre`
  ADD CONSTRAINT `livre_genre_ibfk_1` FOREIGN KEY (`IDLivre`) REFERENCES `livre` (`ID`),
  ADD CONSTRAINT `livre_genre_ibfk_2` FOREIGN KEY (`IDGenre`) REFERENCES `genre` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
