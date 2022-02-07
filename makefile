default:
	make start

build:
	npm run prod

build-dev:
	npm run dev

install:
	cp docker-compose.override-example.yaml docker-compose.override.yaml
	cp .env.example .env
	make install-deps
	php artisan key:generate
	make start
	make migrate
	make build
	NETWORK=syllabus .bin/php artisan accounts:create-user

install-deps:
	composer install
	npm ci

migrate:
	NETWORK=syllabus php artisan migrate

start:
	docker compose up -d

stop:
	docker compose down
