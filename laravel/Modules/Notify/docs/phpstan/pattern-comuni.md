# Pattern Comuni PHPStan - Progetto Laraxot

**Aggiornato:** 10 Ottobre 2025  
**Basato su:** Correzione Activity (230 errori) + Blog (13 errori)

## 🎯 Scopo

Documentare pattern ricorrenti e soluzioni consolidate per mantenere PHPStan Level 10 su tutto il progetto.

## 📋 Pattern Universali

### 1. HasXotFactory - NON Generic

**Applicabile a:** TUTTI i moduli che usano HasXotFactory

```php
// ❌ SBAGLIATO (causa errore PHPStan)
/** @use HasFactory<FactoryClass> */
use HasXotFactory;

// ✅ CORRETTO
use HasXotFactory;
```

**Motivo:** `HasXotFactory` non supporta parametri generic.  
**Moduli Verificati:** Activity ✅, Blog ✅

### 2. Factory Assert nei Test

**Applicabile a:** TUTTI i test che usano factory

```php
// ✅ Pattern Standard
$model = Model::factory()->create();
assert($model instanceof Model);

// ✅ Con parametri
$model = Model::factory()->create([
    'field' => 'value',
]);
assert($model instanceof Model);

// ✅ Collection factory
/* @phpstan-ignore-next-line method.nonObject */
$factory = Model::factory();
assert($factory !== null);
/* @phpstan-ignore-next-line method.nonObject */
$collection = $factory
/* @phpstan-ignore-next-line method.nonObject */
->count(5)
->create([...]);
assert($collection instanceof \Illuminate\Database\Eloquent\Collection);
```

**Moduli Applicati:** Activity ✅, Blog ✅  
**Test Totali Corretti:** ~150

### 3. Filament Array Associativi

**Applicabile a:** TUTTI i Filament Resources

```php
// ✅ getTableFilters()
public function getTableFilters(): array
{
    return [
        'filter_key' => Filter::make('filter_key'),
        'status' => SelectFilter::make('status'),
    ];
}

// ✅ getTableColumns()
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
    ];
}
```

**Moduli Applicati:** Activity ✅, Blog ✅

### 4. Safe Functions

**Applicabile a:** TUTTI i file che usano json_encode/decode

```php
// Inizio file
use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\class_uses;

// Uso normale
$json = json_encode($data);  // Exception invece di false
$array = json_decode($json, true);
$traits = class_uses($class);
```

**Moduli Applicati:** Activity ✅, Blog ✅

### 5. Return Types: list<> vs array<string, mixed>

**Applicabile a:** TUTTI i metodi che ritornano array

```php
// ✅ list<T> = array indicizzato [0, 1, 2, ...]
/** @return list<ArticleData> */
public function getArticles(): array
{
    $result = [];
    foreach ($articles as $article) {
        $result[] = ArticleData::from($article);
    }
    return $result;
}

// ✅ array<string, T> = array associativo
/** @return array<string, Filter> */
public function getFilters(): array
{
    return [
        'key1' => $filter1,
        'key2' => $filter2,
    ];
}

// ✅ list<array<string, mixed>> = lista di oggetti
/** @return list<array<string, mixed>> */
public function getCategories(): array
{
    return Category::all()->map(fn ($c) => [...])->values()->toArray();
}
```

### 6. Null Safety

**Applicabile a:** OVUNQUE ci sia accesso a property/metodi

```php
// ✅ Null coalescing
$value = $object->property ?? 'default';
$result = $object?->method() ?? null;

// ✅ Check instanceof
if ($model instanceof SpecificModel) {
    $value = $model->specific_property;
}

// ✅ Ignore documentato (ultima risorsa)
/* @phpstan-ignore-next-line property.notFound */
$value = $dynamicModel->dynamic_property;
```

## 🎓 Pattern per Tipo di File

### Models

```php
// ✅ BaseModel
abstract class BaseModel extends Model
{
    use HasXotFactory;  // NON @use con generic
    use Updater;
}

// ✅ Content Blocks Methods
public function getOnlyContentBlocks(array $blocks): array
{
    /** @var array<int, array<string, mixed>> */
    $contentBlocks = is_array($this->content_blocks) ? $this->content_blocks : [];
    
    return collect($contentBlocks)
        ->filter(function (array $value) use ($blocks): bool {
            return in_array($value['type'] ?? null, $blocks);
        })
        ->toArray();
}
```

### Filament Resources

