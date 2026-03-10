# Risoluzione Conflitti Git - Progetto Laraxot PTVX

## Panoramica

Questo documento fornisce una guida di alto livello per la risoluzione dei conflitti Git nel progetto Laraxot PTVX.

**Per la documentazione tecnica completa e dettagliata,consulta:**

👉 **[Modules/Xot/docs/git-conflicts-resolution-strategy.md](../Modules/Xot/docs/git-conflicts-resolution-strategy.md)**

## Stato Attuale

**Data:** 2025-01-27

### Conflitti Identificati
- **Total file PHP con marker conflitti:** 586
- **Priorità:** MASSIMA (blocca esecuzione, PHPStan, test)
- **Tipo:** Residui merge passati non completati

### Approccio
- **Strategia:** Risoluzione manuale focalizzata su business logic
- **Principi:** DRY + KISS
- **Tool:** Analisi manuale, PHPStan livello 10, Test suite

## Quick Links

### Documentazione Moduli

- **Xot:** [git-conflicts-resolution-strategy.md](../Modules/Xot/docs/git-conflicts-resolution-strategy.md)
- **User:** [README.md](../Modules/User/docs/README.md)
- **Job:** [README.md](../Modules/Job/docs/README.md)
- **Tenant:** [README.md](../Modules/Tenant/docs/README.md)

### Best Practices

- **Testing:** NO RefreshDatabase - Solo mock e oggetti in-memory
- **Naming:** File docs in lowercase (eccetto README.md)
- **PHPStan:** Livello 10 compliance obbligatoria
- **Documentation:** Sempre in `Modules/*/docs/`, MAI in `/docs/` root

## Business Logic e Motivazioni

### Perché i Conflitti Sono Critici

1. **Bloccano esecuzione**: File con marker non sono validi PHP
2. **Degradano qualità**: PHPStan e linter falliscono
3. **Confondono sviluppatori**: Codice ambiguo
4. **Violano DRY**: Spesso contengono codice duplicato

### Principi di Risoluzione

**DRY (Don't Repeat Yourself):**
- Eliminiamo SEMPRE codice duplicato
- Consolidiamo logica comune
- Manteniamo una sola fonte di verità

**KISS (Keep It Simple, Stupid):**
- Scegliamo la versione PIÙ SEMPLICE
- Rimuoviamo complessità inutile
- Preferiamo leggibilità a cleverness

## Workflow Rapido

### 1. Identificare Conflitti

```bash
# Trova tutti i file con conflitti

# Conta conflitti
```

### 2. Analizzare File

```bash
# Visualizza conflitti in un file

# Conta sezioni conflittuali
```

### 3. Risolvere

**Domande da porsi:**
1. Quale versione riflette la business logic ATTUALE?
2. Quale versione è PIÙ SEMPLICE (KISS)?
3. Quale versione ELIMINA duplicazioni (DRY)?
4. Quale versione segue best practices?

### 4. Verificare

```bash
# Verifica sintassi
php -l path/to/file.php

# Verifica PHPStan
./vendor/bin/phpstan analyse path/to/file.php

# Esegui test relativi
php artisan test --filter=TestName
```

## Pattern Comuni

### Anti-Pattern: RefreshDatabase

```php
// ❌ SBAGLIATO (trovato nei conflitti)
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; // VIETATO!
}
```

```php
// ✅ CORRETTO (risoluzione)
class UserTest extends TestCase
{
    // NO RefreshDatabase - test unitari usano SOLO mock
    // Principio: Test veloci (< 100ms), isolati, deterministici
}
```

### Pattern: Duplicazione Import

```php
// ❌ CONFLITTO TIPICO
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
```

```php
// ✅ RISOLUZIONE
use Tests\TestCase;
// Rimosso tutto ciò che tocca database
```

## Prevenzione Futura

### Git Hooks

```bash
# .git/hooks/pre-commit
#!/bin/bash
    echo "ERRORE: Conflitti Git non risolti trovati!"
    exit 1
fi
```

### CI/CD Checks

- Aggiungere check per marker conflitti
- Fallire build se trovati
- Alert automatici a team

### Code Review

- Checklist include "No conflict markers"
- Reviewer verifica sintassi valida
- Test automatici devono passare

## Metriche

### Target
- **File con conflitti:** 586 → 0
- **Test passing:** 100%
- **PHPStan:** Livello 10, zero errori
- **Performance:** Test suite < 30 secondi

### Tracking Progress

```bash
# Conflitti rimanenti

# File risolti oggi
git log --since="today" --pretty=format:"%s" | grep -c "risolto conflitto"
```

## Supporto

### Domande Frequenti

**Q: Quale versione scegliere in un conflitto?**  
A: Quella che riflette la business logic ATTUALE e segue best practices (NO RefreshDatabase, DRY, KISS).

**Q: Posso usare merge automatico?**  
A: NO. Ogni conflitto richiede analisi manuale per capire business logic.

**Q: Come gestire conflitti in documentazione?**  
A: Unire contenuti utili, eliminare duplicazioni, mantenere focus su business logic.

**Q: PHPStan fallisce dopo risoluzione?**  
A: Eseguire `./vendor/bin/phpstan analyse file.php` e correggere errori tipo/sintassi.

### Risorse

- **Documentazione Tecnica:** [Modules/Xot/docs/git-conflicts-resolution-strategy.md](../Modules/Xot/docs/git-conflicts-resolution-strategy.md)
- **Testing Best Practices:** [Modules/Xot/docs/README.md](../Modules/Xot/docs/README.md)
- **Laravel Docs:** [https://laravel.com/docs](https://laravel.com/docs)
- **PHPStan Docs:** [https://phpstan.org/](https://phpstan.org/)

---

**Nota:** Questo è un documento di panoramica. Per dettagli operativi, pattern specifici, esempi codice, e workflow dettagliati, consultare la documentazione completa nel modulo Xot.

