# XotBaseResource Pattern

## Panoramica

`XotBaseResource` estende `Resource` di Filament e centralizza configurazione comune (DRY).

## Metodi Finali (NON sovrascrivere)

- `form()` — delegato a `getFormSchema()`
- `table()` — delegato a `XotBaseListRecords::getListTableColumns()`

## Metodi da Implementare nella Resource

- `getFormSchema(): array` — schema del form (obbligatorio)

## Metodi NON Necessari nella Resource

- `getTableColumns()` — **NON richiesto**, gestito da `XotBaseListRecords::getListTableColumns()` nella pagina ListRecords
- `getPages()` — NON necessario se standard (CRUD)
- `getTableActions()` — NON necessario se standard
Il `XotBaseResource` è una classe astratta che estende il `Resource` di Filament e fornisce una base comune per tutte le risorse dei moduli. Questo pattern segue il principio DRY (Don't Repeat Yourself) centralizzando la configurazione comune delle risorse.

## Caratteristiche Principali

### 1. Metodi Finali
- Il metodo `form()` è dichiarato come `final` e non può essere sovrascritto
- Utilizzare `getFormSchema()` per personalizzare lo schema del form
- Il metodo `table()` è dichiarato come `final` e non può essere sovrascritto
- Utilizzare `getTableColumns()` per personalizzare le colonne della tabella

### 2. Metodi da Implementare
- `getFormSchema()`: array - Definisce lo schema del form
- `getTableColumns()`: array - Definisce le colonne della tabella
- `getRelations()`: array - Definisce le relazioni della risorsa
- `getPages()`: array - Definisce le pagine associate alla risorsa

### 3. Personalizzazione
Ogni modulo può personalizzare:
- Lo schema del form attraverso `getFormSchema()`
- Le colonne della tabella attraverso `getTableColumns()`
- Le relazioni attraverso `getRelations()`
- Le pagine attraverso `getPages()`

## Utilizzo

```php
namespace Modules\YourModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

use Modules\Xot\Filament\Resources\XotBaseResource;

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    public static function getFormSchema(): array
    {
        return [
            // Definisci qui lo schema del form
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            // Definisci qui le colonne della tabella
        ];
    }
    // getTableColumns() NON necessario - gestito da XotBaseListRecords
}
```

## Best Practices

1. NON sovrascrivere `form()` e `table()` (sono `final`)
2. Le colonne tabella vanno in `ListRecords::getListTableColumns()`, NON nella Resource
3. Namespace: `Modules\{ModuleName}\Filament\Resources`
4. `declare(strict_types=1)` obbligatorio

Per la guida completa: `filament-class-extension-rules.md`
1. Non sovrascrivere i metodi `form()` e `table()`
2. Utilizzare i metodi `getFormSchema()` e `getTableColumns()` per la personalizzazione
3. Mantenere la coerenza dei namespace seguendo la convenzione `Modules\{ModuleName}\Filament\Resources`
4. Documentare eventuali personalizzazioni specifiche del modulo

## Note Tecniche
- Il resource utilizza `strict_types=1`
- Supporta la configurazione dei metatag attraverso `MetatagData`
- Integra con il sistema di moduli Laravel attraverso la configurazione `modules.namespace`