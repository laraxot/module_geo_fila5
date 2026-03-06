# Regola Documentazione Agnostica - NO Riferimenti Progetto-Specifici

## Regola Fondamentale

**I file di documentazione (.md, .txt) DEVONO essere agnostici e NON devono contenere riferimenti a nomi di progetti specifici, moduli di altri progetti, o dettagli implementativi di altri progetti.**

## Perché

1. **Genericità**: La documentazione di un modulo deve essere valida per qualsiasi progetto che lo utilizza
2. **Riusabilità**: Un modulo come `Rating` può essere usato in progetti completamente diversi
3. **Chiarezza**: Riferimenti esterni creano confusione su cosa sia parte del modulo
4. **Manutenibilità**: Documentazione accoppiata a progetti esterni è difficile da mantenere

## Riferimenti Vietati

### Nomi di Progetti
- `<nome progetto>` - Progetto esterno
- `Fila5` - Progetto esterno
- `ExternalProject` - Progetto esterno
- `healthcare_app` - Progetto esterno
- Qualsiasi altro nome progetto-specifico

### Nomi di Moduli Esterni
- Riferimenti a moduli che non fanno parte del progetto corrente
- Esempi: `LimeSurvey` (se non è il progetto corrente), `Customer`, `Survey`

### Path e URL Specifici
- URL di produzione di altri progetti
- Path assoluti di altri progetti
- Configurazioni specifiche di altri progetti

## Pattern Corretto

### ✅ OK - Documentazione Agnostica
```markdown
# Rating Module

## Overview
Modulo agnostico per la gestione dei criteri di valutazione.

## Integrazione
Il modulo espone trait che altri moduli possono implementare:
- `HasRatingsTrait` - Per modelli che hanno ratings

## Installazione
```bash
# Installazione in qualsiasi progetto Laravel
composer require laraxot/modules-rating
```

## Utilizzo
```php
use Modules\Rating\Models\Traits\HasRatingsTrait;

class MioModello extends BaseModel
{
    use HasRatingsTrait;
}
```
```

## Pattern Anti (VIETATO)

### ❌ Riferimenti a Progetti Esterni
```markdown
# Rating Module

## Overview
Modulo per gestione valutazioni in ExternalProject.

## Integrazione
Usato principalmente in ExternalProject Fila5 per gestire i rating.
```

### ❌ Riferimenti a Moduli Esterni
```markdown
# Rating Module

## Dipendenze
Richiede il modulo LimeSurvey per funzionare correttamente.

## Esempi
Vedi implementazione in Customer::class per dettagli.
```

### ❌ Path e URL Specifici
```markdown
# Configurazione

Imposta `BASE_URL=https://altro-progetto.it` nel file .env
```

## Eccezioni Consentite

### ✅ Riferimenti Interni Progetto
- `Xot` - Framework core del progetto corrente
- `UI` - Componenti UI del progetto corrente
- `User` - Modulo autenticazione del progetto corrente

### ✅ Esempi Concreti nel Proprio Progetto
```markdown
## Esempio nel Tuo Progetto

```php
// Se hai un modulo Performance nel tuo progetto:
class Performance extends BaseModel
{
    use HasRatingsTrait;
}
```
```

## Checklist

- [ ] Nessun nome progetto esterno (<nome progetto>, ExternalProject, Fila5, healthcare_app, ecc.)
- [ ] Nessun riferimento a moduli che non esistono nel progetto corrente
- [ ] Nessuna URL o path di progetti esterni
- [ ] Esempi usano nomi generici (`MioModulo`, `MioModello`)
- [ ] La documentazione è valida se copiata in un altro progetto

## Collegamenti

- [modularity-rules.md](modularity-rules.md) - Regola modularità
- [AGENTS.md](../AGENTS.md) - Linee guida generali

---

**Ultimo aggiornamento**: 2026-02-24
**Stato**: Attivo
