# NestedSet Migration Best Practices — DOCUMENTO LEGACY

> **ATTENZIONE**: Questo documento è **legacy**. Il progetto ha completato la migrazione
> da `kalnoy/nestedset` a `staudenmeir/laravel-adjacency-list` (marzo 2026).
>
> Il pacchetto `kalnoy/nestedset` è stato **rimosso** dal progetto.

## Documento Aggiornato

Per le best practices attuali sulle strutture ad albero, consultare:

- **[Adjacency List Migration — Filosofia Completa](../../Xot/docs/adjacency-list-migration.md)**
- **[Adjacency List Best Practices](../../Xot/docs/best-practices/adjacency-list-best-practices.md)**
- **[BaseTreeModel Documentation](../../Xot/docs/models/base-tree-model.md)**

## Regola Attuale

Per tutti i nuovi modelli ad albero:

```php
use Modules\Xot\Models\BaseTreeModel;

class MyTreeModel extends BaseTreeModel
{
    // Tutto il tree functionality è ereditato automaticamente
}
```

**NON usare** `NodeTrait`, `NestedSet::columns()`, o colonne `_lft`/`_rgt`.

## Cronologia

- **Pre-2025**: Progetto usava `kalnoy/nestedset`
- **2025**: Migrazione progressiva a `staudenmeir/laravel-adjacency-list`
- **2026-03**: Rimozione completa di `kalnoy/nestedset`

*Ultimo aggiornamento: marzo 2026*
