<<<<<<< HEAD
# IndennitaResponsabilita Module Roadmap

## Visione

Sistema di valutazione e calcolo indennità dirigenziali per PA: criteri configurabili, calcolo automatico, audit trail e documentazione PDF.

**Business Logic**: [business-logic](business-logic.md) — PERCHÉ e COME funziona

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (In Progress)
=======
# IndennitaResponsabilita Module - Roadmap
>>>>>>> a779533d (docs: expand module roadmaps with detailed phases, testing structure, and TDD guidelines)

## Overview
**Purpose**: Gestione indennità di responsabilità per dipendenti pubblici
**Status**: Active Development
**Dependencies**: Xot (core), Rating (criteri valutazione), User (autenticazione)

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%

### Struttura Test
```
Modules/IndennitaResponsabilita/tests/
├── Unit/
│   ├── Models/
│   │   └── IndennitaResponsabilitaTest.php
│   └── Services/
├── Feature/
│   ├── Filament/
│   │   └── IndennitaResponsabilitaResourceTest.php
│   └── Pages/
│       └── CompilaIndennitaResponsabilitaTest.php
├── Pest.php
└── TestCase.php
```

### Test Esistenti
- [x] `CompilaIndennitaResponsabilitaTest` - Test pagina compilazione

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Notification)
- [ ] Test naming descrittivo
- [ ] Test validazione form

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/IndennitaResponsabilita/tests

# Test con coverage
./vendor/bin/pest Modules/IndennitaResponsabilita/tests --coverage --min=80
```

## Current State

### ✅ Completed
- [x] PHPStan Level 10 Compliance
<<<<<<< HEAD
- [x] Compila Page Systematization (Unified Form + Live Summary)
- [x] Validazione criteri minimi (2+ con punteggio > 0) — [minimum-positive-ratings-validation](minimum-positive-ratings-validation.md)
- [ ] Test Coverage improvement
  - [ ] Unit test `IndennitaCalculationService` (post-refactoring)
  - [ ] Feature test pagina Compila
  - [ ] Feature test salvataggio e validazione
- [ ] Documentazione consolidata
  - [ ] Pulizia file duplicati in docs/
  - [ ] Indice documentazione aggiornato

### Fase 2: Refactoring DRY+KISS+SOLID (Planned)

Dettaglio: [refactoring-action-plan](refactoring-action-plan.md)

- [ ] **Foundation & Services** (Giorni 1-3)
  - [ ] IndennitaCalculationService — estrarre logica calcolo da CompilaIndennitaResponsabilita
  - [ ] RatingService — estrarre getRatingsForYear, prepareRatingsForView
  - [ ] DTO: IndennitaCompilazioneData, RatingValueData
- [ ] **Compila Page Refactoring** (Giorni 4-6)
  - [ ] Ridurre God Class (457 linee → <200)
  - [ ] Iniettare Services invece di logica inline
  - [ ] Separare recalculateReadonlyFields in RatingService
- [ ] **Trait Responsibility** (Giorni 7-8)
  - [ ] Spostare getRatingsWhere da HasRatingsTrait a RatingService — [why-getratings-should-move](why-getratings-should-move.md)
  - [ ] Refactoring rating functions — [refactoring-rating-functions](refactoring-rating-functions.md)
- [ ] **Integrazione PDF avanzata**
  - [ ] HTML2PDF — [html2pdf](html2pdf/index.md)
  - [ ] Lettere ufficiali e report

### Fase 3: Integrazione e Ottimizzazione (Future)

- [ ] Integrazione con moduli valutazione/survey (se presenti)
- [ ] Reportistica avanzata
- [ ] Performance form reattivo (lazy load ratings)
- [ ] Traduzioni it/en/de complete — [translations](translations.md)

## Technical Debt

| Area | Stato | Target | Riferimento |
|------|-------|--------|-------------|
| PHPStan | Level 10 | 0 errori | [quality/phpstan](quality/phpstan.md) |
| God Class Compila | 417 linee | <200 | [refactoring-action-plan](refactoring-action-plan.md) |
| Service Layer | Assente | IndennitaCalculationService, RatingService | [refactoring-action-plan](refactoring-action-plan.md) |
| DTO Pattern | Assente | IndennitaCompilazioneData | [refactoring-action-plan](refactoring-action-plan.md) |
| Test Coverage | Parziale | >85% | [development/testing](development/testing.md) |

## Dipendenze

- **Rating**: HasRatingsTrait, Rating model — [Rating/docs](../Rating/docs/)
- **Ptv**: BaseScheda, CompilaAction — [Ptv/docs](../Ptv/docs/)
- **Activity**: Audit trail — [activity-log-integration](activity-log-integration.md)
- **Sigma**: Dati anagrafici — [architecture/models](architecture/models.md)

## Collegamenti

- [README](README.md)
- [Business Logic](business-logic.md)
- [Refactoring Action Plan](refactoring-action-plan.md)
- [Compila Form Architecture](compila-form-architecture.md)
- [Trait Responsibility Violation](trait-responsibility-violation.md)

## Checklist Qualità

- [x] PHPStan Level 10
- [ ] Test coverage flussi critici
- [ ] Traduzioni it/en complete
- [x] Documentazione business-logic
- [ ] Service layer implementato
- [ ] DTO pattern implementato

---

**Ultimo aggiornamento**: Febbraio 2026
=======
- [x] Compila Page con form unificato
- [x] Sistema validazione criteri minimi (2+ ratings > 0)
- [x] Traduzioni IT/EN/DE

### 🔄 In Progress
- [ ] Test Coverage miglioramento
- [ ] Refactoring page class

### ❌ Pending
- [ ] Analytics dashboard
- [ ] Export PDF
- [ ] Storicizzazione

## Roadmap

### Phase 1: Code Quality
- [x] PHPStan Level 10
- [ ] Test Coverage 80%+

### Phase 2: Features
- [ ] Export PDF
- [ ] Storicizzazione valutazioni

### Phase 3: Analytics
- [ ] Dashboard analitiche
- [ ] Reportistica

---

**Last Updated**: 2026-02-24
**Status**: Active Development
>>>>>>> a779533d (docs: expand module roadmaps with detailed phases, testing structure, and TDD guidelines)
