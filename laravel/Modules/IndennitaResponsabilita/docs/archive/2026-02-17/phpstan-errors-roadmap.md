# PHPStan Level 10 Errors Roadmap - Modulo IndennitaResponsabilita

**Data**: 2026-01-12  
**Modulo**: IndennitaResponsabilita  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 4

1. **`app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`** (Linea 267)
   - **Errore**: `Call to an undefined method getRatingsWhere()`
   - **Tipo**: `method.notFound`

2. **`app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`** (Linea 301)
   - **Errore**: `Static method withExtraAttributes() invoked with 1 parameter, 0 required`
   - **Tipo**: `arguments.count`

3. **`app/Filament/Resources/RatingResource/Pages/ListRatings.php`** (Linea 54)
   - **Errore**: `Static method withExtraAttributes() invoked with 1 parameter, 0 required`
   - **Tipo**: `arguments.count`

4. **`app/Filament/Resources/RatingResource/Pages/ListRatings.php`** (Linea 119)
   - **Errore**: `Method withExtraAttributes() invoked with 1 parameter, 0 required`
   - **Tipo**: `arguments.count`

---

## 🧠 Analisi Errori

### Pattern 1: Metodo getRatingsWhere() Non Trovato

**Problema**: Il metodo `getRatingsWhere()` non esiste nel modello `IndennitaResponsabilita`.

**Causa**: 
- Metodo non implementato nel trait `HasRatingsTrait`
- Metodo rimosso o mai esistito

**Soluzione**: 
- Implementare il metodo nel trait o nel modello
- Oppure correggere il codice per usare `ratings()` con filtri appropriati

### Pattern 2: withExtraAttributes() con Parametri

**Problema**: `withExtraAttributes()` è uno scope che non accetta parametri, ma viene chiamato con parametri.

**Causa**: 
- Lo scope `withExtraAttributes()` in `Rating` non accetta parametri
- Il codice cerca di filtrare per attributi extra ma usa la sintassi sbagliata

**Soluzione**: 
- Verificare come filtrare per `extra_attributes` usando Spatie SchemalessAttributes
- Correggere le chiamate per usare la sintassi corretta

---

## 📋 Piano di Correzione

### Fase 1: Correzione getRatingsWhere()

**File**: `app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

**Analisi**: Il metodo `getRatingsWhere()` non esiste. Deve essere implementato o il codice deve usare `ratings()` con filtri.

**Opzione A - Implementare metodo**:
```php
// Aggiungere al trait HasRatingsTrait o al modello
public function getRatingsWhere(array $filters): Collection
{
    $query = $this->ratings();
    
    foreach ($filters as $key => $value) {
        $query->where("extra_attributes->{$key}", $value);
    }
    
    return $query->get();
}
```

**Opzione B - Correggere codice**:
```php
// ❌ PRIMA
$ratings = $record->getRatingsWhere(['anno' => $record->anno]);

// ✅ DOPO
$ratings = $record->ratings()
    ->where('extra_attributes->anno', $record->anno)
    ->get();
```

### Fase 2: Correzione withExtraAttributes()

**File**: `app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php` (Linea 301)

**Correzione**:
```php
// ❌ PRIMA
$rows = Rating::withExtraAttributes(['anno' => $anno])->get();

// ✅ DOPO - Usa whereHas per filtrare extra_attributes
$rows = Rating::query()
    ->where('extra_attributes->anno', $anno)
    ->get();
```

**File**: `app/Filament/Resources/RatingResource/Pages/ListRatings.php` (Linee 54, 119)

**Correzione simile**:
```php
// ❌ PRIMA
$rows = $model::withExtraAttributes(['anno' => $anno_prec])->get();
return $query->withExtraAttributes(['anno' => $anno]);

// ✅ DOPO
$rows = $model::query()
    ->where('extra_attributes->anno', $anno_prec)
    ->get();

return $query->where('extra_attributes->anno', $anno);
```

---

## ✅ Checklist Implementazione

- [ ] Analizzare se implementare `getRatingsWhere()` o correggere codice
- [ ] Correggere chiamata `getRatingsWhere()` in `CompilaIndennitaResponsabilita.php`
- [ ] Correggere chiamate `withExtraAttributes()` con parametri
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/IndennitaResponsabilita --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/IndennitaResponsabilita text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/IndennitaResponsabilita`
- [ ] Formattare codice: `./vendor/bin/pint Modules/IndennitaResponsabilita`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Spatie SchemalessAttributes Documentation](https://github.com/spatie/laravel-schemaless-attributes)

---

## 🎯 Strategia

**Approccio**: Analisi approfondita necessaria - metodi mancanti e scope con parametri  
**Priorità**: Media (4 errori, richiede comprensione business logic)  
**Tempo stimato**: 30 minuti
