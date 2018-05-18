[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Ajouter une catégorie`](#ajouter-une-catégorie)
	* [`Ajouter un utilisateur`](#ajouter-un-utilisateur)
___

## Requêtes de lecture





______________________






# Requêtes d'écriture

## Ajouter une catégorie
Ajoute une nouvelle catégorie
* Route : `add_categorie.php`
* Méthode : `POST`
* Paramètres :
	* `cat_nom` - Nom de la catégorie
* Renvoie :
	* `id` - l'ID de la catégorie ajoutée

## Ajouter un utilisateur
Crée un utilisateur. Un utilisateur correspond à un adhérent dans la plupart des cas, mais pas nécessairement.
* Route : `add_utilisateur.php`
* Méthode : `POST`
* Paramètres :
	* `uti_identifiant` - Identifiant de connexion
	* `uti_mot_de_passe` - Mot de passe de connexion
	* `uti_droits` - (*optionnel*) - Niveau de droits accordés à cet utilisateur. Ne prend que deux valeurs :
		* `A` - Administrateur
		* `W` (*par défaut*) - Utilisateur (writer)
	* `uti_adh_id` - (*optionnel*) - ID de l'adhérent à associer à ce compte
* Renvoie :
	* `id` - l'ID de l'utilisateur ajouté
