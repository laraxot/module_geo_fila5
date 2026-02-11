# Schemaless Attributes — IndennitaResponsabilita Module

**Package**: [`spatie/laravel-schemaless-attributes`](https://github.com/spatie/laravel-schemaless-attributes)
**Status**: ✅ CORRETTO — Rating estende BaseRating (DRY)

---

## Architettura

```
Rating (Modules\IndennitaResponsabilita\Models\Rating)
  └── extends BaseRating (Modules\Rating\Models\BaseRating)
        └── extends BaseModel (Modules\Rating\Models\BaseModel)
              └── extends XotBaseModel (Modules\Xot\Models\XotBaseModel)
```

> [!IMPORTANT]
> `IndennitaResponsabilita\Rating` eredita **tutto** da `BaseRating`:
> - `casts()` con `extra_attributes => SchemalessAttributes::class`
> - `scopeWithExtraAttributes()` con query JSON dirette
> - `$fillable`, `linkedTo()`, `registerMediaConversions()`
>
> **Non duplicare** nessuno di questi metodi nel modello locale.

---

## Errori Passati e Correzioni (Storico)

### 1. ~~`property_exists()` invece di `isset()`~~ ✅ RISOLTO

```php
// ❌ ERRATO — non funziona con cast Eloquent
if (property_exists($this, 'extra_attributes')) { ... }

// ✅ CORRETTO — isset() funziona con __get()
if (isset($this->extra_attributes)) { ... }
```

**Motivo**: `property_exists()` controlla le proprietà della classe PHP, non i magic attributes Eloquent. `extra_attributes` è un cast `SchemalessAttributes`, accessibile solo via `__get()`.

### 2. ~~`$casts` array deprecato~~ ✅ RISOLTO

```php
// ❌ DEPRECATO in Laravel 11+
protected $casts = ['extra_attributes' => SchemalessAttributes::class];

// ✅ CORRETTO — metodo con return type
protected function casts(): array
{
    return ['extra_attributes' => SchemalessAttributes::class];
}
```

### 3. ~~`modelScope()` ignora i parametri~~ ✅ RISOLTO

L'errore più grave: `$this->extra_attributes->modelScope()` restituisce un `Builder` **senza** applicare filtri. Le query andavano fatte con `where()` diretto.

```php
// ❌ ERRATO — modelScope() ignora completamente i parametri
return $this->extra_attributes->modelScope();

// ✅ CORRETTO — query JSON diretta (implementato in BaseRating)
return $query->where("extra_attributes->{$key}", $value);
```

---

## Pattern Corretti di Utilizzo

### Query

```php
// Filtra per anno
$ratings = Rating::where('extra_attributes->anno', 2024)->get();

// Usa lo scope
$ratings = Rating::withExtraAttributes('anno', 2024)->get();
$ratings = Rating::withExtraAttributes(['anno' => 2024, 'type' => 'indennita'])->get();

// Con operatore custom
$ratings = Rating::where('extra_attributes->anno', '>=', 2020)->get();
```

### Get/Set

```php
// Set (sempre chiamare save()!)
$rating->extra_attributes->set('anno', 2024);
$rating->extra_attributes->set(['anno' => 2024, 'type' => 'indennita']);
$rating->save();

// Get (con default)
$anno = $rating->extra_attributes->get('anno', (int) date('Y'));

// Dot notation
$value = $rating->extra_attributes->get('nested.key', 'default');

// Rimuovi
$rating->extra_attributes->forget('key');
$rating->save();
```

---

## Filament Integration

```php
// ListRatings.php — colonne per schemaless attributes
TextColumn::make('extra_attributes.type'),
TextColumn::make('extra_attributes.anno'),

// Filtro per anno
$query->where('extra_attributes->anno', $anno);
```

---

## Regole DRY/KISS

1. **Mai** duplicare casts/scope/fillable — tutto ereditato da `BaseRating`
2. **Mai** usare `property_exists()` su Eloquent — usare `isset()`
3. **Mai** usare `modelScope()` per filtrare — usare `where()` diretto
4. **Sempre** chiamare `save()` dopo `set()`
5. **Sempre** usare `casts()` method, non `$casts` property

---

## Checklist di Implementazione

- [x] Correggere `property_exists()` → `isset()`
- [x] Migrare `$casts` → `casts()` method
- [x] Aggiungere import corretti (`Casts\SchemalessAttributes`)
- [x] Refactoring scope da `modelScope()` a `where()` diretto
- [x] Ereditarietà DRY: Rating estende BaseRating
- [x] PHPStan Level 10 verificato

## Riferimenti

- [spatie/laravel-schemaless-attributes](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel News](https://laravel-news.com/laravel-schemaless-attributes-package)
- [Rating Module Docs](../../Rating/docs/schemaless-attributes.md)
- [Rating Errors & Fixes](../../Rating/docs/schemaless-attributes-errors.md)
- [Xot Schemaless Guide](../../Xot/docs/spatie-schemaless-attributes.md)