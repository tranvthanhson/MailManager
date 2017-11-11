#!/bin/bash

HEROKU_APP=

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

heroku config:set DB_CONNECTION=$DB_CONNECTION --app=$HEROKU_APP
heroku config:set DB_HOST=$DB_HOST --app=$HEROKU_APP
heroku config:set DB_PORT=$DB_PORT --app=$HEROKU_APP
heroku config:set DB_DATABASE=$DB_DATABASE --app=$HEROKU_APP
heroku config:set DB_USERNAME=$DB_USERNAME --app=$HEROKU_APP
heroku config:set DB_PASSWORD=$DB_PASSWORD --app=$HEROKU_APP
