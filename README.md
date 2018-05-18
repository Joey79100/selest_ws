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



#### Exemples de réponse pour des requêtes satisfaites

Récupération des offres :
```
// Statut : 200
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

Ajout d'une prestation :
```
// Statut : 201
{
    "id": "3",
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


## <a name="sommaire_requetes"></a>Liste des requêtes

Les requêtes du webservice sont documentées dans [`/doc/utilisateur/requetes_***.md`](doc/utilisateur). Elles sont classées par catégories :

* [`requetes_adherents.md`](doc/utilisateur/requetes_administration.md) - Requêtes concernant les adhérents
* [`requetes_administration.md`](doc/utilisateur/requetes_administration.md) - (*note : les requêtes accessibles aux utilisateurs normaux mais dont le passage de certains paramètres requiert l'accès administrateur ne s'y trouvent pas*)
* [`requetes_authentification.md`](doc/utilisateur/requetes_authentification.md) - Requête d'authentification au webservice
* [`requetes_messages.md`](doc/utilisateur/requetes_messages.md) - Requêtes relatives aux conversations et messages
* [`requetes_prestations.md`](doc/utilisateur/requetes_prestations.md) - Requêtes concernant les prestations