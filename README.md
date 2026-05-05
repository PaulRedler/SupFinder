# SupFinder


Vous pouvez récupérer le dump de la base supfinder.sql sur le dossier https://lyceefulbert-my.sharepoint.com/my?id=%2Fpersonal%2Fpaul%5Fredler%5Flyceefulbert%5Ffr%2FDocuments%2Ftest&ga=1




 
# Prérequis
 
Avant de commencer, assurez-vous d’avoir installé :
 
- PHP
- Composer
- Symfony CLI
- Git
- MariaDB (optionnel selon le mode d’installation)
 
---
 
# Installation du projet
 
## 1. Cloner le dépôt
 
```bash
git clone https://github.com/PaulRedler/SupFinder
cd SupFinder
```
 
---
 
# Lancement du projet
 
 
## Installation de MariaDB
 
### Debian / Ubuntu
 
```bash
sudo apt-get install mariadb-server
```
 
---
 
## Connexion à MariaDB
 
```bash
sudo mariadb
```
 
---
 
## Création d’un utilisateur MariaDB
 
```sql
CREATE USER 'utilisateur'@'IP_MACHINE' IDENTIFIED BY 'mot_de_passe';
GRANT ALL PRIVILEGES ON *.* TO 'utilisateur'@'IP_MACHINE';
FLUSH PRIVILEGES;
```
 
### Explications
 
| Paramètre | Description |
|---|---|
| utilisateur | Nom de l’utilisateur MariaDB |
| IP_MACHINE | Adresse IP de la machine hébergeant Symfony |
| mot_de_passe | Mot de passe du compte MariaDB |
 
---
 
# Configuration du fichier `.env`
 
Modifier les informations de connexion à la base de données dans le fichier `.env`.
 
Exemple :
 
```env
DATABASE_URL="mysql://utilisateur:mot_de_passe@IP:3306/nom_base"
```
 
### Paramètres
 
| Variable | Description |
|---|---|
| IP | Adresse IP du serveur MariaDB |
| utilisateur | Utilisateur créé précédemment |
| mot_de_passe | Mot de passe de l’utilisateur |
 
---
 
# Installation des dépendances
 
```bash
composer install
```
 
---
 
# Initialisation de la base de données
 
## Créer la base de données
 
```bash
php bin/console doctrine:database:create
```
 
## Exécuter les migrations
 
```bash
php bin/console doctrine:migrations:migrate
```
 
---
 
# Importer la base de données fournie (optionnel)
 
## Copier le fichier `supfinder.sql` sur la VM MariaDB
 
Depuis votre machine locale :
 
```bash
scp ./supfinder.sql utilisateur_VM@IP_VM:/chemin/vers/votre/dossier
```
 
### Explications
 
| Paramètre | Description |
|---|---|
| utilisateur_VM | Nom de l’utilisateur de votre VM |
| IP_VM | Adresse IP de la machine hébergeant MariaDB |
| /chemin/vers/votre/dossier | Dossier où copier le fichier |
 
---
 
## Importer le dump SQL
 
Depuis la VM hébergeant MariaDB :
 
```bash
mysql -u utilisateur -p nom_base < /chemin/vers/votre/dossier/supfinder.sql
```
 
### Explications
 
| Paramètre | Description |
|---|---|
| utilisateur | Utilisateur MariaDB |
| nom_base | Nom de la base de données |
| /chemin/vers/votre/dossier/supfinder.sql | Chemin du fichier SQL |
 
---
 
# Lancer le serveur Symfony
 
```bash
symfony server:start
```
 
---
 
# Accéder au projet
 
```txt
http://127.0.0.1:8000
```
 
---
