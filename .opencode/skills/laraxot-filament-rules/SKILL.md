---
name: laraxot-filament-rules
description: Regole Filament in Laraxot: usare XotBase*, no label/placeholder/helperText, no table() override, metodi getTable* pubblici. Usare per Resource/RelationManager/Widget.
---

# Laraxot Filament Rules

## Scopo
Applicare le regole Filament/Xot per coerenza e traduzioni automatiche.

## Regole critiche
- Estendere sempre `XotBase*` (mai Filament diretto)
- Vietato usare `->label()`, `->placeholder()`, `->helperText()`
- Vietato override `table()` e `form()` nelle classi che estendono XotBase
- Metodi `getTable*()` devono essere `public`
- `getInfolistSchema()` restituisce array con chiavi stringa
- Per widget: non dichiarare `$heading` statico, usare `getHeading()`
- Non sostituire colonne custom (es. `WorkerColumn`, `ValutatoreColumn`) con `TextColumn`
- Non rimuovere opzioni anno/quadrimestre senza requisito esplicito
- Nei filtri, preservare chiavi associative (es. `$filters['quadrimestre']`)
- Non rimuovere azioni header esistenti senza motivazione documentata

## Pattern RelationManager
```php
class ExampleRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'items';

    /** @return array<string, \Filament\Tables\Columns\Column> */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name'),
        ];
    }
}
```

## Widget chart (JS)
- Usa `RawJs::make(<<<'JS' ... JS)` quando non serve interpolazione PHP
- Niente `display` in datalabels multi-label
