#!/usr/bin/env bash

set -e
php bin/run migrate --path=app/Setting/Database/Migrations

php bin/run migrate --path=app/System/Database/Migrations

php bin/run db:seed --path=app/Setting/Database/Seeders

php bin/run db:seed --path=app/System/Database/Seeders

php bin/run mine:update

composer coverage