### Installation

#### Projet
Vendor:  
```bash
composer install
```  
NodeModule:  
```bash
npm install
```  
Dépendance Webpack PopperJS:  
```bash
npm i @popperjs/core
```  
#### Base de données
Créer la base de données:  
```bash
doctrine:database:create
```  
Migration des tables:  
```bash  
doctrine:migrations:migrate 
```  

http://localhost:8000/admin