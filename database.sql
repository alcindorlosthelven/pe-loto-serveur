-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.31 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de la table pe_loto_serveur. banque
DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banque` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banque` (`banque`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.banque : ~1 rows (environ)
/*!40000 ALTER TABLE `banque` DISABLE KEYS */;
INSERT IGNORE INTO `banque` (`id`, `banque`, `longitude`, `latitude`) VALUES
	(1, 'banque delmas 31', '72.25455555', '18.2222222');
/*!40000 ALTER TABLE `banque` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. branche
DROP TABLE IF EXISTS `branche`;
CREATE TABLE IF NOT EXISTS `branche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branche` varchar(50) DEFAULT NULL,
  `id_reseau` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branche` (`branche`),
  KEY `FK_branche_reseau` (`id_reseau`),
  CONSTRAINT `FK_branche_reseau` FOREIGN KEY (`id_reseau`) REFERENCES `reseau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.branche : ~2 rows (environ)
/*!40000 ALTER TABLE `branche` DISABLE KEYS */;
INSERT IGNORE INTO `branche` (`id`, `branche`, `id_reseau`) VALUES
	(1, 'branche sud', 1),
	(2, 'branche ouest', 1);
/*!40000 ALTER TABLE `branche` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. client
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.client : ~1 rows (environ)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT IGNORE INTO `client` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(1, 'default', 'client', 'm', '00000000', 'defaultclient', 'null', 'non', 'client');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. code_jeux
DROP TABLE IF EXISTS `code_jeux`;
CREATE TABLE IF NOT EXISTS `code_jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `gagne` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.code_jeux : ~9 rows (environ)
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

-- Listage de la structure de la table pe_loto_serveur. configuration
DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `valeur` text,
  `categorie` enum('image','text','video','non_modifiable') DEFAULT 'image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.configuration : 4 rows
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT IGNORE INTO `configuration` (`id`, `nom`, `valeur`, `categorie`) VALUES
	(1, 'licence_email', 'los-framework@gmail.com', 'non_modifiable'),
	(2, 'licence_code', '53-240-936-26', 'non_modifiable'),
	(3, 'licence_url', 'http://licence-serveur-sge.bioshaiti.com/licence-serveur-sge', 'text'),
	(4, 'taxe', '10', 'text');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. departement
DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement` varchar(50) NOT NULL,
  `id_reseau_globale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departement` (`departement`),
  KEY `FK_departement_reseau_globale` (`id_reseau_globale`),
  CONSTRAINT `FK_departement_reseau_globale` FOREIGN KEY (`id_reseau_globale`) REFERENCES `reseau_globale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.departement : ~2 rows (environ)
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT IGNORE INTO `departement` (`id`, `departement`, `id_reseau_globale`) VALUES
	(1, 'departement ouest', 1),
	(2, 'departement sud', 1);
/*!40000 ALTER TABLE `departement` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. groupe
DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `id_departement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groupe_departement` (`id_departement`),
  CONSTRAINT `FK_groupe_departement` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.groupe : ~2 rows (environ)
/*!40000 ALTER TABLE `groupe` DISABLE KEYS */;
INSERT IGNORE INTO `groupe` (`id`, `nom`, `id_departement`) VALUES
	(2, 'groupe fontamara', 2),
	(3, 'groupe 12', 2);
/*!40000 ALTER TABLE `groupe` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. lotterie
DROP TABLE IF EXISTS `lotterie`;
CREATE TABLE IF NOT EXISTS `lotterie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lotterie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lotterie` (`lotterie`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.lotterie : 2 rows
/*!40000 ALTER TABLE `lotterie` DISABLE KEYS */;
INSERT IGNORE INTO `lotterie` (`id`, `lotterie`) VALUES
	(1, 'new york'),
	(2, 'florida');
/*!40000 ALTER TABLE `lotterie` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. lot_gagnant
DROP TABLE IF EXISTS `lot_gagnant`;
CREATE TABLE IF NOT EXISTS `lot_gagnant` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '1900-12-12',
  `tirage` varchar(50) NOT NULL DEFAULT 'n/a',
  `lotterie` varchar(50) NOT NULL DEFAULT 'n/a',
  `lot1` varchar(50) NOT NULL DEFAULT '',
  `lot2` varchar(50) NOT NULL DEFAULT '0',
  `lot3` varchar(50) NOT NULL DEFAULT '0',
  `loto3` varchar(50) NOT NULL DEFAULT '0',
  `mariaj` text NOT NULL,
  `loto4` text NOT NULL,
  `loto5` text NOT NULL,
  `borlette` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_tirage_lotterie` (`date`,`tirage`,`lotterie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.lot_gagnant : ~0 rows (environ)
/*!40000 ALTER TABLE `lot_gagnant` DISABLE KEYS */;
INSERT IGNORE INTO `lot_gagnant` (`id`, `date`, `tirage`, `lotterie`, `lot1`, `lot2`, `lot3`, `loto3`, `mariaj`, `loto4`, `loto5`, `borlette`) VALUES
	(2, '2021-05-04', 'nyc-12h30', 'null', '12', '21', '05', '112', '["21*05","05*21","12*21","21*12","12*05","05*12"]', '{"option1":"2105","option2":"1221","option3":"1205"}', '{"option1":"11221","option2":"11205","option3":"22105"}', '{"lot1":"12","lot2":"21","lot3":"05"}');
/*!40000 ALTER TABLE `lot_gagnant` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. motif_elimination
DROP TABLE IF EXISTS `motif_elimination`;
CREATE TABLE IF NOT EXISTS `motif_elimination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.motif_elimination : 1 rows
/*!40000 ALTER TABLE `motif_elimination` DISABLE KEYS */;
INSERT IGNORE INTO `motif_elimination` (`id`, `motif`) VALUES
	(6, 'erreur reseau');
/*!40000 ALTER TABLE `motif_elimination` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. pos
DROP TABLE IF EXISTS `pos`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.pos : ~1 rows (environ)
/*!40000 ALTER TABLE `pos` DISABLE KEYS */;
INSERT IGNORE INTO `pos` (`id`, `id_branche`, `id_superviseur`, `id_banque`, `id_reseau`, `id_groupe`, `id_departement`, `imei`, `longitude`, `latitude`, `statut`) VALUES
	(3, 2, 8, 1, 1, 2, 2, '958325e6-f5c1-485d-9a90-e339fae4687c', '-72.3221835', '18.5400291', 'actif');
/*!40000 ALTER TABLE `pos` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. pos_vendeur
DROP TABLE IF EXISTS `pos_vendeur`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.pos_vendeur : ~1 rows (environ)
/*!40000 ALTER TABLE `pos_vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `pos_vendeur` (`id`, `id_vendeur`, `id_pos`) VALUES
	(2, 1, 3);
/*!40000 ALTER TABLE `pos_vendeur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. prime
DROP TABLE IF EXISTS `prime`;
CREATE TABLE IF NOT EXISTS `prime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_code_jeux` int(11) NOT NULL DEFAULT '0',
  `pos` int(11) DEFAULT NULL,
  `branche` int(11) DEFAULT NULL,
  `superviseur` int(11) DEFAULT NULL,
  `groupe` int(11) DEFAULT NULL,
  `departement` int(11) DEFAULT NULL,
  `prime_pour` enum('generale','autre') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prime_code_jeux` (`id_code_jeux`),
  CONSTRAINT `FK_prime_code_jeux` FOREIGN KEY (`id_code_jeux`) REFERENCES `code_jeux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.prime : ~0 rows (environ)
/*!40000 ALTER TABLE `prime` DISABLE KEYS */;
/*!40000 ALTER TABLE `prime` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. reseau
DROP TABLE IF EXISTS `reseau`;
CREATE TABLE IF NOT EXISTS `reseau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `id_groupe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reseau_groupe` (`id_groupe`),
  CONSTRAINT `FK_reseau_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `groupe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.reseau : ~1 rows (environ)
/*!40000 ALTER TABLE `reseau` DISABLE KEYS */;
INSERT IGNORE INTO `reseau` (`id`, `nom`, `id_groupe`) VALUES
	(1, 'reseau 23', 2);
/*!40000 ALTER TABLE `reseau` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. reseau_globale
DROP TABLE IF EXISTS `reseau_globale`;
CREATE TABLE IF NOT EXISTS `reseau_globale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.reseau_globale : ~0 rows (environ)
/*!40000 ALTER TABLE `reseau_globale` DISABLE KEYS */;
INSERT IGNORE INTO `reseau_globale` (`id`, `nom`) VALUES
	(1, 'PEL');
/*!40000 ALTER TABLE `reseau_globale` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. tirage
DROP TABLE IF EXISTS `tirage`;
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.tirage : 2 rows
/*!40000 ALTER TABLE `tirage` DISABLE KEYS */;
INSERT IGNORE INTO `tirage` (`id`, `tirage`, `nom`, `heure_fermeture`, `heure_ouverture`, `heure_rapport`, `email_rapport`, `site_api`, `statut`, `programer`, `heure_programer`) VALUES
	(10, 'nyc-20h30', 'new york 8h30', '14:30', '08:00', '14:31', 'alcindorlos@gmail.com', 'n/a', 'n/a', 'non', 'non'),
	(9, 'nyc-12h30', 'new york midi 30', '13:30', '08:00', '13:31', 'alcindorlos@gmail.com', 'n/a', 'n/a', 'non', 'non');
/*!40000 ALTER TABLE `tirage` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. utilisateur
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `nom_prenom` (`nom`,`prenom`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.utilisateur : ~2 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT IGNORE INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `password`, `role`, `objet`, `connect`) VALUES
	(7, 'alcindor', 'losthelven', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'utilisateur', 'oui'),
	(8, 'louis', 'john merlin', 'louis', '6b2bc449c920175311f7b1e7922d3bce', 'superviseur', 'utilisateur', 'non');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. vendeur
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_prenom` (`nom`,`prenom`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vendeur : ~1 rows (environ)
/*!40000 ALTER TABLE `vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `vendeur` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`) VALUES
	(1, 'alcindor', 'losthelven', 'masculin', '37391567', 'v-alosthelven', 'd4748ddc1eb78bab20009a7759ff2cf6', 'oui', 'vendeur');
/*!40000 ALTER TABLE `vendeur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. vente
DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `paris` text,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vente : ~5 rows (environ)
/*!40000 ALTER TABLE `vente` DISABLE KEYS */;
INSERT IGNORE INTO `vente` (`id`, `id_vendeur`, `id_client`, `paris`, `tirage`, `no_ticket`, `ref_pos`, `tid`, `sequence`, `serial`, `date`, `heure`, `eliminer`, `gain`, `total_gain`, `payer`) VALUES
	(1, 1, 1, '[{"codeJeux":"20:Borlette","pari":"12","mise":50,"lot":"lot1","montant":2500,"gain":"oui"},{"codeJeux":"20:Borlette","pari":"21","mise":50,"lot":"lot2","montant":1000,"gain":"oui"},{"codeJeux":"30:loto3","pari":"112","mise":100,"lot":"loto3","montant":50000,"gain":"oui"},{"codeJeux":"40:Mariage","pari":"12*05","mise":50,"lot":"mariaj","montant":50000,"gain":"oui"},{"codeJeux":"41: Loto 4 option 1","pari":"1205","mise":25,"checked":true,"lot":"lotto 4 option 3","montant":125000,"gain":"oui"},{"codeJeux":"42: Loto 4 option 2","pari":"1205","mise":25,"checked":true,"lot":"lotto 4 option 3","montant":125000,"gain":"oui"},{"codeJeux":"43: Loto 4 option 3","pari":"1205","mise":25,"checked":true,"lot":"lotto 4 option 3","montant":125000,"gain":"oui"},{"codeJeux":"51: Loto 5 option 1","pari":"11221","mise":25,"checked":true,"lot":"lotto 5 option 1","montant":625000,"gain":"oui"},{"codeJeux":"52: Loto 5 option 2","pari":"11221","mise":25,"checked":true,"lot":"lotto 5 option 1","montant":625000,"gain":"oui"},{"codeJeux":"53: Loto 5 option 3","pari":"11221","mise":25,"checked":true,"lot":"lotto 5 option 1","montant":625000,"gain":"oui"}]', 'nyc-12h30', '566-2-21087', '958325e6-f5c1-485d-9a90-e339fae4687c', '958325e6-f5c1-485d-9a90-e339fae4687c', '994-2-21746', '958325e6-f5c1-485d-9a90-e339fae4687c', '2021-05-04', '12:10:30', 'non', 'oui', '2353500', 'non'),
	(2, 1, 1, '[{"codeJeux":"20:Borlette","pari":"00","mise":50},{"codeJeux":"20:Borlette","pari":"25","mise":50}]', 'nyc-12h30', '361-15-441169', '958325e6-f5c1-485d-9a90-e339fae4687c', '958325e6-f5c1-485d-9a90-e339fae4687c', '833-15-441305', '958325e6-f5c1-485d-9a90-e339fae4687c', '2021-05-04', '12:16:07', 'non', 'n/a', '0', 'n/a'),
	(3, 1, 1, '[{"codeJeux":"20:Borlette","pari":"21","mise":100,"lot":"lot2","montant":2000,"gain":"oui"}]', 'nyc-12h30', '581-17-1289', '958325e6-f5c1-485d-9a90-e339fae4687c', '958325e6-f5c1-485d-9a90-e339fae4687c', '51-17-121185', '958325e6-f5c1-485d-9a90-e339fae4687c', '2021-05-04', '12:17:26', 'non', 'oui', '2000', 'oui'),
	(4, 1, 1, '[{"codeJeux":"20:Borlette","pari":"87","mise":10},{"codeJeux":"20:Borlette","pari":"50","mise":78},{"codeJeux":"20:Borlette","pari":"74","mise":25}]', 'nyc-12h30', '732-17-28428', '958325e6-f5c1-485d-9a90-e339fae4687c', '958325e6-f5c1-485d-9a90-e339fae4687c', '192-17-281448', '958325e6-f5c1-485d-9a90-e339fae4687c', '2021-05-04', '12:17:53', 'non', 'n/a', '0', 'n/a'),
	(5, 1, 1, '[{"codeJeux":"20:Borlette","pari":"87","mise":10},{"codeJeux":"20:Borlette","pari":"50","mise":78},{"codeJeux":"20:Borlette","pari":"74","mise":25}]', 'nyc-12h30', '199-2-16597', '958325e6-f5c1-485d-9a90-e339fae4687c', '958325e6-f5c1-485d-9a90-e339fae4687c', '650-2-161952', '958325e6-f5c1-485d-9a90-e339fae4687c', '2021-05-04', '13:02:24', 'non', 'n/a', '0', 'n/a');
/*!40000 ALTER TABLE `vente` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. vente_eliminer
DROP TABLE IF EXISTS `vente_eliminer`;
CREATE TABLE IF NOT EXISTS `vente_eliminer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vente` int(11) DEFAULT NULL,
  `motif` tinytext,
  `status` enum('en cours','terminer') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_vente` (`id_vente`),
  CONSTRAINT `FK_vente_eliminer_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vente_eliminer : ~0 rows (environ)
/*!40000 ALTER TABLE `vente_eliminer` DISABLE KEYS */;
/*!40000 ALTER TABLE `vente_eliminer` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
