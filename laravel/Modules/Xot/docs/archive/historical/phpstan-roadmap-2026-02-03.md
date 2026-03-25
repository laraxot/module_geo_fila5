# PHPStan Level 10 Roadmap - Xot Module

**Data**: 2026-02-03
**Status**: ✅ Completato
**Errori Totali**: 1

## Errori Identificati

### Models
- [x] `app/Models/Module.php:65` - `property.phpDocType` - PHPDoc type `string|null` of property `$connection` is not covariant with overridden property in `BaseModel`.

## Pattern di Correzione
- **property.phpDocType**: Allineare il tipo della proprietà `$connection` con quello della classe base (`BaseModel`). Se la classe base lo dichiara come `string`, non può essere `string|null` nella sottoclasse (Liskov Substitution Principle).

## Prossimi Passi
- [x] Correggere `Module.php`
- [x] Verificare con PHPStan

## Verifica

- [x] `./vendor/bin/phpstan analyse Modules --level=10`
