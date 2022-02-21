#-----------------------------------------------------------
# Docker
#-----------------------------------------------------------

# Wake up docker containers
up:
	docker-compose up -d
# Build and up docker containers
build:
	docker-compose up -d --build
# Shut down docker containers
down:
	docker-compose down

# Stop services only
stop:
	docker-compose stop

# Show a status of each container
status:
	docker-compose ps
# Status alias
s: status

# Show logs of each container
logs:
	docker-compose logs

# Restart all containers
restart: down up

# Build and up docker containers
rebuild: down build
#-----------------------------------------------------------
# Dependencies
#-----------------------------------------------------------

# Install composer dependencies
composer-install:
	docker-compose exec php composer install

# Update composer dependencies
composer-update:
	docker-compose exec php composer update

# Add permissions for Laravel cache and storage folders
permissions:
	sudo chmod -R 777 api/bootstrap
	sudo chmod -R 777 api/storage

# Add Migrations
migration:
	docker-compose exec php php artisan migrate

seed:
    docker-compose exec php artisan db:seed

cron:
    docker-compose exec php  crontab
#-----------------------------------------------------------
# Clearing
#-----------------------------------------------------------
# copy past env
copy-past:
	cp api/.env.example api/.env

# Shut down and remove all volumes
remove-volumes:
	docker-compose down --volumes

# Remove all existing networks (useful if network already exists with the same attributes)
prune-networks:
	docker network prune

# Clear cache
prune-a:
	docker system prune -a

#-----------------------------------------------------------
# Run project
#-----------------------------------------------------------------------------------------------
# Build Test Project
build-mytest: rebuild permissions copy-past composer-install restart migration seed cron