# Scheda Resource — ereditarietà pagine Filament

## Scopo

Le pagine CRUD delle risorse che estendono `BaseSchedaResource` (Ptv, Progressioni, Performance) condividono comportamento tramite classi base nel modulo **Ptv**. Evita duplicazione e mantiene allineati list/create/edit tra moduli.

## Regola

| Classe concreta nel modulo | Deve estendere (namespace Ptv) | Non estendere |
| :--- | :--- | :--- |
| `ListSchedas` | `Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseListSchedas` | `XotBaseListRecords` |
| `EditScheda` | `BaseEditScheda` | `XotBaseEditRecord`, `EditRecord` |
| `CreateScheda` | `BaseCreateScheda` | `XotBaseCreateRecord`, `CreateRecord` |

La classe concreta imposta solo `protected static string $resource` sulla propria Resource e, se serve, override di `getTable*()`, `getHeaderActions()`, ecc.

## Naming index

`XotBaseResource::getPages()` risolve l'index come `List{plural}` → per `SchedaResource` la page è **`ListSchedas`**, non `ListScheda`.

`ListScheda` in Ptv resta come alias thin per Performance (`ListIndividuales`, `ListOrganizzativas`, …) che estendono `ListScheda` → `BaseListSchedas`.

## Moduli

### Ptv

- `ListSchedas` — override colonne flat e azioni tabella
- `ListScheda` — thin wrapper su `BaseListSchedas`
- `EditScheda` / `CreateScheda` — thin su base Ptv

### Progressioni

- `ListSchedas` — override completo di header, colonne, filtri e bulk (template email `progressioni-{anno}`); `getHeaderWidgets()` vuoto (no widget firma Ptv)
- `ListScheda.php` — **rimosso** (duplicato)
- `EditScheda` — `BaseEditScheda` + `DeleteAction` in header

### Performance

- `ListIndividuales`, `ListOrganizzativas`, `ListIndividualeAdms` estendono `Ptv\ListScheda` → ereditano `BaseListSchedas` senza modifiche aggiuntive

## Override consigliato (Progressioni vs Ptv)

Quando un modulo ha UI lista diversa dalla base Ptv, estendere `BaseListSchedas` e sovrascrivere esplicitamente:

- `getHeaderActions()`
- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getHeaderWidgets()` se non si vogliono i widget Ptv

## Anti-pattern

```php
// ❌ ERRATO
class ListSchedas extends XotBaseListRecords { }

// ❌ ERRATO
class CreateScheda extends CreateRecord { }

// ✅ CORRETTO
class ListSchedas extends BaseListSchedas
{
    protected static string $resource = SchedaResource::class;
}
```

## Collegamenti

- [scheda-contract-inheritance.md](./wiki/concepts/scheda-contract-inheritance.md) — modello e `BaseSchedaResource`
- [Progressioni — getPages naming](../../Progressioni/docs/filament-resource-getpages-naming.md)
- [filament-resources.md](./filament-resources.md)

*Ultimo aggiornamento: giugno 2025*
