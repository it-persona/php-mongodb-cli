#!/usr/bin/env bash

# Create default .ENV config
# --------------------------
#cp .env_example .env

# Start
# -----
chmod +x ip.sh
./ip.sh && echo "PRE-BUILDING..."

docker-compose build apache2 mongo php-fpm workspace
docker-compose up -d apache2 mongo

docker-compose exec mongo sh /mongo.sh user password

# Execute workspace with install dependencies & run CLI
# -----------------------------------------------------
composer install
docker-compose exec workspace phpunit && php cli.php

# Execute specified containers
# ----------------------------
#docker-compose exec php-fpm bash docker-php-ext-enable xdebug
