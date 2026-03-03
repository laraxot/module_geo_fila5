# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | Xot |
| **Repository** | laraxot/module_xot_fila3 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Xot è il modulo **core** e fondamento dell'intero ecosistema Laraxot. Fornisce astrazioni Filament avanzate, pattern XotBase, e funzionalità trasversali utilizzate da tutti gli altri moduli. Senza Xot, nessun altro modulo può funzionare correttamente.

### Visione
Essere il **foundation layer** solido e manutenibile su cui costruire tutti i moduli dell'ecosistema Laraxot, garantendo:
- Consistenza architetturale
- Pattern unificati
- Code quality elevato (PHPStan Level 10)
- Test coverage adeguato

### Target Users
- **Sviluppatori moduli**: utilizzano le classi base
- **Team frontend**: utilizzano componenti Filament
- **DevOps**: utilizzano CLI tools

---

## 2. Problema

### Problema Risolto
Lo sviluppo di moduli Filament in Laravel soffre di:
1. **Duplicazione codice**: Stesse funzionalità riscritte in ogni modulo
2. **Inconsistenza**: Pattern diversi tra moduli
3. **Difficoltà manutenzione**: Codice spargso e non standardizzato
4. **Testing difficile**: Assenza di pattern uniformi

### Pain Points Attuali
- Ogni modulo reimplementa le stesse classi base
- Nessuno standard per risorse Filament
- Difficoltà nel tracciare dipendenze
- Code quality non omogeneo

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Sviluppatore | estendere XotBaseResource | avere funzionalità Filament standardizzate |
| Sviluppatore | usare XotBaseModel | avere funzionalità Eloquent avanzate |
| Sviluppatore | usare trait comuni | condividere logica tra moduli |
| Sviluppatore | generare risorse Filament | velocizzare lo sviluppo |
| Team Lead | verificare PHPStan | garantire quality gate |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Maintainer | Decisioni architetturali, code review |
| Core Team | Sviluppo feature core |
| Module Authors | Utilizzo pattern, feedback |

---

## 4. Soluzione Proposta

### Approccio Architetturale
Xot fornisce un **layer di astrazione** che standardizza:

```
Modulo Specifico → XotBase → Filament/Laravel
```

### Funzionalità Core

#### 4.1 Classi Base Filament

##### XotBaseResource
Classe base per tutte le risorse Filament:
```php
class UserResource extends XotBaseResource
{
    // Già include:
    // - getModel()
    // - getRelations()
    // - getFormSchema()
    // - getTableColumns()
    // - getNavigationBadge()
    // - getPolicies()
}
```

##### XotBasePanel
Panel provider avanzato:
- Automatic tenant scoping
- Theme integration
- Navigation building

##### XotBaseRelationManager
Relation manager con funzionalità avanzate

#### 4.2 Classi Base Eloquent

##### XotBaseModel
Modello base con:
- Trait automaticamente caricati
- Scope per tenant
- Metodi helper
- Type casting avanzato

##### BaseModel (invocabile)
```php
class User extends BaseModel
{
    public static function get(int $id): ?self
    {
        return static::find($id);
    }
}
```

#### 4.3 Service Provider

##### XotBaseServiceProvider
Provider base con:
- Autodiscovery risorse
- Event registration
- Route loading
- View composers

#### 4.4 Trait e Helper

##### Trait Comuni
- `TenantScopeTrait` - Scope automatico tenant
- `FilamentRulesTrait` - Regole form
- `ExportableTrait` - Esportazione dati
- `WithPermissionsTrait` - Permessi dinamici

##### Helper Functions
- `get_model()` - Fetch model con caching
- `get_user()` - Current user
- `tenant()` - Current tenant

#### 4.5 Generatori

##### Comandi Artisan
```bash
php artisan make:xot-resource User
php artisan make:xot-model User
php artisan make:xot-module Blog
```

#### 4.6 Testing Infrastructure

##### Pest Configuration
- Test base classes
- Fixtures condivise
- Database factories

#### 4.7 Quality Gates

##### PHPStan Integration
- Level 10 configuration
- Custom rules per XotBase
- CI/CD integration

---

## 5. Scope

### In Scope (Inclusi)
- [x] XotBaseResource con funzionalità avanzate
- [x] XotBaseModel con trait standard
- [x] XotBaseServiceProvider
- [x] Trait condivisi
- [x] Helper functions
- [x] Generatori (se presenti)
- [x] Testing base classes
- [x] PHPStan configuration

