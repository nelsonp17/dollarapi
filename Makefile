build:
	docker build -f php.Dockerfile -t midolar-php:latest .
	docker build -f nginx.Dockerfile -t midolar-nginx:latest .

run:
	docker compose -f docker-compose.yml up -d php-mydolar nginx-mydolar --build db

deps:
	docker exec -u 1000 -i midolar-php /bin/sh -c "composer install --ignore-platform-req=ext-intl"

down:
	docker compose -f docker-compose.yml down