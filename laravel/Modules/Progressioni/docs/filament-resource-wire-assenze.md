# Wire manuale — AssenzeResource (pilota fase 3, **non ancora applicato**)

## Scopo

Guida per la **fase 3** del modulo **Progressioni**: collegare Resource e List page alle classi in `Schemas/` e `Tables/` **senza script**.

**Regola durante la conversione:** finché la fase 3 non è esplicitamente completata per una risorsa, **`AssenzeResource.php` e `ListAssenza.php` restano la sorgente operativa** (schema inline). Le classi `AssenzaForm` / `AssenzeTable` contengono solo la **copia** prodotta in fase 2 e non sostituiscono il runtime.

**Modello:** `Modules\Progressioni\Models\Assenza`  
**Resource:** `AssenzeResource`  
**List page:** `ListAssenza` (estende `PtvBaseYearListRecords`)

## Perché Assenze come pilota

- CRUD semplice (7 campi form / 7 colonne tabella).
- Nessun infolist popolato (solo scaffold vuoto).
- List page con override solo su `getTableColumns()` — nessun filtro custom locale.
- Filtro anno ereditato da `PtvBaseYearListRecords` (`yearFieldName = 'anno'`).

## Convenzione nome Form (discovery Xot)

`XotBaseResource::form()` risolve la classe form come:

`{ResourceNamespace}\Schemas\{ModelBasename}Form`

Per modello `Assenza` → **`AssenzaForm`**, non `AssenzeForm`.

| File | Classe |
| :--- | :--- |
| `Schemas/AssenzaForm.php` | `AssenzaForm` |

Rinominato manualmente da `AssenzeForm.php` (fase 2 usava il nome della Resource).

## Passi da eseguire (fase 3 — quando si decide di wire)

### 1. Verificare parità fase 2

Confrontare `AssenzaForm::getFormSchema()` con `AssenzeResource::getFormSchema()` e `AssenzeTable::getTableColumns()` con `ListAssenza::getTableColumns()`. Devono essere equivalenti prima di delegare.

### 2. Delega form sulla Resource

Solo dopo verifica:

```php
use Modules\Progressioni\Filament\Resources\AssenzeResource\Schemas\AssenzaForm;

public static function getFormSchema(): array
{
    return AssenzaForm::getFormSchema();
}
```

### 3. Delega colonne su ListAssenza

```php
use Modules\Progressioni\Filament\Resources\AssenzeResource\Tables\AssenzeTable;

public function getTableColumns(): array
{
    return app(AssenzeTable::class)->getTableColumns();
}
```

### 4. Pulizia AssenzeTable — solo colonne

Non aggiungere `getTableFilters()` in `AssenzeTable` se il filtro anno è già su `PtvBaseYearListRecords`. `getTableFilters()` nella Table non deve referenziare `$this->yearFieldName` (proprietà della List page).

## Stato attuale

| File | Fase 3 wire |
| :--- | :---: |
| `AssenzeResource.php` | ❌ schema inline (sorgente attiva) |
| `ListAssenza.php` | ❌ colonne inline (sorgente attiva) |
| `Schemas/AssenzaForm.php` | ✅ copia fase 2 |
| `Tables/AssenzeTable.php` | ✅ copia fase 2 (solo colonne) |

## Verifica dopo il wire

1. Panel Filament: lista Assenze — colonne e filtro anno.
2. Create/Edit: stessi 7 campi di prima.
3. `vendor/bin/pint --dirty` sui file modificati.

## Prossima risorsa

Dopo Assenze wire: ripetere su una risorsa CRUD semplice (es. `CoeffResource`), poi List con override, infine `ProgressioniResource` / `SchedaResource`.

## Collegamenti

- [filament-resource-schemas-tables](./filament-resource-schemas-tables.md)
- [PtvBaseYearListRecords](../../Ptv/app/Filament/Resources/Pages/PtvBaseYearListRecords.php)
- [XotBaseResource](../../Xot/app/Filament/Resources/XotBaseResource.php)

*Ultimo aggiornamento: giugno 2025*
