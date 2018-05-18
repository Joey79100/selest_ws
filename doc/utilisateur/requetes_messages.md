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
	* `id_emetteur` (*optionnel* - *admin seulement*) - ID d'un utilisateur émetteur 


## Récupérer des messages
Récupère les messages d'une conversation.

Les messages sont triés par ordre décroissant (le plus récent en premier).

Seulement 10 messages sont chargés par défaut. Pour avoir la suite des messages, renvoyer une requête en envoyant l'ID du message le plus ancien ayant déjà été récupéré.

* Route : `get_messages.php`
* Méthode : `GET`
* Paramètres :
	* `id_conversation` - ID de la conversation d'où tirer les messages
	* `id_message` (*optionnel*) - ID du message le plus ancien ayant déjà été récupéré
	* `nb_messages` (*optionnel*) - Nombre de messages à charger (10 par défaut)





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
