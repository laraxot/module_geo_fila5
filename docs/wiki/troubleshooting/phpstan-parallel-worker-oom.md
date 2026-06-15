---
title: "PHPStan — OOM worker paralleli su analyse Modules"
type: troubleshooting
tags: [phpstan, oom, memory, parallel, larastan]
created: 2026-06-15
updated: 2026-06-15
qmd: "phpstan OOM 536870912 parallel worker memory Modules gate"
related:
  - ../memories/phpstan-modules-inventory.md
  - ../guidelines/phpstan-config-immutability.md
  - ../../bashscripts/tools/phpstan-modules-gate.sh
---

# PHPStan — OOM worker paralleli

## Sintomo

```text
Child process error (exit code 255): Allowed memory size of 536870912 bytes exhausted
 while running parallel worker
```

Con `./vendor/bin/phpstan analyse Modules/` (1280 file, parallel default).

## Causa

PHPStan avvia **N worker** (≈ numero core). Ogni worker ha budget memoria proprio; su setup WSL spesso **512M** per processo figlio — insufficiente per moduli grandi (Sigma, User, Xot) anche con `--memory-limit=2G` sul comando principale.

`phpstan.neon` ha `parallel` commentato → PHPStan usa default multi-process.

## Soluzione operativa (agenti — senza toccare `phpstan.neon`)

```bash
# Gate canonico — sequenziale per modulo
bash bashscripts/tools/phpstan-modules-gate.sh

# Singolo modulo
bash bashscripts/tools/phpstan-modules-gate.sh Ptv

# Env
CACHE_DRIVER=file SESSION_DRIVER=file PHPSTAN_MEMORY=2G bash bashscripts/tools/phpstan-modules-gate.sh
```

## Alternativa utente (modifica `phpstan.neon` — solo umano)

```neon
parameters:
    parallel:
        maximumNumberOfProcesses: 1
```

Più `--memory-limit=2G` sul CLI. File wrapper opzionale: `laravel/phpstan-gate.neon` (include `phpstan.neon`).

## Vietato agli agenti

Modificare `laravel/phpstan.neon` per aggirare OOM → usare gate script o chiedere all'utente.

## Collegamenti

- [phpstan-modules-inventory.md](../memories/phpstan-modules-inventory.md)
