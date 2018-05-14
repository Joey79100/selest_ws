# Utilisation du Webservice Selest



## Généralités


### Envoi d'une requête




#### Prérequis
Avant d'envoyer des requêtes, il est nécessaire de s'authentifier avant.

L'authentification permet de récupérer un `token` (chaîne de caractères aléatoire servant à "matérialiser" une connexion). Ce token doit être renvoyé dans l'en-tête de chaque requête. S'il n'est pas envoyé ou qu'il n'est pas valide, toutes les requêtes renverront un message signalant qu'une authentification est requise.

L'authentification s'effectue en envoyant une requête vers la page `authentification.php`, en passant un identifiant et un mot de passe utilisateur valides (*voir la section **Requêtes de lecture** > **Authentification***). Si le paramètre `success == 1`, la connexion a réussi, le paramètre `token` est renvoyé. Ce `token` est valide jusqu'à ce qu'une nouvelle tentative d'authentification soit effectuée.





#### Envoyer une requête
Une requête doit être envoyée au webservice en précisant la route (fichier php correspondant).
* Dans le **body**, envoyer les paramètres éventuels (`GET` ou `POST`).
* Dans le **header**, envoyer le `token` matérialisant la connexion. Un token est récupéré après avoir effectué une authentification (voir la requête Authentification)


#### Exemple :
Envoi d'une requête permettant d'ajouter une nouvelle catégorie de prestations.

```
POST: http://localhost/selest_ws/add_categorie.php
```
Head :
```
token:1a63ecc32f837cefe62d33c98e23a6992082fad09fdfcc6d6e95ea686676dbb8
```
Body :
```
cat_nom:Chats
```




### Réponse à une requête
Un code HTTP est renvoyé avec la réponse en fonction du résultat de la requête.

* `200` (`CODE_OK`) : trouvé
* `201` (`CODE_CREATED_CONTENT`) : l'élément a été créé, retourne le contenu
* `204` (`CODE_CREATED_NO_CONTENT`) : l'élément a été créé, ne retourne rien
* `400` (`CODE_BAD_REQUEST`) : la requête est incorrecte
* `401` (`CODE_UNAUTHORIZED`) : utilisateur non authentifié
* `403` (`CODE_FORBIDDEN`) : page non accessible pour cet utilisateur
* `404` (`CODE_NOT_FOUND`) : requête correcte mais aucun contenu
* `500` (`CODE_INTERNAL_SERVER_ERROR`) : requête correcte mais un problème est survenu
* `501` (`CODE_NOT_IMPLEMENTED`) : requête correcte mais pas encore implémentée
* `503` (`CODE_SERVICE_UNAVAILABLE`) : base de données non disponible

La réponse est toujours renvoyée au format JSON.
Elle contient : 
* `success` : 1 si la requête a réussi, 0 sinon
* `error` (*si `success` = 0*) : code d'erreur
* `message` (*si `success` = 0*) : message décrivant l'erreur



#### Exemple de réponse pour une requête satisfaite
Statut : ```200```

Body :
```
{
    "offres": [
        {
            "pre_id": 1,
            "cat_id": 7,
            "cat_nom": "Chats",
            "pre_date_souhaitee_debut": null,
            "pre_date_souhaitee_fin": null,
            "pre_description": "Vente de chats empaillés",
            "pre_souets": 0
        },
        {
            "pre_id": 2,
            "cat_id": 7,
            "cat_nom": "Chats",
            "pre_date_souhaitee_debut": "2018-09-01",
            "pre_date_souhaitee_fin": null,
            "pre_description": "Prêt de chats empilés",
            "pre_souets": 200
        }
    ],
    "success": 1
}
```

#### Exemples de réponse pour des requêtes non satisfaites
Tentative de requête avec paramètres manquants ou invalides :
```
// Statut : 400
{
    "success": 0,
    "message": "Requête invalide - champs manquants ou invalides"
}
```

Tentative de récupération d'un élément sans avoir passé de token valide :
```
// Statut : 401
{
    "success": 0,
    "message": "Une authentification est requise pour accéder à cette page"
}
```

Tentative de requête sur une page en étant authentifié mais en n'ayant pas les droits requis (par exemple si on essaie d'ajouter un adhérent sans être administrateur) :
```
// Statut : 403
{
    "success": 0,
    "message": "L'utilisateur n'a pas les droits nécessaires pour accéder à cette page"
}
```

Tentative de récupération d'un élément non-existant dans la base :
```
// Statut : 404
{
    "success": 0,
    "message": "Aucun résultat"
}
```


## Requêtes de lecture


### Authentification
Renvoie un token matérialisant la connexion utilisateur au webservice. Ce token, à passer dans l'en-tête de la requête, est nécessaire pour pouvoir envoyer les requêtes suivantes.
* Route : `authentification.php`
* Méthode : `POST`
* Paramètres :
	* `identifiant` - Identifiant de l'utilisateur
	* `mot_de_passe` - Mot de passe de l'utilisateur
* Retourne :
	* `token` (*si authentification réussie*) - le token à utiliser à chaque prochaine requête





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

### Ajouter un utilisateur
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

### Ajouter un adhérent
Ajoute un nouvel adhérent. Créer un adhérent ne créée pas d'utilisateur : les utilisateurs ne peuvent être créés que par des administrateurs.
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




