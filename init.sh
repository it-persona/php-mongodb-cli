#!/usr/bin/env bash

# Start
# -----
docker-compose build apache2 workspace mongo php-fpm
docker-compose up -d apache2 mongo
docker-compose exec mongo sh /mongo.sh user password

# Execute workspace
# -----------------
docker-compose exec workspace php cli.php

# Execute specified containers
# ----------------------------
#docker-compose exec php-fpm bash docker-php-ext-enable xdebug