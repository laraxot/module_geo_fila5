# Modulo Progressioni

## Overview

Il modulo **Progressioni** gestisce le schede di valutazione e la logica di progressione economica.

## Regole Chiave

1. I model PHP sono singolari (`Scheda`, non `Schede`).
2. Le tabelle restano plurali (`schede`).
3. Le risorse Filament puntano sempre al model singolare.
4. Dopo rename di model o file class-based va sempre rigenerato l'autoload Composer prima di eseguire `ide-helper`, altrimenti possono restare classmap stale verso path rimossi come `app/Models/Schede.php`.

## Documenti Da Leggere Prima Di Modificare

- [00-index.md](./00-index.md)
- [rename-schede-to-scheda.md](./rename-schede-to-scheda.md)
- [architecture-rules.md](./architecture-rules.md)
- [phpstan-errors-systematic-fix-plan.md](./phpstan-errors-systematic-fix-plan.md)

## Struttura

```text
Progressioni/
├── app/
├── database/
├── docs/
├── lang/
└── resources/
```

## Backlinks

- [Indice Moduli](../README.md)
