# Memory: property_exists() NON può essere usato nei Modelli Eloquent

## Regola Critica

**property_exists() NON può essere usato nei modelli Eloquent perché gli attributi sono magici.**

Questa è una regola fondamentale che deve essere sempre rispettata.

## Pattern di Sostituzione

- **Attributi**: `property_exists($model, 'attr')` → `isset($model->attr)`
- **Relazioni**: `property_exists($record, 'relation')` → `isset($record->relation)`
- **Pivot**: `property_exists($pivot, 'field')` → `isset($pivot->field)`
- **Schema check**: `property_exists($model, 'field')` → `$model->hasAttribute('field')`
- **Fillable check**: `property_exists($model, 'field')` → `$model->isFillable('field')`

## File Corretti (24 Nov 2025)

- `Modules/Sigma/app/Models/Policies/RepartPolicy.php`
- `Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectEmployees.php`
- `Modules/Sigma/app/Models/Wmen00f.php`
- `Modules/Sigma/app/Models/Wstr02f.php`
- `Modules/UI/app/Filament/Tables/Columns/IconStateColumn.php`

## Eccezioni

- Static properties dichiarate: OK
- Oggetti stdClass senza magic methods: OK


