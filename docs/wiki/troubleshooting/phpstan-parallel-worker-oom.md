---
title: "PHPStan — OOM worker paralleli su analyse Modules"
type: troubleshooting
tags: [phpstan, oom, memory, parallel, larastan]
created: 2026-06-15
updated: 2026-06-18
qmd: "phpstan OOM 536870912 parallel worker memory Modules gate"
related:
  - ../rules/phpstan-single-neon-config.md
  - ../memories/phpstan-modules-inventory.md
  - ../../bashscripts/tools/phpstan-modules-gate.sh
---

# PHPStan — OOM worker paralleli

## Sintomo

```text
Child process error (exit code 255): Allowed memory size of 536870912 bytes exhausted
 while running parallel worker
```

Con `./vendor/bin/phpstan analyse Modules/` e molti file (es. 3000+), parallel default.

## Causa

1. **`--memory-limit=-1` è controproducente** — i worker figli restano spesso a **512M** (`536870912` bytes).
2. PHPStan avvia **N worker** (≈ numero core). Ogni worker ha budget memoria proprio.
3. `phpstan.neon` senza `parallel` esplicito → default multi-process.
4. **Xdebug attivo** aumenta il consumo: usare `php -d xdebug.mode=off`.

## Fix immediato (monolite)

```bash
cd laravel
php -d xdebug.mode=off -d memory_limit=2G \
  ./vendor/bin/phpstan analyse Modules/ \
  --memory-limit=2G
```

Usa **solo** `laravel/phpstan.neon` (auto-discovery). **Mai** `-c altro.neon` né file wrapper. **Mai** `--memory-limit=-1` su scan ampi.

## Soluzione operativa (agenti — senza toccare `phpstan.neon`)

```bash
# Gate canonico — sequenziale per modulo
bash bashscripts/tools/phpstan-modules-gate.sh

# Swarm parallelo (preferito se serve velocità)
SWARM_JOBS=4 bash bashscripts/tools/phpstan-modules-swarm.sh

# Singolo modulo
bash bashscripts/tools/phpstan-modules-gate.sh Ptv

# Env
CACHE_DRIVER=file SESSION_DRIVER=file PHPSTAN_MEMORY=2G bash bashscripts/tools/phpstan-modules-gate.sh
```

## Alternativa utente (solo umano)

Modificare `parallel` **dentro** `laravel/phpstan.neon` se serve — **non** creare altri file `.neon`.

Vedi [phpstan-single-neon-config.md](../rules/phpstan-single-neon-config.md).

## Vietato agli agenti

- Modificare `laravel/phpstan.neon`
- Creare wrapper `.neon` (`phpstan-gate.neon`, ecc.)
- Usare `-c` con config diversa da `phpstan.neon`

Per OOM → gate script per modulo (vedi sopra).

## Race cache con swarm (non OOM)

Sintomo: errori interni `Could not read file …` su moduli grandi (Sigma, Performance) con `SWARM_JOBS>1` e `tmpDir` condiviso `/tmp/phpstan/`.

Fix: `phpstan-modules-swarm.sh` con `tmpDir` isolato. Vedi [phpstan-modules-swarm.md](../how-to/phpstan-modules-swarm.md).

## Collegamenti

- [phpstan-single-neon-config.md](../rules/phpstan-single-neon-config.md)
- [phpstan-modules-inventory.md](../memories/phpstan-modules-inventory.md)
