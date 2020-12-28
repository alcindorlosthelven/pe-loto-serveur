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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.client: ~2 rows (approximately)
DELETE FROM `client`;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `nom`, `prenom`, `sexe`, `telephone`) VALUES
	(2, 'alcindor xs', 'losthelven abd', 'masculin', '37391567'),
	(3, 'baptistins', 'roothelange', 'masculin', '37391567');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.code_jeux
DROP TABLE IF EXISTS `code_jeux`;
CREATE TABLE IF NOT EXISTS `code_jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.code_jeux: ~2 rows (approximately)
DELETE FROM `code_jeux`;
/*!40000 ALTER TABLE `code_jeux` DISABLE KEYS */;
INSERT INTO `code_jeux` (`id`, `code`) VALUES
	(31, '1040'),
	(30, '20');
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

-- Dumping structure for table pe_loto_serveur.vendeur
DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vendeur: ~2 rows (approximately)
DELETE FROM `vendeur`;
/*!40000 ALTER TABLE `vendeur` DISABLE KEYS */;
INSERT INTO `vendeur` (`id`, `nom`, `prenom`, `sexe`, `telephone`) VALUES
	(1, 'baptistins', 'roothelange', 'masculin', '37391567'),
	(2, 'baptistins', 'nhgkkjgj', 'masculin', '37391567');
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
  `heure` time DEFAULT NULL,
  `eliminer` enum('oui','non') DEFAULT 'non',
  PRIMARY KEY (`id`),
  KEY `FK_vente_vendeur` (`id_vendeur`),
  KEY `FK_vente_client` (`id_client`),
  CONSTRAINT `FK_vente_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`),
  CONSTRAINT `FK_vente_vendeur` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente: ~2 rows (approximately)
DELETE FROM `vente`;
/*!40000 ALTER TABLE `vente` DISABLE KEYS */;
INSERT INTO `vente` (`id`, `id_vendeur`, `id_client`, `paris`, `tirage`, `no_ticket`, `ref_pos`, `tid`, `sequence`, `serial`, `date`, `heure`, `eliminer`) VALUES
	(19, 1, 3, '[{"id_code_jeux":"31","pari":"43","mise":"250"},{"id_code_jeux":"31","pari":"43","mise":"250"},{"id_code_jeux":"31","pari":"43","mise":"250"}]', 'abcd', '00254', '#45434$54', '534-543-325-543', 'seq-dfsdsd09', 's-e543464', '2020-12-12', '12:22:00', 'oui');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente_eliminer: ~1 rows (approximately)
DELETE FROM `vente_eliminer`;
/*!40000 ALTER TABLE `vente_eliminer` DISABLE KEYS */;
INSERT INTO `vente_eliminer` (`id`, `id_vente`, `motif`, `status`) VALUES
	(4, 19, 'voici le motif', 'terminer');
/*!40000 ALTER TABLE `vente_eliminer` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
