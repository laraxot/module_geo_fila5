# Fix IDE Helper Relation Errors

## Problem Statement
The `php artisan ide-helper:models -W` command was reporting an error in the `IndennitaCondizioniLavoro` module:
- `Error resolving relation model of Modules\IndennitaCondizioniLavoro\Models\ServizioEsterno:trasferte() : Class "Modules\Trasferte\Models\FuoriSedeDip" not found`. This happened because the `Trasferte` module might not be loaded in all environments.

## Solution
### 1. Robust Relation Handling
Updated `ServizioEsterno::trasferte()` to check if the related class exists before returning the relation:
- Used `class_exists()` to safely detect if `Modules\Trasferte\Models\FuoriSedeDip` is available.
- If the class is missing, it returns an empty `hasMany` relation to prevent `ide-helper` from crashing or reporting errors.

### 2. Standardized Eloquent Relations
- Replaced `belongsToManyX` with standard `belongsToMany` in `ServizioEsterno` for `indennitaTipoDettaglio` and `tipoDettaglio`. This improves compatibility with automated tools like `ide-helper` while maintaining the exact same behavior via the `using()` and `withPivot()` methods.

## Verification
- Ran `php artisan ide-helper:models -W` and confirmed that the "Class not found" error for `trasferte()` is resolved.
