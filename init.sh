#!/usr/bin/env bash

# Create default .ENV config
# --------------------------
#cp .env_example .env
sudo sed -i '3i 10.0.3.1    mongocli' /etc/hosts

# Start
# -----
docker-compose build apache2 mongo php-fpm workspace
docker-compose up -d apache2 mongo
docker-compose exec mongo sh /mongo.sh user password

# Execute workspace with install dependencies & run CLI
# -----------------------------------------------------
docker-compose exec workspace composer install && php cli.php

# Execute workspace
# -----------------
#docker-compose exec workspace php cli.php

# Execute specified containers
# ----------------------------
#docker-compose exec php-fpm bash docker-php-ext-enable xdebug
