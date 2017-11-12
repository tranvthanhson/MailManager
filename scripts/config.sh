#!/bin/bash

HEROKU_APP=mail-manager

DB_CONNECTION=pgsql
DB_HOST=ec2-23-21-85-76.compute-1.amazonaws.com
DB_PORT=5432
DB_DATABASE=dcgubva22llt2m
DB_USERNAME=krruncjhwqphpk
DB_PASSWORD=283b30e371a4bb08432511f05047f0afdc28b3d96d6b7314f60208a38fd2b9aa

heroku config:set DB_CONNECTION=$DB_CONNECTION --app=$HEROKU_APP
heroku config:set DB_HOST=$DB_HOST --app=$HEROKU_APP
heroku config:set DB_PORT=$DB_PORT --app=$HEROKU_APP
heroku config:set DB_DATABASE=$DB_DATABASE --app=$HEROKU_APP
heroku config:set DB_USERNAME=$DB_USERNAME --app=$HEROKU_APP
heroku config:set DB_PASSWORD=$DB_PASSWORD --app=$HEROKU_APP
