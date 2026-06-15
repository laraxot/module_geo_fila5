# Filament Resource: Schemas e Tables (tema One)

## Scopo

Se il tema espone risorse Filament (`Themes\One\Filament\Resources\...`), usare la stessa struttura dei moduli Laraxot: cartelle `Schemas/` e `Tables/` accanto alla Resource.

## Struttura

```
Themes/One/app/Filament/Resources/{ResourceName}/
├── Schemas/
│   ├── {Entity}Form.php
│   └── {Entity}Infolist.php
├── Tables/
│   └── {Entities}Table.php
└── {ResourceName}.php
```

## Regole

- Estendere `XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable`.
- Nessun `->label()` / `->placeholder()` / `->helperText()`.
- Chiavi stringa negli array restituiti dai metodi get*.
- **`getPages()`:** omettere se la Resource ha solo `index` / `create` / `edit` e le Page seguono `List{plural}`, `Create{name}`, `Edit{name}` — [regola Xot](../../Modules/Xot/docs/filament/getpages-redundancy-rule.md).

## Riferimenti

- [Xot — getPages ridondanza](../../Modules/Xot/docs/filament/getpages-redundancy-rule.md)
- [Xot – Filament v5 hybrid pattern](../../Modules/Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md)
- [Progressioni – migrazione in corso](../../Modules/Progressioni/docs/filament-resource-schemas-tables.md)
- [Progressioni – wire pilota Assenze](../../Modules/Progressioni/docs/filament-resource-wire-assenze.md)
- [Zero – stesso pattern](../Zero/docs/filament-resource-schemas-tables.md)
- [Three – stesso pattern](../Three/docs/filament-resource-schemas-tables.md)

*Ultimo aggiornamento: giugno 2025*
