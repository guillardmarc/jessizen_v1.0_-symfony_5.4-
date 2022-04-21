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

### Bundle "Authentificator" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Configuration du bundle (Etat : Fait)

### Bundle "Reset password" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Configuration du bundle (Etat : Fait)

### Création des entitées : (Dépôt GITHUB : )
1. Création de l'entitée "**UsersLinks**" avec les champs suivants (Etat : Fait )
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | type | string (255) | non nul |
    | url | string (255) | non nul |
    | | | |
    | <ins>user</ins> | relation avec l'entité "**Users**" | ManyToOne |

1. Création de l'entitée "**Websites**" avec les champs suivants (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | logoText | string (255) | non nul |
    | logoPictureAlt | string (255) | nullable |
    | logoPictureLink | string (255) | nullable |
    | logoPictureName | string (255) | nullable |
    | copyright | string (255) | non nul |
    | regulation | text | non nul |
    | version | string (3) | non nul |
    | presentationText | text | non nul |
    | presentationPictureAlt | string (255) | non nul |
    | presentationPictureLink | string (255) | non nul |
    | presentationPictureName | string (255) | non nul |
    | publicationDate | date | nullable |
    | | | |
    | <ins>author</ins> | relation avec l'entité "**Users**" | ManyToOne |
    | <ins>developer</ins> | relation avec l'entité "**Users**" | ManyToOne |
    | <ins>owner</ins> | relation avec l'entité "**Users**" | ManyToOne |

1. Création de l'entitée "**WebsitesUpdates**" avec les champs suivant (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | title | string (255) | non nul |
    | date | date | non nul |
    | moreInfo | text | nullable |
    | underVersion | string (3) | nullable |
    | | | |
    | <ins>author</ins> | relation avec l'entité "**Users**" | ManyToOne |
    | <ins>website</ins> | relation avec l'entité "**Websites** | ManyToOne |

1. Création de l'entité "**Categories**" avec les champs suivant (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | title | string (255) | non nul |
    | slug | string (255) | non nul |
    | moreInfo | text | nullable |
    | pictureAlt | string (255) | nullable |
    | pictureLink | string (255) | nullable |
    | pictureName | string (255) | nullable |
    | | | |
    | <ins>author</ins> | relation avec l'entité "**Users**" | ManyToOne |

