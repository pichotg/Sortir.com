# Sortir.com

Projet Symfony 4 réalisé durant formation ENI.

## Installation

Installation du serveur web apache, php 7.3.10, base de données mysql, phpmyadmin et maildev via [docker](https://www.docker.com/).
Installation de l'application Symfony.

```bash
cd /path/to/project

docker-compose up --build

docker exec -it -u dev sortir.com_php bash
composer update
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

## Commandes utiles
Lancer les containers :
```bash
docker-compose up --build
```

Se connecter sur le container php en tant que dev :
```bash
docker exec -it -u dev sortir.com_php bash
```

Se connecter sur le container php en tant que root :
```bash
docker exec -it sortir.com_php bash 
```

Mise à jour de la base de données :
```bash
php bin/console doctrine:schema:update --force
```

Mettre en place le jeu de données :
```bash
php bin/console doctrine:fixtures:load
```