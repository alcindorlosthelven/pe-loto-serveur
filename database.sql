-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table pe_loto_serveur.client
DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.client: ~1 rows (approximately)
DELETE FROM `client`;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(14, 'default', 'client', 'masculin', 'all', 'c-aall', 'a181a603769c1f98ad927e7367c7aa51', 'non', 'client');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.code_jeux
DROP TABLE IF EXISTS `code_jeux`;
CREATE TABLE IF NOT EXISTS `code_jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.code_jeux: ~11 rows (approximately)
DELETE FROM `code_jeux`;
/*!40000 ALTER TABLE `code_jeux` DISABLE KEYS */;
INSERT INTO `code_jeux` (`id`, `code`, `description`) VALUES
	(63, '20', 'Borlette'),
	(64, '30', 'Loto 3'),
	(65, '40', 'Mariage'),
	(66, '41', 'Loto 4 Option 1'),
	(67, '42', 'Loto 4 Option 2'),
	(68, '43', 'Loto 4 Option 3'),
	(69, '49', 'Loto 4 Option toutes les options (1,2,3)'),
	(70, '51', 'Loto 5 option 1'),
	(71, '52', 'Loto 5 option 2'),
	(72, '53', 'Loto 5 option 3'),
	(73, '59', 'Loto 5 Toutes les options(1,2,3)');
/*!40000 ALTER TABLE `code_jeux` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.configuration
DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `valeur` text DEFAULT NULL,
  `categorie` enum('image','text','video','non_modifiable') DEFAULT 'image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.configuration: 4 rows
DELETE FROM `configuration`;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` (`id`, `nom`, `valeur`, `categorie`) VALUES
	(1, 'licence_email', 'los-framework@gmail.com', 'non_modifiable'),
	(2, 'licence_code', '53-240-936-26', 'non_modifiable'),
	(3, 'licence_url', 'http://licence-serveur-sge.bioshaiti.com/licence-serveur-sge', 'text'),
	(4, 'taxe', '10', 'text');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.lot_gagnant
DROP TABLE IF EXISTS `lot_gagnant`;
CREATE TABLE IF NOT EXISTS `lot_gagnant` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '1900-12-12',
  `tirage` varchar(50) NOT NULL DEFAULT 'n/a',
  `lot1` int(11) NOT NULL DEFAULT 0,
  `lot2` int(11) NOT NULL DEFAULT 0,
  `lot3` int(11) NOT NULL DEFAULT 0,
  `loto3` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_tirage` (`date`,`tirage`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.lot_gagnant: ~6 rows (approximately)
DELETE FROM `lot_gagnant`;
/*!40000 ALTER TABLE `lot_gagnant` DISABLE KEYS */;
INSERT INTO `lot_gagnant` (`id`, `date`, `tirage`, `lot1`, `lot2`, `lot3`, `loto3`) VALUES
	(23, '2021-03-10', 'midi', 23, 5, 25, 123);
/*!40000 ALTER TABLE `lot_gagnant` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.motif_elimination
DROP TABLE IF EXISTS `motif_elimination`;
CREATE TABLE IF NOT EXISTS `motif_elimination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.motif_elimination: 3 rows
DELETE FROM `motif_elimination`;
/*!40000 ALTER TABLE `motif_elimination` DISABLE KEYS */;
INSERT INTO `motif_elimination` (`id`, `motif`) VALUES
	(4, 'erreur reseau'),
	(3, 'error vendeur'),
	(5, 'autre error');
/*!40000 ALTER TABLE `motif_elimination` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.tirage
DROP TABLE IF EXISTS `tirage`;
CREATE TABLE IF NOT EXISTS `tirage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tirage` varchar(50) DEFAULT NULL,
  `statut` enum('en cours','n/a') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.tirage: 3 rows
DELETE FROM `tirage`;
/*!40000 ALTER TABLE `tirage` DISABLE KEYS */;
INSERT INTO `tirage` (`id`, `tirage`, `statut`) VALUES
	(1, 'midi', 'en cours'),
	(2, 'soir', 'n/a'),
	(3, 'matin', 'n/a');
/*!40000 ALTER TABLE `tirage` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.utilisateur
DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT 'non',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.utilisateur: ~1 rows (approximately)
DELETE FROM `utilisateur`;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `password`, `role`, `objet`, `connect`) VALUES
	(7, 'alcindor', 'losthelven', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'utilisateur', 'oui'),
	(8, 'alcindor', 'roothelven', 'root', '63a9f0ea7bb98050796b649e85481845', 'admin', 'utilisateur', 'non');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vendeur
DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vendeur: ~1 rows (approximately)
DELETE FROM `vendeur`;
/*!40000 ALTER TABLE `vendeur` DISABLE KEYS */;
INSERT INTO `vendeur` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(6, 'alcindor', 'losthelven', 'masculin', '37391567', 'v-alosthelven', 'd4748ddc1eb78bab20009a7759ff2cf6', 'oui', 'vendeur'),
	(7, 'alcindor', 'roothelange', 'feminin', '33964995', 'v-aroothelange', 'e93c9892bb5f73b109f55ed7b596320e', 'oui', 'vendeur');
