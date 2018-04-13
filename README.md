# Webservices Selest



## Généralités
### Envoi d'une requête



### Réponse à une requête
Un code HTTP est renvoyé avec la réponse en fonction du résultat de la requête.

* `200` (`CODE_OK`) : trouvé
* `201` (`CODE_CREATED_CONTENT`) : l'élément a été créé, retourne le contenu
* `204` (`CODE_CREATED_NO_CONTENT`) : l'élément a été créé, ne retourne rien
* `400` (`CODE_BAD_REQUEST`) : la requête est incorrecte
* `404` (`CODE_NOT_FOUND`) : requête correcte mais aucun contenu
* `500` (`CODE_INTERNAL_SERVER_ERROR`) : requête correcte mais un problème est survenu
* `501` (`CODE_NOT_IMPLEMENTED`) : requête correcte mais pas encore implémentée
* `503` (`CODE_SERVICE_UNAVAILABLE`) : base de données non disponible

La réponse est toujours renvoyée au format JSON.
Elle contient : 
* `success` : 1 si la requête a réussi, 0 sinon
* `error` (*si `success` = 0*) : code d'erreur
* `message` (*si `success` = 0*) : message décrivant l'erreur







## Requêtes de lecture


### Récupérer les adhérents
Récupère l'intégralité des informations d'un adhérent.
* Route : `get_adherent.php` 
* Méthode : `GET`
* Paramètres :
	* `adh_id` - ID de l'adhérent


### Récupérer un adhérent
Récupère l'intégralité des informations d'un adhérent.
* Route : `get_adherent.php` 
* Méthode : `GET`
* Paramètres :
	* `adh_id - ID de l'adhérent`


### Récupérer tous les adhérents
Récupère l'ensemble des adhérents avec leurs informations basiques (nom prénom).
* Route : `get_adherents.php` 
* Méthode : `GET`


### Récupérer toutes les catégories
Récupère l'intégralité des catégories.
* Route : `get_categories.php` 
* Méthode : `GET`


### Récupérer les offres ou les demandes d'une catégorie
Récupère les offres et les demandes actives, éventuellement d'une catégorie en particulier.
* Route : `get_prestations_categorie.php` 
* Méthode : `GET`
* Paramètres :
	* `type` - prend uniquement deux valeurs : `offre` ou `demande`
	* `cat_id` (*optionnel*) - ID de la catégorie (pour ne chercher les prestations que d'une catégorie)


### Récupérer une conversation entre deux utilisateurs
Récupère les messages entre deux adhérents.
* Route : `get_conversation.php` 
* Méthode : `GET`
* Paramètres :
	* `id_emetteur` - ID d'un adhérent émetteur
	* `id_destinataire` - ID d'un adhérent destinataire


## Requêtes d'écriture

### Ajouter une catégorie
Ajoute une nouvelle catégorie
* Route : `add_categorie.php`
* Méthode : `POST`
* Paramètres :
	* `cat_nom` - Nom de la catégorie
* Renvoie :
	* `id` - l'ID de la catégorie ajoutée

### Ajouter un adhérent
Ajoute un nouvel adhérent
* Route : `add_adherent.php`
* Méthode : `POST`
* Paramètres :
	* `adh_nom`
	* `adh_prenom`
	* `adh_telephone`
	* `adh_mobile`
	* `adh_email`
	* `adh_adresse`
	* `adh_code_postal`
	* `adh_ville`
* Renvoie :
	* `id` - l'ID de l'adhérent ajouté

### Aouter un message
Ajoute un nouveau message
* Route : `add_message.php`
* Méthode : `POST`
* Paramètres :
	* `mes_adh_id_emetteur` - ID de l'adhérent émetteur
	* `mes_adh_id_destinataire` - ID de l'adhérent destinataire
	* `mes_texte` - Contenu du message
* Renvoie :
	* `id` - l'ID du message ajouté

### Ajouter une offre ou une demande
Ajoute une prestation
* Route : `add_prestation.php`
* Méthode : `POST`
* Paramètres :
	* `pre_adh_id` - ID de l'apprenant soumettant la prestation
	* `pre_cat_id` - ID de la catégorie choisie
	* `pre_ltp_id` - ID du type de prestation
	* `pre_date_souhaitee_debut` (*optionnel*) - Date de début de réalisation souhaitée
	* `pre_date_souhaitee_fin` (*optionnel*) - Date de fin de réalisation souhaitée
	* `pre_description` - Description de la prestation
	* `pre_souets` - Valeur en souets


### Ajouter une réponse à une offre
Ajoute une réponse à une offre
* Route : `add_reponse.php`
* Méthode : `POST`
* Paramètres :
	* `adh_id` - ID de l'adhérent répondant à la prestation
	* `pre_id` - ID de la prestation


