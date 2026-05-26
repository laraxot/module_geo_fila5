---
title: XotBaseResourceTable — getTableColumns Filament
type: concept
tags: [filament, xot, tables, phpstan]
updated: 2026-05-26
related:
  - ../rules/gettablecolumns-keys-rule.md
  - ../rules/filament-rules-summary.md
  - ../memories/merge-collision-filament-table-signature.md
---

# `getTableColumns()` — filosofia Filament + Laraxot

## Regola assoluta

Nelle classi `*Table` che estendono `XotBaseResourceTable`:

```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->sortable(),
    ];
}
```

| Vietato | Motivo |
|---------|--------|
| `public static function getTableColumns()` | Fatal PHP: parent `XotBaseResourceTable` e trait `HasXotTable` usano metodo di **istanza**; Filament/Livewire risolvono colonne sull’oggetto tabella |

## Dove vive il metodo

- **Sì:** `app/Filament/Resources/<Resource>/Tables/<Name>Table.php`
- **No:** `XotBaseResource` (Resource PHP) — colonne nella classe `*Table` dedicata
- **No:** `ListRecords` con override statico dello stesso nome (vedi doc Activity su errori static/instance)

## Base class

`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`:

```php
abstract public function getTableColumns(): array;
```

## Merge collision

Se HEAD ha `static` e incoming ha `public function`: **corpo colonne da HEAD**, **firma `public function`** — vedi [memoria merge](../memories/merge-collision-filament-table-signature.md).

## Verifica agente

```bash
cd laravel
# Nessun static su *Table.php (escluso getTableColumnsSchema e simili)
! git grep -n 'public static function getTableColumns' -- 'Modules/*/app/**/Tables/*Table.php'
./vendor/bin/phpstan analyse Modules/<Nome> --memory-limit=2G
```

Riferimento codice: `Modules/Job/.../FailedJobsTable.php`, `Modules/Notify/.../ContactsTable.php`.
