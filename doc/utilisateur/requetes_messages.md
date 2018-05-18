[`< Retour`](../../README.md#sommaire_requetes)
___
### Accès rapide
* **Requêtes de lecture**
	* [`Récupérer toutes les conversations d'un utilisateur`](#récupérer-toutes-les-conversations-d'un-utilisateur)
	* [`Récupérer des messages`](#récupérer-des-messages)
* **Requêtes d'écriture**
	* [`Ajouter un message`](#ajouter-un-message)
	* [`Marquer une conversation comme lue`](#marquer-une-conversation-comme-lue)
___

# Requêtes de lecture



## Récupérer toutes les conversations d'un utilisateur
Récupère la liste des conversations d'un utilisateur.

Renvoie également pour chaque conversation le contenu du dernier message et le nombre de messages non lus.

Les administrateurs peuvent passer un paramètre id_emetteur pour pouvoir voir les conversations d'un utilisateur autre que lui-même.

* Route : `get_conversations.php` 
* Méthode : `GET`
* Paramètres :
	* `id_emetteur` (*optionnel* - *admin seulement*) - ID de l'utilisateur pour qui récupérer les conversations - par défaut, c'est l'utilisateur connecté
* Exemple de requête réussie :
```
{
    "conversations": [
        {
            "con_id": 22,
            "con_nom": "testest",
            "rcu_uti_id": 1,
            "rcu_nb_messages_non_lus": 0,
            "mes_texte": "testest",
            "mes_date": "2018-05-18 08:51:32"
        },
        {
            "con_id": 21,
            "con_nom": "testest",
            "rcu_uti_id": 1,
            "rcu_nb_messages_non_lus": 0,
            "mes_texte": "La révolution a eu lieu, cher Plop. Signé Master.",
            "mes_date": "2018-05-17 09:19:28"
        },
        {
            "con_id": 2,
            "con_nom": "testest",
            "rcu_uti_id": 1,
            "rcu_nb_messages_non_lus": 0,
            "mes_texte": "Nous devons nous concerter.",
            "mes_date": "2018-05-17 08:21:44"
        },
        {
            "con_id": 3,
            "con_nom": "testest",
            "rcu_uti_id": 1,
            "rcu_nb_messages_non_lus": 0,
            "mes_texte": "La révolution a eu lieu, cher Plop. Signé Master.",
            "mes_date": "2018-05-15 15:21:28"
        }
    ],
    "success": 1
}
```

















## Récupérer des messages
Récupère les messages d'une conversation, ainsi que les participants (utilisateur, et adhérent associé si présent)

Les messages sont triés par ordre décroissant (le plus récent en premier).

Seulement 10 messages sont chargés par défaut. Pour avoir la suite des messages, renvoyer une requête en envoyant l'ID du message le plus ancien ayant déjà été récupéré.

* Route : `get_messages.php`
* Méthode : `GET`
* Paramètres :
	* `id_conversation` - ID de la conversation d'où tirer les messages
	* `id_message` (*optionnel*) - ID du message le plus ancien ayant déjà été récupéré
	* `nb_messages` (*optionnel*) - Nombre de messages à charger (10 par défaut)
* Exemple de requête réussie :
```
{
    "participants": [
        {
            "utilisateur": {
                "uti_id": 1,
                "uti_identifiant": "plop",
                "uti_droits": "W"
            },
            "adherent": {
                "adh_id": 1,
                "adh_nom": "Chirac",
                "adh_prenom": "Patrick",
                "adh_ville": "Très loin"
            }
        },
        {
            "utilisateur": {
                "uti_id": 3,
                "uti_identifiant": "monsieur",
                "uti_droits": "W"
            },
            "adherent": null
        },
        {
            "utilisateur": {
                "uti_id": 4,
                "uti_identifiant": "johnny",
                "uti_droits": "W"
            },
            "adherent": {
                "adh_id": 7,
                "adh_nom": "Haliday",
                "adh_prenom": "Johnny",
                "adh_ville": "En cendre"
            }
        }
    ],
    "messages": [
        {
            "mes_id": 21,
            "mes_uti_id_emetteur": 1,
            "mes_texte": "Nous devons nous concerter.",
            "mes_date": "2018-05-17 08:21:44"
        },
        {
            "mes_id": 14,
            "mes_uti_id_emetteur": 3,
            "mes_texte": "Bonjour ma meilleure amie",
            "mes_date": "2018-04-11 16:58:35"
        },
        {
            "mes_id": 13,
            "mes_uti_id_emetteur": 3,
            "mes_texte": "J'entends un épiléptique de l'au-delà...",
            "mes_date": "2018-03-09 16:46:58"
        },
        {
            "mes_id": 12,
            "mes_uti_id_emetteur": 4,
            "mes_texte": "Auu!",
            "mes_date": "2018-03-09 16:46:47"
        },
        {
            "mes_id": 11,
            "mes_uti_id_emetteur": 3,
            "mes_texte": "?",
            "mes_date": "2018-03-09 16:46:25"
        },
        {
            "mes_id": 10,
            "mes_uti_id_emetteur": 4,
            "mes_texte": "Yiiihi",
            "mes_date": "2018-03-09 16:46:16"
        }
    ],
    "success": 1
}
```





______________________






# Requêtes d'écriture


## Ajouter un message
Ajoute un nouveau message dans une conversation entre deux utilisateurs.
La conversation doit avoir été créée auparavant.
* Route : `add_message.php`
* Méthode : `POST`
* Paramètres :
	* `mes_id_destinataire` - ID de l'utilisateur destinataire
	* `mes_texte` - Contenu du message
* Renvoie :
	* `id` - l'ID du message ajouté


## Marquer une conversation comme lue
Marque tous les messages d'une conversation comme lue pour l'utilisateur lisant les messages.
* Route : `set_conversation_lue.php`
* Méthode : `POST`
* Paramètres :
	* `id_conversation` - ID de la conversation à marquer comme lue
