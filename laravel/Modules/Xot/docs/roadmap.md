# Xot Module Roadmap

<<<<<<< HEAD
"Il motore dell'ecosistema Laraxot."
=======
"Il motore che muove l'universo Laravel."
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)

## Visione

Consolidare Xot come framework "Zero-Config" per Laravel 12: ogni nuovo modulo eredita sicurezza, internazionalizzazione, gestione temi e performance tramite estensione di classi base.

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

### Fase 1: Framework Stabilization (In Progress)

- [x] PHPStan Level 10 Compliance as standard
- [ ] Rimozione definitiva dei file obsoleti
- [ ] Refactoring `XotBaseServiceProvider` per boot asincrono
- [ ] Piena compatibilità Filament v5 Plugins
- [ ] Consolidamento documentazione

### Fase 2: Developer Happiness (Planned)

- [ ] **Xot CLI**: Comandi Artisan per generare moduli conformi
- [ ] **Trait Auditor**: Rilevamento collisioni nomi Trait a tempo di build
- [ ] Miglioramento `XotBasePage` per Folio + Volt nativo

### Fase 3: AI Core Integration (Future)

- [ ] **AI Code Reviewer**: Verifica regole pre-commit
- [ ] **Self-Healing Base Classes**: Suggerimenti correzioni tipo da PHPStan
- [ ] **Cross-Module Dependency Resolver**: Visualizzazione dipendenze moduli

## Technical Debt

| Area | Stato | Target |
|------|-------|--------|
| File obsoleti | Da pulire | 0 |
| XotBaseServiceProvider | Sincrono | Boot asincrono |
| Test coverage | Parziale | 100% dispatcher Actions |

## Classi Base Critiche

- **XotBaseResource**
- **XotBasePage**
- **XotBaseWidget**
- **XotBaseServiceProvider**
- **XotBaseRelationManager**

## Checklist Qualità

- [x] PHPStan Level 10
- [ ] Zero dipendenze esterne non necessarie (Keep it Lean)
- [ ] 100% test coverage sui dispatcher di Actions
- [ ] Documentazione consolidata

---

**Ultimo aggiornamento**: Febbraio 2026
