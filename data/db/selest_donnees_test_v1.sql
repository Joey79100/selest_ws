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
	(2, 'Montgomery', 'Brenda', '0801020304', '0701020304', 'brenda.montgomery@etoile.com', '2 ici', '32000', 'Saint Andrews', 2480),
	(3, 'Rockwell', 'Criquette', '0908070605', '', 'ciquette.rockwell@tv-st-andrews.com', '3 tout près d\'à côté', '39502', 'Au nord de pas très loin', -750),
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

-- Export de données de la table selest.conversation : ~22 rows (environ)
/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
INSERT INTO `conversation` (`con_id`, `con_nom`) VALUES
	(1, 'testest'),
	(2, 'testest'),
	(3, 'testest'),
	(18, 'testest'),
	(19, 'testest'),
	(20, 'testest'),
	(21, 'testest'),
	(22, 'testest');
/*!40000 ALTER TABLE `conversation` ENABLE KEYS */;

-- Export de données de la table selest.historique : ~10 rows (environ)
/*!40000 ALTER TABLE `historique` DISABLE KEYS */;
INSERT INTO `historique` (`his_pre_id`, `his_adh_id`, `his_type_adherent`, `his_date`, `his_montant`, `his_solde_avant`, `his_solde_apres`) VALUES
	(11, 2, 'auteur', '2018-05-17 16:27:53', 50, 2080, 2380),
	(11, 1, 'participant', '2018-05-17 16:27:53', 50, 300, 250),
	(11, 3, 'participant', '2018-05-17 16:27:53', 50, -650, -700),
	(11, 4, 'participant', '2018-05-17 16:27:53', 50, -500, -550),
	(11, 5, 'participant', '2018-05-17 16:27:53', 50, 900, 850),
	(11, 6, 'participant', '2018-05-17 16:27:53', 50, 900, 850),
	(11, 7, 'participant', '2018-05-17 16:27:53', 50, 900, 850),
	(11, 2, 'auteur', '2018-05-17 16:31:15', 50, 2380, 2480),
	(11, 1, 'participant', '2018-05-17 16:31:15', 50, 300, 250),
	(11, 3, 'participant', '2018-05-17 16:31:15', 50, -700, -750);
/*!40000 ALTER TABLE `historique` ENABLE KEYS */;

-- Export de données de la table selest.liste_type_prestation : ~2 rows (environ)
/*!40000 ALTER TABLE `liste_type_prestation` DISABLE KEYS */;
INSERT INTO `liste_type_prestation` (`ltp_id`, `ltp_nom`) VALUES
	(1, 'offre'),
	(2, 'demande');
/*!40000 ALTER TABLE `liste_type_prestation` ENABLE KEYS */;

