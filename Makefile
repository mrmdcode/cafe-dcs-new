# ------------------------------------------
# Docker Management Makefile
# ------------------------------------------

SHELL := /bin/bash

.PHONY: start start-bg stop build rebuild logs shell migrate seed fresh artisan npm-build status clean help

start:
	@echo "Starting the application..."
	docker-compose up

start-bg:
	@echo "Starting the application in background..."
	docker-compose up -d

stop:
	@echo "Stopping the application..."
	docker-compose down

build:
	@echo "Building and starting the application..."
	docker-compose up --build

rebuild:
	@echo "Rebuilding the application..."
	docker-compose down
	docker-compose up --build

logs:
	@if [ -z "$(service)" ]; then \
		docker-compose logs; \
	else \
		docker-compose logs $(service); \
	fi

shell:
	@echo "Accessing app container shell..."
	docker-compose exec app bash

migrate:
	@echo "Running database migrations..."
	docker-compose exec app php artisan migrate

seed:
	@echo "Seeding the database..."
	docker-compose exec app php artisan db:seed

fresh:
	@echo "Fresh migration with seeding..."
	docker-compose exec app php artisan migrate:fresh --seed

artisan:
	@echo "Running artisan command..."
	docker-compose exec app php artisan $(cmd)

npm-build:
	@echo "Running npm run build..."
	docker-compose exec app npm run build

status:
	@echo "Container status:"
	docker-compose ps

clean:
	@echo "Cleaning up Docker resources..."
	docker-compose down --volumes --remove-orphans
	docker system prune -f

help:
	@echo ""
	@echo "Docker Management (Makefile)"
	@echo ""
	@echo "Available commands:"
	@echo "  make start            - Start the application"
	@echo "  make start-bg         - Start in background"
	@echo "  make stop             - Stop the application"
	@echo "  make build            - Build and start"
	@echo "  make rebuild          - Rebuild everything"
	@echo "  make logs service=name - Show logs"
	@echo "  make shell            - Enter app container"
	@echo "  make migrate          - Run migrations"
	@echo "  make seed             - Seed database"
	@echo "  make fresh            - Fresh migrate + seed"
	@echo "  make artisan cmd=XXX  - Run artisan command"
	@echo "  make npm-build        - Run npm build"
	@echo "  make status           - Container status"
	@echo "  make clean            - Full cleanup"
	@echo ""
	@echo "Services:"
	@echo "  App: http://localhost:8000"
	@echo "  phpMyAdmin: http://localhost:8080"
