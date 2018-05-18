[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Récupérer un adhérent`](#récupérer-un-adhérent)
	* [`Récupérer tous les adhérents`](#récupérer-tous-les-adhérents)
	* [`Récupérer les prestations à venir`](#récupérer-les-prestations-à-venir)
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


### Récupérer les prestations à venir
Récupère les prestations pas encore réalisées auxquelles l'adhérent a répondu.
Pour chaque prestation on récupère l'adhérent auteur, ainsi et les autres participants (les autres adhérents ayant également répondu).

* Route : `get_prestations_categorie.php` 
* Méthode : `GET`
* Paramètres :
	* `ID adhérent` (*optionnel, admin seulement*) - ID de l'adhérent pour qui voir les prestations auxquelles il va participer





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


