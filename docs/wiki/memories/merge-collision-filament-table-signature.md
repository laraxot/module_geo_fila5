---
title: getTableColumns — sempre public function (Filament)
type: memory
tags: [filament, merge, xot, tables]
updated: 2026-05-26
related:
  - ../concepts/xotbase-table-columns-enforcement.md
  - ../rules/gettablecolumns-keys-rule.md
  - ../../laravel/Modules/Notify/docs/wiki/memories/merge-collision-notify-lessons.md
---

# `getTableColumns()` — canon Filament (non static)

## Filosofia

Laraxot + Filament v5: colonne tabella su classi `*Table extends XotBaseResourceTable` con metodo di **istanza**, allineato a `HasXotTable` e al lifecycle Filament.

**Mai** `public static function getTableColumns(): array` in `*Table.php`.

## Conflitto merge tipico

| Lato | Firma | Azione |
|------|-------|--------|
| HEAD | `static` | Scartare solo il keyword `static` |
| Incoming | `public function` | Tenere questa firma |
| Corpo array colonne | Di solito HEAD | Tenere chiavi stringa + colonne |

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/<Nome> --memory-limit=2G
```

Fatal tipico se si lascia `static`: *Cannot make non static method … static in class …*

## Errore agente (2026-05-26)

Documentazione e merge avevano suggerito «HEAD» includendo `static` — corretto in codice e wiki: **istanza sempre**.
