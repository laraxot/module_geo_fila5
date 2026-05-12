# Regola Modularità - Moduli Agnostici

## Regola Fondamentale

**Ogni modulo deve essere agnostico e riutilizzabile in qualsiasi progetto Laravel, senza dipendenze hardcoded da moduli specifici del progetto corrente.**

## Perché Questa Regola

### 1. Riutilizzabilità
- Un modulo come `Rating` potrebbe essere usato in progetti completamente diversi
- Non deve assumere l'esistenza di moduli come `IndennitaResponsabilita` o `Ptv`
- Deve essere generico e flessibile

### 2. Separazione delle Responsabilità
- Ogni modulo ha un compito specifico e ben definito
- Non deve conoscere i dettagli implementativi di altri moduli
- Le integrazioni devono essere opzionali e configurabili

### 3. Manutenibilità
- Moduli accoppiati sono difficili da modificare
- Cambiare un modulo non deve rompere altri moduli
- Test indipendenti per ogni modulo

### 4. Testabilità
- Moduli agnostici sono più facili da testare in isolamento
- Non richiedono la presenza di altri moduli per funzionare
- Mocking più semplice

## Pattern Corretto

### Documentazione Modulo
```markdown
# Rating Module Roadmap

## Visione
Modulo agnostico per la gestione dei criteri di valutazione e dei punteggi.
Utilizzabile in qualsiasi progetto Laravel con moduli che richiedono valutazioni.

## Integrazioni
Il modulo espone trait e interfacce che altri moduli possono implementare:
- `HasRatingsTrait` - Per modelli che hanno ratings
- `Ratingable` - Interfaccia per contratto
```

### Codice
```php
// ✅ CORRETTO - Modulo agnostico
namespace Modules\Rating\Models\Traits;

trait HasRatingsTrait
{
    public function ratings()
    {
        return $this->morphToMany(Rating::class, 'ratingable');
    }
}

// Altri moduli USANO il trait, non viceversa
namespace Modules\IndennitaResponsabilita\Models;

use Modules\Rating\Models\Traits\HasRatingsTrait;

class IndennitaResponsabilita extends BaseModel
{
    use HasRatingsTrait;  // ✅ Il modulo specifico USA il trait generico
}
```

## Pattern Anti (VIETATO)

### Documentazione
```markdown
# ❌ VIETATO - Riferimenti a moduli specifici
Modulo per integrazione con IndennitaResponsabilita e Ptv.
```

### Codice Accoppiato
```php
// ❌ VIETATO - Hardcoded dependency
namespace Modules\Rating\Models;

class Rating extends BaseModel
{
    // ❌ MAI fare questo
    public function indennitaResponsabilita()
    {
        return $this->belongsTo(\Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita::class);
    }
}
```

## Esempi di Modularità Corretta

### Esempio 1: Modulo Activity (Log)
```php
// ✅ CORRETTO - Activity è agnostico
namespace Modules\Activity\Models;

class Activity extends BaseModel
{
    // Polymorphic - funziona con qualsiasi modello
    public function subject()
    {
        return $this->morphTo();
    }
    
    public function causer()
    {
        return $this->morphTo();
    }
}
```

### Esempio 2: Modulo User (Auth)
```php
// ✅ CORRETTO - User espone interfacce, non dipende da specifici
namespace Modules\User\Contracts;

interface Authenticatable
{
    public function can($ability, $arguments = []);
    public function roles();
}
```

### Esempio 3: Modulo Rating (Valutazioni)
```php
// ✅ CORRETTO - Rating espone trait generici
namespace Modules\Rating\Models;

class Rating extends BaseModel
{
    // Polymorphic relationship - agnostico
    public function rateable()
    {
        return $this->morphTo();
    }
}
```

## Dipendenze Consentite

### Dipendenze OK
- **Xot**: Framework core (tutti i moduli dipendono da Xot)
- **UI**: Componenti UI condivisi
- **User**: Autenticazione base
- **Librerie esterne**: Spatie, Filament, Laravel

### Dipendenze da Evitare
- Moduli business-specifici (es. `IndennitaResponsabilita`, `Ptv`, `Performance`)
- Moduli che implementano logiche di dominio specifiche

## Checklist Modularità

Per ogni modulo, verificare:
- [ ] Nessun riferimento a moduli business-specifici nel codice
- [ ] Nessun riferimento a moduli specifici nella documentazione
- [ ] Usa relazioni polimorfiche dove possibile
- [ ] Espone interfacce e trait per estensibilità
- [ ] Può essere installato in un progetto pulito e funzionare
- [ ] Test indipendenti senza dipendenze da altri moduli business

## Collegamenti

- [AGENTS.md](../AGENTS.md) - Linee guida generali
- [architecture.md](architecture.md) - Architettura modulare

---

**Ultimo aggiornamento**: 2026-02-24
**Stato**: Attivo
