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

-- Listage de la structure de la table pe_loto_serveur. acces
DROP TABLE IF EXISTS `acces`;
CREATE TABLE IF NOT EXISTS `acces` (
  `acces` varchar(50) NOT NULL,
  `titre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`acces`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.acces : ~0 rows (environ)
/*!40000 ALTER TABLE `acces` DISABLE KEYS */;
INSERT IGNORE INTO `acces` (`acces`, `titre`) VALUES
	('0', 'Tableau de bord');
/*!40000 ALTER TABLE `acces` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. acces_user
DROP TABLE IF EXISTS `acces_user`;
CREATE TABLE IF NOT EXISTS `acces_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `acces` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_acces_user_utilisateur` (`id_user`) USING BTREE,
  KEY `FK_acces_user_acces` (`acces`) USING BTREE,
  CONSTRAINT `FK_acces_user_acces` FOREIGN KEY (`acces`) REFERENCES `acces` (`acces`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_acces_user_utilisateur` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.acces_user : ~0 rows (environ)
/*!40000 ALTER TABLE `acces_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `acces_user` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. banque
DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banque` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banque` (`banque`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.banque : ~1 rows (environ)
/*!40000 ALTER TABLE `banque` DISABLE KEYS */;
INSERT IGNORE INTO `banque` (`id`, `banque`, `longitude`, `latitude`) VALUES
	(1, 'banque delmas 31', '72.25455555', '18.2222222');
/*!40000 ALTER TABLE `banque` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. branche
DROP TABLE IF EXISTS `branche`;
CREATE TABLE IF NOT EXISTS `branche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_supperviseur` int(11) NOT NULL DEFAULT '0',
  `branche` varchar(50) DEFAULT NULL,
  `addresse` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `prime` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branche` (`branche`),
  KEY `FK_branche_utilisateur` (`id_supperviseur`),
  CONSTRAINT `FK_branche_utilisateur` FOREIGN KEY (`id_supperviseur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.branche : ~1 rows (environ)
/*!40000 ALTER TABLE `branche` DISABLE KEYS */;
INSERT IGNORE INTO `branche` (`id`, `id_supperviseur`, `branche`, `addresse`, `telephone`, `longitude`, `latitude`, `prime`) VALUES
	(7, 11, 'branche no 1', 'fontamara 27', '50944552545', 'n/a', 'n/a', '[{"id_code_jeux":"63","code":"20","description":"Borlette","prime":"60|20|15"},{"id_code_jeux":"64","code":"30","description":"Loto 3","prime":"500"},{"id_code_jeux":"65","code":"40","description":"Mariage","prime":"1000"},{"id_code_jeux":"66","code":"41","description":"L4O1","prime":"5000"},{"id_code_jeux":"67","code":"42","description":"L4O2","prime":"5000"},{"id_code_jeux":"68","code":"43","description":"L4O3","prime":"5000"},{"id_code_jeux":"70","code":"51","description":"L5O1","prime":"25000"},{"id_code_jeux":"71","code":"52","description":"L5O2","prime":"25000"},{"id_code_jeux":"72","code":"53","description":"L5O3","prime":"25000"},{"id_code_jeux":"73","code":"44","description":"Mariage Gratuit","prime":"1000"}]'),
	(9, 11, 'branche no 2', 'delmas 65', '543534534534', 'n/a', 'n/a', '[{"id_code_jeux":"63","code":"20","description":"Borlette","prime":"55|25|15"},{"id_code_jeux":"64","code":"30","description":"Loto 3","prime":"500"},{"id_code_jeux":"65","code":"40","description":"Mariage","prime":"1000"},{"id_code_jeux":"66","code":"41","description":"L4O1","prime":"5000"},{"id_code_jeux":"67","code":"42","description":"L4O2","prime":"5000"},{"id_code_jeux":"68","code":"43","description":"L4O3","prime":"5000"},{"id_code_jeux":"70","code":"51","description":"L5O1","prime":"25000"},{"id_code_jeux":"71","code":"52","description":"L5O2","prime":"25000"},{"id_code_jeux":"72","code":"53","description":"L5O3","prime":"25000"},{"id_code_jeux":"73","code":"44","description":"Mariage Gratuit","prime":"1000"}]');
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
  `token` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.client : ~1 rows (environ)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT IGNORE INTO `client` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `pseudo`, `password`, `connect`, `objet`, `token`) VALUES
	(1, 'default', 'client', 'm', '00000000', 'defaultclient', 'null', 'non', 'client', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

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
	(72, '53', 'L5O3', '25000'),
	(73, '44', 'Mariage Gratuit', '1000');
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.configuration : 6 rows
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT IGNORE INTO `configuration` (`id`, `nom`, `valeur`, `categorie`) VALUES
	(1, 'licence_email', 'los-framework@gmail.com', 'non_modifiable'),
	(2, 'licence_code', '53-240-936-26', 'non_modifiable'),
	(3, 'licence_url', 'http://licence-serveur-sge.bioshaiti.com/licence-serveur-sge', 'text'),
	(4, 'taxe', '10', 'text'),
	(5, 'nom_app', 'Altagrace lotto', 'text'),
	(6, 'logo', 'app/DefaultApp/public/image/logo.jfif', 'image');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.departement : ~1 rows (environ)
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT IGNORE INTO `departement` (`id`, `departement`, `id_reseau_globale`) VALUES
	(4, 'Ouest', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.groupe : ~0 rows (environ)
/*!40000 ALTER TABLE `groupe` DISABLE KEYS */;
INSERT IGNORE INTO `groupe` (`id`, `nom`, `id_departement`) VALUES
	(5, 'Leogane', 4);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.lot_gagnant : ~1 rows (environ)
/*!40000 ALTER TABLE `lot_gagnant` DISABLE KEYS */;
/*!40000 ALTER TABLE `lot_gagnant` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. message_promotion
DROP TABLE IF EXISTS `message_promotion`;
CREATE TABLE IF NOT EXISTS `message_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('message','promotion') DEFAULT NULL,
  `titre` text,
  `contenue` text,
  `date` date DEFAULT NULL,
  `heure` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.message_promotion : 2 rows
/*!40000 ALTER TABLE `message_promotion` DISABLE KEYS */;
INSERT IGNORE INTO `message_promotion` (`id`, `type`, `titre`, `contenue`, `date`, `heure`) VALUES
	(8, 'message', 'bnmbnmbmn', 'bbnnj.,hghjkj', '2021-06-18', '13:12:23'),
	(9, 'message', 'jfaksldjf', 'faklsdjf', '2021-06-18', '13:15:51');
/*!40000 ALTER TABLE `message_promotion` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. motif_elimination
DROP TABLE IF EXISTS `motif_elimination`;
CREATE TABLE IF NOT EXISTS `motif_elimination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.motif_elimination : 3 rows
/*!40000 ALTER TABLE `motif_elimination` DISABLE KEYS */;
INSERT IGNORE INTO `motif_elimination` (`id`, `motif`) VALUES
	(6, 'erreur reseau'),
	(7, 'autre erreur'),
	(8, 'erreur vendeur');
/*!40000 ALTER TABLE `motif_elimination` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. numero_controler
DROP TABLE IF EXISTS `numero_controler`;
CREATE TABLE IF NOT EXISTS `numero_controler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branche` int(11) NOT NULL,
  `limite` text NOT NULL,
  `limite_vente` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departement_groupe_reseau_branche` (`branche`),
  CONSTRAINT `FK_numero_controler_branche` FOREIGN KEY (`branche`) REFERENCES `branche` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.numero_controler : ~1 rows (environ)
/*!40000 ALTER TABLE `numero_controler` DISABLE KEYS */;
INSERT IGNORE INTO `numero_controler` (`id`, `branche`, `limite`, `limite_vente`) VALUES
	(14, 7, '[{"numero":"00","limite":"250","bloquer":true},{"numero":"10","limite":"250","bloquer":true}]', '1000000');
/*!40000 ALTER TABLE `numero_controler` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. pos
DROP TABLE IF EXISTS `pos`;
CREATE TABLE IF NOT EXISTS `pos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imei` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `statut` enum('actif','inactif','eteint','desactiver') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `imei` (`imei`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.pos : ~2 rows (environ)
/*!40000 ALTER TABLE `pos` DISABLE KEYS */;
INSERT IGNORE INTO `pos` (`id`, `imei`, `longitude`, `latitude`, `statut`) VALUES
	(8, 'n/a', '-72.3192614', '18.5382818', 'actif'),
	(9, '0000000000', 'null', 'null', 'actif'),
	(10, '7777777777', 'null', 'null', 'actif');
/*!40000 ALTER TABLE `pos` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. pos_vendeur
DROP TABLE IF EXISTS `pos_vendeur`;
CREATE TABLE IF NOT EXISTS `pos_vendeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `id_pos` int(11) DEFAULT NULL,
  `pourcentage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_vendeur_id_pos` (`id_vendeur`,`id_pos`),
  UNIQUE KEY `id_vendeur` (`id_vendeur`),
  UNIQUE KEY `id_pos` (`id_pos`),
  CONSTRAINT `FK_pos_vendeur_pos` FOREIGN KEY (`id_pos`) REFERENCES `pos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pos_vendeur_vendeur` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.pos_vendeur : ~1 rows (environ)
/*!40000 ALTER TABLE `pos_vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `pos_vendeur` (`id`, `id_vendeur`, `id_pos`, `pourcentage`) VALUES
	(11, 12, 8, 10);
/*!40000 ALTER TABLE `pos_vendeur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. reseau
DROP TABLE IF EXISTS `reseau`;
CREATE TABLE IF NOT EXISTS `reseau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `id_groupe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reseau_groupe` (`id_groupe`),
  CONSTRAINT `FK_reseau_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `groupe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.reseau : ~1 rows (environ)
/*!40000 ALTER TABLE `reseau` DISABLE KEYS */;
INSERT IGNORE INTO `reseau` (`id`, `nom`, `id_groupe`) VALUES
	(3, 'petit-goave', 5);
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
	(10, 'nyc-20h30', 'new york 8h30', '18:31', '08:00', '14:31', 'alcindorlos@gmail.com', 'n/a', 'en cours', 'non', 'non'),
	(9, 'nyc-12h30', 'new york midi 30', '20:00', '08:00', '13:31', 'alcindorlos@gmail.com', 'n/a', 'en cours', 'non', 'non');
/*!40000 ALTER TABLE `tirage` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. tracabilite
DROP TABLE IF EXISTS `tracabilite`;
CREATE TABLE IF NOT EXISTS `tracabilite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `heure` varchar(50) DEFAULT NULL,
  `utilisateur` varchar(50) DEFAULT NULL,
  `action` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.tracabilite : 0 rows
/*!40000 ALTER TABLE `tracabilite` DISABLE KEYS */;
/*!40000 ALTER TABLE `tracabilite` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.utilisateur : ~1 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT IGNORE INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `password`, `role`, `objet`, `connect`) VALUES
	(10, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'utilisateur', 'oui'),
	(11, 'superviseur', 'superviseur', 'superviseur', '84d284a1eeb2909880112d2a650b6b69', 'superviseur', 'utilisateur', 'non');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. vendeur
DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_branche` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `addresse` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `connect` enum('oui','non') DEFAULT NULL,
  `objet` varchar(50) DEFAULT NULL,
  `token` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_prenom` (`nom`,`prenom`),
  UNIQUE KEY `pseudo` (`pseudo`),
  KEY `FK_vendeur_branche` (`id_branche`),
  CONSTRAINT `FK_vendeur_branche` FOREIGN KEY (`id_branche`) REFERENCES `branche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vendeur : ~2 rows (environ)
/*!40000 ALTER TABLE `vendeur` DISABLE KEYS */;
INSERT IGNORE INTO `vendeur` (`id`, `id_branche`, `nom`, `prenom`, `pseudo`, `sexe`, `telephone`, `addresse`, `password`, `connect`, `objet`, `token`) VALUES
	(12, 7, 'vendeur', 'vendeur', 'v-vvendeur', 'masculin', '509445544757', 'delmas 43', '81dc9bdb52d04dc20036dbd8313ed055', 'oui', 'vendeur', 'null');
/*!40000 ALTER TABLE `vendeur` ENABLE KEYS */;

-- Listage de la structure de la table pe_loto_serveur. vente
DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_branche` int(11) NOT NULL,
  `id_superviseur` int(11) NOT NULL,
  `id_pos` int(11) NOT NULL,
  `paris` text,
  `tirage` varchar(50) DEFAULT NULL,
  `no_ticket` varchar(50) NOT NULL,
  `ref_pos` varchar(50) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `sequence` varchar(50) NOT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` varchar(50) DEFAULT NULL,
  `eliminer` enum('oui','non') DEFAULT 'non',
  `gain` enum('oui','non','n/a') DEFAULT 'n/a',
  `total_gain` varchar(50) DEFAULT '0',
  `payer` enum('oui','non','n/a') DEFAULT 'n/a',
  `tire` enum('oui','non','n/a') DEFAULT 'n/a',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_ticket` (`no_ticket`),
  UNIQUE KEY `sequence` (`sequence`),
  KEY `FK_vente_vendeur` (`id_vendeur`),
  KEY `FK_vente_client` (`id_client`),
  KEY `FK_vente_branche` (`id_branche`),
  KEY `FK_vente_utilisateur` (`id_superviseur`),
  KEY `FK_vente_pos` (`id_pos`),
  CONSTRAINT `FK_vente_branche` FOREIGN KEY (`id_branche`) REFERENCES `branche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vente_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vente_pos` FOREIGN KEY (`id_pos`) REFERENCES `pos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vente_utilisateur` FOREIGN KEY (`id_superviseur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vente_vendeur` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vente : ~6 rows (environ)
/*!40000 ALTER TABLE `vente` DISABLE KEYS */;
INSERT IGNORE INTO `vente` (`id`, `id_vendeur`, `id_client`, `id_branche`, `id_superviseur`, `id_pos`, `paris`, `tirage`, `no_ticket`, `ref_pos`, `tid`, `sequence`, `serial`, `date`, `heure`, `eliminer`, `gain`, `total_gain`, `payer`, `tire`) VALUES
	(5, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"50","mise":25},{"codeJeux":"20:Borlette","pari":"78","mise":50},{"codeJeux":"20:Borlette","pari":"12","mise":25},{"codeJeux":"20:Borlette","pari":"98","mise":50},{"codeJeux":"40:Mariage ","pari":"54*65","mise":25},{"codeJeux":"30:Loto3   ","pari":"123","mise":45},{"codeJeux":"41:L4O1    ","pari":"1245","mise":12,"checked":true},{"codeJeux":"41:L4O1    ","pari":"4512","mise":12,"checked":true},{"codeJeux":"42:L4O2    ","pari":"1245","mise":12,"checked":true},{"codeJeux":"42:L4O2    ","pari":"4512","mise":12,"checked":true},{"codeJeux":"43:L4O3    ","pari":"1245","mise":12,"checked":true},{"codeJeux":"43:L4O3    ","pari":"4512","mise":12,"checked":true},{"codeJeux":"51:L5O1    ","pari":"54642","mise":25,"checked":true},{"codeJeux":"52:L5O2    ","pari":"54642","mise":25,"checked":true},{"codeJeux":"53:L5O3    ","pari":"54642","mise":25,"checked":true}]', 'nyc-12h30', '782-15-39157', 'n/a', 'n/a', '416-15-391763', 'n/a', '2021-08-24', '12:17:14', 'non', 'n/a', '0', 'n/a', 'oui'),
	(6, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"25","mise":59}]', 'nyc-12h30', '22-17-15522', 'n/a', 'n/a', '474-17-15444', 'n/a', '2021-08-24', '12:18:08', 'non', 'n/a', '0', 'n/a', 'oui'),
	(7, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"54","mise":65}]', 'nyc-20h30', '149-18-35874', 'n/a', 'n/a', '721-18-35618', 'n/a', '2021-08-24', '12:18:58', 'non', 'n/a', '0', 'n/a', 'oui'),
	(8, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"76","mise":43}]', 'nyc-12h30', '959-18-581328', 'n/a', 'n/a', '451-18-581553', 'n/a', '2021-08-25', '12:19:10', 'non', 'oui', '500', 'n/a', 'oui'),
	(9, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"76","mise":43}]', 'nyc-12h30', '438-47-271296', 'n/a', 'n/a', '887-47-271044', 'n/a', '2021-08-25', '13:47:45', 'non', 'oui', '100', 'oui', 'oui'),
	(10, 12, 1, 7, 11, 8, '[{"codeJeux":"20:Borlette","pari":"54","mise":10},{"codeJeux":"20:Borlette","pari":"57","mise":10}]', 'nyc-12h30', '715-48-29881', 'n/a', 'n/a', '700-48-29140', 'n/a', '2021-08-24', '13:48:55', 'non', 'n/a', '0', 'n/a', 'oui');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Listage des données de la table pe_loto_serveur.vente_eliminer : ~1 rows (environ)
/*!40000 ALTER TABLE `vente_eliminer` DISABLE KEYS */;
INSERT IGNORE INTO `vente_eliminer` (`id`, `id_vente`, `motif`, `status`) VALUES
	(2, 5, 'autre erreur', 'en cours');
/*!40000 ALTER TABLE `vente_eliminer` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
