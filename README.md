# Laravel Docker Setup Guide

## Prerequisites
- Docker installed
- Docker Compose installed

---

## First Time Setup

After running `docker compose up -d` for the first time, follow these steps:

### 1. Install Composer Dependencies

```bash
docker compose exec app composer install
```

### 2. Generate Application Key

```bash
docker compose exec app php artisan key:generate
```

### 3. Run Database Migrations

```bash
docker compose exec app php artisan migrate
```

### 4. Fix Storage Permissions

```bash
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### 5. Create Storage Symlink

```bash
docker compose exec app php artisan storage:link
```

### 6. Clear Caches

```bash
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan view:clear
```

---

## All Steps in One Block

You can copy and run all commands at once:

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
docker compose exec app php artisan storage:link
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan view:clear
```

---

## Everyday Usage

### Start containers
```bash
docker compose up -d
```

### Stop containers
```bash
docker compose down
```

### View logs
```bash
docker compose logs -f
```

### Rebuild containers (after Dockerfile changes)
```bash
docker compose up -d --build
```

---

## Troubleshooting

### Permission denied on storage/logs
```bash
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Enter the container shell
```bash
docker compose exec app bash
```

### Check PHP extensions
```bash
docker compose exec app php -m
```
