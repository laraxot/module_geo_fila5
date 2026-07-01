---
title: "PHPStan swarm — analisi parallela per modulo"
type: how-to
tags: [phpstan, swarm, parallel, larastan]
created: 2026-06-15
updated: 2026-07-01
qmd: "phpstan swarm parallel moduli SWARM_JOBS gate"
related:
  - ../memories/phpstan-modules-inventory.md
  - ../troubleshooting/phpstan-parallel-worker-oom.md
  - ../../bashscripts/tools/phpstan-modules-swarm.sh
---

# PHPStan swarm

## Perché

| Comando | Problema |
|---------|----------|
| `phpstan analyse Modules/` | OOM worker 512M (parallel interno PHPStan) |
| Gate sequenziale | Lento (~7 min / 35 moduli) |
| **Swarm** | **1 processo PHPStan per modulo**, N moduli in parallelo |

## Uso

```bash
cd /var/www/_bases/base_ptvx_fila5
SWARM_JOBS=2 bash bashscripts/tools/phpstan-modules-swarm.sh
```

Esclusi default: `Incentivi`, `Pdnd` (`SWARM_SKIP_MODULES`). Neon effimero: `parallel.maximumNumberOfProcesses: 0` + `tmpDir` isolato per worker.

Ordine moduli random (default `SWARM_RANDOM=1`):

```bash
SWARM_RANDOM=0 SWARM_JOBS=4 bash bashscripts/tools/phpstan-modules-swarm.sh
```

Singolo modulo:

```bash
bash bashscripts/tools/phpstan-modules-swarm.sh Sigma
```

Env automatici: `CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file` (no Redis per Larastan bootstrap).

## Tuning

| Variabile | Default | Note |
|-----------|---------|------|
| `SWARM_JOBS` | `4` (max 8) | 4 stabile; 8 più veloce ma più RAM |
| `PHPSTAN_MEMORY` | `2G` | Per processo modulo |
| `SWARM_RANDOM` | `1` | `0` = ordine glob `Modules/*/` |

## Isolamento cache (anti-race)

Ogni worker genera un neon effimero in `/tmp/phpstan-swarm-$$/` con `tmpDir` dedicato (`cache-<Modulo>/`). Evita errori interni «Could not read file» quando più PHPStan condividevano `/tmp/phpstan/`.

Moduli esclusi in `phpstan.neon` (`Pdnd`, `Incentivi`) → `[SKIP] excluded`, non contano come FAIL.

## Benchmark (2026-06-15)

- Swarm 4 job + cache isolata: **33 OK + 2 SKIP**, wall **~342s** (Sigma/Performance/Xot OK)
- Swarm 8 job (cache condivisa, legacy): falsi FAIL su race I/O
- Gate sequenziale: **~7 min**

## Vietato

- `phpstan analyse Modules/` monolitico senza fix neon parallel
- Modificare `phpstan.neon` dagli agenti
