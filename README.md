<h1 align="center">L'Aura Natur'elle</h1>

<img src="/preview.png" alt="Illustration de l'application">


## Description du projet

Site vitrine professionnel pour L’Aura Natur’elle, une entreprise individuelle d’esthétique située à Saint-Quentin (02). L’objectif du projet était d’offrir une réelle visibilité de l’entreprise sur le web.

> [!IMPORTANT]
> Le repository est désormais public, puisque le projet a été abandonné et qu'une nouvelle version est en cours de développement. Pour consulter la démo de la V.2, rendez-vous [ici](https://laura-naturelle-demo.vercel.app).


Pour en savoir plus, vous pouvez consulter la page de mon [portfolio](https://perrine-dassonville.dev/portfolio/projet/laura-naturelle-v1) dédiée au projet.

> [!CAUTION]
> Attention, le projet est ancien et n'est pas forcément conforme et bien que très avancé, il n'a pas été finalisé.


Si vous souhaitez consulter uniquement la démo, c'est par [ici](https://xenophee.github.io/Laura-Naturelle--Demo-V.1/).


## Installation avec Laragon

1. **Télécharger et installer Laragon :**
    - Rendez-vous sur le site officiel de [Laragon](https://laragon.org/) et téléchargez la version appropriée pour votre système d'exploitation.
    - Installez Laragon en suivant les instructions fournies.


2. **Télécharger PHP et le configurer dans Laragon :**
    - Rendez-vous sur le site officiel de [PHP](https://www.php.net/downloads.php) et téléchargez la version 7.4.19 (ou supérieur) (x64) Thread Safe.
    - Extrayez le contenu de l'archive téléchargée dans le répertoire `bin\php` de Laragon (généralement `C:\laragon\bin\php`).
    - Renommez le répertoire extrait en `php-7.4.19`.
    - Ouvrez Laragon et allez dans `Menu > PHP > Version > php-7.4.19`.
    - Redémarrez Laragon pour appliquer les modifications.


3. **Cloner le dépôt du projet :**
    - Rendez vous vers le répertoire `www` de Laragon (généralement `C:\laragon\www`).
    - Clonez le dépôt du projet :
      ```sh
      git clone https://github.com/Xenophee/Laura-Naturelle-V.1.git
      ```

4. **Installer les dépendances du projet :**
   - Si vous ne l'avez pas déjà, rendez-vous sur le site officiel de [Composer](https://getcomposer.org/) et téléchargez l'installateur pour votre système d'exploitation.
   - Ouvrez un terminal et placez-vous dans le répertoire du projet cloné.
   - Exécutez la commande suivante pour installer les dépendances :
     ```sh
     composer install
     ```


5. **Mettre en place la base de données :**
    - Créez une base de données nommée `laura_naturelle`.
    - Dans le dossier `resources` du projet, vous trouverez le script `bdd.sql` à exécuter dans la base de données nouvellement créée.

Par défaut, Laragon propose HeidiSQL pour gérer les bases de données. Vous pouvez lancer l'application depuis le menu de Laragon.
Si vous préférez phpMyAdmin, vous pouvez l'ajouter manuellement en le téléchargeant et en le plaçant dans le répertoire `C:\laragon\etc\apps`.
Redémarrez ensuite Laragon pour que les modifications soient prises en compte et accédez à phpMyAdmin depuis le menu de Laragon.

6. **Configurer l'accès à la base de données :**
    - Créez un fichier `.env` à la racine du projet selon le même modèle que `.env.example` et renseignez les différentes variables d'environnement selon votre configuration.


7. **Accéder au projet :**
    - Démarrer Laragon
    - Ouvrez votre navigateur et accédez à l'URL suivante :
      ```
      http://laura-naturelle-v.1.test
      ```
   
8. **Accéder à l'administration :**
    - Pour accéder à l'administration, vous pouvez vous rendre à l'URL suivante :
      ```
      http://laura-naturelle-v.1.test/lan-connexion
      ```
    - Les identifiants par défaut sont :
      - Identifiant : `esthetique@gmail.com`
      - Mot de passe : `123`
