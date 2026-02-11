# Schemaless Attributes Documentation

## Overview
Questa documentazione spiega l'uso corretto dei **Schemaless Attributes** del pacchetto Spatie all'interno dei moduli Rating e IndennitaResponsabilita.

## Errori Identificati e Soluzioni

### Errore Critico 1: Uso di `property_exists()` invece di `isset()`

#### 🚨 Problema nel Modulo Rating
**File**: `/Modules/Rating/app/Models/Rating.php:113`

```php
// ❌ ERRATO - property_exists() non funziona con i cast
if (property_exists($this, 'extra_attributes') && method_exists($this->extra_attributes, 'modelScope')) {
    // Questo codice non verrà mai eseguito!
}
```

#### ✅ Soluzione Corretta (Già Implementata in IndennitaResponsabilita)
```php
// ✅ CORRETTO - isset() funziona con oggetti castati
if (isset($this->extra_attributes) && is_object($this->extra_attributes) && method_exists($this->extra_attributes, 'modelScope')) {
    $result = $this->extra_attributes->modelScope();
    if ($result instanceof Builder) {
        return $result;
    }
}
```

### Errore Critico 2: Mancanza del Metodo `casts()` in Rating

#### 🚨 Problema
Il modulo Rating usa l'array `$casts` invece del metodo `casts()` che è il best practice moderno.

```php
// ❌ ERRATO - approccio deprecato
protected $casts = [
    'extra_attributes' => SchemalessAttributes::class,
];
```

#### ✅ Soluzione Corretta
```php
// ✅ CORRETTO - metodo casts() con tipi dichiarati
protected function casts(): array
{
    return [
        'extra_attributes' => SchemalessAttributes::class,
        'rule' => RuleEnum::class,
        'is_disabled' => 'boolean',
        'is_readonly' => 'boolean',
    ];
}
```

### Errore Critico 3: Imports Mancanti in Rating

#### 🚨 Problema
Il modulo Rating ha diversi errori di import:

1. **Manca `HasMedia` interface**
2. **Manca `InteractsWithMedia` trait**  
3. **Manca classi Media Library**
4. **Imports Eloquent errate** (usano percorsi relativi non necessari)

#### ✅ Soluzione Completa
Aggiungere le import corrette:
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
```

### Errore 4: Metodi Mancanti per Media Conversions

#### 🚨 Problema
Il metodo `registerMediaConversions()` è vuoto.

#### ✅ Soluzione
```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('300x300')
        ->width(300)
        ->height(300);
    $this->addMediaConversion('150x150')
        ->width(151)
        ->height(151);
    $this->addMediaConversion('50x50')
        ->width(150)
        ->height(150);
}
```

### Errore 5: Tipo di Ritorno Errato per Scope Metodi (BaseScheda)

#### 🚨 Problema
Nel modello `Modules\Ptv\Models\BaseScheda.php`, il metodo `scopeWithCalculatedData()` ha un tipo di ritorno `SchemalessAttributes` quando invece dovrebbe essere `Builder`. I metodi scope in Laravel devono sempre ritornare un'istanza di `Illuminate\Database\Eloquent\Builder`.

```php
// ❌ ERRATO - Il tipo di ritorno dovrebbe essere Builder
public function scopeWithCalculatedData(): SchemalessAttributes
{
    return $this->calculated_data;
}
```

#### ✅ Soluzione Corretta
Il metodo scope dovrebbe modificare la query builder e poi ritornarla, non ritornare direttamente l'attributo. Se l'intento è fornire accesso all'attributo, ciò dovrebbe avvenire tramite l'istanza del modello, non tramite uno scope.

```php
// ✅ CORRETTO - Modifica la query e ritorna Builder
public function scopeWithCalculatedData(Builder $query): Builder
{
    // Esempio di come un scope potrebbe interagire con calculated_data
    // Se lo scope deve filtrare o aggiungere condizioni basate su calculated_data,
    // si farebbe qui. Ad esempio:
    // return $query->where('calculated_data->some_key', 'some_value');

    // Se l'intento era solo accedere all'attributo, lo scope non è il posto giusto.
    // In questo caso, lo scope WithCalculatedData dovrebbe essere rimosso
    // o reinterpretato per modificare la query.
    return $query; // Ritorna la query builder modificata (o non modificata)
}
```

---

## Architettura Corretta Schemaless Attributes

### Pattern per Modelli con Schemaless Attributes

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

abstract class BaseSchemalessModel extends Model
{
    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
        ];
    }

    /**
     * Scope per filtrare per attributi schemaless.
     */
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        if (isset($this->extra_attributes) && is_object($this->extra_attributes) && method_exists($this->extra_attributes, 'modelScope')) {
            return $this->extra_attributes->modelScope();
        }

        return $query;
    }

    /**
     * Scope per attributi specifici.
     */
    public function scopeWithExtraAttributes(Builder $query, array|string $key = null, mixed $value = null, ?string $operator = null): Builder
    {
        if (isset($this->extra_attributes) && is_object($this->extra_attributes) && method_exists($this->extra_attributes, 'modelScope')) {
            return $this->extra_attributes->modelScope();
        }

        return $query;
    }
}
```

### Migration Pattern Standard

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            // Altri colonne specifiche del modello...
            $table->schemalessAttributes('extra_attributes');
            $table->timestamps();
        });
    }
}
```

## Best Practices Complete

### 1. **Sempre usare `isset()`** per verificare attributi castati
### 2. **Implementare sempre `casts()` method** invece di `$casts` array
### 3. **Verificare tutti gli imports** necessari
### 4. **Creare scope methods specifici** per le query comuni
### 5. **Documentare tutti gli approcci** nei commenti PHPDoc

## Riferimenti

- [Spatie Schemaless Attributes - Documentation Ufficiale](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel Data Integration](https://spatie.be/docs/laravel-data/v4)
- [Media Library Integration](https://spatie.be/docs/laravel-medialibrary/v11)

## Checklist di Implementazione

- [ ] Correggere l'uso di `property_exists()` in Rating
- [ ] Implementare il metodo `casts()` in Rating  
- [ ] Aggiungere le import mancanti in Rating
- [ ] Verificare che tutti i moduli seguano lo stesso pattern
- [ ] Eseguire test PHPStan Level 10 per verificare le correzioni