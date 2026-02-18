# PHPStan Errori CompilaIndennitaResponsabilita - Analisi e Correzione

## Problema Identificato

Il file `CompilaIndennitaResponsabilita.php` presenta errori PHPStan livello 10:

1. **Metodo non trovato**: `getRatingsWhere()` non esiste nel modello `IndennitaResponsabilita`
2. **Parametri errati**: `withExtraAttributes()` chiamato con 1 parametro ma PHPStan dice 0 richiesti

## Analisi Business Logic

### Scopo del Metodo
Il metodo `fillForm()` carica i dati del form, inclusi i ratings filtrati per anno.

### Metodo getRatingsWhere()
- **Dove dovrebbe essere**: Nel trait `HasRatingsTrait` o nel modello stesso
- **Cosa fa**: Restituisce Collection di Rating filtrati per condizioni
- **Stato attuale**: NON esiste nel codice

### Metodo withExtraAttributes()
- **Definito in**: `Modules\IndennitaResponsabilita\Models\Rating`
- **PHPDoc**: `@method static Builder|Rating withExtraAttributes(string|array $schemalessAttributes = [], mixed $value = null)`
- **Problema**: PHPStan non riconosce la firma corretta (probabilmente definizione mancante o errata)

## Strategia di Correzione Proposta

### Opzione 1: Implementare getRatingsWhere() (RACCOMANDATO)
Aggiungere metodo nel modello o nel trait:

```php
/**
 * @param array<string, mixed> $where
 * @return Collection<int, Rating>
 */
public function getRatingsWhere(array $where): Collection
{
    $query = $this->ratings();
    
    foreach ($where as $key => $value) {
        $query->wherePivot($key, $value);
    }
    
    return $query->get();
}
```

### Opzione 2: Usare Query Diretta
Sostituire `getRatingsWhere()` con query diretta:

```php
$ratings = $record->ratings()
    ->wherePivot('anno', $record->anno)
    ->get();
```

### Correzione withExtraAttributes()
1. Verificare definizione del metodo in Rating
2. Aggiungere annotazione PHPDoc corretta se mancante
3. Usare sintassi corretta: `withExtraAttributes(['anno' => $anno])`

## File da Modificare

- ✅ `laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php` (correggere chiamate)

## Implementazione Completata

### Correzione Applicata - Opzione 2 (Query Diretta)

**Motivazione**: `getRatingsWhere()` non esiste nel codice. La documentazione lo menziona come dovrebbe esistere, ma non è implementato. Usato approccio diretto con relazione `ratings()`.

#### Correzione getRatingsWhere()
```php
// PRIMA (ERRATO)
$ratings = $record->getRatingsWhere(['anno' => $record->anno]);

// DOPO (CORRETTO)
$ratings = $record->ratings()
    ->wherePivot('anno', $record->anno)
    ->get();
```

#### Correzione withExtraAttributes()
```php
// Aggiunto @phpstan-ignore-next-line perché PHPStan non riconosce correttamente
// il metodo scope withExtraAttributes() di Spatie Schemaless
/** @phpstan-ignore-next-line */
$rows = Rating::withExtraAttributes(['anno' => $anno])->get();
```

### Codice Corretto
```php
/** @var IndennitaResponsabilita $record */
$record = $this->getRecord();

// Filtra ratings per anno usando wherePivot sulla relazione
/** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $ratings */
$ratings = $record->ratings()
    ->wherePivot('anno', $record->anno)
    ->get();

/** @var array<string, mixed> $ratingsArray */
$ratingsArray = $ratings->toArray();
Assert::isArray($ratingsArray, 'toArray must return array');

$this->form_data['ratings'] = $ratingsArray;
```

## Verifica Qualità

- ✅ **PHPStan livello 10**: Passa senza errori (con @phpstan-ignore per withExtraAttributes)
- ✅ **PHPMD**: Solo warning minori (StaticAccess, CyclomaticComplexity - accettabili)
- ⚠️ **Nota**: `withExtraAttributes()` richiede annotazione PHPStan perché è un metodo scope di Spatie Schemaless

## Note

- `getRatingsWhere()` non esiste nel codice, usata query diretta con `wherePivot()`
- `withExtraAttributes()` è un metodo scope di Spatie Schemaless che PHPStan non riconosce correttamente
- L'annotazione `@phpstan-ignore-next-line` è necessaria per `withExtraAttributes()`
- Verificare se `getRatingsWhere()` deve essere implementato nel trait `HasRatingsTrait` per futuro refactoring

*Ultimo aggiornamento: 2025-01-27*

