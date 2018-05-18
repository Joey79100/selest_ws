[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Récupérer toutes les catégories`](#récupérer-toutes-les-catégories)
	* [`Récupérer les offres ou les demandes d'une catégorie`](#récupérer-les-offres-ou-les-demandes-d'une-catégorie)
* **Requêtes d'écriture**
	* [`Ajouter une offre ou une demande`](#ajouter-une-offre-ou-une-demande)
	* [`Ajouter une réponse à une offre`](#ajouter-une-réponse-à-une-offre)
	* [`Valider une prestation`](#valider-une-prestation)
___

## Requêtes de lecture



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







______________________






## Requêtes d'écriture


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


### Valider une prestation
Marque une prestation comme réalisée et transfère les souets comme nécessaire.
* Route : `valider_prestation.php`
* Méthode : `POST`
* Paramètres :
	* `pre_id` - ID de la prestation à réaliser
	* `adh_ids` - IDs des adhérents ayant participé (à qui les souets doivent être versés/pris), séparés par des virgules
	* `pre_date_realisation` (*optionnel*) - Date de réalisation (par défaut, la date de l'appel de la requête sera utilisée)