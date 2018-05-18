[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Authentification`](#authentification)
___

## Requêtes de lecture


## Authentification
Renvoie un token matérialisant la connexion utilisateur au webservice. Ce token, à passer dans l'en-tête de la requête, est nécessaire pour pouvoir envoyer les requêtes suivantes.
* Route : `authentification.php`
* Méthode : `POST`
* Paramètres :
	* `identifiant` - Identifiant de l'utilisateur
	* `mot_de_passe` - Mot de passe de l'utilisateur
* Retourne :
	* `token` (*si authentification réussie*) - le token à utiliser à chaque prochaine requête





______________________