/*!40000 ALTER TABLE `vendeur` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vente
DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `paris` tinytext DEFAULT NULL,
  `tirage` varchar(50) DEFAULT NULL,
  `no_ticket` varchar(50) DEFAULT NULL,
  `ref_pos` varchar(50) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `sequence` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` varchar(50) DEFAULT NULL,
  `eliminer` enum('oui','non') DEFAULT 'non',
  `gain` enum('oui','non','n/a') DEFAULT 'n/a',
  `total_gain` varchar(50) DEFAULT '0',
  `payer` enum('oui','non','n/a') DEFAULT 'n/a',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_ticket` (`no_ticket`),
  UNIQUE KEY `sequence` (`sequence`),
  KEY `FK_vente_vendeur` (`id_vendeur`),
  KEY `FK_vente_client` (`id_client`),
  CONSTRAINT `FK_vente_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`),
  CONSTRAINT `FK_vente_vendeur` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente: ~28 rows (approximately)
DELETE FROM `vente`;
/*!40000 ALTER TABLE `vente` DISABLE KEYS */;
INSERT INTO `vente` (`id`, `id_vendeur`, `id_client`, `paris`, `tirage`, `no_ticket`, `ref_pos`, `tid`, `sequence`, `serial`, `date`, `heure`, `eliminer`, `gain`, `total_gain`, `payer`) VALUES
	(63, 7, 14, '[{"codeJeux":"20:Borlette","pari":23,"mise":125,"lot":"lot1","montant":1250},{"codeJeux":"20:Borlette","pari":56,"mise":54},{"codeJeux":"20:Borlette","pari":12,"mise":100}]', 'midi', '921-15-41672', 'n/a', 'n/a', '30-15-41427', 'n/a', '2021-03-10', '10:15:41', 'non', 'oui', '1250', 'non'),
	(64, 7, 14, '[{"codeJeux":"20:Borlette","pari":25,"mise":33,"lot":"lot3","montant":66},{"codeJeux":"30:Loto 3","pari":125,"mise":50},{"codeJeux":"20:Borlette","pari":23,"mise":104,"lot":"lot1","montant":1040},{"codeJeux":"20:Borlette","pari":55,"mise":10}]', 'midi', '483-17-57908', 'n/a', 'n/a', '705-17-571245', 'n/a', '2021-03-10', '10:17:57', 'non', 'oui', '1106', 'non'),
	(65, 7, 14, '[{"codeJeux":"20:Borlette","pari":5,"mise":50,"lot":"lot2","montant":200}]', 'midi', '888-18-581136', 'n/a', 'n/a', '837-18-58462', 'n/a', '2021-03-10', '10:18:58', 'non', 'oui', '200', 'non'),
	(66, 7, 14, '[{"codeJeux":"20:Borlette","pari":23,"mise":100,"lot":"lot1","montant":1000},{"codeJeux":"30:Loto 3","pari":123,"mise":50,"lot":"loto3","montant":5000}]', 'midi', '496-19-251631', 'n/a', 'n/a', '377-19-25275', 'n/a', '2021-03-10', '10:19:25', 'non', 'oui', '6000', 'non'),
	(67, 7, 14, '[{"codeJeux":"20:Borlette","pari":54,"mise":65},{"codeJeux":"20:Borlette","pari":0,"mise":30},{"codeJeux":"20:Borlette","pari":56,"mise":21}]', 'midi', '561-20-0854', 'n/a', 'n/a', '646-20-01120', 'n/a', '2021-03-10', '10:20:00', 'non', 'n/a', '0', 'n/a');
/*!40000 ALTER TABLE `vente` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vente_eliminer
DROP TABLE IF EXISTS `vente_eliminer`;
CREATE TABLE IF NOT EXISTS `vente_eliminer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vente` int(11) DEFAULT NULL,
  `motif` tinytext DEFAULT NULL,
  `status` enum('en cours','terminer') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_vente` (`id_vente`),
  CONSTRAINT `FK_vente_eliminer_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente_eliminer: ~0 rows (approximately)
DELETE FROM `vente_eliminer`;
/*!40000 ALTER TABLE `vente_eliminer` DISABLE KEYS */;
/*!40000 ALTER TABLE `vente_eliminer` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