1. Entité **Articles** avec les champs (Etat: Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | title | string (255) | non nul |
    | slug | string (255) |non nul |
    | content | text | non nul |
    | pictureTopAlt | string (255) | non nul |
    | pictureTopLink | string (255) | non nul |
    | pictureTopName | string (255) | non nul |
    | note | decimale (12.2) | nullable |
    | voterNumber| decimale (10.00) | nullable |
    | viewNumber | decimale (10,0) | nullable |
    | isCommented | boolean | nullable |
    | publicationDate | date | nullable |
    | | |
    | <ins>author</ins> | relation avec l'entité "**Users**" | ManyToOne |
    | <ins>categories</ins> | relation avec l'entité "**Categories**" | ManyToMany |
    | <ins>favories</ins> | relation avec l'entité "**Users**" | ManyToMany |

1. Création de l'entité "**ArticlesPictures**" avec les champs suivant (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | alt | string (255) | non nul |
    | link | string (255) | non nul |
    | name | string (255) | non nul |
    | | | |
    | <ins>article</ins> | relaton avec l'entité "**Articles**" | ManyToOne |

1. Création de l'entité "**ArticlesComments**" avec les champs suivant (Etat : Fait)
    | Nom du champs | Type de champs | Complément d'informations |
    | :------------ | :------------- | :------------------------ |
    | createdAt | datetime | non nul |
    | modifiedAt | datetime | non nul |
    | comment | text | non nul |
    | | | |
    | <ins>article</ins> | relation avec l'entité "**Articles**" | ManyToOne |+
    | <ins>author</ins> | relation avec l'entité "**Users**" | ManyToOne |

### Bundle "Symfony Fixtures" : (Dépôt GITHUB : Faite)
1. Installation du bundle (Etat : Fait)
1. Création des données de fixture (Etat : Fait)
1. Ajout des données de fixture dans la base de données (Etat : Fait)

### Création des "Extension twig" : (Dépôt GITHUB : Faite)
1. Création du services twig "**ArticlesExtension.php**" (Etat : Fait)
1. Création du services twig "**CategoriesExtension.php**" (Etat : Fait)
1. Création du services twig "**WebsitesExtension.php** (Etat : Fait)

### Bundle "Webpack Encors" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Configuration du bundle (Etat : Fait)

### Fichier Scss : (Dépôt GITHUB : )
1. Création du fichier "**_font.scss**" contenant les polices d'ecriture (Etat : Fait)
1. Création du fichier "**_footer.scss**" contenant les classes scss de la balise "footer" (Etat : Fait)
1. Création du fichier "**_global.scss**" contenant les classes scss globals (Etat : Fait)
1. Création du fichier "**_main.scss**" contenant les classes scss de la balise "main" (Etat : Fait)
1. Création du fichier "**_nav.scss**" contenant les classes scss de la balise "nav" (Etat : Fait)
1. Création du fichier "**_var.scss**" contenant les variables scss (Etat : Fait)
1. Import des fichiers précédents via le fichier "**app.scss**" (Etat : Fait)

### Bundle "Bootstrap icon" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Import du bundle via le fichier "**app.scss**" (Etat : Fait)

### Bundle "Bootstrap Scss" : (Dépôt GITHUB : Fait)
1. Installation du bundle (Etat : Fait)
1. Création des variable de couleur custom dans le fichier "**_var.scss**" (Etat : Fait)
1. Configuration du bundle (Etat : Fait)
1. Import du bundle via le fichier "**app.js**" (Etat : Fait)
1. Import du bundle via le fichier "**app.scss**" (Etat : Fait)

### Template de l'accueil du site : (Dépôt GITHUB : Fait)
1. Fichier "**base.html.twig**" (Etat : Fait)
    1. Template block "nav"
    1. Template block "header"
    1. Template block "main"
    1. Template block "footer"
    1. Template block "modale
    1. Template block "alert success"
1. Fichier "**index.html.twig**" (Etat : Fait)
    1. Template block "présentation"
    1. Template block "les 5 dernier articles publier"
    1. Template block "les 3 articles les mieux notés"
    1. Template block "les 5 articles les plus vu"

### Template de l'identification : (Dépot GITHUB : Fait)
1. Fichier "**login.html.twig**" (Etat : Fait)
1. Partie "**registration**" (Etat : Fait)
    1. Fichier "**confirmation_email.html.twig**"
    1. Fichier "**register.html.twig**"

### Template de reset password : (Dépôt GITHUB : Fait)
1. Fichier "**chek_email.html.twig**" (Etat : Fait)
1. Fichier "**email.html.twig**" (Etat : Fait)
1. Fichier "**request.html.twig**" (Etat : Fait)
1. Fichier "**reset.html.twig**" (Etat :Fait)

### Partie "User" (Dépôt GITHub : )
1. Création du controller "**User**" 
    1. Création de la fonction "**dashboard**" (Etat : Fait)
    1. Création de la fonction "**deletUser**" (Etat : Fait)
        1. Installation du bundle "**dompdf**" (Etat : Fait)
    1. Création de la fonction "**editUser**" (Etat : Fait)
    1. Création de la fonction "**deleteImage**" (Etat : Fait)
1. Création du controller "**Category**"
    1. Création de la fonction "**viewCategory**" (Etat : Fait)
    1. Création de la fonction "**addFavoryCategory**" (Etat : Fait)
    1. Création de la fonction "**deletFavoryCategory**" (Etat : Fait)
    1. Création de la fonction "**listFavoriesCategory**" (Etat : Fait)
1. Création du controller "**Article**"
    1. Création de la fonction "**viewArticle**" (Etat : Fait)
    1. Création de la fonction "**addFavoryArticle**" (Etat : Fait)
    1. Création de la fonction "**deletFavoryArticle**" (Etat : Fait)
    1. Création de la fonction "**listFavoriesArticles**" (Etat : Fait)