<<<<<<< HEAD
# Ptv Module Roadmap

## Visione

Modulo core PTV (Piano di Valutazione): gestione schede valutazione, valutatori, criteri, anni e integrazione con IndennitaResponsabilita e IndennitaCondizioniLavoro.

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (Planned)
- [ ] PHPStan Level 10 Compliance
- [ ] Allineamento traduzioni ptv::actions.*
- [ ] Test Coverage improvement

### Fase 2: Funzionalità (Planned)
- [ ] CompilaAction e header actions
- [ ] Filtri anno/valutatore
- [ ] Export e report

### Fase 3: Integrazione (Future)
- [ ] Integrazione Sigma/Progressioni
- [ ] Documentazione completa

## Checklist Qualità

- [ ] PHPStan Level 10
- [ ] Traduzioni it/en complete
- [ ] Test coverage
- [ ] Documentazione in docs/

---

**Ultimo aggiornamento**: Febbraio 2026
=======
# Ptv Module - Roadmap

## Overview
**Purpose**: Personnel evaluation and assessment management system (Personale - Valutazione - Tracciamento)
**Status**: Active Development
**Dependencies**: Xot (core), User (authentication), Rating (evaluation criteria)

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%

### Struttura Test
```
Modules/Ptv/tests/
├── Unit/
│   ├── Actions/
│   ├── Models/
│   └── Services/
├── Feature/
│   ├── Filament/
│   │   └── {Resource}Test.php
│   └── Pages/
│       └── {Page}Test.php
├── Pest.php
└── TestCase.php
```

### Test Esistenti
- [x] `CompilaIndennitaResponsabilitaTest` - Test pagina compilazione

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Mail, Queue)
- [ ] Test naming descrittivo
- [ ] Dataset per multiple scenarios

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/Ptv/tests

# Test con coverage
./vendor/bin/pest Modules/Ptv/tests --coverage --min=80
```

## Current State

### ✅ Completed
- [x] Base Filament resources for personnel evaluation
- [x] Database schema for Ptv tracking
- [x] Integration with Rating module
- [x] Basic CRUD operations
- [x] Translation files (IT, EN, DE)

### 🔄 In Progress
- [ ] PHPStan Level 10 compliance
- [ ] Test coverage improvement
- [ ] Advanced filtering and reporting
- [ ] Stabi dirigente management

### ❌ Pending
- [ ] Ptv analytics and insights
- [ ] Automated Ptv reports
- [ ] Ptv history tracking
- [ ] Multi-year Ptv comparison
- [ ] Ptv export (PDF, Excel)
- [ ] Ptv notifications
- [ ] Integration with other HR modules

## Roadmap

### Phase 1: Code Quality (Q1 2026)
**Priority**: High
**Tasks**:
- [ ] Complete PHPStan Level 10 compliance
- [ ] Achieve 80%+ test coverage
- [ ] Documentation completion
- [ ] Refactoring for best practices

### Phase 2: Core Features (Q1-Q2 2026)
**Priority**: High
**Tasks**:
- [ ] Stabi dirigente management
- [ ] Advanced filtering and search
- [ ] Ptv history view
- [ ] Bulk operations for evaluations

### Phase 3: Reporting & Analytics (Q2 2026)
**Priority**: Medium
**Tasks**:
- [ ] Ptv reports
- [ ] Analytics and insights
- [ ] Export functionality (PDF, Excel)
- [ ] Scheduled reports

### Phase 4: Integration (Q3 2026)
**Priority**: Medium
**Tasks**:
- [ ] Integration with User module
- [ ] Integration with Performance module
- [ ] Integration with other HR modules
- [ ] API endpoints for external systems

## Technical Debt
- [ ] PHPStan Level 10 compliance
- [ ] Test coverage improvement (target 80%+)
- [ ] Documentation completion
- [ ] Refactoring legacy code

## Dependencies
- Xot: Core framework functionality
- User: User management and authentication
- Rating: Evaluation criteria and scoring

## Success Criteria
- [ ] PHPStan Level 10 compliance
- [ ] 80%+ test coverage
- [ ] Complete Ptv dashboard
- [ ] Export functionality working
- [ ] Full documentation
- [ ] All translations complete (IT, EN, DE)

---

**Last Updated**: 2026-02-24
**Maintainer**: Team Laraxot
**Status**: Active Development
>>>>>>> a779533d (docs: expand module roadmaps with detailed phases, testing structure, and TDD guidelines)
