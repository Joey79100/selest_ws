[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Récupérer un adhérent`](#récupérer-un-adhérent)
	* [`Récupérer tous les adhérents`](#récupérer-tous-les-adhérents)
* **Requêtes d'écriture**
	* [`Ajouter un adhérent`](#ajouter-un-adhérent)
___

## Requêtes de lecture



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





______________________






## Requêtes d'écriture


### Ajouter un adhérent
Ajoute un nouvel adhérent. Créer un adhérent ne crée pas d'utilisateur : les utilisateurs ne peuvent être créés que par des administrateurs.
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


