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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
  `mes_adh_id_emetteur` int(11) NOT NULL,
  `mes_adh_id_destinataire` int(11) NOT NULL,
  `mes_texte` varchar(512) NOT NULL,
  `mes_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mes_id`),
  KEY `fk_mes_adh_id_destinataire` (`mes_adh_id_destinataire`),
  KEY `mes_adh_id_emetteur_mes_adh_id_destinataire` (`mes_adh_id_emetteur`,`mes_adh_id_destinataire`),
  CONSTRAINT `fk_mes_adh_id_destinataire` FOREIGN KEY (`mes_adh_id_destinataire`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_mes_adh_id_emetteur` FOREIGN KEY (`mes_adh_id_emetteur`) REFERENCES `adherent` (`adh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. prestation
CREATE TABLE IF NOT EXISTS `prestation` (
  `pre_id` int(11) NOT NULL AUTO_INCREMENT,
  `pre_adh_id_auteur` int(11) NOT NULL,
  `pre_adh_id_realisateur` int(11) DEFAULT NULL,
  `pre_cat_id` int(11) NOT NULL,
  `pre_ltp_id` int(11) NOT NULL,
  `pre_date_souhaitee_debut` date DEFAULT NULL,
  `pre_date_souhaitee_fin` date DEFAULT NULL,
  `pre_date_realisation` date DEFAULT NULL,
  `pre_description` varchar(100) NOT NULL,
  `pre_souets` int(11) NOT NULL,
  PRIMARY KEY (`pre_id`),
  KEY `fk_pre_ltp_id` (`pre_ltp_id`),
  KEY `fk_pre_adh_id_auteur` (`pre_adh_id_auteur`),
  KEY `fk_pre_adh_id_realisateur` (`pre_adh_id_realisateur`),
  KEY `pre_cat_id` (`pre_cat_id`),
  CONSTRAINT `fk_pre_adh_id_auteur` FOREIGN KEY (`pre_adh_id_auteur`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_pre_adh_id_realisateur` FOREIGN KEY (`pre_adh_id_realisateur`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_pre_cat_id` FOREIGN KEY (`pre_cat_id`) REFERENCES `categorie` (`cat_id`),
  CONSTRAINT `fk_pre_ltp_id` FOREIGN KEY (`pre_ltp_id`) REFERENCES `liste_type_prestation` (`ltp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table selest. rel_prestation_adherent
CREATE TABLE IF NOT EXISTS `rel_prestation_adherent` (
  `rpa_pre_id` int(11) NOT NULL,
  `rpa_adh_id` int(11) NOT NULL,
  PRIMARY KEY (`rpa_pre_id`,`rpa_adh_id`),
  KEY `fk_rpa_adh_id` (`rpa_adh_id`),
  CONSTRAINT `fk_rpa_adh_id` FOREIGN KEY (`rpa_adh_id`) REFERENCES `adherent` (`adh_id`),
  CONSTRAINT `fk_rpa_pre_id` FOREIGN KEY (`rpa_pre_id`) REFERENCES `prestation` (`pre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
