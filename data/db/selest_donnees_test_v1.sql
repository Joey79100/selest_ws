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

-- Export de données de la table selest.adherent : ~8 rows (environ)
/*!40000 ALTER TABLE `adherent` DISABLE KEYS */;
INSERT INTO `adherent` (`adh_id`, `adh_nom`, `adh_prenom`, `adh_telephone`, `adh_mobile`, `adh_email`, `adh_adresse`, `adh_code_postal`, `adh_ville`, `adh_souets`) VALUES
	(1, 'Chirac', 'Patrick', '0201020304', '0601020304', 'patrick@chirac.fr', '1 là-bas', '12345', 'Très loin', 300),
	(2, 'Montgomery', 'Brenda', '0801020304', '0701020304', 'brenda.montgomery@etoile.com', '2 ici', '32000', 'Saint Andrews', 1180),
	(3, 'Rockwell', 'Criquette', '0908070605', '', 'ciquette.rockwell@tv-st-andrews.com', '3 tout près d\'à côté', '39502', 'Au nord de pas très loin', -200),
	(4, 'Jackson', 'Mickael', '', '0674185296', 'jackson@grey-lifes-matter.com', '5 pieds sous terre', '64023', 'Bill Igeane', -500),
	(5, 'Michel', 'Jean', '0501020304', '0601020304', 'jean.michel@wanttodo.fr', '1 rue avec une route', '12345', 'Jolie ville', 900),
	(6, 'Haliday', 'Johnny', '0501020304', '0601020304', 'jean.michel@wanttodo.fr', '1 route du feu allumé', '12345', 'En cendre', 900),
	(7, 'Haliday', 'Johnny', '0501020304', '0601020304', 'jean.michel@wanttodo.fr', '1 route du feu allumé', '12345', 'En cendre', 900),
	(11, 'Holiday', 'John', '0501020304', '0601020304', 'jean.mich@wanttodo.fr', '1 route du feu rouge', '12345', 'En poudre', 900);
/*!40000 ALTER TABLE `adherent` ENABLE KEYS */;

-- Export de données de la table selest.categorie : ~7 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`cat_id`, `cat_nom`) VALUES
	(1, 'Garde d\'enfants'),
	(2, 'Prêts'),
	(3, 'Garde de vieux'),
	(4, 'Cours particuliers'),
	(5, 'Massages'),
	(6, 'Ramassages'),
	(7, 'Chats'),
	(8, 'Chats');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Export de données de la table selest.conversation : ~2 rows (environ)
/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
INSERT INTO `conversation` (`con_id`, `con_uti_id_1`, `con_uti_id_2`) VALUES
	(1, 2, 3),
	(2, 3, 4),
	(3, 2, 1);
/*!40000 ALTER TABLE `conversation` ENABLE KEYS */;

-- Export de données de la table selest.liste_type_prestation : ~2 rows (environ)
/*!40000 ALTER TABLE `liste_type_prestation` DISABLE KEYS */;
INSERT INTO `liste_type_prestation` (`ltp_id`, `ltp_nom`) VALUES
	(1, 'offre'),
	(2, 'demande');
/*!40000 ALTER TABLE `liste_type_prestation` ENABLE KEYS */;

-- Export de données de la table selest.message : ~17 rows (environ)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`mes_id`, `mes_con_id`, `mes_uti_id_emetteur`, `mes_texte`, `mes_date`, `mes_lu`) VALUES
	(1, 1, 2, 'Bonjour je voudrais parler à Becky', '2018-03-09 16:39:15', 1),
	(2, 1, 2, 'Mais je n\'arrive pas à la joindre', '2018-03-09 16:39:41', 1),
	(3, 1, 3, 'Odieuse créature vous avez kidnappé le petit Doug-doug', '2018-03-09 16:40:09', 0),
	(4, 1, 2, 'Bon, hé bien, je suppose que ma meilleure amie est dans sa période sensible du mois...', '2018-03-09 16:40:46', 1),
	(5, 1, 2, 'Aucune nouvelle de Becky ? La dame au bout du téléphone semble ne pas m\'écouter', '2018-03-09 16:41:46', 1),
	(6, 1, 3, 'Mais il fallait le dire plus tôt ! Rencontrons-nous chez Lewis afin de palier à ce problème.', '2018-03-09 16:43:46', 1),
	(7, 1, 2, 'Becky sera-t-elle présente ?', '2018-03-09 16:44:03', 1),
	(8, 1, 3, 'Non mais...', '2018-03-09 16:44:14', 0),
	(9, 1, 2, 'Alors je refuse, Criquette vous avez essayé de me duper !', '2018-03-09 16:44:40', 1),
	(10, 2, 4, 'Yiiihi', '2018-03-09 16:46:16', 1),
	(11, 2, 3, '?', '2018-03-09 16:46:25', 1),
	(12, 2, 4, 'Auu!', '2018-03-09 16:46:47', 1),
	(13, 2, 3, 'J\'entends un épiléptique de l\'au-delà...', '2018-03-09 16:46:58', 1),
	(14, 2, 3, 'Bonjour ma meilleure amie', '2018-04-11 16:58:35', 1),
	(15, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:25:47', 1),
	(16, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:44:20', 1),
	(17, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:44:48', 1),
	(18, 1, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:15:52', 0),
	(19, 1, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:15:57', 0),
	(20, 3, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:21:28', 0);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Export de données de la table selest.parametres : 1 rows
/*!40000 ALTER TABLE `parametres` DISABLE KEYS */;
INSERT INTO `parametres` (`par_nom`, `par_valeur`) VALUES
	('nombre_initial_souets', '900');
/*!40000 ALTER TABLE `parametres` ENABLE KEYS */;

-- Export de données de la table selest.prestation : ~3 rows (environ)
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
INSERT INTO `prestation` (`pre_id`, `pre_adh_id`, `pre_cat_id`, `pre_ltp_id`, `pre_date_souhaitee_debut`, `pre_date_souhaitee_fin`, `pre_date_realisation`, `pre_description`, `pre_souets`) VALUES
	(1, 1, 7, 1, NULL, NULL, NULL, 'Vente de chats empaillés', 0),
	(2, 1, 7, 1, '2018-09-01', NULL, NULL, 'Vente de chats empaillés', 200),
	(3, 1, 7, 1, NULL, NULL, NULL, 'Vente de chats empaillés', 0);
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;

-- Export de données de la table selest.rel_prestation_adherent : ~0 rows (environ)
/*!40000 ALTER TABLE `rel_prestation_adherent` DISABLE KEYS */;
INSERT INTO `rel_prestation_adherent` (`rpa_pre_id`, `rpa_adh_id`) VALUES
	(2, 1);
/*!40000 ALTER TABLE `rel_prestation_adherent` ENABLE KEYS */;

-- Export de données de la table selest.utilisateur : ~4 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` (`uti_id`, `uti_identifiant`, `uti_mot_de_passe`, `uti_droits`, `uti_adh_id`) VALUES
	(1, 'plop', 'azerty', 'W', 1),
	(2, 'master', 'system', 'A', NULL),
	(3, 'monsieur', 'toctoc', 'W', NULL),
	(4, 'monsieur', 'toctoc', 'W', 7),
	(8, 'monsieur', 'toctoc', 'W', 11);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
