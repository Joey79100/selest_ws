USE `selest`
;



CREATE TABLE `adherent` (
	`adh_id` 								INT(11) 								NOT NULL AUTO_INCREMENT,
	`adh_nom` 								VARCHAR(50)								NOT NULL,
	`adh_prenom` 							VARCHAR(50)								NOT NULL,
	`adh_telephone` 						VARCHAR(15) 							NOT NULL,
	`adh_mobile` 							VARCHAR(15) 							NOT NULL,
	`adh_email` 							VARCHAR(30) 							NOT NULL,
	`adh_adresse` 							VARCHAR(200) 							NOT NULL,
	`adh_code_postal` 						VARCHAR(10) 							NOT NULL,
	`adh_ville`								VARCHAR(50) 							NOT NULL,
	`adh_souets` 							INT(11) 								NOT NULL DEFAULT '0',
	CONSTRAINT pk_adherent					PRIMARY KEY (`adh_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `message` (
	`mes_id`								INT(11)									NOT NULL,
	`mes_adh_id_emetteur`					INT(11)									NOT NULL,
	`mes_adh_id_destinataire`				INT(11)									NOT NULL,
	`mes_texte`								VARCHAR(512)							NOT NULL,
	`mes_date`								DATETIME								NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_message					PRIMARY KEY (`mes_id`),
	CONSTRAINT fk_mes_adh_id_emetteur		FOREIGN KEY (`mes_adh_id_emetteur`)		REFERENCES `adherent` (`adh_id`),
	CONSTRAINT fk_mes_adh_id_destinataire	FOREIGN KEY (`mes_adh_id_destinataire`)	REFERENCES `adherent` (`adh_id`),
	INDEX `mes_adh_id_emetteur_mes_adh_id_destinataire` (`mes_adh_id_emetteur`, `mes_adh_id_destinataire`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `categorie` (
	`cat_id`								INT(11)									NOT NULL AUTO_INCREMENT,
	`cat_nom`								VARCHAR(50)								NOT NULL,
	CONSTRAINT pk_categorie					PRIMARY KEY (`cat_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `liste_type_prestation` (
	`ltp_id`								INT(11)									NOT NULL AUTO_INCREMENT,
	`ltp_nom`								VARCHAR(50)								NOT NULL DEFAULT '0',
	CONSTRAINT pk_liste_type_prestation		PRIMARY KEY (`ltp_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `prestation` (
	`pre_id`								INT(11)									NOT NULL AUTO_INCREMENT,
	`pre_adh_id_auteur`						INT										NOT NULL,
	`pre_cat_id` 							INT(11)									NOT NULL,
	`pre_ltp_id` 							INT(11)									NOT NULL,
	`pre_date_souhaitee_debut`				DATE									NULL DEFAULT NULL,
	`pre_date_souhaitee_fin`				DATE									NULL DEFAULT NULL,
	`pre_date_realisation`					DATE									NULL DEFAULT NULL,
	`pre_description`						VARCHAR(100)							NOT NULL,
	`pre_souets` 							INT(11)									NOT NULL,
	`pre_nb_participants_demande`			INT(11)									NULL DEFAULT NULL,
	CONSTRAINT pk_prestation				PRIMARY KEY (`pre_id`),
	CONSTRAINT fk_pre_cat_id				FOREIGN KEY (`pre_cat_id`)				REFERENCES `categorie` (`cat_id`),
	CONSTRAINT fk_pre_ltp_id				FOREIGN KEY (`pre_ltp_id`)				REFERENCES `liste_type_prestation` (`ltp_id`),
	CONSTRAINT fk_pre_adh_id_auteur			FOREIGN KEY (`pre_adh_id_auteur`)		REFERENCES `adherent` (`adh_id`),
	CONSTRAINT fk_pre_adh_id_realisateur	FOREIGN KEY (`pre_adh_id_realisateur`)	REFERENCES `adherent` (`adh_id`),
	CONSTRAINT c_dates_souhaitee			CHECK (`pre_date_souhaitee_fin` IS NULL OR `pre_date_souhaitee_fin` >= `pre_date_souhaitee_debut`),
	CONSTRAINT c_date_realisation			CHECK (`pre_date_realisation` IS NULL OR `pre_date_realisation` >= `pre_date_souhaitee_debut`),
	INDEX `pre_cat_id` (`pre_cat_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `rel_prestation_adherent` (
	`rpa_pre_id`							INT										NOT NULL,
	`rpa_adh_id`							INT										NOT NULL,
	CONSTRAINT pk_rel_prestation_adherent	PRIMARY KEY (`rpa_pre_id`, `rpa_adh_id`),
	CONSTRAINT fk_rpa_pre_id				FOREIGN KEY (`rpa_pre_id`)				REFERENCES `prestation` (`pre_id`),
	CONSTRAINT fk_rpa_adh_id				FOREIGN KEY (`rpa_adh_id`)				REFERENCES `adherent` (`adh_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



INSERT INTO `liste_type_prestation` (`ltp_nom`) VALUES ('offre');
INSERT INTO `liste_type_prestation` (`ltp_nom`) VALUES ('demande');