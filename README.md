# FRONT / ANGULAR

## Modale de connexion


# BACK / SYMFONY

## Fixtures

26/10: Problème avec le composer require --dev orm-fixtures : j'étais en php 8.2.0 (sodium inactif) alors que wamp était en php 8.0.1 (sodium actif), je ne pouvais pas l'installer. PB résolu en mettant à jour la version de PHP sur Wamp et en décommentant sodium.

## JWT token
dans le lexik_jwt_authentication.yaml, je rajoute un user_identify_field: id pour récupérer l'id de l'user dans le token afin de relier mon panier (selection) à un user_id.

Il faut également actualiser la UserInterface dans le User.php