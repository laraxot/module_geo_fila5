# Filament Resource: cartelle Schemas e Tables (migrazione Filament 5)

## Scopo

Separare form, infolist e tabella dalle classi `*Resource.php`, seguendo il layout del [demo Filament 5](https://github.com/filamentphp/demo/tree/5.x/app/Filament/Resources/Blog/Categories) ma adattato a **Laraxot** (`XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable`).

**Perché:** una sola responsabilità per file, migrazione incrementale senza rompere il panel, allineamento con gli altri moduli (Activity, Notify, User).

## Riferimenti demo Filament 5

| Demo | Ruolo Laraxot |
| :--- | :--- |
| [CategoryForm.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Schemas/CategoryForm.php) | `{Model}Form` → `getFormSchema()` |
| [CategoryInfolist.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Schemas/CategoryInfolist.php) | `{Model}Infolist` → `getInfolistSchema()` |
| [CategoriesTable.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Tables/CategoriesTable.php) | `{Models}Table` → `getTableColumns()` |

Il demo usa `configure(Schema): Schema`; in Laraxot la fase corrente usa ancora **array con chiavi stringa** tramite le classi base Xot. Vedi [filament-v5-hybrid-pattern](../../Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md) per l’evoluzione futura.

## Struttura obbligatoria

```
Modules/Progressioni/app/Filament/Resources/{ResourceName}/
├── Schemas/
│   ├── {Entity}Form.php
│   └── {Entity}Infolist.php
├── Tables/
│   └── {Entities}Table.php
└── Pages/
    └── ...
```

Namespace:

- `Modules\Progressioni\Filament\Resources\{ResourceName}\Schemas\{Entity}Form`
- `Modules\Progressioni\Filament\Resources\{ResourceName}\Schemas\{Entity}Infolist`
- `Modules\Progressioni\Filament\Resources\{ResourceName}\Tables\{Entities}Table`

## Regole Laraxot (non negoziabili)

1. **Estendere sempre** `XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable` — mai Filament diretto.
2. **Mai** `->label()`, `->placeholder()`, `->helperText()` sui componenti: traduzioni automatiche via LangServiceProvider.
3. **Chiavi stringa** obbligatorie:
   - `getFormSchema(): array<string, Component>`
   - `getInfolistSchema(): array<string, Component>`
   - `getTableColumns(): array<string, Column>`
4. **Fase wire (fase 3):** Resource delega a `{ModelBasename}Form`; List page delega colonne a `*Table` via `app()`. Vedi [filament-resource-wire-assenze](./filament-resource-wire-assenze.md).
5. **`getPages()`:** rimuovere dalla Resource se solo CRUD standard e naming Page allineato a `XotBaseResource` — [dettaglio modulo](./filament-resource-getpages-naming.md), [regola Xot](../../Xot/docs/filament/getpages-redundancy-rule.md).

## Fasi di migrazione

| Fase | Stato | Azione |
| :--- | :---: | :--- |
| 1 – Scaffold | ✅ | Creare `Schemas/` e `Tables/` con classi vuote |
| 2 – Spostamento | ✅ | Copiare schema da Resource / List / View → classi dedicate ([script](../../../bashscripts/progressioni/populate-filament-schemas.php), [doc](../../../bashscripts/docs/progressioni/populate-filament-schemas.md)) |
| 3 – Delega | ⏳ | Resource e List delegano a Form/Table **solo quando la fase 3 è completata**; guida pilota: [Assenze](./filament-resource-wire-assenze.md) (wire **non** ancora applicato) |
| 4 – Pulizia | ⏳ | Rimuovere metodi inline duplicati; rimuovere `getPages()` ridondanti (script `analyze-redundant-getpages.php`) |

**Priorità fase 3:** pilota Assenze (guida pronta) → risorse CRUD semplici → List con override → `ProgressioniResource` / `SchedaResource`.

**Durante fasi 1–2:** non modificare `*Resource.php` né `Pages/List*` per delegare; restano la sorgente di verità fino al wire manuale.

## Inventario scaffold (modulo Progressioni)

| Resource | Form | Infolist | Table |
| :--- | :--- | :--- | :--- |
| AssenzeResource | AssenzaForm | AssenzeInfolist | AssenzeTable |
| CategoriaProproResource | CategoriaProproForm | CategoriaProproInfolist | CategoriaProprosTable |
| CedDiffResource | CedDiffForm | CedDiffInfolist | CedDiffsTable |
| CoeffResource | CoeffForm | CoeffInfolist | CoeffsTable |
| CriteriEsclusioneResource | CriteriEsclusioneForm | CriteriEsclusioneInfolist | CriteriEsclusionesTable |
| CriteriOptionResource | CriteriOptionForm | CriteriOptionInfolist | CriteriOptionsTable |
| CriteriPrecedenzaResource | CriteriPrecedenzaForm | CriteriPrecedenzaInfolist | CriteriPrecedenzasTable |
| CriteriValutazioneResource | CriteriValutazioneForm | CriteriValutazioneInfolist | CriteriValutazionesTable |
| EsclusiExtraResource | EsclusiExtraForm | EsclusiExtraInfolist | EsclusiExtrasTable |
| IntegparamResource | IntegparamForm | IntegparamInfolist | IntegparamsTable |
| MailTemplateResource | MailTemplateForm | MailTemplateInfolist | MailTemplatesTable |
| MaxCatecoPosfunAnnoResource | MaxCatecoPosfunAnnoForm | MaxCatecoPosfunAnnoInfolist | MaxCatecoPosfunAnnosTable |
| MessageResource | MessageForm | MessageInfolist | MessagesTable |
| MyLogResource | MyLogForm | MyLogInfolist | MyLogsTable |
| PesiResource | PesiForm | PesiInfolist | PesisTable |
| ProgressioniResource | ProgressioniForm | ProgressioniInfolist | ProgressionisTable |
| SchedaCriteriResource | SchedaCriteriForm | SchedaCriteriInfolist | SchedaCriterisTable |
| SchedaResource | SchedaForm | SchedaInfolist | SchedasTable |
| StabiDirigenteResource | StabiDirigenteForm | StabiDirigenteInfolist | StabiDirigentesTable |
| StipendioTabellareResource | StipendioTabellareForm | StipendioTabellareInfolist | StipendioTabellaresTable |
| ValutatoreResource | ValutatoreForm | ValutatoreInfolist | ValutatoresTable |

## Esempio scaffold (corretto)

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Schemas;

use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ProgressioniForm extends XotBaseResourceForm
{
    /**
     * @return array<string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            // TODO fase 2: spostare campi da ProgressioniResource::getFormSchema()
        ];
    }
}
```

## Anti-pattern

```php
// ❌ Schema inline nella Resource dopo la migrazione completata
public static function getFormSchema(): array { return [ TextInput::make('foo') ]; }

// ❌ Label hardcoded
TextInput::make('name')->label('Nome');

// ❌ Array senza chiavi stringa
return [ TextColumn::make('name') ];

// ❌ Estendere Filament direttamente
class ProgressioniForm extends \Filament\Forms\Form { }
```

## Collegamenti

- [Xot – Filament v5 hybrid pattern](../../Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md)
- [Xot – array keys rule](../../Xot/docs/wiki/array-keys-rule.md)
- [Activity – schemas-tables pattern](../../Activity/docs/wiki/concepts/schemas-tables-pattern.md)
- [filament-resource-wire-assenze](./filament-resource-wire-assenze.md) — pilota fase 3
- [filament-resource-getpages-naming](./filament-resource-getpages-naming.md)
- [Xot — getpages-redundancy-rule](../../Xot/docs/filament/getpages-redundancy-rule.md)
- [Themes One – filament-resource-schemas-tables](../../../Themes/One/docs/filament-resource-schemas-tables.md)
- [Themes Zero – filament-resource-schemas-tables](../../../Themes/Zero/docs/filament-resource-schemas-tables.md)
- [Themes Three – filament-resource-schemas-tables](../../../Themes/Three/docs/filament-resource-schemas-tables.md)
- [Cursor rule](../../../.cursor/rules/filament-resource-schemas-tables.mdc)
- [bashscripts — populate-filament-schemas](../../../bashscripts/docs/progressioni/populate-filament-schemas.md)

*Ultimo aggiornamento: giugno 2025*
