#!make

DOCKER_COMPOSE := docker compose -f ./docker/dev/docker-compose.yml
PHP_SERVICE := php

init: docker-clear docker-build docker-up composer-install database-wait database-migrate
docker-restart: docker-down docker-up
docker-rebuild: docker-down docker-build docker-up

docker-up:
	$(DOCKER_COMPOSE) up -d

docker-down:
	$(DOCKER_COMPOSE) down

docker-build:
	$(DOCKER_COMPOSE) build --pull

docker-clear:
	$(DOCKER_COMPOSE) down -v --remove-orphans

composer-install:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) composer install

composer-update:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) composer update

PACKAGE_NAME = $(filter-out $@,$(MAKECMDGOALS))
%:
 @:
composer-require:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) composer require $(PACKAGE_NAME)

composer-du:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) composer du

database-wait:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) wait-for-it mariadb:3306 -t 60

database-migrate:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

database-rollback:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console doctrine:migrations:migrate prev --no-interaction

database-diff:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console doctrine:migrations:diff

database-validate-schema:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console doctrine:schema:validate

COMMAND_NAME = $(filter-out $@,$(MAKECMDGOALS))
%:
 @:
console:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console $(COMMAND_NAME)

test-init:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console --env=test doctrine:database:create
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console --env=test doctrine:schema:create

test:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) composer test

cache-clear:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console cache:clear
