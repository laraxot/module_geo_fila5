# Xot Module Roadmap

"Il motore che muove l'universo Quaeris."

## Visione

<<<<<<< HEAD
## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Scrivi test che fallisce → Scrivi codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage Minimo**: 80% per tutto il codice core

### Struttura Test
```
Modules/Xot/tests/
├── Unit/
│   ├── Actions/
│   │   └── {Action}Test.php
│   ├── Models/
│   │   └── {Model}Test.php
│   └── Services/
│       └── {Service}Test.php
├── Feature/
│   ├── Filament/
│   │   └── {Resource}Test.php
│   └── Pages/
│       └── {Page}Test.php
├── Pest.php
└── TestCase.php
```

### Comandi Test
```bash
# Test singolo modulo
./vendor/bin/pest Modules/Xot/tests

# Test con coverage
./vendor/bin/pest Modules/Xot/tests --coverage --min=80

# Test specifico
php artisan test --filter=test_name
```

### Best Practices Testing
- [ ] Usare `RefreshDatabase` per test che necessitano database
- [ ] Fake servizi esterni (Mail, Queue, Event)
- [ ] Testare behavior, non implementation details
- [ ] Naming descrittivo: `it('creates user with valid data')`
- [ ] Usare dataset per multiple scenarios

## 🏗️ Fasi di Sviluppo
=======
Consolidare Xot come framework "Zero-Config" per Laravel 12: ogni nuovo modulo eredita sicurezza, internazionalizzazione, gestione temi e performance tramite estensione di classi base.

## Fasi di Sviluppo
>>>>>>> aeaab8a30 (docs: update roadmaps for Mensa, Prenotazioni, Ptv, User, Xot, and Zero themes)

### Fase 1: Framework Stabilization (In Progress)

- [x] PHPStan Level 10 Compliance as standard
- [ ] Rimozione definitiva dei 780+ file obsoleti
- [ ] Refactoring `XotBaseServiceProvider` per boot asincrono
- [ ] Piena compatibilità Filament v5 Plugins
- [ ] Consolidamento documentazione — [roadmap/docs/status](roadmap/docs/status.md)

### Fase 2: Developer Happiness (Planned)

- [ ] **Xot CLI**: Comandi Artisan per generare moduli conformi (Super Mucca compliant)
- [ ] **Trait Auditor**: Rilevamento collisioni nomi Trait a tempo di build
- [ ] Miglioramento `XotBasePage` per Folio + Volt nativo — [xotbasepage-implementation](xotbasepage-implementation.md)
- [ ] Integrazione Filament — [roadmap/integration/filament](roadmap/integration/filament.md)
- [ ] Integrazione Folio/Volt — [roadmap/integration/folio-volt](roadmap/integration/folio-volt.md)

### Fase 3: AI Core Integration (Future)

- [ ] **AI Code Reviewer**: Verifica regole Super Mucca pre-commit
- [ ] **Self-Healing Base Classes**: Suggerimenti correzioni tipo da PHPStan
- [ ] **Cross-Module Dependency Resolver**: Visualizzazione dipendenze moduli

## Technical Debt

| Area | Stato | Target | Riferimento |
|------|-------|--------|-------------|
| File obsoleti | 780+ | 0 | Pulizia docs/ |
| XotBaseServiceProvider | Sincrono | Boot asincrono | [service-provider](service-provider.md) |
| XotBasePage getModel | Fix applicato | Stabile | [xotbasepage-getmodel-fix](xotbasepage-getmodel-fix.md) |
| Test coverage | Parziale | 100% dispatcher Actions | [testing](testing/testing.md) |

## Classi Base Critiche

- **XotBaseResource** — [xotbaseresource](xotbaseresource.md)
- **XotBasePage** — [xotbasepage-implementation](xotbasepage-implementation.md)
- **XotBaseWidget** — [xotbasewidget](xotbasewidget.md)
- **XotBaseServiceProvider** — [service-provider](service-provider.md)
- **XotBaseRelationManager** — [relation-managers](relation-managers.md)

## Collegamenti

- [README](readme.md)
- [Super Mucca Workflow](super-mucca-workflow.md)
- [Roadmap Bottlenecks](roadmap/bottlenecks.md)
- [Tasks Index](tasks/tasks-index.md)

## Checklist Qualità

- [x] PHPStan Level 10
- [ ] Zero dipendenze esterne non necessarie (Keep it Lean)
- [ ] 100% test coverage sui dispatcher di Actions
- [ ] Documentazione consolidata

---

<<<<<<< HEAD
**Ultimo aggiornamento**: Febbraio 2026
=======
**Ultimo aggiornamento**: 24 Febbraio 2026
>>>>>>> a779533d (docs: expand module roadmaps with detailed phases, testing structure, and TDD guidelines)
