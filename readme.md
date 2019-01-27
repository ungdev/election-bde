EtuUTT Election module
======================

Module basé sous Laravel, permettant la tenu des élections du Bureau des Etudiant de l'Université de Technologie de Troyes.
Projet originel de https://github.com/Alabate/utt-bde-election, mis à jour.

### Configuration du site
* Copiez le fichier `.env.example` en `.env`
* Réglez vos paramètres de connexion à la base de donnée dans `.env`
* Executez `php artisan migrate` afin de créer les tables dans la base de donnée
* Executez `php artisan key:generate` afin de générer la clé de chiffrement
* Modifiez la propriété `url` de `config/app.php`. Modifiez aussi les locales et timezone si nécéssaire.
* Copiez le fichier `config/election.example.php` en `config/election.php`
* Créez une application sur le [site etudiant de l'UTT](https://etu.utt.fr/api/panel)
 * Utilisez `http://xxxxxx/login/auth` comme URL de redirection
 * Cochez uniquement 'Données publiques'
* Réglez chaque parametre du fichier `config/election.php`
** A NOTER ** qu'il est possible de configurer les parametres via les variables d'environnement:
    - ETU_APP_ID
    - ETU_APP_SECRET
    - LOGIN_ADMIN (login des admins séparé par des , )
    - EMAILS_ADMIN (si plusieurs, séparer par des , )
    - LOGIN_VIEWER (login des admin en lecture séparé par des , )
    - VOTE_START `ex: 2017-03-02 21:00:00`
    - VOTE_END `ex: 2017-03-02 21:00:00`
* Si votre serveur n'est pas en https, commentez la ligne `URL::forceSchema("https");` du fichier `app/Http/routes.php`
