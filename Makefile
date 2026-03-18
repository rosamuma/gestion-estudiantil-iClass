# ── EduPlatform Docker Commands ─────────────────────────────────────────────

.PHONY: up down build fresh logs shell migrate seed key

## Levantar todos los contenedores
up:
	cp -n .env.docker .env || true
	docker compose up -d

## Parar contenedores
down:
	docker compose down

## Rebuild completo (si cambias Dockerfile)
build:
	docker compose up -d --build

## Primer arranque completo (build + migrate + seed)
fresh:
	cp .env.docker .env
	docker compose up -d --build
	sleep 10
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate:fresh --seed
	@echo ""
	@echo "✅  EduPlatform listo en: http://localhost:8000"
	@echo "📊  phpMyAdmin en:        http://localhost:8080"
	@echo ""
	@echo "   admin@edu.com    / password123  (Admin)"
	@echo "   garcia@edu.com   / password123  (Docente)"
	@echo "   ana@edu.com      / password123  (Estudiante)"

## Ver logs en vivo
logs:
	docker compose logs -f app nginx

## Abrir shell en el contenedor app
shell:
	docker compose exec app bash

## Solo migrar
migrate:
	docker compose exec app php artisan migrate

## Solo seedear
seed:
	docker compose exec app php artisan db:seed

## Generar APP_KEY
key:
	docker compose exec app php artisan key:generate

## Limpiar caché
clear:
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan view:clear

## Ver estado de contenedores
ps:
	docker compose ps
