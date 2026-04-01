# 📚 Sigma Documentation Index

> **Indice centrale per tutta la documentazione del modulo Sigma**  
> **Aggiornato**: 2025-03-25  
> **Versione**: 2.0

---

## 🎯 Panoramica

Questo documento fornisce un **indice centrale** per tutta la documentazione del modulo Sigma, organizzato per categorie e con link diretti ai file.

**Convenzione**: Usare sempre questo indice per trovare documentazione esistente prima di creare nuovi file.

---

## 📋 Categorie Documentazione

### 1. **Architecture & Design** 🏗️

| Documento | Path | Scopo |
|-----------|------|-------|
| Architecture Overview | `docs/architecture.md` | Panoramica architettura modulo |
| Database Schema | `docs/database-schema.md` | Schema database e relazioni |
| Models Guide | `docs/models.md` | Guida completa ai modelli |

### 2. **Accessors & Mutators** 🔄

| Documento | Path | Scopo |
|-----------|------|-------|
| **Accessor/Mutator Philosophy** | [`docs/accessor-mutator-philosophy.md`](accessor-mutator-philosophy.md) | **Filosofia SACRA per accessor** |
| **Accessor Delegation Pattern** | [`docs/accessor-delegation-pattern.md`](accessor-delegation-pattern.md) | **Metodo puro VICINO all'accessor** |
| **Accessor Delegation Complete Guide** | [`docs/accessor-delegation-complete-guide.md`](accessor-delegation-complete-guide.md) | **Guida completa con 22 esempi** |
| **Accessor Delegation Audit** | [`docs/accessor-delegation-audit.md`](accessor-delegation-audit.md) | **Audit completo: 22/22 completati** |
| Accessor Patterns | `docs/accessor-patterns.md` | Pattern comuni per accessor |
| Mutator Best Practices | `docs/mutator-best-practices.md` | Best practices per mutator |

**Template SACRO**:
```php
// ✅ CORRETTO
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // Già calcolato
    }
    
    // Calcola e persisti
    $result = $this->calculate();
    $this->attribute = $result;
    
    if ($this->exists) {
        $this->update(['attribute' => $result]);
    }
    
    return $result;
}
```

### 3. **Models** 📦

| Documento | Path | Scopo |
|-----------|------|-------|
| Model Conventions | `docs/models/conventions.md` | Convenzioni naming models |
| Model Traits | `docs/models/traits.md` | Traits comuni per models |
| Model Relationships | `docs/models/relationships.md` | Guida alle relazioni |

### 4. **Testing** 🧪

| Documento | Path | Scopo |
|-----------|------|-------|
| Testing Guide | `docs/testing.md` | Guida completa ai test |
| Test Examples | `docs/testing/examples.md` | Esempi di test |
| Pest Patterns | `docs/testing/pest-patterns.md` | Pattern per Pest PHP |

### 5. **Filament** 🎨

| Documento | Path | Scopo |
|-----------|------|-------|
| Filament Resources | `docs/filament/resources.md` | Guida alle risorse Filament |
| Filament Pages | `docs/filament/pages.md` | Pagine custom Filament |
| Filament Widgets | `docs/filament/widgets.md` | Widget per dashboard |

### 6. **Services & Actions** ⚙️

| Documento | Path | Scopo |
|-----------|------|-------|
| Actions Guide | `docs/actions.md` | Guida alle Actions |
| Services Pattern | `docs/services.md` | Pattern per Services |
| Jobs & Queues | `docs/jobs.md` | Job per elaborazioni async |

### 7. **API** 🔌

| Documento | Path | Scopo |
|-----------|------|-------|
| API Reference | `docs/api/reference.md` | Documentazione API |
| API Authentication | `docs/api/auth.md` | Autenticazione API |

### 8. **Troubleshooting** 🔧

| Documento | Path | Scopo |
|-----------|------|-------|
| Common Issues | `docs/troubleshooting/common-issues.md` | Problemi comuni e soluzioni |
| Debug Guide | `docs/troubleshooting/debug.md` | Guida al debugging |

---

## 🔍 Come Usare Questo Indice

### Prima di Creare Documentazione

1. **CONTROLLA** questo indice
2. **CERCA** se esiste già documentazione simile
3. **AGGIORNA** documentazione esistente
4. **CREA** nuovo file solo se necessario

### Naming Convention File .md

**Pattern**: `kebab-case-lowercase.md`

```
✅ CORRETTO:
- accessor-mutator-philosophy.md
- model-conventions.md
- testing-guide.md

❌ SBAGLIATO:
- AccessorMutatorPhilosophy.md  (CamelCase)
- ACCESSOR_MUTATOR_PHILOSOPHY.md  (UPPERCASE)
- accessor_mutator_philosophy.md  (snake_case)
```

### Struttura Cartelle

```
Sigma/
├── docs/
│   ├── README.md                    # Indice principale (questo file)
│   ├── accessor-mutator-philosophy.md
│   ├── architecture.md
│   ├── models/
│   │   ├── conventions.md
│   │   ├── traits.md
│   │   └── relationships.md
│   ├── testing/
│   │   ├── guide.md
│   │   └── examples.md
│   └── troubleshooting/
│       ├── common-issues.md
│       └── debug.md
```

---

## 📿 Il Mantra della Documentazione

```
Prima di documentare, ripeti:

"Controllo l'indice, non duplico"
"Uso kebab-case, non CamelCase"
"Aggiorno esistente, creo solo se necessario"

Respira. Documenta. Trova sempre.
```

---

## 🔗 Riferimenti

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Spatie Packages](https://spatie.be/docs)
- [PHPStan Level 10](https://phpstan.org/user-guide/rule-levels)

---

*Documento creato: 2025-03-25*  
*Ultimo aggiornamento: 2025-03-25*  
*Usa SEMPRE questo indice prima di creare nuovi file .md*
