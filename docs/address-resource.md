## AddressColumn come colonna Filament riusabile

Oltre allo schema di form, il modulo Geo espone anche una colonna tabellare riusabile per gli indirizzi:

- **Classe**: `Modules\Geo\Filament\Tables\Columns\AddressColumn`
- **View**: `geo::filament.tables.columns.address`
- **Pattern**:
  - Estende `ViewColumn` e segue lo stesso approccio di `ContactColumn` nel modulo Notify (ViewColumn + Blade view dedicata).
  - La Blade view compone l indirizzo partendo da `full_address` (se presente) oppure dai singoli campi `address`, `city`, `province`, `postal_code`, `country`.
  - È pensata come componente condiviso tra moduli consumer, ad esempio:

    ```php
    use Modules\Geo\Filament\Tables\Columns\AddressColumn;

    // ...
    'address' => AddressColumn::make('full_address'),
    ```

- **Filosofia**:
  - Geo è il modulo sorgente per tutte le primitive di indirizzo (migrazioni, enum, form schema, colonne tabellari).
  - I moduli consumer (come TechPlanner) non definiscono varianti locali di AddressColumn ma la riusano, mantenendo un solo punto di verità e semplificando manutenzione e refactor.

## AddressItemEnum e icone dei campi contatto

`AddressItemEnum` non gestisce solo le componenti strettamente geografiche (route, locality, postal_code, ecc.), ma anche alcuni campi di contatto associati all indirizzo:

- `fax`, `mobile`, `pec`, `whatsapp`, `email`, `notes`

Per ognuno di questi casi:

- Le proprietà `label`, `description`, `icon`, `color` sono risolte tramite i file di lingua del modulo Geo:

  - `Modules/Geo/lang/it/address_item_enum.php`
  - `Modules/Geo/lang/en/address_item_enum.php`
  - `Modules/Geo/lang/de/address_item_enum.php`

- Il metodo `getIcon()` dell enum ritorna il valore della chiave `*.icon`, che viene passato come `prefixIcon` ai `TextInput` generati da `AddressItemEnum::getFormSchema()`.

### Nota operativa

- Se manca una traduzione (es. `fax.icon`), Filament/BladeUI cercherà un icona con nome uguale alla chiave (`geo::address_item_enum.fax.icon`) e genererà un errore `SvgNotFound`.
- Per aggiungere nuovi item a `AddressItemEnum` è quindi **obbligatorio**:
  - Aggiornare **tutte** le lingue in `lang/*/address_item_enum.php` con `label`, `description`, `icon`, `color`.
  - Documentare la scelta delle icone in questo file o in una doc dedicata agli enum Geo.

## Riferimenti

- [../app/Models/Address.php](../app/Models/Address.php)
- [../../Xot/app/Filament/Resources/XotBaseResource.php](../../Xot/app/Filament/Resources/XotBaseResource.php)
- [filament.md](./filament.md)
- [models/address.md](./models/address.md)
---
module: theme
topic: address-resource
canonical: ../../../Themes/docs/shared-components/address-resource-1.md
---

See canonical documentation: ../../../Themes/docs/shared-components/address-resource-1.md