#!/bin/sh

php bin/console cache:clear
php bin/console doctrine:database:create || true
#php bin/console doctrine:schema:update -f --complete
php bin/console doctrine:migrations:migrate --no-interaction
