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

-- Export de données de la table selest.adherent : ~4 rows (environ)
/*!40000 ALTER TABLE `adherent` DISABLE KEYS */;
INSERT INTO `adherent` (`adh_id`, `adh_nom`, `adh_prenom`, `adh_telephone`, `adh_mobile`, `adh_email`, `adh_adresse`, `adh_code_postal`, `adh_ville`, `adh_souets`) VALUES
	(1, 'Chirac', 'Patrick', '0201020304', '0601020304', 'patrick@chirac.fr', '1 là-bas', '12345', 'Très loin', 300),
	(2, 'Montgomery', 'Brenda', '0801020304', '0701020304', 'brenda.montgomery@etoile.com', '2 ici', '32000', 'Saint Andrews', 1180),
	(3, 'Rockwell', 'Criquette', '0908070605', '', 'ciquette.rockwell@tv-st-andrews.com', '3 tout près d\'à côté', '39502', 'Au nord de pas très loin', -200),
	(4, 'Jackson', 'Mickael', '', '0674185296', 'jackson@grey-lifes-matter.com', '5 pieds sous terre', '64023', 'Bill Igeane', -500);
/*!40000 ALTER TABLE `adherent` ENABLE KEYS */;

-- Export de données de la table selest.categorie : ~6 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`cat_id`, `cat_nom`) VALUES
	(1, 'Garde d\'enfants'),
	(2, 'Prêts'),
	(3, 'Garde de vieux'),
	(4, 'Cours particuliers'),
	(5, 'Massages'),
	(6, 'Ramassages');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Export de données de la table selest.liste_type_prestation : ~2 rows (environ)
/*!40000 ALTER TABLE `liste_type_prestation` DISABLE KEYS */;
INSERT INTO `liste_type_prestation` (`ltp_id`, `ltp_nom`) VALUES
	(1, 'offre'),
	(2, 'demande');
/*!40000 ALTER TABLE `liste_type_prestation` ENABLE KEYS */;

-- Export de données de la table selest.message : ~11 rows (environ)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`mes_id`, `mes_adh_id_emetteur`, `mes_adh_id_destinataire`, `mes_texte`, `mes_date`) VALUES
	(1, 2, 3, 'Bonjour je voudrais parler à Becky', '2018-03-09 16:39:15'),
	(2, 2, 3, 'Mais je n\'arrive pas à la joindre', '2018-03-09 16:39:41'),
	(3, 3, 2, 'Odieuse créature vous avez kidnappé le petit Doug-doug', '2018-03-09 16:40:09'),
	(4, 2, 2, 'Bon, hé bien, je suppose que ma meilleure amie est dans sa période sensible du mois...', '2018-03-09 16:40:46'),
	(5, 2, 3, 'Aucune nouvelle de Becky ? La dame au bout du téléphone semble ne pas m\'écouter', '2018-03-09 16:41:46'),
	(6, 3, 2, 'Mais il fallait le dire plus tôt ! Rencontrons-nous chez Lewis afin de palier à ce problème.', '2018-03-09 16:43:46'),
	(7, 2, 3, 'Becky sera-t-elle présente ?', '2018-03-09 16:44:03'),
	(8, 3, 2, 'Non mais...', '2018-03-09 16:44:14'),
	(9, 2, 3, 'Alors je refuse, Criquette vous avez essayé de me duper !', '2018-03-09 16:44:40'),
	(10, 4, 3, 'Yiiihi', '2018-03-09 16:46:16'),
	(11, 3, 4, '?', '2018-03-09 16:46:25'),
	(12, 4, 3, 'Auu!', '2018-03-09 16:46:47'),
	(13, 3, 4, 'J\'entends un épiléptique de l\'au-delà...', '2018-03-09 16:46:58');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Export de données de la table selest.prestation : ~0 rows (environ)
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;

-- Export de données de la table selest.rel_prestation_adherent : ~0 rows (environ)
/*!40000 ALTER TABLE `rel_prestation_adherent` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_prestation_adherent` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