-- Export de données de la table selest.message : ~32 rows (environ)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`mes_id`, `mes_con_id`, `mes_uti_id_emetteur`, `mes_texte`, `mes_date`) VALUES
	(1, 1, 2, 'Bonjour je voudrais parler à Becky', '2018-03-09 16:39:15'),
	(2, 1, 2, 'Mais je n\'arrive pas à la joindre', '2018-03-09 16:39:41'),
	(3, 1, 3, 'Odieuse créature vous avez kidnappé le petit Doug-doug', '2018-03-09 16:40:09'),
	(4, 1, 2, 'Bon, hé bien, je suppose que ma meilleure amie est dans sa période sensible du mois...', '2018-03-09 16:40:46'),
	(5, 1, 2, 'Aucune nouvelle de Becky ? La dame au bout du téléphone semble ne pas m\'écouter', '2018-03-09 16:41:46'),
	(6, 1, 3, 'Mais il fallait le dire plus tôt ! Rencontrons-nous chez Lewis afin de palier à ce problème.', '2018-03-09 16:43:46'),
	(7, 1, 2, 'Becky sera-t-elle présente ?', '2018-03-09 16:44:03'),
	(8, 1, 3, 'Non mais...', '2018-03-09 16:44:14'),
	(9, 1, 2, 'Alors je refuse, Criquette vous avez essayé de me duper !', '2018-03-09 16:44:40'),
	(10, 2, 4, 'Yiiihi', '2018-03-09 16:46:16'),
	(11, 2, 3, '?', '2018-03-09 16:46:25'),
	(12, 2, 4, 'Auu!', '2018-03-09 16:46:47'),
	(13, 2, 3, 'J\'entends un épiléptique de l\'au-delà...', '2018-03-09 16:46:58'),
	(14, 2, 3, 'Bonjour ma meilleure amie', '2018-04-11 16:58:35'),
	(15, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:25:47'),
	(16, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:44:20'),
	(17, 1, 2, 'Bonjour ma meilleure amie', '2018-05-14 16:44:48'),
	(18, 1, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:15:52'),
	(19, 1, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:15:57'),
	(20, 3, 2, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-15 15:21:28'),
	(21, 2, 1, 'Nous devons nous concerter.', '2018-05-17 08:21:44'),
	(22, 18, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 08:52:00'),
	(23, 19, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 08:52:55'),
	(24, 20, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 08:52:56'),
	(25, 21, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:19:25'),
	(26, 21, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:19:27'),
	(27, 21, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:19:28'),
	(28, 22, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:21:16'),
	(29, 22, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:21:18'),
	(30, 22, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:21:21'),
	(31, 22, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:21:47'),
	(32, 22, 1, 'La révolution a eu lieu, cher Plop. Signé Master.', '2018-05-17 09:22:15'),
	(33, 22, 1, 'testest', '2018-05-18 08:51:32');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Export de données de la table selest.parametres : 1 rows
/*!40000 ALTER TABLE `parametres` DISABLE KEYS */;
INSERT INTO `parametres` (`par_nom`, `par_valeur`) VALUES
	('nombre_initial_souets', '900');
/*!40000 ALTER TABLE `parametres` ENABLE KEYS */;

-- Export de données de la table selest.prestation : ~7 rows (environ)
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
INSERT INTO `prestation` (`pre_id`, `pre_adh_id`, `pre_cat_id`, `pre_ltp_id`, `pre_date_souhaitee_debut`, `pre_date_souhaitee_fin`, `pre_date_realisation`, `pre_description`, `pre_souets`, `pre_date_creation`, `pre_date_modification`) VALUES
	(1, 1, 7, 1, NULL, NULL, NULL, 'Vente de chats empaillés', 0, '2018-05-16 13:38:29', NULL),
	(2, 1, 7, 1, '2018-09-01', NULL, '2018-05-17', 'Vente de chats empaillés', 200, '2018-05-16 13:38:29', '2018-05-17 14:40:53'),
	(3, 1, 7, 1, NULL, NULL, NULL, 'Vente de chats empaillés', 0, '2018-05-16 13:38:29', NULL),
	(4, 1, 7, 2, NULL, NULL, NULL, 'Vente de chats empaillés', 0, '2018-05-16 13:38:29', '2018-05-17 16:03:22'),
	(5, 1, 7, 1, NULL, NULL, NULL, 'Vente de chats empaillés', 0, '2018-05-16 13:44:16', NULL),
	(10, 2, 7, 1, '2018-07-01', NULL, NULL, 'Vente de chats empaillés', 0, '2018-05-17 14:04:51', NULL),
	(11, 2, 5, 1, NULL, NULL, '2018-05-17', 'Superbe massage aux huiles essentielles', 50, '2018-05-17 14:21:26', '2018-05-17 16:31:15');
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;

-- Export de données de la table selest.rel_conversation_utilisateur : ~13 rows (environ)
/*!40000 ALTER TABLE `rel_conversation_utilisateur` DISABLE KEYS */;
INSERT INTO `rel_conversation_utilisateur` (`rcu_con_id`, `rcu_uti_id`, `rcu_nb_messages_non_lus`) VALUES
	(1, 2, 0),
	(1, 3, 0),
	(2, 1, 0),
	(2, 3, 0),
	(2, 4, 0),
	(3, 1, 0),
	(3, 2, 0),
	(21, 1, 0),
	(21, 2, 0),
	(21, 3, 0),
	(22, 1, 0),
	(22, 2, 0),
	(22, 3, 0),
	(22, 4, 0);
/*!40000 ALTER TABLE `rel_conversation_utilisateur` ENABLE KEYS */;

-- Export de données de la table selest.rel_prestation_adherent : ~4 rows (environ)
/*!40000 ALTER TABLE `rel_prestation_adherent` DISABLE KEYS */;
INSERT INTO `rel_prestation_adherent` (`rpa_pre_id`, `rpa_adh_id`) VALUES
	(2, 1),
	(4, 1),
	(11, 3),
	(11, 4);
/*!40000 ALTER TABLE `rel_prestation_adherent` ENABLE KEYS */;

-- Export de données de la table selest.utilisateur : ~8 rows (environ)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` (`uti_id`, `uti_identifiant`, `uti_mot_de_passe`, `uti_droits`, `uti_adh_id`) VALUES
	(1, 'plop', 'azerty', 'W', 1),
	(2, 'master', 'system', 'A', NULL),
	(3, 'monsieur', 'toctoc', 'W', NULL),
	(4, 'johnny', 'allumezlefeu', 'W', 7),
	(8, 'monsieur', 'toctoc', 'W', 11),
	(9, 'brenda', 'brenda', 'W', 2),
	(10, 'criquette', 'criquette', 'W', 3),
	(11, 'mjackson', 'mj', 'W', 4);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
