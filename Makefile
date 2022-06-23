up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear blog-clear docker-pull docker-build docker-up blog-init
test: blog-test
test-unit: blog-test-unit

cli:
	docker-compose run --rm blog-php-cli $(c)

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

blog-init: blog-composer-install blog-wait-db blog-migrations blog-fixtures blog-ready

blog-clear:
	docker run --rm -v "${PWD}/blog:/app" --workdir=/app alpine rm -f .ready

blog-composer-install:
	docker-compose run --rm blog-php-cli composer install

blog-wait-db:
	until docker-compose exec -T blog-mysql mysqladmin ping -h 127.0.0.1 --silent; do sleep 1 ; done

blog-migrations:
	docker-compose run --rm blog-php-cli php bin/console doctrine:migrations:migrate --no-interaction

blog-fixtures:
	docker-compose run --rm blog-php-cli php bin/console doctrine:fixtures:load --no-interaction

blog-ready:
	docker run --rm -v "${PWD}/blog:/app" --workdir=/app alpine touch .ready

blog-test:
	docker-compose run --rm blog-php-cli php bin/phpunit

blog-test-unit:
	docker-compose run --rm blog-php-cli php bin/phpunit --testsuite=unit
