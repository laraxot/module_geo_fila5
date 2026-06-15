---
title: "censimento omonimi metodi — modulo Setting"
type: analysis
module: Setting
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Setting

> **26** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Setting)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 17 |
| `E_scheda_stack` | 1 |
| `H_cross_module_homonym` | 8 |

## Dettaglio

### `A_filament_framework` (17 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Setting` · `SettingBasePolicy` · `Modules/Setting/app/Models/Policies/SettingBasePolicy.php`

### `H_cross_module_homonym`

#### `getRows` — 11 classi

- `Setting` · `DatabaseConnection` · `Modules/Setting/app/Models/DatabaseConnection.php`

#### `active` — 10 classi

- `Setting` · `DatabaseConnectionFactory` · `Modules/Setting/database/factories/DatabaseConnectionFactory.php`

#### `inactive` — 7 classi

- `Setting` · `DatabaseConnectionFactory` · `Modules/Setting/database/factories/DatabaseConnectionFactory.php`

#### `afterSave` — 6 classi

- `Setting` · `EditDatabaseConnection` · `Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/EditDatabaseConnection.php`

#### `getRedirectUrl` — 5 classi

- `Setting` · `CreateDatabaseConnection` · `Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/CreateDatabaseConnection.php`
- `Setting` · `EditDatabaseConnection` · `Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/EditDatabaseConnection.php`

#### `download` — 4 classi

- `Setting` · `BackupMysql` · `Modules/Setting/app/Filament/Pages/BackupMysql.php`

#### `afterCreate` — 2 classi

- `Setting` · `CreateDatabaseConnection` · `Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/CreateDatabaseConnection.php`

#### `configureEmailVerification` — 2 classi

- `Setting` · `EventServiceProvider` · `Modules/Setting/app/Providers/EventServiceProvider.php`




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