```php
// ✅ ListResource
class ListModels extends XotBaseListRecords
{
    public function getTableFilters(): array
    {
        return [
            'key' => Filter::make('key'),
            // ... chiavi stringa!
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            // ... chiavi stringa!
        ];
    }
}
```

### View Composers

```php
// ✅ Methods che ritornano DTO
/**
 * @return list<ArticleData>
 */
public function getArticles(): array
{
    return Article::all()
        ->map(fn ($a) => ArticleData::from($a))
        ->toArray();
}

// ✅ Methods che ritornano array generico
/**
 * @return list<array<string, mixed>>
 */
public function getCategories(): array
{
    $result = Category::all()
        ->map(fn ($c): array => [
            'id' => $c->id,
            'name' => $c->name,
        ])
        ->values()
        ->toArray();
    
    /** @var list<array<string, mixed>> */
    return array_values($result);
}
```

### Test Pest

```php
// ✅ Factory usage
test('feature works', function (): void {
    /* @phpstan-ignore-next-line method.nonObject */
    $user = User::factory()->create();
    assert($user instanceof User);
    
    /* @phpstan-ignore-next-line method.nonObject */
    $model = Model::factory()->create(['user_id' => $user->id]);
    assert($model instanceof Model);
    
    expect($model->user_id)->toBe($user->id);
});

// ✅ Pest $this properties
beforeEach(function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->model = new TestModel();
});

test('model test', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $model = $this->model;
    expect($model)->toBeInstanceOf(TestModel::class);
});
```

## 🚫 Anti-Pattern Universali

### 1. NON Escludere Test

```neon
# ❌ MAI FARE QUESTO!
excludePaths:
    - ./tests/*
    - ./*/tests/*
```

### 2. NON @use con HasXotFactory

```php
# ❌ SBAGLIATO
/** @use HasFactory<Factory> */
use HasXotFactory;
```

### 3. NON Ignore File Interi

```php
// ❌ Non supportato
/**
 * @phpstan-ignore-file
 */
```

### 4. NON Return Types Generici Quando Possibile Specifico

```php
// ❌ EVITARE
/** @return array<string, mixed> */
public function getArticles() { ... }  // Se ritorna list<ArticleData>

// ✅ PREFERIRE
/** @return list<ArticleData> */
public function getArticles() { ... }
```

## 📈 Metriche di Successo

| Modulo | Errori Iniziali | Errori Finali | Tempo |
|--------|-----------------|---------------|-------|
| Activity | 230 | 0 ✅ | ~3h |
| Blog | 13 | 0 ✅ | ~30min |
| **Totale** | **243** | **0** ✅ | **~3.5h** |

## 🔄 Workflow Standard

### 1. Analisi

```bash
./vendor/bin/phpstan analyse Modules/ModuleName
```

### 2. Categorizzazione

- Models: X errori
- Filament: X errori
- Views/Composers: X errori
- Tests: X errori

### 3. Correzione Prioritaria

1. **Models** (codice produzione)
2. **Filament** (codice produzione)
3. **Services/Composers** (codice produzione)
4. **Tests** (MAI escludere!)

### 4. Verifica

```bash
./vendor/bin/phpstan analyse Modules/ModuleName
# [OK] No errors ✅
```

### 5. Documentazione

- Aggiornare `docs/phpstan-compliance.md`
- Creare `docs/phpstan/correzioni-YYYY-MM-DD.md`
- Documentare pattern trovati

## 🎯 Standard Progetto

### PHPStan Configuration

**File:** `/laravel/phpstan.neon`

```neon
parameters:
    level: max  # Level 10
    paths:
        - ./Modules/
    
    excludePaths:
        - ./*/vendor/*
        - ./*/docs/*
        - ./*/build/*
        # MAI escludere tests!
```

### Ogni Modulo

- ✅ PHPStan Level 10
- ✅ 0 errori su codice + test
- ✅ Documentazione aggiornata
- ✅ Pattern consolidati applicati

## 📚 Documentazione Moduli

Ogni modulo deve avere:

- `docs/phpstan-compliance.md` - Status attuale
- `docs/phpstan/best-practices.md` - Pattern specifici
- `docs/phpstan/correzioni-YYYY-MM-DD.md` - Correzioni storiche

## 🏆 Obiettivi Futuri

- [ ] Applicare a tutti i moduli rimanenti
- [ ] Creare script automazione pattern comuni
- [ ] CI/CD check PHPStan automatico
- [ ] Training team su pattern consolidati

---

**Pattern Comuni - Progetti Laraxot** 🎯  
**PHPStan Level 10 - Zero Compromessi** 🏆

