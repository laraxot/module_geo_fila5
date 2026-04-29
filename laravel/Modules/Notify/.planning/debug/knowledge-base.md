# GSD Debug Knowledge Base

Resolved debug sessions. Used by `gsd-debugger` to surface known-pattern hypotheses at the start of new investigations.

---

## sqlite-model-contract-fix — ModelContract getKey() signature incompatible with Laravel Model
- **Date:** 2026-04-09
- **Error patterns:** getKey(): mixed, getRelationValue(string $key): mixed, Declaration of Illuminate\Database\Eloquent\Model, must be compatible with
- **Root cause:** Modules\Xot\Contracts\ModelContract interface declared getKey(): mixed and getRelationValue(string $key): mixed which are incompatible with Laravel's Model methods that have no return type declarations. Also contained leftover git merge conflict markers in PHPDoc.
- **Fix:** Removed getKey(): mixed and getRelationValue(string $key): mixed from ModelContract interface. Cleaned up merge conflict markers (<<<<<<< HEAD / ======= / >>>>>>> 9506daa5) from PHPDoc. Removed unused Pivot import.
- **Files changed:** laravel/Modules/Xot/app/Contracts/ModelContract.php
---
