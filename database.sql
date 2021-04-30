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


-- Dumping database structure for pe_loto_serveur
CREATE DATABASE IF NOT EXISTS `pe_loto_serveur` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pe_loto_serveur`;

-- Dumping structure for table pe_loto_serveur.banque
CREATE TABLE IF NOT EXISTS `banque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banque` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banque` (`banque`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.banque: ~0 rows (approximately)
/*!40000 ALTER TABLE `banque` DISABLE KEYS */;
INSERT IGNORE INTO `banque` (`id`, `banque`, `longitude`, `latitude`) VALUES
	(5, 'banque delmas', '81.6545654', '-12.543434'),
	(6, 'banque de carefour', '-78.2458885565', '17.255548458');
/*!40000 ALTER TABLE `banque` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.branche
CREATE TABLE IF NOT EXISTS `branche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branche` varchar(50) DEFAULT NULL,
  `id_reseau` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branche` (`branche`),
  KEY `FK_branche_reseau` (`id_reseau`),
  CONSTRAINT `FK_branche_reseau` FOREIGN KEY (`id_reseau`) REFERENCES `reseau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.branche: ~2 rows (approximately)
/*!40000 ALTER TABLE `branche` DISABLE KEYS */;
INSERT IGNORE INTO `branche` (`id`, `branche`, `id_reseau`) VALUES
	(7, 'branche modifier', 1),
	(8, 'branche 2 m', 2);
/*!40000 ALTER TABLE `branche` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.client
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
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT IGNORE INTO `client` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(14, 'default', 'client', 'masculin', 'all', 'c-aall', 'a181a603769c1f98ad927e7367c7aa51', 'non', 'client');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.code_jeux
CREATE TABLE IF NOT EXISTS `code_jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `gagne` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.code_jeux: ~9 rows (approximately)
/*!40000 ALTER TABLE `code_jeux` DISABLE KEYS */;
INSERT IGNORE INTO `code_jeux` (`id`, `code`, `description`, `gagne`) VALUES
	(63, '20', 'Borlette', '50|20|10'),
	(64, '30', 'Loto 3', '500'),
	(65, '40', 'Mariage', '1000'),
	(66, '41', 'L4O1', '5000'),
	(67, '42', 'L4O2', '5000'),
	(68, '43', 'L4O3', '5000'),
	(70, '51', 'L5O1', '25000'),
	(71, '52', 'L5O2', '25000'),
	(72, '53', 'L5O3', '25000');
/*!40000 ALTER TABLE `code_jeux` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.configuration
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `valeur` text DEFAULT NULL,
  `categorie` enum('image','text','video','non_modifiable') DEFAULT 'image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.configuration: 4 rows
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT IGNORE INTO `configuration` (`id`, `nom`, `valeur`, `categorie`) VALUES
	(1, 'licence_email', 'los-framework@gmail.com', 'non_modifiable'),
	(2, 'licence_code', '53-240-936-26', 'non_modifiable'),
	(3, 'licence_url', 'http://licence-serveur-sge.bioshaiti.com/licence-serveur-sge', 'text'),
	(4, 'taxe', '10', 'text');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.departement
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement` varchar(50) NOT NULL,
  `id_reseau_globale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departement` (`departement`),
  KEY `FK_departement_reseau_globale` (`id_reseau_globale`),
  CONSTRAINT `FK_departement_reseau_globale` FOREIGN KEY (`id_reseau_globale`) REFERENCES `reseau_globale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.departement: ~1 rows (approximately)
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT IGNORE INTO `departement` (`id`, `departement`, `id_reseau_globale`) VALUES
	(6, 'ouest modifier', 1),
	(7, 'sud', 1);
/*!40000 ALTER TABLE `departement` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.groupe
CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `id_departement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groupe_departement` (`id_departement`),
  CONSTRAINT `FK_groupe_departement` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.groupe: ~0 rows (approximately)
/*!40000 ALTER TABLE `groupe` DISABLE KEYS */;
INSERT IGNORE INTO `groupe` (`id`, `nom`, `id_departement`) VALUES
	(1, 'groupe 1 modifier', 6),
	(2, 'groupe 2 m', 7);
/*!40000 ALTER TABLE `groupe` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.lotterie
CREATE TABLE IF NOT EXISTS `lotterie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lotterie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lotterie` (`lotterie`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.lotterie: 2 rows
/*!40000 ALTER TABLE `lotterie` DISABLE KEYS */;
INSERT IGNORE INTO `lotterie` (`id`, `lotterie`) VALUES
	(1, 'new york'),
	(2, 'florida');
/*!40000 ALTER TABLE `lotterie` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.lot_gagnant
CREATE TABLE IF NOT EXISTS `lot_gagnant` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '1900-12-12',
  `tirage` varchar(50) NOT NULL DEFAULT 'n/a',
  `lotterie` varchar(50) NOT NULL DEFAULT 'n/a',
  `lot1` int(11) NOT NULL,
  `lot2` int(11) NOT NULL DEFAULT 0,
  `lot3` int(11) NOT NULL DEFAULT 0,
  `loto3` int(11) NOT NULL DEFAULT 0,
  `mariaj` text NOT NULL,
  `loto4` text NOT NULL,
  `loto5` text NOT NULL,
  `borlette` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_tirage_lotterie` (`date`,`tirage`,`lotterie`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.lot_gagnant: ~1 rows (approximately)
/*!40000 ALTER TABLE `lot_gagnant` DISABLE KEYS */;
/*!40000 ALTER TABLE `lot_gagnant` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.motif_elimination
CREATE TABLE IF NOT EXISTS `motif_elimination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.motif_elimination: 1 rows
/*!40000 ALTER TABLE `motif_elimination` DISABLE KEYS */;
INSERT IGNORE INTO `motif_elimination` (`id`, `motif`) VALUES
	(6, 'erreur reseau');
/*!40000 ALTER TABLE `motif_elimination` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.pos
CREATE TABLE IF NOT EXISTS `pos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_branche` int(11) NOT NULL,
  `id_superviseur` int(11) NOT NULL,
  `id_banque` int(11) NOT NULL,
  `id_reseau` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `statut` enum('actif','inactif','eteint','desactiver') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `imei` (`imei`),
  KEY `FK_pos_utilisateur` (`id_superviseur`),
  KEY `FK_pos_branche` (`id_branche`),
  KEY `FK_pos_banque` (`id_banque`),
  KEY `FK_pos_reseau` (`id_reseau`),
  KEY `FK_pos_groupe` (`id_groupe`),
  KEY `FK_pos_departement` (`id_departement`),
  CONSTRAINT `FK_pos_banque` FOREIGN KEY (`id_banque`) REFERENCES `banque` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_branche` FOREIGN KEY (`id_branche`) REFERENCES `branche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_departement` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `groupe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_reseau` FOREIGN KEY (`id_reseau`) REFERENCES `reseau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_utilisateur` FOREIGN KEY (`id_superviseur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.pos: ~1 rows (approximately)
/*!40000 ALTER TABLE `pos` DISABLE KEYS */;
INSERT IGNORE INTO `pos` (`id`, `id_branche`, `id_superviseur`, `id_banque`, `id_reseau`, `id_groupe`, `id_departement`, `imei`, `longitude`, `latitude`, `statut`) VALUES
	(11, 8, 10, 6, 2, 2, 7, '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '-72.3192614', '18.5382818', 'actif'),
	(12, 8, 10, 6, 2, 2, 7, '778758748758475847584', 'null', 'null', 'actif');
/*!40000 ALTER TABLE `pos` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.pos_vendeur
CREATE TABLE IF NOT EXISTS `pos_vendeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `id_pos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_vendeur_id_pos` (`id_vendeur`,`id_pos`),
  UNIQUE KEY `id_vendeur` (`id_vendeur`),
  UNIQUE KEY `id_pos` (`id_pos`),
  CONSTRAINT `FK_pos_vendeur_pos` FOREIGN KEY (`id_pos`) REFERENCES `pos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_vendeur_vendeur` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.pos_vendeur: ~2 rows (approximately)
/*!40000 ALTER TABLE `pos_vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `pos_vendeur` (`id`, `id_vendeur`, `id_pos`) VALUES
	(20, 6, 11),
	(22, 7, 12);
/*!40000 ALTER TABLE `pos_vendeur` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.prime
CREATE TABLE IF NOT EXISTS `prime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_code_jeux` int(11) NOT NULL DEFAULT 0,
  `pos` int(11) DEFAULT NULL,
  `branche` int(11) DEFAULT NULL,
  `superviseur` int(11) DEFAULT NULL,
  `groupe` int(11) DEFAULT NULL,
  `departement` int(11) DEFAULT NULL,
  `prime_pour` enum('generale','autre') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prime_code_jeux` (`id_code_jeux`),
  CONSTRAINT `FK_prime_code_jeux` FOREIGN KEY (`id_code_jeux`) REFERENCES `code_jeux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.prime: ~0 rows (approximately)
/*!40000 ALTER TABLE `prime` DISABLE KEYS */;
/*!40000 ALTER TABLE `prime` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.reseau
CREATE TABLE IF NOT EXISTS `reseau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `id_groupe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reseau_groupe` (`id_groupe`),
  CONSTRAINT `FK_reseau_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `groupe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.reseau: ~0 rows (approximately)
/*!40000 ALTER TABLE `reseau` DISABLE KEYS */;
INSERT IGNORE INTO `reseau` (`id`, `nom`, `id_groupe`) VALUES
	(1, 'reseau modifier', 1),
	(2, 'reseau 2 m', 2);
/*!40000 ALTER TABLE `reseau` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.reseau_globale
CREATE TABLE IF NOT EXISTS `reseau_globale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.reseau_globale: ~0 rows (approximately)
/*!40000 ALTER TABLE `reseau_globale` DISABLE KEYS */;
INSERT IGNORE INTO `reseau_globale` (`id`, `nom`) VALUES
	(1, 'PEL');
/*!40000 ALTER TABLE `reseau_globale` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.tirage
CREATE TABLE IF NOT EXISTS `tirage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tirage` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `heure_fermeture` varchar(50) NOT NULL DEFAULT '',
  `heure_ouverture` varchar(50) NOT NULL DEFAULT '',
  `heure_rapport` varchar(50) NOT NULL DEFAULT '',
  `email_rapport` varchar(50) NOT NULL,
  `site_api` varchar(50) DEFAULT NULL,
  `statut` enum('en cours','n/a','fermer') NOT NULL,
  `programer` enum('oui','non') NOT NULL DEFAULT 'non',
  `heure_programer` varchar(50) DEFAULT 'non',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tirage` (`tirage`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.tirage: 2 rows
/*!40000 ALTER TABLE `tirage` DISABLE KEYS */;
INSERT IGNORE INTO `tirage` (`id`, `tirage`, `nom`, `heure_fermeture`, `heure_ouverture`, `heure_rapport`, `email_rapport`, `site_api`, `statut`, `programer`, `heure_programer`) VALUES
	(7, 'nyc-12h30', 'new york midi', '20:30', '08:00', '14:32', 'alcindorlos@gmail.com', 'n/a', 'en cours', 'non', 'non'),
	(8, 'nyc-20h30', 'new york soire', '13:30', '08:00', '20:31', 'alcindorlosthelven@gmail.com', 'n/a', 'en cours', 'non', 'non');
/*!40000 ALTER TABLE `tirage` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT 'non',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `nom_prenom` (`nom`,`prenom`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.utilisateur: ~2 rows (approximately)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT IGNORE INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `password`, `role`, `objet`, `connect`) VALUES
	(7, 'alcindor', 'losthelven', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'utilisateur', 'oui'),
	(9, 'louis jhon', 'merlin x', 'superviseur', '6b2bc449c920175311f7b1e7922d3bce', 'superviseur', 'utilisateur', 'non'),
	(10, 'alcindor', 'roothelange', 'roothelange', '81dc9bdb52d04dc20036dbd8313ed055', 'superviseur', 'utilisateur', 'non');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vendeur
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_prenom` (`nom`,`prenom`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vendeur: ~1 rows (approximately)
/*!40000 ALTER TABLE `vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `vendeur` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(6, 'alcindor', 'losthelven', 'masculin', '37391567', 'v-alosthelven', 'd4748ddc1eb78bab20009a7759ff2cf6', 'oui', 'vendeur'),
	(7, 'alcindor', 'roothelange', 'feminin', '33964995', 'v-aroothelange', 'e93c9892bb5f73b109f55ed7b596320e', 'oui', 'vendeur'),
	(8, 'pc', 'vendeur', 'masculin', '123456', 'v-pvendeur', '0b47c0ccc70b07873307a07a262c5075', 'non', 'vendeur');
/*!40000 ALTER TABLE `vendeur` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vente
CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `paris` text DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente: ~4 rows (approximately)
/*!40000 ALTER TABLE `vente` DISABLE KEYS */;
INSERT IGNORE INTO `vente` (`id`, `id_vendeur`, `id_client`, `paris`, `tirage`, `no_ticket`, `ref_pos`, `tid`, `sequence`, `serial`, `date`, `heure`, `eliminer`, `gain`, `total_gain`, `payer`) VALUES
	(84, 6, 14, '[{"codeJeux":"20:Borlette","pari":"12","mise":500},{"codeJeux":"20:Borlette","pari":"67","mise":250,"lot":"lot1","montant":12500,"gain":"oui"},{"codeJeux":"40:Mariage","pari":"20*30","mise":20,"lot":"mariaj","montant":20000,"gain":"oui"},{"codeJeux":"40:Mariage","pari":"30*25","mise":75},{"codeJeux":"30:loto3","pari":"123","mise":5},{"codeJeux":"30:loto3","pari":"023","mise":50},{"codeJeux":"20:Borlette","pari":"00","mise":50},{"codeJeux":"41: Loto 4 option 1","pari":"2545","mise":75,"checked":true},{"codeJeux":"42: Loto 4 option 2","pari":"2545","mise":75,"checked":true},{"codeJeux":"43: Loto 4 option 3","pari":"2545","mise":75,"checked":true},{"codeJeux":"51: Loto 5 option 1","pari":"36587","mise":100,"checked":true},{"codeJeux":"52: Loto 5 option 2","pari":"36587","mise":100,"checked":true},{"codeJeux":"53: Loto 5 option 3","pari":"36587","mise":100,"checked":true}]', 'nyc-12h30', '839-17-491669', 'n/a', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '929-17-491056', 'n/a', '2021-04-13', '11:17:49', 'non', 'oui', '32500', 'oui'),
	(87, 6, 14, '[{"codeJeux":"20:Borlette","pari":"12","mise":500},{"codeJeux":"20:Borlette","pari":"67","mise":250,"lot":"lot1","montant":12500,"gain":"oui"},{"codeJeux":"40:Mariage","pari":"20*30","mise":20,"lot":"mariaj","montant":20000,"gain":"oui"},{"codeJeux":"40:Mariage","pari":"30*25","mise":75},{"codeJeux":"30:loto3","pari":"123","mise":5},{"codeJeux":"30:loto3","pari":"023","mise":50},{"codeJeux":"20:Borlette","pari":"00","mise":50},{"codeJeux":"41: Loto 4 option 1","pari":"2545","mise":75,"checked":true},{"codeJeux":"42: Loto 4 option 2","pari":"2545","mise":75,"checked":true},{"codeJeux":"43: Loto 4 option 3","pari":"2545","mise":75,"checked":true},{"codeJeux":"51: Loto 5 option 1","pari":"36587","mise":100,"checked":true},{"codeJeux":"52: Loto 5 option 2","pari":"36587","mise":100,"checked":true},{"codeJeux":"53: Loto 5 option 3","pari":"36587","mise":100,"checked":true}]', 'nyc-12h30', '839-17-491670', 'n/a', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '929-17-491057', 'n/a', '2021-04-13', '11:17:49', 'non', 'oui', '32500', 'non'),
	(88, 6, 14, '[{"codeJeux":"41: Loto 4 option 1","pari":"1221","mise":50,"checked":true},{"codeJeux":"42: Loto 4 option 2","pari":"1221","mise":50,"checked":true},{"codeJeux":"43: Loto 4 option 3","pari":"1221","mise":50,"checked":true}]', 'nyc-12h30', '514-35-531666', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '410-35-531301', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '2021-04-20', '14:35:53', 'non', 'n/a', '0', 'n/a'),
	(89, 6, 14, '[{"codeJeux":"20:Borlette","pari":"50","mise":55},{"codeJeux":"40:Mariage","pari":"50*20","mise":15},{"codeJeux":"30:loto3","pari":"150","mise":25},{"codeJeux":"41: Loto 4 option 1","pari":"5248","mise":12,"checked":true},{"codeJeux":"42: Loto 4 option 2","pari":"5248","mise":12,"checked":true},{"codeJeux":"43: Loto 4 option 3","pari":"5248","mise":12,"checked":true},{"codeJeux":"51: Loto 5 option 1","pari":"12345","mise":50,"checked":true},{"codeJeux":"52: Loto 5 option 2","pari":"12345","mise":50,"checked":true},{"codeJeux":"53: Loto 5 option 3","pari":"12345","mise":50,"checked":true}]', 'nyc-12h30', '260-37-45382', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '247-37-451829', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '2021-04-20', '14:37:45', 'non', 'n/a', '0', 'n/a'),
	(90, 6, 14, '[{"codeJeux":"51: Loto 5 option 1","pari":"58748","mise":25,"checked":true},{"codeJeux":"52: Loto 5 option 2","pari":"58748","mise":25,"checked":true},{"codeJeux":"53: Loto 5 option 3","pari":"58748","mise":25,"checked":true}]', 'nyc-12h30', '797-43-12297', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '670-43-12785', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '2021-04-20', '14:43:12', 'non', 'n/a', '0', 'n/a'),
	(91, 6, 14, '[{"codeJeux":"20:Borlette","pari":"12","mise":32}]', 'nyc-12h30', '538-57-28549', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '899-57-28183', '28d6fc06-9485-4f48-8daf-bcf8c70338d3', '2021-04-21', '10:57:46', 'non', 'n/a', '0', 'n/a');
/*!40000 ALTER TABLE `vente` ENABLE KEYS */;

-- Dumping structure for table pe_loto_serveur.vente_eliminer
CREATE TABLE IF NOT EXISTS `vente_eliminer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vente` int(11) DEFAULT NULL,
  `motif` tinytext DEFAULT NULL,
  `status` enum('en cours','terminer') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_vente` (`id_vente`),
  CONSTRAINT `FK_vente_eliminer_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table pe_loto_serveur.vente_eliminer: ~0 rows (approximately)
/*!40000 ALTER TABLE `vente_eliminer` DISABLE KEYS */;
/*!40000 ALTER TABLE `vente_eliminer` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
