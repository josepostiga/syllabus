default:
	make start

install:
	cp docker-compose.override-example.yaml docker-compose.override.yaml
	cp .env.example .env
	composer install
	npm ci
	php artisan key:generate
	make start
	make migrate

migrate:
	NETWORK=syllabus php artisan migrate

start:
	docker compose up -d

stop:
	docker compose down
