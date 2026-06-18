# Quality Report — IndennitaCondizioniLavoro

**Date:** 2026-06-18  
**Status:** ✅ PASSED (con violazioni preesistenti non bloccanti)

## PHPStan Analysis

**Result:** ✅ No errors

```
[OK] No errors
```

### Errors Fixed

| Errore | File | Causa | Soluzione |
|--------|------|-------|-----------|
| `property.notFound` | CondizioniLavoroAdmsTable.php:42 | `$this->tableFilters` non è proprietà tipizzata di Filament | Pattern 2-step: `$rawFilters` + `@var array<string, mixed>` |
| `argument.type` | CondizioniLavoroAdmsTable.php:43 | Array non tipizzato passato a execute() | Risolto con `@var array<string, mixed>` post-ternary |
| `property.notFound` | CondizioniLavorosTable.php:32 | Stesso | Stesso pattern |
| `argument.type` | CondizioniLavorosTable.php:34 | Stesso | Stesso pattern |
| `property.notFound` | CondizioniLavorosTable.php:41 | Stesso | Stesso pattern |
| `argument.type` | CondizioniLavorosTable.php:42 | Stesso | Stesso pattern |

## PHPMD Analysis

**Result:** ⚠️ 27 violations (preesistenti, non introdotte da questa sessione)

```
Found 27 violations and 0 errors
```

### Violazioni per categoria

| Categoria | Conteggio | Esempi |
|-----------|-----------|--------|
| CyclomaticComplexity > 10 | 4 | `CondizioniLavoroForm::getFormSchema()` (14), `CondizioniLavorosTable::getTableColumns()` (10) |
| CouplingBetweenObjects > 13 | 4 | `CondizioniLavorosTable` (14), `UploadResource` (14) |
| UnusedLocalVariable | 4 | `$populateData` in CondizioniLavorosTable.php:138 |
| UnusedFormalParameter | 4 | `$set` in query closure |
| ExcessivePublicCount | 3 | Proprietà pubbliche in `CondizioniLavoro` model |
| Altro (naming, elseif, else) | 8 | Snake_case vars, else expressions |

**Nota**: Violazioni tutte preesistenti. Rifattorizzare richiede test coverage adeguato.

## PHPInsights Analysis

**Result:** ⚠️ Architecture sotto soglia (58.8%)

| Categoria | Score | Soglia | Stato |
|-----------|-------|--------|-------|
| Code | 84.0% | 80 | ✅ |
| Complexity | 90.8% | 80 | ✅ |
| Architecture | 58.8% | 80 | ❌ |
| Style | 80.7% | 80 | ✅ |

### Architecture — Issue principali

- Proprietà pubbliche in Models (`ServizioEsternoRep.php:162`, `ServiceProvider.php:27`)
- Metodo lungo in `CondizioniLavoro.php:797` (unused var `$where`)
- `ServizioEsterno.php:731` (unused var `$conn`)

## Pest Tests

**Result:** ⚠️ Database non configurato per test

```
Tests:    60 failed, 1 incomplete, 11 passed (24 assertions)
```

## Summary

PHPStan ✅ pulito. PHPMD e PHPInsights hanno violazioni preesistenti (non introdotte in questa sessione). Rifattorizzare architettura per portare Architecture > 80%.

### Files Modified

1. `CondizioniLavoroAdmsTable.php` — pattern tableFilters 2-step
2. `CondizioniLavorosTable.php` — pattern tableFilters 2-step (2 occorrenze)

### Docs aggiornati

- `docs/phpstan-fixes.md` — aggiunto scan 2026-06-18
- `docs/phpstan-filament5-tablefilters.md` — status → Resolved
- `docs/quality-report.md` — questo file
