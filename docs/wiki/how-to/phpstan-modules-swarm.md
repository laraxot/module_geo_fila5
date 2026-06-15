---
title: "PHPStan swarm — analisi parallela per modulo"
type: how-to
tags: [phpstan, swarm, parallel, larastan]
created: 2026-06-15
updated: 2026-06-15
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
SWARM_RANDOM=1 SWARM_JOBS=8 bash bashscripts/tools/phpstan-modules-swarm.sh
```

Singolo modulo:

```bash
bash bashscripts/tools/phpstan-modules-swarm.sh Sigma
```

Env automatici: `CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file` (no Redis per Larastan bootstrap).

## Tuning

| Variabile | Default | Note |
|-----------|---------|------|
| `SWARM_JOBS` | `nproc/2` (max 12) | 8 stabile su 45GB RAM |
| `PHPSTAN_MEMORY` | `2G` | Per processo modulo |
| `SWARM_RANDOM` | `0` | `1` randomizza la coda dei moduli |

## Benchmark (2026-06-15)

- Swarm 8 job: **35/35 OK**, wall **~83s**
- Gate sequenziale: **~7 min**

## Vietato

- `phpstan analyse Modules/` monolitico senza fix neon parallel
- Modificare `phpstan.neon` dagli agenti
