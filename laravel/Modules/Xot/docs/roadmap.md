# Xot Module Roadmap

"Il motore che muove l'universo Quaeris."

## 🎯 Visione
Consolidare Xot come un framework "Zero-Config" per Laravel 12, dove ogni nuovo modulo eredita automaticamente sicurezza, internazionalizzazione, gestione temi e performance di alto livello tramite una semplice estensione di classi base.

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
- [x] PHPStan Level 10 Compliance as standard.
- [ ] Rimozione definitiva dei 780+ file obsoleti.
- [ ] Refactoring di `XotBaseServiceProvider` per supportare il boot asincrono.
- [ ] Piena compatibilità con **Filament v5 Plugins**.

### Fase 2: Developer Happiness (Planned)
- [ ] **Xot CLI**: Comandi Artisan per generare moduli conformi in 1 secondo (Super Mucca compliant).
- [ ] **Trait Auditor**: Tool che rileva collisioni di nomi nei Trait a tempo di build.
- [ ] Miglioramento della `XotBasePage` per supportare Folio + Volt in modo nativo.

### Fase 3: AI Core Integration (Future)
- [ ] **AI Code Reviewer**: Modello locale che verifica le regole Super Mucca prima del commit.
- [ ] **Self-Healing Base Classes**: Le classi base suggeriscono correzioni di tipo in base al PHPStan.
- [ ] **Cross-Module Dependency Resolver**: Visualizzazione grafica 3D delle dipendenze tra moduli core.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Zero dipendenze esterne non necessarie (Keep it Lean).
- [ ] 100% test coverage sui dispatcher di Actions.

---

<<<<<<< HEAD
**Ultimo aggiornamento**: Febbraio 2026
=======
**Ultimo aggiornamento**: 24 Febbraio 2026
>>>>>>> a779533d (docs: expand module roadmaps with detailed phases, testing structure, and TDD guidelines)
