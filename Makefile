DC = docker exec -it opendorme_app /bin/bash -c

connect-app: ## Connect to app container
	docker exec -it opendorme_app /bin/bash

build: ## Build container images
	mkdir -p ./storage/nginx
	touch ./storage/nginx/error.log
	touch ./storage/nginx/access.log
	docker-compose build

setup: build start composer-install key-generate migrate npm-install npm-dev  ## Setup project for development

start: ## Start application silently
	docker-compose up -d

stop: ## Stop application
	docker-compose down

restart: stop start ## Restart the application

composer-install: ## Install composer dependencies
	$(DC) 'composer install'

composer-update: ## Update composer dependencies
	$(DC) 'composer update $(filter-out $@,$(MAKECMDGOALS))'

copy-env: ## Copy .env.example as .env
	cp .env.example .env

key-generate: ## Generate key for laravel
	$(DC) 'php artisan key:generate'

migrate: ## Migrate database
	$(DC) 'php artisan migrate'

seed: ## Migrate database and seed
	$(DC) 'php artisan migrate --seed'

test: ## Run tests
	$(DC) 'php artisan test'

horizon: ## Run Horizon
	$(DC) 'php artisan horizon'

npm-install: ## Install npm
	$(DC) 'npm install'

npm-dev: ## Run development build
	$(DC) 'npm run development'

npm-prod: ## Run production build
	$(DC) 'npm run production'

cleanup-docker: ## Remove old docker images
	docker rmi $$(docker images --filter "dangling=true" -q --no-trunc)

run: ## Run command in the container
	$(DC) '$(filter-out $@,$(MAKECMDGOALS))'

help: # Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
