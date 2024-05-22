-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 02:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expression_du_besoin`
--

-- --------------------------------------------------------

--
-- Table structure for table `reponses`
--

CREATE TABLE `reponses` (
  `id` int(11) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `balises` varchar(255) NOT NULL,
  `attribut_question` varchar(255) NOT NULL,
  `type_input` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reponses`
--

INSERT INTO `reponses` (`id`, `reponse`, `id_question`, `id_user`, `balises`, `attribut_question`, `type_input`, `label`) VALUES
(1, '', 1, 0, 'input', '', 'text', NULL),
(2, 'Faire évoluer un service numérique existant (application, téléservice, site web…)', 2, 0, 'input', 'ajout', 'checkbox', 'Nom du service?'),
(3, 'Remplacer un service numérique existant', 2, 0, 'input', 'ajout', 'checkbox', 'Nom du service?'),
(4, 'Disposer d’un nouveau service numérique', 2, 0, 'input', 'ajout', 'checkbox', 'Précisez:'),
(5, 'Automatisation d’un flux et/ou d’une interface entre applications dans les domaines RH, financier, comptable, administratif, etc.,', 3, 0, 'input', 'choixm', 'checkbox', NULL),
(6, 'Dématérialisation d’un processus métier, intégrant ou non la signature électronique, un ou plusieurs circuits de gestion/validation, etc.,', 3, 0, 'input', 'choixm', 'checkbox', NULL),
(7, 'Gestion électronique de documents (bureautiques, multimédias, plans, etc.), gestion documentaire, archivage électronique,', 3, 0, 'input', 'choixm', 'checkbox', NULL),
(8, 'Exploitation, suivi et analyse de données produites et/ou acquises par la/les direction/s', 3, 0, 'input', 'choixm', 'checkbox', NULL),
(9, 'Service lié à la gestion spécifique d’un domaine métier du Département', 3, 0, 'input', 'choixm ajout', 'checkbox', 'Domaine métier concerné ?'),
(10, 'Autre', 3, 0, 'input', 'autre ajout', 'checkbox', 'Précisez:'),
(11, 'oui', 4, 0, 'input', 'ajout', 'checkbox', 'précisez le nom de la solution identifiée:'),
(12, 'non', 4, 0, 'input', '', 'checkbox', NULL),
(13, 'Réduire les tâches chronophages et/ou redondantes', 5, 0, 'input', '  choixm', 'checkbox', NULL),
(14, 'Améliorer l’organisation du travail et les processus métiers', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(15, 'Simplifier le travail des agents au quotidien', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(16, 'Faciliter les échanges et développer la/les collaboration/s internes et externes', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(17, 'Favoriser l’implication et la motivation des agents au quotidien', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(18, 'Acquérir et/ou renforcer les compétences des équipes', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(19, 'Mutualiser un service numérique au sein d’un ou plusieurs services/directions', 5, 0, 'input', '  choixm ', 'checkbox', NULL),
(20, 'Autre', 5, 0, 'input', 'ajout autre', 'checkbox', 'Précisez:'),
(21, 'A la hausse', 6, 0, 'input', ' multitude  ', 'checkbox', 'précisez le niveau estimé :'),
(22, 'A la baisse', 6, 0, 'input', ' multitude  ', 'checkbox', 'précisez le niveau estimé :'),
(23, 'Aucun', 6, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(24, '< à 1 ETP', 6, 0, 'h5', 'hidden', 'checkbox', NULL),
(25, 'Entre 1 et 5 ETP', 6, 0, 'h5', 'hidden', 'checkbox', NULL),
(26, '> 5 ETP', 6, 0, 'h5', 'hidden', 'checkbox', NULL),
(27, 'Oui', 7, 0, 'input', 'multitude  ', 'checkbox', 'précisez le temps gagné:'),
(28, 'Non', 7, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(29, 'A la hausse', 8, 0, 'input', ' multitude  ', 'checkbox', 'précisez l’impact estimé :'),
(30, 'A la baisse', 8, 0, 'input', ' multitude  ', 'checkbox', 'précisez l’impact estimé :'),
(31, 'Aucun', 8, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(32, 'Oui', 9, 0, 'input', 'ajout', 'checkbox', 'listez les principaux indicateurs de suivi souhaités:'),
(33, 'Non', 9, 0, 'input', '', 'checkbox', NULL),
(34, 'Oui', 10, 0, 'input', '', 'checkbox', NULL),
(35, 'Non', 10, 0, 'input', '', 'checkbox', NULL),
(36, 'Oui', 11, 0, 'input', 'tableauoui', 'checkbox', 'listez les types de données et, si possible, leur délai de conservation légal'),
(37, 'Non', 11, 0, 'input', 'tableaunon', 'checkbox', NULL),
(38, 'Oui', 12, 0, 'input', 'tableauoui', 'checkbox', 'listez les types de données et, si possible, leur délai de conservation légal'),
(39, 'Non', 12, 0, 'input', 'tableaunon', 'checkbox', NULL),
(40, 'Oui', 13, 0, 'input', 'multitude', 'checkbox', 'précisez leur provenance et, si possible, leur format'),
(41, 'Non', 13, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(42, 'Oui', 14, 0, 'input', 'multitude', 'checkbox', NULL),
(43, 'Non', 14, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(44, 'Oui', 15, 0, 'input', 'multitude', 'checkbox', NULL),
(45, 'Non', 15, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(46, 'Oui', 16, 0, 'input', 'multitude', 'checkbox', NULL),
(47, 'Non', 16, 0, 'input', 'aucun multitude', 'checkbox', NULL),
(48, 'Haute (24h/24 7j/7)', 17, 0, 'input', '', 'checkbox', NULL),
(49, 'Basse (horaires de bureaux)', 17, 0, 'input', ' ', 'checkbox', NULL),
(50, 'Autre', 17, 0, 'input', 'autre ajout', 'checkbox', 'Précisez:'),
(51, 'Oui', 18, 0, 'input', 'ajout', 'checkbox', 'Si oui, précisez le/s matériel/s requis :'),
(52, 'Non', 18, 0, 'input', '', 'checkbox', ''),
(53, 'Oui', 19, 0, 'input', 'ajout', 'checkbox', 'Précisez le budget inscrit :'),
(54, 'Non', 19, 0, 'input', 'ajout', 'checkbox', 'Précisez le montant estimé :'),
(55, 'Oui', 20, 0, 'input', 'tableauoui', 'checkbox', NULL),
(56, 'Non', 20, 0, 'input', 'tableaunon', 'checkbox', NULL),
(57, '', 21, 0, 'input', 'min={new Date().toISOString().split(\'T\')[0]}', 'date', NULL),
(58, 'Oui', 22, 0, 'input', 'ajout', 'checkbox', 'Si oui, précisez la contrainte réglementaire :'),
(59, 'Non', 22, 0, 'input', '', 'checkbox', NULL),
(60, '< 2 jours', 7, 0, 'h5', 'hidden', 'checkbox', NULL),
(61, 'Entre 2 et 5 jours', 7, 0, 'h5', 'hidden', 'checkbox', NULL),
(62, 'Entre 5 et 20 jours', 7, 0, 'h5', 'hidden', 'checkbox', NULL),
(63, '> 20 jours', 7, 0, 'h5', 'hidden', 'checkbox', NULL), 
(64, '< 5000$', 8, 0, 'h5', 'hidden', 'checkbox', NULL),
(66, 'Entre 5000 et 20000€', 8, 0, 'h5', 'hidden', 'checkbox', NULL),
(67, '> 20000€', 8, 0, 'h5', 'hidden', 'checkbox', NULL),
(68, 'Application/s interne/s au Département', 13, 0, 'h5', 'hidden', 'checkbox', NULL),
(69, 'Application/s externe/s au Département', 13, 0, 'h5', 'hidden', 'checkbox', NULL),
(70, 'Format/s des données :', 13, 0, 'h5', 'hidden choixm ajout', 'checkbox', NULL),
(71, '< 100 Go', 14, 0, 'h5', 'hidden', 'checkbox', NULL),
(72, 'Entre 100 Go et 1 To', 14, 0, 'h5', 'hidden', 'checkbox', NULL),
(73, 'Entre 1 To et 5 To', 14, 0, 'h5', 'hidden', 'checkbox', NULL),
(74, '> 5 To', 14, 0, 'h5', 'hidden', 'checkbox', NULL),
(75, '< 100 Go', 15, 0, 'h5', 'hidden', 'checkbox', NULL),
(76, 'Entre 100 Go et 1 To', 15, 0, 'h5', 'hidden', 'checkbox', NULL),
(77, 'Entre 1 To et 5 To', 15, 0, 'h5', 'hidden', 'checkbox', NULL),
(78, '> 5 To', 15, 0, 'h5', 'hidden', 'checkbox', NULL),
(79, 'Quotidien', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(80, 'Hebdomadaire', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(81, 'Bi-mensuel', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(82, 'Mensuel', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(83, 'Trimestriel', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(84, 'Semestriel', 16, 0, 'h5', 'hidden', 'checkbox', NULL),
(85, 'Annuel', 16, 0, 'h5', 'hidden', 'checkbox', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
