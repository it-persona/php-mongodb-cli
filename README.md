MongoDB Client (CLI)
====================

![Build status](https://travis-ci.org/it-persona/php-mongodb-cli.svg?branch=master)

PHP MongoDB Client is a CLI-script represent alternative syntax like MySQL for run queries and get data from MongoDB server.

### Docker containers

 - Workspace Utilities (php7.0, composer, phpunit, vi)
 - PHP-FPM (php7.0, xdebug)
 - Server Apache2;
 - MongoDB (mongo shell version: 3.6.3)
 - Application Code (volume for project code base directory)
 - Databases Data (storage for mongo databases & session storage)

### Requirements

#### Software requirements

 - Docker 17.05.0-ce;
 - docker-compose 1.18.0
 - PHPUnit 6.5.x-dev

#### Components & Libs

 - PHP 7.0
 - MongoDB driver library 1.2.x-dev
 - Symfony Console Component 3.4.x-dev
 - PHP dotenv 2.5

Installation
------------

Before deploy **MongoDB Client** you must make sure **Docker** and **docker-compose** is installed in your OS.

#### Installation guides:

 - [Docker CE](https://docs.docker.com/install/#supported-platforms) - cross-platform installation guide
 - [docker-compose](https://docs.docker.com/compose/install) - guide for install docker compose

#### Install Docker & docker-compose

```
# clone from github repository

git clone git@github.com:it-persona/php-mongodb-cli.git
```

By default environment for **MongoDB PHP Client (CLI)** get ready for use without manually edit **.env** configuration.
For build application with default configuration you must follow next simple steps in your terminal:

```
# if init.sh don't execute after cloning repository
# make script executable

chmod +x init.sh
```

Script **init.sh** use for build containers and execute application workspace

```
# run script from terminal

./init.sh

# use alternative

sh init.sh
```

After success script execution you must see **CLI** on your display (for example look next console output):

```
root@b67e82eab9bc:/var/www# php cli.php 

PHP MongoDB Client (CLI) version: 1.0

Connected to database: test
Collections:
  projects[3]
  developers[5]

Enter your query with MySQL syntax like:
> 
```

Usage
-----

### Basic syntax
 
- **SELECT** - select fields separated by comma. Use **( * )** symbol for select all

- **ORDER BY** **<field_name>** **ASC|DESC** - sorting records by field name with sort methods **ASC|DESC**

- **FROM** **<collection_name>** - collection pointer

- **WHERE** **<field_name>****[comparison operator]****<exp_value>** **[logic operator]** **[..]** - filter collection by expressions. Available comparison operators: **( <>, >, <, >=, <=, = )** Available logic operators **( AND, OR )**

- **LIMIT** **<items_digit>** - limit number of items records

- **SKIP** **<items_digit>** - skip number of items records

#### Input query example

```
root@b67e82eab9bc:/var/www# php cli.php 

PHP MongoDB Client (CLI) version: 1.0

Connected to database: test
Collections:
  projects[3]
  developers[5]

Enter your query with MySQL syntax like:
> select * from projects order by name desc
```

#### Console commands for manual usage

**FIRST STEP:** for deploy app in manual mode is create **.env** configuration file.

```
# Create your .env config from .env_example file

cp .env_example .env
```

After, you must set environment variables for configure services before building containers.

##### Environment variables:

```
# Path to project root directory

PROJECT_DIRECTORY=../php-mongodb-cli

# Customize default services ports

HTTP_PORT=8081
HTTPS_PORT=443
MONGODB_PORT=27077

# Configure install environment software

INSTALL_XDEBUG=true
INSTALL_MONGO=true
COMPOSER_GLOBAL_INSTALL=true

# MongoDB Server Configuration
# `mongocli` is hostname URL for mongodb & php-fpm containers

DB_HOST="mongodb://mongocli"
DB_PORT=27077
DB_NAME=test
```

**SECOND STEP:** set a base URL and host IP for **workspace** and **php-fpm** into ```docker-compose.yaml```.
For change this parameters find next blocks:

````
    extra_hosts:
        - "{{ base_url }}:{{ host_ip }}"
````

**FINAL STEP:** run ``docker-compose`` commands for **buil**, **up** and **execute** containers.

````
# Build & up

docker-compose build apache2 mongo php-fpm workspace
docker-compose up -d apache2 mongo

# Execute mongodb container with run shell script
# create account for a database administrator user

docker-compose exec mongo sh /mongo.sh user password

# Execute workspace container

docker-compose exec workspace bash
````

Install dependencies using package manager **Composer** ``composer install``

````
# Run PHP MongoDB CLI in workspace container

php cli.php
````

Stopping containers

````
# Stopping containers

docker-compose stop

# For remove data contained in storage folder use this
rm -rf docker_data

````

Enter your queries before **'>'** symbol in your console output (see example):

Unit tests
----------

Use next simple command into **workspace** container for run all test cases in test suites of PHP Unit

````
phpunit
````
