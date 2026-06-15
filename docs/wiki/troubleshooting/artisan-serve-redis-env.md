---
title: "artisan serve — Redis e variabili shell"
type: troubleshooting
tags: [laravel, redis, artisan-serve, opcache, wsl]
created: 2026-06-15
updated: 2026-06-15
qmd: "artisan serve redis connection refused CACHE_STORE SESSION_DRIVER opcache"
related:
  - ../memories/phpstan-modules-inventory.md
  - ../../bashscripts/tools/artisan-serve-dev.sh
---

# artisan serve — errori Redis / cache

## Sintomi tipici

```text
Connection refused [tcp://127.0.0.1:6379]
Predis\Connection\Resource\Exception\StreamInitException
```

In `storage/logs/laravel.log` durante bootstrap o prima richiesta HTTP.

## Cause (investigate, non assumere)

| Causa | Evidenza |
|-------|----------|
| **Redis non in ascolto** | `redis-cli ping` → `Connection refused` |
| **systemd vs istanza manuale** | `redis-server.service` failed + log `Address already in use` su 6379 |
| **`.env` Laravel 13** | `CACHE_DRIVER=redis` **non basta** — serve `CACHE_STORE=redis` (`config/cache.php`) |
| **Override shell** | `env \| rg CACHE_DRIVER` → `file` sovrascrive `.env` (agenti PHPStan) |

## OPcache

Già installato: `php -m | rg -i opcache`.  
`opcache.enable=On` (FPM/web); `opcache.enable_cli=Off` è normale per CLI — **non** è la causa degli errori Redis.

## Fix operativo (WSL senza sudo)

```bash
# 1) Redis
redis-server --daemonize yes --bind 127.0.0.1 --port 6379 --dir /tmp --logfile /tmp/redis-dev.log
redis-cli ping   # PONG

# 2) .env (Laravel 13)
CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_CLIENT=predis

# 3) Serve senza override shell
unset CACHE_DRIVER SESSION_DRIVER
cd laravel && php artisan serve
```

Script unificato: `bash bashscripts/tools/artisan-serve-dev.sh`

## Con sudo (produzione locale)

```bash
redis-cli shutdown nosave
sudo systemctl start redis-server
sudo systemctl enable redis-server
```

## PHPStan / Larastan bootstrap

Larastan avvia Laravel durante l'analisi. Con `.env` su Redis e **Redis spento** (o `CACHE_STORE=redis` senza server):

```text
Laravel framework bootstrap failed
Connection refused [tcp://127.0.0.1:6379]
```

**Fix (senza toccare `phpstan.neon`):**

```bash
cd laravel
CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file \
  php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Sigma
```

Oppure:

```bash
bash bashscripts/tools/phpstan-module.sh Sigma
```

Laravel 13: `config/cache.php` legge **`CACHE_STORE`**, non solo `CACHE_DRIVER`.

## PHPStan vs dev serve

Per PHPStan usare **tutte e tre** le variabili — solo sul comando gate:

```bash
CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file bash bashscripts/tools/phpstan-modules-gate.sh
# singolo modulo:
bash bashscripts/tools/phpstan-module.sh Sigma
```
