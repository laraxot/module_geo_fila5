---
title: "Job Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-06-05
---

# Modulo Job

## Overview

Il modulo **Job** gestisce i job asincroni e le code di elaborazione.

## Funzionalità

- Job queue management
- Retry logic
- Failed job handling
- Job monitoring

## Modelli Principali

```php
// Job
Job\Models\Job

// Failed Job
Job\Models\FailedJob

// Job Batch
Job\Models\JobBatch
```

## Services

```php
// Job dispatcher
Job\Services\JobDispatcher

// Queue manager
Job\Services\QueueManager
```

## Collegamenti

- [Documentazione Root](../../../docs/JOB_MODULE.md)
- [Xot Base](../Xot/docs/)
- [Notify Module](../Notify/docs/) - per notifiche job

## Backlinks

- [Queue Config](./queue/)
- [Failed Jobs](./failed/)
---

## ✅ PHPStan Status — Verifica 2026-07-01

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/Job --level=max --memory-limit=512M
# [OK] No errors
```

Modulo conforme alle regole Laraxot:
- Classi Filament estendono XotBase (mai direttamente Filament)
- Nessun label/placeholder/tooltip hardcoded
- Nessun BadgeColumn (usa TextColumn::make()->badge())
- Actions usano QueueableAction pattern
- Nessun Service tradizionale
