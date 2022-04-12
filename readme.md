# CAHIER DES CHARGES DU PROJET

## NOM :
* jessizen

## Version :
* v1.0

## Description
* Site web de type blog, où la lecture des articles est réserver aux personnes possédant au minimum le rôle "user".
* Les articles seront classer par catégories. Et afficher par ordre déchronologique. Chaque fois qu'une article est visonner, son nombre de vu augment.
* Le site permettra au utilisateur de mettre en favorie des articles, de noté les articles, de commenter les articles si l'auteur l'a autoriser pour l'article. 
* Le site offre la possibilité de bannir des utilisateurs ne respectant pas les règles du site.
* Chaque "**utilisateur**" possède une pages personnel, lui permettant de gérer ces informations personnels, ces articles favories, ces commentaires.
* Chaque "**author**" possède un pages personnel, lui permettant de gérer ces informations personnels, ces articles favories, ces commentaires. Mais aussi d'éditer, de modifier et des supprimer ces articles. Et de consulter les commentaires reliés à ces articles.
* Chaque "**administrateur** possède une page personnel, lui permettant de gérer ces informations personnels, ces articles favories, ces commentaires. Mais aussi d'éditer, de modifier et des supprimer ces articles. Et de consulter les commentaires reliés à ces articles. Mais permet aussi de gérer tous les articles du site, les commentaires, les utilisateurs.

## Fabriqué avec :
* VSCode (Editeur de code)
* Xamp (Serveur Appache, PHP, SQL)

## Technologies :
* Symfony 5.4 (Framework PHP 7.4)
* HTML5
* CSS3 (scss)
* Javascript
* Bundle "**Register**" (Création de compte utilisateur)
* Bundle "**Authentificator**" (Identification)
* Bundle "** ResetPassword**" (Réinitialisation du mot de passe)
* Bundle "**Symfony fixture**"
* Bundle "**Symfony webpack**"
* Bundle "**Bootstrap icon**"
* Bundle "**Bootstrap scss**"
* Bundle "**CKEditor**"

## Hébergement :
* "**Hébergeur**" => [o2swith](https://o2swith.fr)
* "**Adresse web**" => [jessizen](https://jessizen.guillardmarc.fr)

## Propriétaire :
* "**Jessica**"

## Dévélopeur web :
* "**Marc GUILLARD**"

## Etapes du projet :

### Fichier ".env" : (Dépôt GITHUB : Fait)
1. Configuration du MAILER_DSN (Etat : Fait)
1. Configuration du DATABASE_URL (Etat : Fait)
1. Création de la base de donnée (Etat : Fait)

### Fichier "base.html.twig" et "base_dashboard.html.twig" : (Dépôt GITHUB : Fait)
1. Modification du fichier "**base.html.twig**" (Etat : Fait)
1. Création du fichier "**base_dashboard.html.twig**" via le fichier "**base.html.twig**" (Etat : Fait)

### Controlleur "BasicPages" : (Dépôt GITHUB : Fait)
1. Création du controlleur (Etat : Fait)
1. Modification du controlleur (Etat : Fait)

### Entité "Users" : (Dépôt GITHUB : Fait)
1. Crétion de l'entité avec les champs suivant : (Etat : Fait)
    * email
    * roles
    * password
1. Ajout des champs  suivant : (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | pseudo | string (255) | non nul |
    | pictureProfilAlt | string (255) | nullable |
    | pictureProfilLink | string (255) | nullable |
    | pictureProfilName | string (255) | nullable |
    | birthday | date | nullable |
    | moreInfo | text | nullable |
    | websiteSettlementAccept | boolean | non nul |
1. Modification de l'entité : (Etat : Fait)
    * Ajout des constante "**roles**"
    * Attribution par défaut de la constante "**roles user**" par défaut

### Bundle "Register Form" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Configuration du bundle (Etat : Fait)
1. Modification du fichier "RegistrationFormType.php" (Etat : Fait)

### Bundle "Authentificator" : (Dépôt GITHUB : )
1. Installation du bundle (Etat : Fait)
1. Configuration du bundle (Etat : Fait)