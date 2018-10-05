# Test Symfony 4.1

Test Application Catalogue de produits et gestion de panier Basique sous Symfony 4.1 environnement PHP >= 7.1 et SQLite

## Indications
	* L'application propose 12 produits au total.
	* Les produits continnent les champs suivants: id, nom, description, prix
	* Les produits seront stockés en base de donnée.
	* Le panier sera stocké en session

## Install

    composer install
    Rmplacer dans le fichier .env par les bon parametres pour la base de donnée et ses connexions
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
    php bin/console doctrine:migrations:migrate
    yarn install
    yarn build

## Charger les Fixtures
	
	* php bin/console doctrine:fixtures:load

## Compiler les Assets pour la production

	yarn encore production

## Lancer le projet
	
	php bin/console server:start
	et aller sur l'url http://localhost:8000

## Test Unitaires et fonctionnel

	 Rmplacer dans le fichier phpunit.xml.dist par les bon parametres pour la base de donnée et ses connexions
	* Run php bin/phpunit



## TODO
	Finish test code for Controllers, using Form
	I comment ProductControllerTest because no time for finish it