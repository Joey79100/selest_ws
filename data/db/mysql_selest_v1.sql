-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.14 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour selest
CREATE DATABASE IF NOT EXISTS `selest` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `selest`;

-- Export de la structure de la table selest. adherent
CREATE TABLE IF NOT EXISTS `adherent` (
  `adh_id` int(11) NOT NULL AUTO_INCREMENT,
  `adh_nom` varchar(50) NOT NULL,
  `adh_prenom` varchar(50) NOT NULL,
  `adh_telephone` varchar(15) DEFAULT NULL,
  `adh_mobile` varchar(15) DEFAULT NULL,
  `adh_email` varchar(100) DEFAULT NULL,
  `adh_adresse` varchar(200) DEFAULT NULL,
  `adh_code_postal` varchar(10) DEFAULT NULL,
  `adh_ville` varchar(50) DEFAULT NULL,
  `adh_souets` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. conversation
CREATE TABLE IF NOT EXISTS `conversation` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_nom` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. historique
CREATE TABLE IF NOT EXISTS `historique` (
  `his_pre_id` int(11) NOT NULL,
  `his_adh_id` int(11) NOT NULL,
  `his_type_adherent` enum('auteur','participant') NOT NULL,
  `his_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `his_montant` int(11) NOT NULL,
  `his_solde_avant` int(11) NOT NULL,
  `his_solde_apres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. liste_type_prestation
CREATE TABLE IF NOT EXISTS `liste_type_prestation` (
  `ltp_id` int(11) NOT NULL AUTO_INCREMENT,
  `ltp_nom` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ltp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. message
CREATE TABLE IF NOT EXISTS `message` (
  `mes_id` int(11) NOT NULL AUTO_INCREMENT,
  `mes_con_id` int(11) NOT NULL,
  `mes_uti_id_emetteur` int(11) NOT NULL,
  `mes_texte` varchar(512) NOT NULL,
  `mes_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mes_id`),
  KEY `fk_mes_con_id` (`mes_con_id`),
  KEY `fk_mes_uti_id_emetteur` (`mes_uti_id_emetteur`),
  CONSTRAINT `fk_mes_con_id` FOREIGN KEY (`mes_con_id`) REFERENCES `conversation` (`con_id`),
  CONSTRAINT `fk_mes_uti_id_emetteur` FOREIGN KEY (`mes_uti_id_emetteur`) REFERENCES `utilisateur` (`uti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. parametres
CREATE TABLE IF NOT EXISTS `parametres` (
  `par_nom` varchar(32) NOT NULL,
  `par_valeur` varchar(256) NOT NULL,
  PRIMARY KEY (`par_nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. prestation
CREATE TABLE IF NOT EXISTS `prestation` (
  `pre_id` int(11) NOT NULL AUTO_INCREMENT,
  `pre_adh_id` int(11) NOT NULL,
  `pre_cat_id` int(11) NOT NULL,
  `pre_ltp_id` int(11) NOT NULL,
  `pre_date_souhaitee_debut` date DEFAULT NULL,
  `pre_date_souhaitee_fin` date DEFAULT NULL,
  `pre_date_realisation` date DEFAULT NULL,
  `pre_description` varchar(100) NOT NULL,
  `pre_souets` int(11) NOT NULL,
  `pre_date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pre_date_modification` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pre_id`),
  KEY `fk_pre_ltp_id` (`pre_ltp_id`),
  KEY `pre_cat_id` (`pre_cat_id`),
  KEY `fk_pre_adh_id` (`pre_adh_id`),
  CONSTRAINT `fk_pre_adh_id` FOREIGN KEY (`pre_adh_id`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_pre_cat_id` FOREIGN KEY (`pre_cat_id`) REFERENCES `categorie` (`cat_id`),
  CONSTRAINT `fk_pre_ltp_id` FOREIGN KEY (`pre_ltp_id`) REFERENCES `liste_type_prestation` (`ltp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. rel_conversation_utilisateur
CREATE TABLE IF NOT EXISTS `rel_conversation_utilisateur` (
  `rcu_con_id` int(11) NOT NULL,
  `rcu_uti_id` int(11) NOT NULL,
  PRIMARY KEY (`rcu_con_id`,`rcu_uti_id`),
  KEY `fk_rcu_uti_id` (`rcu_uti_id`),
  CONSTRAINT `fk_rcu_con_id` FOREIGN KEY (`rcu_con_id`) REFERENCES `conversation` (`con_id`),
  CONSTRAINT `fk_rcu_uti_id` FOREIGN KEY (`rcu_uti_id`) REFERENCES `utilisateur` (`uti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. rel_prestation_adherent
CREATE TABLE IF NOT EXISTS `rel_prestation_adherent` (
  `rpa_pre_id` int(11) NOT NULL,
  `rpa_adh_id` int(11) NOT NULL,
  PRIMARY KEY (`rpa_pre_id`,`rpa_adh_id`),
  KEY `fk_rpa_adh_id` (`rpa_adh_id`),
  CONSTRAINT `fk_rpa_adh_id` FOREIGN KEY (`rpa_adh_id`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_rpa_pre_id` FOREIGN KEY (`rpa_pre_id`) REFERENCES `prestation` (`pre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cette table associe des adhérents à des prestations : chaque association correspond à une réponse à une prestation (l''auteur de la prestation est enregistré directement dans la table Prestation)';

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `uti_id` int(11) NOT NULL AUTO_INCREMENT,
  `uti_identifiant` varchar(64) NOT NULL,
  `uti_mot_de_passe` varchar(256) NOT NULL,
  `uti_droits` enum('A','W') NOT NULL DEFAULT 'W' COMMENT 'Autorisations de l''utilisateur : A = administrateur, W =utilisateur lambda (writer)',
  `uti_adh_id` int(11) DEFAULT NULL COMMENT 'Un utilisateur est généralement un adhérent, mais pas nécessairement',
  PRIMARY KEY (`uti_id`),
  KEY `fk_uti_adh_id` (`uti_adh_id`),
  CONSTRAINT `fk_uti_adh_id` FOREIGN KEY (`uti_adh_id`) REFERENCES `adherent` (`adh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
