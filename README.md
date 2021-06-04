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
npm run watch
```  

##

### Base de données  

__Création de la base de donnée__
```bash
php bin/console doctrine:migrations:migrate
```  
__Fixtures(fake datas)__
```bash
php bin/console doctrine:fixtures:load
```  
__Modèle de données__
![modele_logique_de_donnees](https://www.zupimages.net/up/21/22/32rg.png) 

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