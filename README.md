### Installation

__Bundles et dépendances Vendor__  
```bash
composer install
```  
__Packages et dépendances NodeModule__  
```bash
npm install
```  
__Webpack Compile__
```bash
npm run dev-server  
npm run watch
```  
__Intervention/image__  
Redimension d'image.  
Après 'composer install', activer l'extension "gd" dans le fichier php.ini  

##

### Base de données  

__Création de la base de donnée__
```bash
php bin/console doctrine:database:drop // seulement si une base de donnée existe déjà
php bin/console doctrine:database:create
```  
```bash
php bin/console doctrine:migrations:migrate
```  
__Fixtures(fake datas)__
```bash
php bin/console doctrine:fixtures:load
```  
__Modèle de données__  
![modele_logique_de_donnees](https://www.zupimages.net/up/21/23/uhg7.png) 

##

### Test  
__Serveur local__  
```bash
php -S localhost:8000 -t public
```  
__Connexion__  
- _Administrateur_     
Email: admin@example.fr  
Mot de passe: passAdmin  
- _Utilisateur_   
Email: user@example.fr  
Mot de passe: passUser  

__Back-office__   
Accessible uniquement si connecté en tant qu'administrateur:  
__http://localhost:8000/admin__