# Schemaless Attributes - Best Practices Complete v2.0

## 🎯 **OVERVIEW COMPLETO**

Questa documentazione aggiorna completamente l'approccio a **Schemaless Attributes** nel progetto PTVX, seguendo le best practices di Spatie e i pattern moderni Laravel/Filament v5.

## 📚 **DOCUMENTAZIONE SPAITE STUDIATA A FONDO**

### 📋 **Riferimenti Principali**:
1. **[Spatie Laravel Schemaless Attributes](https://github.com/spatie/laravel-schemaless-attributes)**
   - Pattern ufficiale per attributi dinamici
   - `schemalessAttributes()` in migrations
   - `SchemalessAttributes::class` in model casts
   - Scope `withExtraAttributes()` per query

2. **[Spatie Laravel Data](https://spatie.be/docs/laravel-data/v4)**
   - Validazione avanzata con attributes
   - Lazy properties per performance
   - Integration con Schemaless Attributes

3. **[Spatie Laravel Media Library](https://spatie.be/docs/laravel-medialibrary/v11)**
   - Custom properties con extra_attributes
   - Integration pattern

---

## 🎯 **AGGIORNAMENTI CRITICI IMPLEMENTATI**

### ✅ **1. MIGRATION PATTERN CORRETTO**

**File**: `/Modules/IndennitaResponsabilita/database/migrations/2026_02_10_140733_add_calculated_data_to_indennita_responsabilita_table.php`

```php
// ✅ CORRETTO: Pattern XOT + Schemaless Attributes
return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('extra_attributes')) {
                // @phpstan-ignore-next-line method.notFound
                $table->schemalessAttributes('extra_attributes');
            }
        });
    }
}
```

### ✅ **2. MODEL CON SCHEMALESS ATTRIBUTES COMPLETO**

**File**: `/Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`

```php
// ✅ CORRETTO: Modello conforme best practices
class IndennitaResponsabilita extends BaseScheda
{
    protected $fillable = [
        // ... campi standard ...
        'extra_attributes', // ✅ Aggiunto per Schemaless Attributes
    ];

    // ✅ CORRETTO: Metodo casts() con tipi
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'extra_attributes' => SchemalessAttributes::class, // ✅ Schemaless Attributes
            // ... altri casts ...
        ]);
    }

    // ✅ CORRETTO: Scope per query Schemaless Attributes
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        if (isset($this->extra_attributes) && is_object($this->extra_attributes)) {
            return $this->extra_attributes->modelScope();
        }
        return $query;
    }

    // ✅ NUOVO: Metodi helper per Schemaless Attributes
    public function setCalculatedData(string $key, mixed $value): void
    {
        $this->extra_attributes->set($key, $value);
    }

    public function getCalculatedData(string $key, mixed $default = null): mixed
    {
        return $this->extra_attributes->get($key, $default);
    }
}
```

### ✅ **3. FORM REATTIVO CON PATTERN FILAMENT V5**

**File**: `/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

```php
// ✅ CORRETTO: Field Hydration secondo Filament v5
class CompilaIndennitaResponsabilita
{
    // ✅ Setup iniziale con afterStateHydrated
    protected function mount(int|string $record): void
    {
        // ... setup iniziale ...
        
        // Get ratings con relationship Eloquent standard
        $ratings = $this->record->ratings()->wherePivot('anno', $this->record->anno)->get();
        $modelData['ratings'] = $ratings->keyBy('id')->toArray();
        
        $this->form->fill($modelData);
    }

    // ✅ Campi con reactivity ottimizzata
    protected function getFormSchema(): array
    {
        foreach ($ratings as $rating) {
            $item = TextInput::make('ratings.'.$rating->id.'.pivot.value')
                ->label(__('indennita.fields.' . Str::kebab($rating->title))) // ✅ Traduzioni
                ->rules('required|numeric|min:0|max:5') // ✅ Validazione completa
                ->reactive() // ✅ Reattività
                ->live(onBlur: true) // ✅ Performance
                ->columns(2);

            if ($rating->is_readonly) {
                // ✅ Campi readonly calcolati automaticamente
                $item->formatStateUsing(function (Get $get) use ($rating) {
                    $method = 'get' . Str::studly($rating->title);
                    if (method_exists($this, $method)) {
                        return $this->$method($get); // ✅ Usa dati reali
                    }
                    return 0;
                })
                ->readOnly()
                ->extraInputAttributes(['class' => 'bg-gray-100']);
            } else {
                // ✅ Campi editabili con afterStateUpdated
                $item->afterStateUpdated(function (): void {
                    $this->recalculateReadonlyFields(); // ✅ Ricalcola tutti i readonly
                });
            }

            $schema[] = $item;
        }

        return $schema;
    }
}
```

---

## 🎯 **NUOVI METODI HELPER IMPLEMENTATI**

### 📋 **SchemalessAttributesHelper Trait**
<tool_call>write
<arg_key>content</arg_key>
<arg_value><?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Modules\Xot\Database\Eloquent\Model;

/**
 * Trait per implementare Schemaless Attributes in modo consistente
 * 
 * Questo trait fornisce metodi standard per lavorare con extra_attributes
 * seguendo le best practices di Spatie e del progetto PTVX.
 * 
 * @see https://github.com/spatie/laravel-schemaless-attributes
 * @see /Modules/Xot/docs/schemaless-attributes-patterns.md
 */
trait HasSchemalessAttributes
{
    /**
     * Aggiunge extra_attributes al fillable.
     * 
     * @return array<string>
     */
    protected function schemalessFillable(): array
    {
        return array_merge($this->fillable, [
            'extra_attributes',
        ]);
    }

    /**
     * Get the attributes that should be cast.
     * 
     * @return array<string, string>
     */
    protected function schemalessCasts(): array
    {
        return array_merge($this->casts ?? [], [
            'extra_attributes' => SchemalessAttributes::class,
        ]);
    }

    /**
     * Scope per filtrare per attributi schemaless.
     * 
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        // ✅ isset() invece di property_exists() per compatibilità con i cast
        if (isset($this->extra_attributes) && is_object($this->extra_attributes)) {
            return $this->extra_attributes->modelScope();
        }

        return $query;
    }

    /**
     * Scope per query specifiche su extra_attributes.
     * 
     * @param Builder $query
     * @param string $key
     * @param mixed $value
     * @return Builder
     */
    public function scopeWhereExtraAttribute(Builder $query, string $key, mixed $value): Builder
    {
        return $query->where("extra_attributes->{$key}", $value);
    }

    /**
     * Get un valore da extra_attributes.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getExtraAttribute(string $key, mixed $default = null): mixed
    {
        return $this->extra_attributes?->get($key, $default) ?? $default;
    }

    /**
     * Set un valore in extra_attributes.
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setExtraAttribute(string $key, mixed $value): void
    {
        if (!$this->extra_attributes) {
            $this->extra_attributes = new SchemalessAttributes();
        }

        $this->extra_attributes->set($key, $value);
    }

    /**
     * Get tutti gli extra_attributes come array.
     * 
     * @return array<string, mixed>
     */
    public function getExtraAttributes(): array
    {
        return $this->extra_attributes?->all() ?? [];
    }

    /**
     * Controlla se esiste un attributo in extra_attributes.
     * 
     * @param string $key
     * @return bool
     */
    public function hasExtraAttribute(string $key): bool
    {
        return $this->extra_attributes?->has($key) ?? false;
    }

    /**
     * Rimuove un attributo da extra_attributes.
     * 
     * @param string $key
     * @return void
     */
    public function removeExtraAttribute(string $key): void
    {
        $this->extra_attributes->forget($key);
    }

    /**
     * Sincronizza gli extra_attributes con il database.
     * 
     * @return void
     */
    public function syncExtraAttributes(): void
    {
        $this->save(); // Salva automaticamente il cast
    }

    /**
     * Esempio di calcolo complesso con extra_attributes.
     * 
     * @return float
     */
    public function calculateComplexTotal(): float
    {
        $total = (float) $this->getExtraAttribute('base_amount', 0);
        $multiplier = (float) $this->getExtraAttribute('multiplier', 1.0);
        $discount = (float) $this->getExtraAttribute('discount', 0);

        return ($total * $multiplier) - $discount;
    }

    /**
     * Esempio di validazione avanzata con extra_attributes.
     * 
     * @return array<string>
     */
    public function getExtraAttributesValidationRules(): array
    {
        return [
            'extra_attributes.base_amount' => 'required|numeric|min:0',
            'extra_attributes.multiplier' => 'required|numeric|min:0.1|max:10',
            'extra_attributes.discount' => 'nullable|numeric|min:0|max:100',
        ];
    }
}