### Out of Scope (Esclusi)
- [ ] Funzionalità specifiche di business
- [ ] UI components (modulo UI)
- [ ] Notifiche (modulo Notify)
- [ ] Media handling (modulo Media)

### Non-Goals
- Replicare funzionalità Filament non necessarie
- Implementare feature request senza validazione
- Mantenere retrocompatibilità con versioni vecchie

---

## 6. Metriche di Successo

### KPI Tecnici
| KPI | Target | Misura |
|-----|--------|--------|
| PHPStan Level | 10 (0 errori) | `./vendor/bin/phpstan analyse` |
| Test Coverage | >80% | `pest --coverage` |
| Response Time | <100ms | Benchmark base calls |
| Breaking Changes | 0 per release | Changelog review |

### KPI Funzionali
| KPI | Target | Misura |
|-----|--------|--------|
| Moduli Compatibili | 100% | Test matrix |
| BC Breaks | <2 per year | Release notes |

---

## 7. Timeline e Milestone

### Milestone
| Milestone | Data | Deliverable |
|-----------|------|-------------|
| M1: Core v5 | Q1 2026 | XotBaseResource v5 compatible |
| M2: PHPStan L10 | Q2 2026 | 0 errori |
| M3: Testing | Q3 2026 | >80% coverage |
| M4: Docs | Q4 2026 | Documentazione completa |

### Cicli di Release
- Release mensile per bugfix
- Release trimestrale per feature
- LTS ogni 2 anni

---

## 8. Dipendenze

### Dipendenze Esterne
| Pacchetto | Versione | Scopo |
|-----------|----------|-------|
| filament/filament | ^5.0 | Admin panel |
| laravel/framework | * | Core Laravel |
| nwidart/laravel-modules | * | Modular architecture |
| spatie/laravel-permission | * | Permissions |
| spatie/laravel-data | * | Data objects |
| laravel/pennant | * | Feature flags |
| livewire/livewire | * | Reactive components |
| doctrine/dbal | * | Schema handling |

### Moduli Dipendenti
**Tutti i moduli dipendono da Xot**:
- User, Tenant, Notify, Lang, Gdpr, Activity, Job, Media, Seo, Setting, Rating, DbForge, UI
- Badge, CertFisc, ContoAnnuale, Europa, Inail, Incentivi, Indennita*, Legge*, Mensa, Mobilita*, Pdnd, Performance, Prenotazioni, PresenzeAssenze, Progressioni, Ptv, Questionari, Sigma, Sindacati

### Impatto Breakage
Se Xot ha un bug, **tutti i moduli sono impattati**. Priorità massima per fix.

---

## 9. Risk e Assunzioni

### Rischi
| Rischio | Probabilità | Impatto | Mitigazione |
|---------|-------------|---------|-------------|
| Breaking change Filament | Alta | Alto | Version pinning, changelog |
| BC con moduli esistenti | Media | Alto | Test matrix, deprecation |
| Performance degradation | Bassa | Medio | Benchmark, profiling |
| Maintainer availability | Media | Alto | Documentazione, bus factor |

### Assunzioni
- PHP 8.2+ disponibile
- Laravel 12 come baseline
- Filament 5.x stabile
- Composer disponibile

---

## 10. Domande Aperte

- [ ] Supporto Filament 6.x?
- [ ] Generatori automatici?
- [ ] Event system custom?
- [ ] API-first approach?

---

## 11. Appendici

### Struttura Directory
```
Xot/
├── app/
│   ├── Contracts/       # Interfacce
│   ├── Concerns/        # Trait
│   ├── Exceptions/     # Exception handlers
│   ├── Filament/       # Resource base classes
│   ├── Http/           # Middleware, Controllers
│   ├── Models/         # Base models
│   ├── Providers/      # Service providers
│   └── Traits/         # Trait condivisi
├── config/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── docs/
├── resources/
├── routes/
└── tests/
```

### Composer Dependencies
```json
{
  "require": {
    "php": "^8.2",
    "filament/filament": "^5.0",
    "laravel/framework": "*",
    "nwidart/laravel-modules": "*",
    "spatie/laravel-permission": "*",
    "spatie/laravel-data": "*"
  }
}
```

### Glossario
| Termine | Definizione |
|---------|-------------|
| XotBase* | Classi base fornite dal modulo |
| Trait | Clase PHP riutilizzabile |
| Module | Componente Laravel standalone |
| Panel | UI Filament admin |

---

## 12. Changelog

| Version | Data | Modifiche |
|---------|------|-----------|
| 1.0.0 | 2026-03-03 | Initial PRD |
