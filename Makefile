.PHONY: help

docker-compose=docker-compose
docker-compose-gitlab=docker-compose -f docker-compose.gitlab.yml

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

start: stop build up _finish ## Starts containers with build
fast: stop up _finish ## Attempts to start existing containers

up:
	docker network create amciu_backend || true
	$(docker-compose) run --rm dependencies
	$(docker-compose) up --force-recreate -d

build:
	$(docker-compose) build
	$(docker-compose) exec app composer install
	$(docker-compose) exec app sh ./tools/post_deploy.sh

stop: ## Stops containers and removes network
	$(docker-compose) down --remove-orphans
	docker network prune -f

_finish:
	@echo "----------------------------------------------------------------------------"
	@echo "Client is running in watch mode with data mock under: http://localhost:8888/"
	@echo "----------------------------------------------------------------------------"
	@echo "There are also dev tools available:"
	@echo "Mailhog UI: http://localhost:8025/"
	@echo "----------------------------------------------------------------------------"

copy_vendor: ### Copy vendor directory into a host machine
	sudo docker cp $$(docker-compose ps -q app):/app/vendor .

envs: ### Debug env file
	$(docker-compose) exec app php bin/console debug:dotenv

params: ### Debug container parameters
	$(docker-compose) exec app php bin/console debug:container --parameters

config_dump: ### Displays merged docker-compose configuration
	$(docker-compose) config

post_deploy: ### Runs post deploy script that normally would be run in CI process
	$(docker-compose) exec app sh ./tools/post_deploy.sh

tests_unit: ### Runs unit tests
	$(docker-compose-gitlab) run --rm tests_unit

tests_arch: ### Runs architecture tests (deptrac)
	$(docker-compose-gitlab) run --rm tests_architecture

tests: tests_arch tests_unit

migrations_diff: ### Generates new migration
	$(docker-compose) exec app php bin/console doctrine:migrations:diff --em default

mig_prev: ### Rollbacks migration
	$(docker-compose) exec app php bin/console doctrine:migrations:migrate prev --no-interaction

migrate: ### Run migrations
	$(docker-compose) exec app php bin/console doctrine:migrations:migrate --no-interaction

mig: migrations_diff migrate ### Generates new migration and run it immediately

seed: ### Seeds and cleans up database
	$(docker-compose) exec app composer db:seed:tests

seed_metrics: ### Appends more metric seeds
	$(docker-compose) exec app composer db:seed:more-metrics

logs:
	$(docker-compose) logs -f