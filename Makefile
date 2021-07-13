DC = docker exec -it opendorme_app_1 /bin/bash -c

connect-app: ## Connect to app container
	docker exec -it opendorme_app_1 /bin/bash

build: ## Build local environment
	mkdir -p ./storage/nginx
	touch ./storage/nginx/error.log
	touch ./storage/nginx/access.log
	docker-compose build

start: ## Start local environment silently
	docker-compose up -d

stop: ## Stop local environment
	docker-compose down

restart: stop start ## Restart the application

composer-install: ## Install composer dependencies
	$(DC) 'composer install'

composer-update: ## Update composer dependencies
	$(DC) 'composer update $(filter-out $@,$(MAKECMDGOALS))'

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
	$(DC) 'npm run dev'

npm-prod: ## Run production build
	$(DC) 'npm run prod'

cleanup-docker: ## Remove old docker images
	docker rmi $$(docker images --filter "dangling=true" -q --no-trunc)

run: ## Run command in the container
	$(DC) '$(filter-out $@,$(MAKECMDGOALS))'

help: # Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
