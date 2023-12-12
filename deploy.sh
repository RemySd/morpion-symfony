#!/usr/bin/env bash

git pull || echo "git pull failed. Skipping..."

bin/console d:m:m -n
composer install
bin/console cache:clear --env=prod
